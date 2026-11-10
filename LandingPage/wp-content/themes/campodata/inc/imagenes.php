<?php
/**
 * Imágenes del sistema (assets/images/sistema/): medidas, carga diferida y prioridad.
 *
 * El core solo difiere la carga de las imágenes que traen width y height, y las del tema no
 * los traen porque no vienen de la Biblioteca de medios. Este filtro los toma del archivo.
 *
 * @package CampoData\Tema
 */

namespace CampoData\Tema;

defined( 'ABSPATH' ) || exit;

add_filter( 'render_block_core/image', __NAMESPACE__ . '\\completar_imagen_del_sistema', 10, 2 );

/**
 * Agrega width, height, loading y fetchpriority a las imágenes de assets/images/sistema/.
 *
 * Con la clase cd-sin-diferir la imagen se carga de inmediato (es lo primero que se ve), y con
 * cd-prioridad, además, antes que el resto. Las demás se cargan al acercarse.
 *
 * @param string $html   HTML del bloque.
 * @param array  $bloque Bloque analizado.
 * @return string
 */
function completar_imagen_del_sistema( string $html, array $bloque ): string {
	if ( ! str_contains( $html, get_theme_file_uri( 'assets/images/sistema/' ) ) ) {
		return $html;
	}
	$procesador = new \WP_HTML_Tag_Processor( $html );
	if ( ! $procesador->next_tag( 'img' ) ) {
		return $html;
	}
	$archivo = get_theme_file_path( 'assets/images/sistema/' . wp_basename( (string) wp_parse_url( (string) $procesador->get_attribute( 'src' ), PHP_URL_PATH ) ) );
	if ( null === $procesador->get_attribute( 'width' ) && is_readable( $archivo ) ) {
		$medidas = wp_getimagesize( $archivo );
		if ( $medidas ) {
			$procesador->set_attribute( 'width', (string) $medidas[0] );
			$procesador->set_attribute( 'height', (string) $medidas[1] );
		}
	}
	$clases = (string) ( $bloque['attrs']['className'] ?? '' );
	$procesador->set_attribute( 'loading', str_contains( $clases, 'cd-sin-diferir' ) ? 'eager' : 'lazy' );
	$procesador->set_attribute( 'decoding', 'async' );
	if ( str_contains( $clases, 'cd-prioridad' ) ) {
		$procesador->set_attribute( 'fetchpriority', 'high' );
	}
	return $procesador->get_updated_html();
}
