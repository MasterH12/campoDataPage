<?php
/**
 * Plugin Name: CampoData Core
 * Description: Funcionalidad propia del sitio que no depende del tema: seguridad básica, datos de contacto, SEO y protecciones del entorno local.
 * Version: 0.1.0
 * Requires at least: 7.0
 * Requires PHP: 8.3
 * License: GPL-2.0-or-later
 *
 * WordPress solo carga los archivos PHP de la raíz de mu-plugins: este archivo carga los demás.
 *
 * @package CampoData\Core
 */

namespace CampoData\Core;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/campodata-core/seguridad.php';
require_once __DIR__ . '/campodata-core/contacto.php';
require_once __DIR__ . '/campodata-core/seo.php';

if ( 'local' === wp_get_environment_type() ) {
	require_once __DIR__ . '/campodata-core/entorno-local.php';
}
