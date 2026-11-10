<?php
/**
 * Imágenes del tema (assets/images/sistema/ y assets/images/apoyos/): medidas, carga diferida y prioridad.
 *
 * El core solo difiere la carga de las imágenes que traen width y height, y las del tema no
 * los traen porque no vienen de la Biblioteca de medios. Este filtro los toma del archivo.
 *
 * @package CampoData\Tema
 */

namespace CampoData\Tema;

defined( 'ABSPATH' ) || exit;

add_filter( 'render_block_core/image', __NAMESPACE__ . '\\completar_imagen_del_tema', 10, 2 );

/**
 * Carpetas del tema cuyas imágenes completa el filtro.
 */
const CARPETAS_DE_IMAGENES = array( 'assets/images/sistema/', 'assets/images/apoyos/' );

/**
 * Agrega width, height, loading y fetchpriority a las imágenes de las carpetas del tema.
 *
 * Con la clase cd-sin-diferir la imagen se carga de inmediato (es lo primero que se ve), y con
 * cd-prioridad, además, antes que el resto. Las demás se cargan al acercarse.
 *
 * @param string $html   HTML del bloque.
 * @param array  $bloque Bloque analizado.
 * @return string
 */
function completar_imagen_del_tema( string $html, array $bloque ): string {
	$carpeta = null;
	foreach ( CARPETAS_DE_IMAGENES as $candidata ) {
		if ( str_contains( $html, get_theme_file_uri( $candidata ) ) ) {
			$carpeta = $candidata;
			break;
		}
	}
	if ( null === $carpeta ) {
		return $html;
	}
	$procesador = new \WP_HTML_Tag_Processor( $html );
	if ( ! $procesador->next_tag( 'img' ) ) {
		return $html;
	}
	$archivo = get_theme_file_path( $carpeta . wp_basename( (string) wp_parse_url( (string) $procesador->get_attribute( 'src' ), PHP_URL_PATH ) ) );
	if ( null === $procesador->get_attribute( 'width' ) && is_readable( $archivo ) ) {
		$medidas = medidas_de_imagen( $archivo );
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

/**
 * Ancho y alto de una imagen del tema. En un SVG, los toma de los atributos width y height
 * de su raíz (los logos de assets/images/apoyos/ los traen sin unidades).
 *
 * @param string $archivo Ruta del archivo.
 * @return array{0: int, 1: int}|null
 */
function medidas_de_imagen( string $archivo ): ?array {
	if ( str_ends_with( $archivo, '.svg' ) ) {
		$inicio = (string) file_get_contents( $archivo, false, null, 0, 2048 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Archivo local del tema.
		if ( preg_match( '/<svg\b[^>]*\swidth="([\d.]+)"[^>]*\sheight="([\d.]+)"/', $inicio, $partes ) ) {
			return array( (int) round( (float) $partes[1] ), (int) round( (float) $partes[2] ) );
		}
		return null;
	}
	$medidas = wp_getimagesize( $archivo );
	return $medidas ? array( (int) $medidas[0], (int) $medidas[1] ) : null;
}
