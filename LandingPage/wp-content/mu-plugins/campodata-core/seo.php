<?php
/**
 * SEO técnico (spec 05): indexación por entorno, título y descripción (Ajustes → SEO), vista previa
 * al compartir, datos estructurados, un <head> sin enlaces que no aportan, feeds y búsqueda, sitemap
 * y las URLs del sitio anterior.
 *
 * Lo visual (el ícono y la imagen para compartir) vive en el tema. Si falta un archivo del tema,
 * se omiten sus etiquetas: este archivo nunca depende de que el tema esté completo.
 *
 * @package CampoData\Core
 */

namespace CampoData\Core;

defined( 'ABSPATH' ) || exit;

const OPCION_SEO = 'campodata_seo';

// Nombre legal para los datos estructurados (confirmado por el usuario, spec 05).
const NOMBRE_LEGAL = 'CampoData SpA';

// Imágenes del tema que usan las etiquetas.
const IMAGEN_PARA_COMPARTIR = 'assets/images/compartir/campodata.jpg';
const TEXTO_DE_LA_IMAGEN    = 'CampoData: gestión simple y efectiva para tu predio lechero, con la pantalla Hoy de Producción';
const LOGO                  = 'assets/images/marca/emblema.webp';
const CAPTURA_DEL_SISTEMA   = 'assets/images/sistema/banner-hoy.webp';

// Fuera de producción el sitio nunca se indexa, diga lo que diga la base. La base dice "indexar"
// (bin/setup), así una base migrada a producción queda indexable. WordPress considera producción
// a todo sitio que no define WP_ENVIRONMENT_TYPE: un servidor de pruebas tiene que definirlo como staging.
if ( 'production' !== wp_get_environment_type() ) {
	add_filter( 'pre_option_blog_public', '__return_zero' );
}

// Ajustes → SEO.
add_action( 'init', __NAMESPACE__ . '\\registrar_opcion_seo' );
add_action( 'admin_init', __NAMESPACE__ . '\\registrar_campos_seo' );
add_action( 'admin_menu', __NAMESPACE__ . '\\agregar_pantalla_seo' );

// Portada: título, descripción, vista previa al compartir y datos estructurados.
add_filter( 'pre_get_document_title', __NAMESPACE__ . '\\titulo_de_la_portada' );
add_action( 'wp_head', __NAMESPACE__ . '\\imprimir_metadatos', 5 );
add_action( 'wp_head', __NAMESPACE__ . '\\imprimir_datos_estructurados', 6 );

// Un <head> sin feeds, RSD, enlace corto, REST API ni oEmbed. La REST API sigue funcionando:
// el editor no usa estos enlaces. El core engancha dos veces el descubrimiento de oEmbed.
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 4 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// Feeds, búsqueda y URLs del sitio anterior. Prioridad 1: antes de redirect_canonical (10) y
// de las páginas de autor (5, seguridad.php).
add_action( 'template_redirect', __NAMESPACE__ . '\\redirigir_urls_sin_contenido', 1 );

// El sitemap del core lista solo páginas (los usuarios ya los quita seguridad.php).
add_filter( 'wp_sitemaps_post_types', __NAMESPACE__ . '\\sitemap_solo_de_paginas' );
add_filter( 'wp_sitemaps_add_provider', __NAMESPACE__ . '\\quitar_sitemap_de_taxonomias', 10, 2 );

/**
 * Campos de Ajustes → SEO: etiqueta, ayuda y filas (0 es un campo de una línea).
 *
 * @return array
 */
function campos_seo(): array {
	return array(
		'titulo'      => array(
			'etiqueta' => 'Título para buscadores',
			'ayuda'    => 'Aparece en la pestaña, en Google y al compartir. Hasta 60 caracteres: Google corta los más largos.',
			'filas'    => 0,
		),
		'descripcion' => array(
			'etiqueta' => 'Descripción',
			'ayuda'    => 'Aparece bajo el título en Google y al compartir. Entre 70 y 155 caracteres.',
			'filas'    => 3,
		),
	);
}

/**
 * Registra la opción con sus claves vacías por defecto.
 */
function registrar_opcion_seo(): void {
	register_setting(
		'campodata_seo',
		OPCION_SEO,
		array(
			'type'              => 'array',
			'sanitize_callback' => __NAMESPACE__ . '\\limpiar_datos_seo',
			'default'           => array_fill_keys( array_keys( campos_seo() ), '' ),
			'show_in_rest'      => false,
		)
	);
}

/**
 * Limpia los textos que llegan desde la pantalla de ajustes: quedan en una sola línea.
 *
 * @param mixed $valores Valores enviados.
 * @return array
 */
function limpiar_datos_seo( $valores ): array {
	$valores = is_array( $valores ) ? $valores : array();
	$limpios = array();
	foreach ( array_keys( campos_seo() ) as $clave ) {
		$limpios[ $clave ] = sanitize_text_field( isset( $valores[ $clave ] ) ? (string) $valores[ $clave ] : '' );
	}
	return $limpios;
}

/**
 * Devuelve un texto de Ajustes → SEO, o una cadena vacía si no existe.
 *
 * @param string $clave titulo o descripcion.
 * @return string
 */
function dato_seo( string $clave ): string {
	$datos = get_option( OPCION_SEO );
	return is_array( $datos ) && isset( $datos[ $clave ] ) ? (string) $datos[ $clave ] : '';
}

/**
 * Agrega Ajustes → SEO.
 */
function agregar_pantalla_seo(): void {
	add_options_page( 'SEO', 'SEO', 'manage_options', 'campodata-seo', __NAMESPACE__ . '\\mostrar_pantalla_seo' );
}

/**
 * Registra la sección y los campos de la pantalla de ajustes.
 */
function registrar_campos_seo(): void {
	add_settings_section( 'campodata_seo_textos', '', '__return_null', 'campodata-seo' );
	foreach ( campos_seo() as $clave => $campo ) {
		add_settings_field(
			'campodata_seo_' . $clave,
			$campo['etiqueta'],
			__NAMESPACE__ . '\\mostrar_campo_seo',
			'campodata-seo',
			'campodata_seo_textos',
			array(
				'clave'     => $clave,
				'campo'     => $campo,
				'label_for' => 'campodata-seo-' . $clave,
			)
		);
	}
}

/**
 * Dibuja un campo de la pantalla de ajustes, con cuántos caracteres tiene hoy.
 *
 * @param array $argumentos Clave y definición del campo.
 */
function mostrar_campo_seo( array $argumentos ): void {
	$clave = $argumentos['clave'];
	$valor = dato_seo( $clave );
	$id    = $argumentos['label_for'];
	$name  = OPCION_SEO . '[' . $clave . ']';
	if ( $argumentos['campo']['filas'] > 0 ) {
		printf(
			'<textarea class="large-text" id="%1$s" name="%2$s" rows="%3$d">%4$s</textarea>',
			esc_attr( $id ),
			esc_attr( $name ),
			(int) $argumentos['campo']['filas'],
			esc_textarea( $valor )
		);
	} else {
		printf( '<input type="text" class="large-text" id="%1$s" name="%2$s" value="%3$s">', esc_attr( $id ), esc_attr( $name ), esc_attr( $valor ) );
	}
	printf( '<p class="description">%1$s Hoy tiene %2$d.</p>', esc_html( $argumentos['campo']['ayuda'] ), (int) mb_strlen( $valor ) );
}

/**
 * Pantalla Ajustes → SEO.
 */
function mostrar_pantalla_seo(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="wrap"><h1>SEO</h1>';
	echo '<p>Estos textos se usan en la portada. El teléfono, el correo, la zona y las redes de los datos estructurados salen de Ajustes → Datos de contacto.</p>';
	echo '<form action="options.php" method="post">';
	settings_fields( 'campodata_seo' );
	do_settings_sections( 'campodata-seo' );
	submit_button( 'Guardar los textos' );
	echo '</form></div>';
}

/**
 * En la portada, el título es el de Ajustes → SEO. Vacío, queda el del core.
 *
 * El core imprime este valor tal cual dentro de <title>, sin escaparlo como al título que arma él.
 *
 * @param string $titulo Título que propone el filtro (vacío por defecto).
 * @return string
 */
function titulo_de_la_portada( string $titulo ): string {
	if ( ! is_front_page() ) {
		return $titulo;
	}
	$propio = dato_seo( 'titulo' );
	return '' === $propio ? $titulo : esc_html( $propio );
}

/**
 * Datos de un archivo del tema: URL, medidas y tipo. Null si el archivo no existe o no es una imagen.
 *
 * @param string $ruta          Ruta relativa a la carpeta del tema.
 * @param bool   $con_version   Si la URL lleva ?ver= con la fecha del archivo.
 * @return array|null
 */
function imagen_del_tema( string $ruta, bool $con_version = false ): ?array {
	$archivo = get_theme_file_path( $ruta );
	if ( ! is_file( $archivo ) ) {
		return null;
	}
	$medidas = wp_getimagesize( $archivo );
	if ( ! $medidas ) {
		return null;
	}
	$url = get_theme_file_uri( $ruta );
	return array(
		'url'   => $con_version ? add_query_arg( 'ver', (string) filemtime( $archivo ), $url ) : $url,
		'ancho' => (int) $medidas[0],
		'alto'  => (int) $medidas[1],
		'tipo'  => (string) $medidas['mime'],
	);
}

/**
 * Imprime en la portada la descripción, Open Graph y la tarjeta de Twitter.
 */
function imprimir_metadatos(): void {
	if ( ! is_front_page() ) {
		return;
	}
	$titulo      = dato_seo( 'titulo' );
	$descripcion = dato_seo( 'descripcion' );
	if ( '' !== $descripcion ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $descripcion ) );
	}

	$etiquetas = array(
		'og:type'        => 'website',
		'og:site_name'   => get_bloginfo( 'name' ),
		'og:locale'      => get_locale(),
		'og:url'         => esc_url( home_url( '/' ) ),
		'og:title'       => '' === $titulo ? get_bloginfo( 'name' ) : $titulo,
		'og:description' => $descripcion,
	);
	$imagen    = imagen_del_tema( IMAGEN_PARA_COMPARTIR, true );
	if ( $imagen ) {
		$etiquetas += array(
			'og:image'        => esc_url( $imagen['url'] ),
			'og:image:type'   => $imagen['tipo'],
			'og:image:width'  => (string) $imagen['ancho'],
			'og:image:height' => (string) $imagen['alto'],
			'og:image:alt'    => TEXTO_DE_LA_IMAGEN,
		);
	}
	foreach ( $etiquetas as $propiedad => $valor ) {
		if ( '' !== $valor ) {
			printf( '<meta property="%1$s" content="%2$s">' . "\n", esc_attr( $propiedad ), esc_attr( $valor ) );
		}
	}
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}

/**
 * Quita de un arreglo las propiedades vacías: un dato que falta se omite, no va vacío.
 *
 * @param array $datos Propiedades.
 * @return array
 */
function sin_vacios( array $datos ): array {
	return array_filter( $datos, static fn( $valor ) => '' !== $valor && array() !== $valor && null !== $valor );
}

/**
 * Imprime en la portada los datos estructurados: la organización, el sitio y la aplicación.
 * Solo lleva lo que ya está publicado: sin precios, calificaciones, reseñas ni dirección (spec 05, §5).
 */
function imprimir_datos_estructurados(): void {
	if ( ! is_front_page() ) {
		return;
	}
	$inicio       = home_url( '/' );
	$organizacion = array( '@id' => $inicio . '#organizacion' );
	$correo       = dato_de_contacto( 'correo' );
	$telefono     = dato_de_contacto( 'telefono' );
	$logo         = imagen_del_tema( LOGO );
	$captura      = imagen_del_tema( CAPTURA_DEL_SISTEMA );

	$redes = array_values( sin_vacios( array( dato_de_contacto( 'linkedin' ), dato_de_contacto( 'instagram' ) ) ) );

	$punto_de_contacto = '' === $correo && '' === $telefono ? array() : sin_vacios(
		array(
			'@type'             => 'ContactPoint',
			'contactType'       => 'ventas',
			'email'             => $correo,
			'telephone'         => $telefono,
			'availableLanguage' => 'es',
		)
	);

	$grafo = array(
		sin_vacios(
			array(
				'@type'        => 'Organization',
				'@id'          => $organizacion['@id'],
				'name'         => get_bloginfo( 'name' ),
				'legalName'    => NOMBRE_LEGAL,
				'url'          => $inicio,
				'logo'         => $logo ? array(
					'@type'  => 'ImageObject',
					'url'    => $logo['url'],
					'width'  => $logo['ancho'],
					'height' => $logo['alto'],
				) : null,
				'email'        => $correo,
				'telephone'    => $telefono,
				'areaServed'   => dato_de_contacto( 'zona' ),
				'contactPoint' => $punto_de_contacto,
				'sameAs'       => $redes,
			)
		),
		array(
			'@type'      => 'WebSite',
			'@id'        => $inicio . '#sitio',
			'url'        => $inicio,
			'name'       => get_bloginfo( 'name' ),
			'inLanguage' => str_replace( '_', '-', get_locale() ),
			'publisher'  => $organizacion,
		),
		sin_vacios(
			array(
				'@type'               => 'SoftwareApplication',
				'@id'                 => $inicio . '#aplicacion',
				'name'                => get_bloginfo( 'name' ),
				'url'                 => $inicio,
				'applicationCategory' => 'BusinessApplication',
				'operatingSystem'     => 'Web',
				'inLanguage'          => 'es',
				'description'         => dato_seo( 'descripcion' ),
				'screenshot'          => $captura ? $captura['url'] : '',
				'publisher'           => $organizacion,
			)
		),
	);

	// JSON_HEX_TAG escribe < y > como < y >: ningún texto puede cerrar la etiqueta <script>.
	wp_print_inline_script_tag(
		(string) wp_json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph'   => $grafo,
			),
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG
		),
		array( 'type' => 'application/ld+json' )
	);
}

/**
 * URLs que tenía el sitio anterior (campodata.cl, medido el 2026-11-10): las que tienen una sección
 * equivalente redirigen a ella; las de plantilla ya no existen. Ruta sin barras al inicio ni al final
 * => destino ('' responde 410). Para sumar una URL, agrégala aquí.
 *
 * @return array
 */
function urls_del_sitio_anterior(): array {
	return array(
		'about'                  => '/#para-quien',
		'services'               => '/#como',
		'contact'                => '/#demo',
		'blog'                   => '',
		'sample-page'            => '',
		'2026/01/12/hello-world' => '',
		'2026/01/13/unlocking-the-power-of-data-how-campodata-transforms-business-management' => '',
		'category/uncategorized' => '',
		'sitemaps.xml'           => '/wp-sitemap.xml',
	);
}

/**
 * Feeds y búsqueda van a la portada (no hay entradas ni buscador). Las URLs del sitio anterior
 * redirigen a su sección o responden 410, solo si nada del sitio responde en esa ruta.
 */
function redirigir_urls_sin_contenido(): void {
	if ( is_feed() || is_search() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
	// Una categoría o etiqueta sin entradas responde 200 con una página vacía (la instalación crea
	// "Uncategorized" aunque no haya entradas): se trata como lo que es, una página que no existe.
	if ( ( is_category() || is_tag() || is_tax() ) && ! have_posts() ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	}
	if ( ! is_404() ) {
		return;
	}
	global $wp;
	$ruta     = trim( (string) $wp->request, '/' );
	$antiguas = urls_del_sitio_anterior();
	if ( ! isset( $antiguas[ $ruta ] ) ) {
		return;
	}
	if ( '' === $antiguas[ $ruta ] ) {
		// La plantilla 404 del tema se muestra igual, con el estado 410.
		status_header( 410 );
		nocache_headers();
		return;
	}
	wp_safe_redirect( home_url( $antiguas[ $ruta ] ), 301 );
	exit;
}

/**
 * El sitemap lista solo páginas: no hay entradas.
 *
 * @param array $tipos Tipos de contenido del sitemap.
 * @return array
 */
function sitemap_solo_de_paginas( array $tipos ): array {
	return array_intersect_key( $tipos, array( 'page' => true ) );
}

/**
 * Quita del sitemap las categorías y etiquetas: no hay entradas que las usen.
 *
 * @param \WP_Sitemaps_Provider|false $proveedor Proveedor del sitemap.
 * @param string                      $nombre    Nombre del proveedor.
 * @return \WP_Sitemaps_Provider|false
 */
function quitar_sitemap_de_taxonomias( $proveedor, string $nombre ) {
	return 'taxonomies' === $nombre ? false : $proveedor;
}
