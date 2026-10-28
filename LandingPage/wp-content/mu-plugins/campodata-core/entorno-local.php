<?php
/**
 * Protecciones del entorno local, para cuando se trabaja con una copia de la base de producción.
 * Solo se carga si WP_ENVIRONMENT_TYPE es "local" (ver campodata-core.php).
 *
 * @package CampoData\Core
 */

namespace CampoData\Core;

defined( 'ABSPATH' ) || exit;

// El sitio local nunca se indexa, diga lo que diga la base.
add_filter( 'pre_option_blog_public', '__return_zero' );

// El sitio local nunca envía correos.
add_filter( 'pre_wp_mail', __NAMESPACE__ . '\\anotar_correo_sin_enviar', 10, 2 );

/**
 * En vez de enviar el correo, anota destinatario y asunto en el log de depuración.
 *
 * @param null|bool $resultado Respuesta que corta el envío; null deja que WordPress envíe.
 * @param array     $correo    Argumentos de wp_mail(): to, subject, message, headers y attachments.
 * @return bool Siempre true: para quien llamó a wp_mail(), el correo salió.
 */
function anotar_correo_sin_enviar( $resultado, array $correo ): bool {
	$destinatarios = is_array( $correo['to'] ) ? implode( ', ', $correo['to'] ) : $correo['to'];

	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- En local, el log de depuración es justo el destino buscado.
	error_log( sprintf( 'Correo no enviado (entorno local). Para: %s. Asunto: %s', $destinatarios, $correo['subject'] ) );

	return true;
}
