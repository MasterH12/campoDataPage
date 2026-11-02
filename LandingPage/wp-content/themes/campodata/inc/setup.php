<?php
/**
 * Configuración del tema: patrones propios, estilos de bloque con CSS y el año del pie de página.
 *
 * @package CampoData\Tema
 */

namespace CampoData\Tema;

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', __NAMESPACE__ . '\\quitar_patrones_del_core' );
add_filter( 'should_load_remote_block_patterns', '__return_false' );
add_action( 'init', __NAMESPACE__ . '\\registrar_categoria_de_patrones' );
add_action( 'init', __NAMESPACE__ . '\\registrar_fuente_del_anio' );
add_action( 'init', __NAMESPACE__ . '\\registrar_estilos_de_bloque' );

/**
 * Quita los patrones que trae el core: el insertador solo muestra los del tema.
 */
function quitar_patrones_del_core(): void {
	remove_theme_support( 'core-block-patterns' );
}

/**
 * Registra la categoría donde aparecen los patrones del tema.
 */
function registrar_categoria_de_patrones(): void {
	register_block_pattern_category( 'campodata', array( 'label' => 'CampoData' ) );
}

/**
 * Registra la fuente de datos "campodata/anio", que entrega "© <año actual>".
 *
 * El pie de página la usa para que el año se actualice solo: un texto fijo en el HTML
 * quedaría desactualizado cada 1 de enero.
 */
function registrar_fuente_del_anio(): void {
	register_block_bindings_source(
		'campodata/anio',
		array(
			'label'              => '© y año actual',
			'get_value_callback' => __NAMESPACE__ . '\\anio_con_copyright',
		)
	);
}

/**
 * Valor de la fuente "campodata/anio".
 *
 * @return string Por ejemplo, "© 2026".
 */
function anio_con_copyright(): string {
	return '© ' . wp_date( 'Y' );
}

/**
 * Registra los estilos de bloque que necesitan CSS propio (assets/css/sitio.css).
 *
 * Los que solo usan propiedades de theme.json están en styles/.
 */
function registrar_estilos_de_bloque(): void {
	$estilos = array(
		'core/group'     => array(
			'cristal' => 'Cristal (sobre fondo oscuro)',
			'ventana' => 'Ventana de aplicación',
		),
		'core/paragraph' => array(
			'ceja'    => 'Ceja de sección',
			'pildora' => 'Píldora',
		),
		'core/heading'   => array(
			'titulo-marca' => 'Destacado con el degradado de la marca',
		),
		'core/list'      => array(
			'lista-check' => 'Lista con checks',
		),
		'core/table'     => array(
			'comparacion' => 'Comparación',
		),
	);
	foreach ( $estilos as $bloque => $variantes ) {
		foreach ( $variantes as $nombre => $etiqueta ) {
			register_block_style(
				$bloque,
				array(
					'name'  => $nombre,
					'label' => $etiqueta,
				)
			);
		}
	}
}
