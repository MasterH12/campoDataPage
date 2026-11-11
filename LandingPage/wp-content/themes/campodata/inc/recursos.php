<?php
/**
 * CSS y JS propios del tema: estilos, el módulo de movimiento y sus datos, y el ícono de la pestaña.
 *
 * @package CampoData\Tema
 */

namespace CampoData\Tema;

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\cargar_recursos' );
add_action( 'after_setup_theme', __NAMESPACE__ . '\\cargar_estilos_del_editor' );
add_action( 'wp_head', __NAMESPACE__ . '\\imprimir_interruptor_de_movimiento', 1 );
add_action( 'wp_head', __NAMESPACE__ . '\\precargar_tipografias', 2 );
add_action( 'wp_head', __NAMESPACE__ . '\\imprimir_icono', 3 );
add_action( 'do_faviconico', __NAMESPACE__ . '\\redirigir_favicon' );
add_filter( 'script_module_data_campodata/movimiento', __NAMESPACE__ . '\\datos_del_movimiento' );

/**
 * Versión de un archivo del tema, para que el navegador no use una copia vieja.
 *
 * @param string $ruta Ruta relativa a la carpeta del tema.
 * @return string
 */
function version_de( string $ruta ): string {
	return (string) filemtime( get_theme_file_path( $ruta ) );
}

/**
 * URL de un archivo del tema con su versión, para que el navegador no use una copia vieja.
 *
 * @param string $ruta Ruta relativa a la carpeta del tema.
 * @return string
 */
function url_con_version( string $ruta ): string {
	return add_query_arg( 'ver', version_de( $ruta ), get_theme_file_uri( $ruta ) );
}

/**
 * Carga el CSS del sitio y el módulo de movimiento.
 */
function cargar_recursos(): void {
	wp_enqueue_style( 'campodata', get_theme_file_uri( 'assets/css/sitio.css' ), array(), version_de( 'assets/css/sitio.css' ) );
	wp_enqueue_script_module( 'campodata/movimiento', get_theme_file_uri( 'assets/js/movimiento.js' ), array(), version_de( 'assets/js/movimiento.js' ) );
}

/**
 * Usa el mismo CSS en el editor, más los ajustes propios del editor.
 */
function cargar_estilos_del_editor(): void {
	add_editor_style( array( 'assets/css/sitio.css', 'assets/css/editor.css' ) );
}

/**
 * Activa el movimiento antes de que se dibuje la página, para que nada parpadee.
 *
 * Agrega cd-con-js a <html> siempre que haya JS (sin JS, el CSS muestra todos los paneles de las
 * pestañas). Agrega cd-movimiento solo si el usuario no prefiere movimiento reducido; si el módulo
 * no avisa en 3 segundos (por ejemplo, porque el JS falló), la quita: nada queda oculto.
 */
function imprimir_interruptor_de_movimiento(): void {
	wp_print_inline_script_tag(
		"(function(h){h.classList.add('cd-con-js');if(window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches)return;h.classList.add('cd-movimiento');setTimeout(function(){if(!window.cdMovimientoListo)h.classList.remove('cd-movimiento');},3000);})(document.documentElement);"
	);
}

/**
 * Precarga las dos tipografías del tema: el texto se dibuja antes con su forma final y cambia
 * menos de alto al cargar (los saltos a un ancla quedan donde deben).
 */
function precargar_tipografias(): void {
	foreach ( array( 'sora-latin-wght-normal.woff2', 'dm-sans-latin-wght-normal.woff2' ) as $fuente ) {
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( get_theme_file_uri( 'assets/fonts/' . $fuente ) ) );
	}
}

/**
 * Ícono de la pestaña: el logo de CampoData sin la palabra (el círculo de emblema.webp), en 32 px para
 * las pestañas y en 96 px para Google, que pide un múltiplo de 48 (spec 05). Si alguien cargó un ícono
 * del sitio en Ajustes → General, manda ese.
 */
function imprimir_icono(): void {
	if ( has_site_icon() ) {
		return;
	}
	foreach ( array( 32, 96 ) as $lado ) {
		printf(
			'<link rel="icon" href="%1$s" sizes="%2$dx%2$d" type="image/png">' . "\n",
			esc_url( url_con_version( "assets/images/marca/favicon-$lado.png" ) ),
			(int) $lado
		);
	}
}

/**
 * Sin ícono del sitio, el core responde /favicon.ico con el logo de WordPress: se lleva al del tema.
 */
function redirigir_favicon(): void {
	if ( has_site_icon() ) {
		return;
	}
	wp_safe_redirect( url_con_version( 'assets/images/marca/favicon-32.png' ) );
	exit;
}

/**
 * Datos que el módulo necesita: el WhatsApp de los datos de contacto, para el formulario.
 *
 * @param array $datos Datos del módulo.
 * @return array
 */
function datos_del_movimiento( array $datos ): array {
	if ( function_exists( '\\CampoData\\Core\\dato_de_contacto' ) ) {
		$datos['whatsapp'] = \CampoData\Core\dato_de_contacto( 'whatsapp' );
	}
	return $datos;
}
