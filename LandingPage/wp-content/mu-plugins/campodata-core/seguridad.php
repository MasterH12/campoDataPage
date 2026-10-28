<?php
/**
 * Seguridad básica, en todos los entornos.
 *
 * @package CampoData\Core
 */

namespace CampoData\Core;

defined( 'ABSPATH' ) || exit;

// XML-RPC: apaga los métodos con autenticación y quita los pingbacks.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', __NAMESPACE__ . '\\quitar_pingbacks' );

// No publicar la versión de WordPress.
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

// Sin recursos de terceros en el sitio: los emojis de WordPress se cargan desde s.w.org.
// Los estilos se apagan quitando print_emoji_styles de wp_print_styles, que es lo que revisa
// wp_enqueue_emoji_styles(). Quitar wp_enqueue_emoji_styles deja enganchada esa función
// obsoleta: imprime los estilos igual y anota un aviso Deprecated en cada visita.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

// No revelar los usuarios: REST API, páginas de autor, sitemap y oEmbed.
add_filter( 'rest_endpoints', __NAMESPACE__ . '\\ocultar_usuarios_en_rest' );
add_action( 'template_redirect', __NAMESPACE__ . '\\responder_404_en_paginas_de_autor', 5 );
add_filter( 'wp_sitemaps_add_provider', __NAMESPACE__ . '\\quitar_sitemap_de_usuarios', 10, 2 );
add_filter( 'oembed_response_data', __NAMESPACE__ . '\\ocultar_autor_en_oembed' );

/**
 * Quita los métodos de pingback de XML-RPC.
 *
 * @param array $metodos Métodos de XML-RPC disponibles.
 * @return array
 */
function quitar_pingbacks( array $metodos ): array {
	unset( $metodos['pingback.ping'], $metodos['pingback.extensions.getPingbacks'] );
	return $metodos;
}

/**
 * Sin sesión iniciada, quita las rutas de usuarios de la REST API (responden 404).
 * El editor de bloques sigue funcionando porque siempre se usa con sesión.
 *
 * @param array $rutas Rutas registradas en la REST API.
 * @return array
 */
function ocultar_usuarios_en_rest( array $rutas ): array {
	if ( is_user_logged_in() ) {
		return $rutas;
	}

	unset( $rutas['/wp/v2/users'], $rutas['/wp/v2/users/(?P<id>[\d]+)'] );
	return $rutas;
}

/**
 * Responde 404 en las páginas de autor y en ?author=N.
 *
 * Corre con prioridad 5, antes de redirect_canonical (prioridad 10), que si no
 * redirigiría ?author=N a /author/<usuario>/ y revelaría el nombre de usuario.
 */
function responder_404_en_paginas_de_autor(): void {
	if ( ! is_author() ) {
		return;
	}

	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
}

/**
 * Quita el sitemap de usuarios del core: lista las páginas de autor, que revelan el nombre de usuario.
 *
 * @param \WP_Sitemaps_Provider|false $proveedor Proveedor del sitemap.
 * @param string                      $nombre    Nombre del proveedor.
 * @return \WP_Sitemaps_Provider|false
 */
function quitar_sitemap_de_usuarios( $proveedor, string $nombre ) {
	return 'users' === $nombre ? false : $proveedor;
}

/**
 * Quita el nombre y la página del autor de las respuestas de oEmbed.
 *
 * @param array $datos Respuesta de oEmbed.
 * @return array
 */
function ocultar_autor_en_oembed( array $datos ): array {
	unset( $datos['author_name'], $datos['author_url'] );
	return $datos;
}
