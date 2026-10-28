<?php
/**
 * Configuración del tema: patrones propios y el año del pie de página.
 *
 * @package CampoData\Tema
 */

namespace CampoData\Tema;

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', __NAMESPACE__ . '\\quitar_patrones_del_core' );
add_filter( 'should_load_remote_block_patterns', '__return_false' );
add_action( 'init', __NAMESPACE__ . '\\registrar_categoria_de_patrones' );
add_action( 'init', __NAMESPACE__ . '\\registrar_fuente_del_anio' );

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
