/**
 * CampoData: movimiento de la portada. Apariciones al bajar, contadores, encabezado con barra de
 * progreso, línea de Cómo funciona, panel que se inclina, foco de luz en las tarjetas, pestañas y
 * el formulario que arma el mensaje de WhatsApp. Sin dependencias.
 *
 * El script en línea del <head> (inc/recursos.php) agrega cd-movimiento a <html> solo si el
 * usuario no prefiere movimiento reducido, y la quita si este módulo no avisa en 3 segundos.
 */

const raiz = document.documentElement;
const conMovimiento = raiz.classList.contains( 'cd-movimiento' );
const conMouse = window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches;
window.cdMovimientoListo = true;

// Los mismos elementos que sitio.css oculta antes de aparecer.
const OBJETIVOS = [
	':where(.wp-block-post-content > section:not(.cd-banner), .cd-pie) > :not(.cd-escalonado, .sin-movimiento)',
	'.cd-escalonado > :not(.sin-movimiento)',
].join( ', ' );

// Elementos que se "activan" una vez al aparecer: la línea de los pasos, los checks, la ventana y la tabla.
const ACTIVABLES = '.cd-pasos, .is-style-lista-check, .is-style-ventana, .is-style-comparacion';

const datos = ( () => {
	try {
		return JSON.parse( document.getElementById( 'wp-script-module-data-campodata/movimiento' )?.textContent || '{}' );
	} catch {
		return {};
	}
} )();

/* Observa una sola vez: al entrar en pantalla, llama a la función y deja de observar. */
function alAparecer( selector, umbral, accion ) {
	const observador = new IntersectionObserver( ( entradas ) => {
		for ( const entrada of entradas ) {
			if ( entrada.isIntersecting ) {
				accion( entrada.target );
				observador.unobserve( entrada.target );
			}
		}
	}, { threshold: umbral } );
	document.querySelectorAll( selector ).forEach( ( el ) => observador.observe( el ) );
}

if ( conMovimiento ) {
	if ( 'IntersectionObserver' in window ) {
		alAparecer( OBJETIVOS, 0.12, ( el ) => el.classList.add( 'cd-visible' ) );
		alAparecer( ACTIVABLES, 0.25, ( el ) => el.classList.add( 'cd-activa' ) );
	} else {
		raiz.classList.remove( 'cd-movimiento' );
	}
}

/* Cifras que cuentan desde cero. El HTML trae el valor final y se restaura al terminar. */
function contar( el ) {
	const original = el.textContent;
	const numero = original.match( /\d[\d.]*/ );
	if ( ! numero ) {
		return;
	}
	const objetivo = parseInt( numero[ 0 ].replace( /\./g, '' ), 10 );
	const formato = new Intl.NumberFormat( 'es-CL' );
	const inicio = performance.now();
	const paso = ( ahora ) => {
		const avance = Math.min( 1, ( ahora - inicio ) / 1200 );
		const valor = Math.round( objetivo * ( 1 - Math.pow( 1 - avance, 3 ) ) );
		el.textContent = avance < 1 ? original.replace( numero[ 0 ], formato.format( valor ) ) : original;
		if ( avance < 1 ) {
			requestAnimationFrame( paso );
		}
	};
	requestAnimationFrame( paso );
}

if ( conMovimiento && 'IntersectionObserver' in window ) {
	// En el banner, espera a que termine la entrada de las cifras.
	alAparecer( '.cd-contador', 0.5, ( el ) => setTimeout( () => contar( el ), el.closest( '.cd-banner' ) ? 500 : 0 ) );
}

/* Encabezado: cristal al pasar los 20px, barra de progreso de lectura y su alto para las anclas. */
const encabezado = document.querySelector( '.wp-site-blocks > header' );
if ( encabezado ) {
	let pendiente = false;
	const actualizar = () => {
		pendiente = false;
		const recorrido = document.documentElement.scrollHeight - window.innerHeight;
		raiz.classList.toggle( 'cd-con-scroll', window.scrollY > 20 );
		raiz.style.setProperty( '--cd-progreso', recorrido > 0 ? Math.min( 1, window.scrollY / recorrido ).toFixed( 4 ) : '0' );
	};
	window.addEventListener( 'scroll', () => {
		if ( ! pendiente ) {
			pendiente = true;
			requestAnimationFrame( actualizar );
		}
	}, { passive: true } );
	actualizar();
	const medir = () => raiz.style.setProperty( '--cd-alto-encabezado', `${ encabezado.offsetHeight }px` );
	medir();
	new ResizeObserver( medir ).observe( encabezado );
}

/* Menú: marca el enlace de la sección que está a la vista. */
const enlaces = [ ...document.querySelectorAll( '.cd-encabezado a.wp-block-navigation-item__content[href^="/#"]' ) ];
if ( enlaces.length && 'IntersectionObserver' in window ) {
	const vista = new IntersectionObserver( ( entradas ) => {
		for ( const entrada of entradas ) {
			if ( entrada.isIntersecting ) {
				const ancla = `/#${ entrada.target.id }`;
				enlaces.forEach( ( a ) => a.classList.toggle( 'cd-activo', a.getAttribute( 'href' ) === ancla ) );
			}
		}
	}, { rootMargin: '-45% 0px -50% 0px' } );
	document.querySelectorAll( '.wp-block-post-content > section[id]' ).forEach( ( s ) => vista.observe( s ) );
}

/* Lo que se repite (píxeles, degradados, paquete de datos) se pausa fuera de la vista y con la pestaña oculta. */
if ( 'IntersectionObserver' in window ) {
	const pausa = new IntersectionObserver( ( entradas ) => {
		for ( const entrada of entradas ) {
			entrada.target.classList.toggle( 'cd-fuera', ! entrada.isIntersecting );
		}
	} );
	document.querySelectorAll( '.cd-banner, .cd-como, .cd-demo' ).forEach( ( s ) => pausa.observe( s ) );
}
document.addEventListener( 'visibilitychange', () => raiz.classList.toggle( 'cd-oculta', document.hidden ) );

/* Al llegar con un ancla (/#reportes), el navegador salta antes de que carguen las tipografías, y
   al cargar el texto cambia de alto. Durante 3 segundos, cada vez que la página cambia de alto se
   vuelve al ancla, salvo que la persona ya haya empezado a moverse por su cuenta. */
const destino = location.hash.length > 1 && document.getElementById( decodeURIComponent( location.hash.slice( 1 ) ) );
if ( destino ) {
	let quieto = true;
	const soltar = () => {
		quieto = false;
	};
	[ 'wheel', 'touchstart', 'keydown', 'mousedown' ].forEach( ( e ) => window.addEventListener( e, soltar, { once: true, passive: true } ) );
	setTimeout( soltar, 3000 );
	new ResizeObserver( () => quieto && destino.scrollIntoView( { behavior: 'instant' } ) ).observe( document.body );
}

/* M5 · El panel del banner se inclina hacia el mouse, hasta 6°. */
const panel = document.querySelector( '.cd-panel' );
if ( panel && conMovimiento && conMouse ) {
	const banner = panel.closest( '.cd-banner' );
	let cuadro = 0;
	banner.addEventListener( 'pointermove', ( evento ) => {
		cancelAnimationFrame( cuadro );
		cuadro = requestAnimationFrame( () => {
			const caja = panel.getBoundingClientRect();
			const x = ( evento.clientX - ( caja.left + caja.width / 2 ) ) / ( window.innerWidth / 2 );
			const y = ( evento.clientY - ( caja.top + caja.height / 2 ) ) / ( window.innerHeight / 2 );
			panel.style.setProperty( '--cd-ry', `${ ( Math.max( -1, Math.min( 1, x ) ) * 6 ).toFixed( 2 ) }deg` );
			panel.style.setProperty( '--cd-rx', `${ ( Math.max( -1, Math.min( 1, -y ) ) * 6 ).toFixed( 2 ) }deg` );
		} );
	} );
	banner.addEventListener( 'pointerleave', () => {
		cancelAnimationFrame( cuadro );
		panel.style.setProperty( '--cd-rx', '0deg' );
		panel.style.setProperty( '--cd-ry', '0deg' );
	} );
}

/* M10 · Foco de luz: sigue al cursor dentro de cada tarjeta. */
if ( conMouse ) {
	document.querySelectorAll( '.cd-tarjeta' ).forEach( ( tarjeta ) => {
		tarjeta.addEventListener( 'pointermove', ( evento ) => {
			const caja = tarjeta.getBoundingClientRect();
			tarjeta.style.setProperty( '--cd-x', `${ Math.round( evento.clientX - caja.left ) }px` );
			tarjeta.style.setProperty( '--cd-y', `${ Math.round( evento.clientY - caja.top ) }px` );
		} );
	} );
}

/* Pestañas: la animación del panel solo después de la primera interacción. */
document.querySelectorAll( '.wp-block-tabs' ).forEach( ( tabs ) => {
	const marcar = () => tabs.classList.add( 'cd-interactuada' );
	tabs.addEventListener( 'click', marcar, { once: true } );
	tabs.addEventListener( 'keydown', marcar, { once: true } );
} );

/* M11 · "Quiero una demo": elige en el formulario el perfil de la tarjeta (su clase cd-perfil-*) y
   la tarjeta del formulario se ilumina un momento. */
document.querySelectorAll( '.cd-perfil .cd-quiero-demo a' ).forEach( ( enlace ) => {
	enlace.addEventListener( 'click', () => {
		const perfil = [ ...enlace.closest( '.cd-perfil' ).classList ].find( ( c ) => c.startsWith( 'cd-perfil-' ) )?.slice( 10 );
		const opcion = document.querySelector( `.cd-formulario input[data-perfil="${ perfil }"]` );
		if ( ! opcion ) {
			return;
		}
		opcion.checked = true;
		const tarjeta = opcion.closest( '.is-style-cristal' );
		tarjeta?.classList.remove( 'cd-resaltado' );
		void tarjeta?.offsetWidth; // Reinicia la animación si se elige dos veces seguidas.
		tarjeta?.classList.add( 'cd-resaltado' );
	} );
} );

/* Formulario: arma el mensaje y abre WhatsApp. No envía nada a ningún servidor. */
document.querySelectorAll( '.cd-formulario' ).forEach( ( formulario ) => {
	if ( ! datos.whatsapp ) {
		return;
	}
	formulario.classList.add( 'cd-activo' );
	formulario.addEventListener( 'submit', ( evento ) => {
		evento.preventDefault();
		const { nombre, predio, perfil } = formulario.elements;
		const error = formulario.querySelector( '.cd-error' );
		const quien = nombre.value.trim();
		if ( ! quien ) {
			error.hidden = false;
			nombre.setAttribute( 'aria-invalid', 'true' );
			nombre.focus();
			return;
		}
		error.hidden = true;
		nombre.removeAttribute( 'aria-invalid' );
		const conPredio = predio.value.trim() ? `, de ${ predio.value.trim() }` : '';
		const mensaje = `Hola, CampoData. Soy ${ quien }${ conPredio }. Perfil: ${ perfil.value || 'Otro' }. Quiero solicitar una demo.`;
		window.open( `https://wa.me/${ datos.whatsapp }?text=${ encodeURIComponent( mensaje ) }`, '_blank', 'noopener' );
	} );
} );
