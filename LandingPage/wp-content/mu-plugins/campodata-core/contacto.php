<?php
/**
 * Datos de contacto en una sola fuente: una opción, su pantalla en Ajustes y la fuente de
 * block bindings "campodata/contacto" que usan la sección de demo y el pie.
 *
 * @package CampoData\Core
 */

namespace CampoData\Core;

defined( 'ABSPATH' ) || exit;

const OPCION_CONTACTO = 'campodata_contacto';

add_action( 'init', __NAMESPACE__ . '\\registrar_opcion_de_contacto' );
add_action( 'init', __NAMESPACE__ . '\\registrar_fuente_de_contacto' );
add_action( 'admin_init', __NAMESPACE__ . '\\registrar_campos_de_contacto' );
add_action( 'admin_menu', __NAMESPACE__ . '\\agregar_pantalla_de_contacto' );
add_filter( 'block_bindings_supported_attributes_core/social-link', __NAMESPACE__ . '\\enlazar_url_de_redes' );

/**
 * Campos de la opción: etiqueta, ayuda y cómo se limpia cada uno.
 *
 * @return array
 */
function campos_de_contacto(): array {
	return array(
		'whatsapp'         => array(
			'etiqueta' => 'WhatsApp',
			'ayuda'    => 'Formato internacional, solo dígitos y sin +. Por ejemplo: 569 y los 8 dígitos del celular.',
			'tipo'     => 'digitos',
		),
		'mensaje_whatsapp' => array(
			'etiqueta' => 'Mensaje inicial de WhatsApp',
			'ayuda'    => 'Texto que aparece escrito al abrir WhatsApp desde los botones.',
			'tipo'     => 'texto',
		),
		'telefono'         => array(
			'etiqueta' => 'Teléfono',
			'ayuda'    => 'Tal como se muestra en la página. Por ejemplo: +56 9 1234 5678.',
			'tipo'     => 'texto',
		),
		'correo'           => array(
			'etiqueta' => 'Correo',
			'ayuda'    => 'Correo donde llegan las solicitudes de demo.',
			'tipo'     => 'correo',
		),
		'asunto_correo'    => array(
			'etiqueta' => 'Asunto del correo',
			'ayuda'    => 'Asunto que aparece escrito al abrir el correo desde los botones.',
			'tipo'     => 'texto',
		),
		'zona'             => array(
			'etiqueta' => 'Zona',
			'ayuda'    => 'Dónde atiende CampoData. Por ejemplo: Chile.',
			'tipo'     => 'texto',
		),
		'linkedin'         => array(
			'etiqueta' => 'LinkedIn',
			'ayuda'    => 'Dirección completa de la página. Si queda vacío, el ícono no aparece.',
			'tipo'     => 'url',
		),
		'instagram'        => array(
			'etiqueta' => 'Instagram',
			'ayuda'    => 'Dirección completa del perfil. Si queda vacío, el ícono no aparece.',
			'tipo'     => 'url',
		),
	);
}

/**
 * Registra la opción con todas sus claves vacías por defecto.
 */
function registrar_opcion_de_contacto(): void {
	register_setting(
		'campodata_contacto',
		OPCION_CONTACTO,
		array(
			'type'              => 'array',
			'sanitize_callback' => __NAMESPACE__ . '\\limpiar_datos_de_contacto',
			'default'           => array_fill_keys( array_keys( campos_de_contacto() ), '' ),
			'show_in_rest'      => false,
		)
	);
}

/**
 * Limpia los datos que llegan desde la pantalla de ajustes.
 *
 * @param mixed $valores Valores enviados.
 * @return array
 */
function limpiar_datos_de_contacto( $valores ): array {
	$valores = is_array( $valores ) ? $valores : array();
	$limpios = array();
	foreach ( campos_de_contacto() as $clave => $campo ) {
		$valor             = isset( $valores[ $clave ] ) ? (string) $valores[ $clave ] : '';
		$limpios[ $clave ] = match ( $campo['tipo'] ) {
			'digitos' => preg_replace( '/\D+/', '', $valor ),
			'correo'  => sanitize_email( $valor ),
			'url'     => esc_url_raw( $valor ),
			default   => sanitize_text_field( $valor ),
		};
	}
	return $limpios;
}

/**
 * Devuelve un dato de contacto, o una cadena vacía si no existe.
 *
 * @param string $clave Clave del dato (whatsapp, correo, zona…).
 * @return string
 */
function dato_de_contacto( string $clave ): string {
	$datos = get_option( OPCION_CONTACTO );
	return is_array( $datos ) && isset( $datos[ $clave ] ) ? (string) $datos[ $clave ] : '';
}

/**
 * Registra la fuente de block bindings "campodata/contacto".
 */
function registrar_fuente_de_contacto(): void {
	register_block_bindings_source(
		'campodata/contacto',
		array(
			'label'              => 'Datos de contacto',
			'get_value_callback' => __NAMESPACE__ . '\\valor_de_contacto',
		)
	);
}

/**
 * Valor que pide un bloque con args.campo. Si el dato está vacío devuelve null, y el bloque
 * muestra el texto o la URL de respaldo de su marcado.
 *
 * @param array $argumentos Argumentos del enlace: "campo".
 * @return string|null
 */
function valor_de_contacto( array $argumentos ): ?string {
	$campo = $argumentos['campo'] ?? '';
	$valor = match ( $campo ) {
		'whatsapp_url'  => url_de_whatsapp(),
		'correo_url'    => url_de_correo(),
		'linkedin_url'  => dato_de_contacto( 'linkedin' ),
		'instagram_url' => dato_de_contacto( 'instagram' ),
		'telefono', 'correo', 'zona' => dato_de_contacto( $campo ),
		default         => '',
	};
	return '' === $valor ? null : $valor;
}

/**
 * Enlace de WhatsApp con el mensaje inicial, si lo hay.
 *
 * @return string
 */
function url_de_whatsapp(): string {
	$numero = dato_de_contacto( 'whatsapp' );
	if ( '' === $numero ) {
		return '';
	}
	$mensaje = dato_de_contacto( 'mensaje_whatsapp' );
	return 'https://wa.me/' . $numero . ( '' === $mensaje ? '' : '?text=' . rawurlencode( $mensaje ) );
}

/**
 * Enlace de correo con el asunto, si lo hay.
 *
 * @return string
 */
function url_de_correo(): string {
	$correo = dato_de_contacto( 'correo' );
	if ( '' === $correo ) {
		return '';
	}
	$asunto = dato_de_contacto( 'asunto_correo' );
	return 'mailto:' . $correo . ( '' === $asunto ? '' : '?subject=' . rawurlencode( $asunto ) );
}

/**
 * Permite enlazar la URL de los íconos de redes sociales (social-link) a una fuente.
 *
 * @param array $atributos Atributos que aceptan enlaces.
 * @return array
 */
function enlazar_url_de_redes( array $atributos ): array {
	$atributos[] = 'url';
	return array_values( array_unique( $atributos ) );
}

/**
 * Agrega Ajustes → Datos de contacto.
 */
function agregar_pantalla_de_contacto(): void {
	add_options_page( 'Datos de contacto', 'Datos de contacto', 'manage_options', 'campodata-contacto', __NAMESPACE__ . '\\mostrar_pantalla_de_contacto' );
}

/**
 * Registra la sección y los campos de la pantalla de ajustes.
 */
function registrar_campos_de_contacto(): void {
	add_settings_section( 'campodata_contacto_datos', '', '__return_null', 'campodata-contacto' );
	foreach ( campos_de_contacto() as $clave => $campo ) {
		add_settings_field(
			'campodata_contacto_' . $clave,
			$campo['etiqueta'],
			__NAMESPACE__ . '\\mostrar_campo_de_contacto',
			'campodata-contacto',
			'campodata_contacto_datos',
			array(
				'clave'     => $clave,
				'campo'     => $campo,
				'label_for' => 'campodata-contacto-' . $clave,
			)
		);
	}
}

/**
 * Dibuja un campo de la pantalla de ajustes.
 *
 * @param array $argumentos Clave y definición del campo.
 */
function mostrar_campo_de_contacto( array $argumentos ): void {
	$clave = $argumentos['clave'];
	$tipo  = match ( $argumentos['campo']['tipo'] ) {
		'correo' => 'email',
		'url'    => 'url',
		default  => 'text',
	};
	printf(
		'<input type="%1$s" class="regular-text" id="%2$s" name="%3$s[%4$s]" value="%5$s"><p class="description">%6$s</p>',
		esc_attr( $tipo ),
		esc_attr( $argumentos['label_for'] ),
		esc_attr( OPCION_CONTACTO ),
		esc_attr( $clave ),
		esc_attr( dato_de_contacto( $clave ) ),
		esc_html( $argumentos['campo']['ayuda'] )
	);
}

/**
 * Pantalla Ajustes → Datos de contacto.
 */
function mostrar_pantalla_de_contacto(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<div class="wrap"><h1>Datos de contacto</h1>';
	echo '<p>Estos datos se muestran en la sección "Solicitar demo", en el formulario de WhatsApp y en el pie de la página.</p>';
	echo '<form action="options.php" method="post">';
	settings_fields( 'campodata_contacto' );
	do_settings_sections( 'campodata-contacto' );
	submit_button( 'Guardar los datos' );
	echo '</form></div>';
}
