<?php
/**
 * Title: Solicitar demo
 * Slug: campodata/demo
 * Categories: campodata
 * Description: El cierre: la oferta de la demo, los botones de WhatsApp y correo y el formulario que arma el mensaje de WhatsApp. Los datos salen de Ajustes → Datos de contacto.
 *
 * @package CampoData\Tema
 */

?>
<!-- wp:group {"tagName":"section","anchor":"demo","align":"full","className":"is-style-seccion-noche cd-demo","gradient":"cierre","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section id="demo" class="wp-block-group alignfull is-style-seccion-noche cd-demo has-cierre-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|70"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:paragraph {"className":"is-style-ceja"} -->
			<p class="is-style-ceja"><strong>06</strong>Solicitar demo</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"is-style-pildora"} -->
			<p class="is-style-pildora">Sin tarjeta de crédito · Sin compromiso · 14 días gratis</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading -->
			<h2 class="wp-block-heading">Empieza a potenciar tu predio hoy</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"large"} -->
			<p class="has-large-font-size">Prueba CampoData 14 días sin costo. Te hacemos una demo personalizada con los datos de tu propio predio para que veas el resultado antes de decidir.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"metadata":{"bindings":{"url":{"source":"campodata/contacto","args":{"campo":"whatsapp_url"}}}}} -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#demo">Escribir por WhatsApp</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"is-style-outline","metadata":{"bindings":{"url":{"source":"campodata/contacto","args":{"campo":"correo_url"}}}}} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#demo">Solicitar demo por correo</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

			<!-- wp:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size">Demo personalizada con los datos de tu predio · Soporte en español · Sin letra chica</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"className":"cd-datos","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group cd-datos">
				<!-- wp:paragraph {"className":"cd-dato cd-dato-correo","metadata":{"bindings":{"content":{"source":"campodata/contacto","args":{"campo":"correo"}}}}} -->
				<p class="cd-dato cd-dato-correo">[Correo de contacto]</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"cd-dato cd-dato-telefono","metadata":{"bindings":{"content":{"source":"campodata/contacto","args":{"campo":"telefono"}}}}} -->
				<p class="cd-dato cd-dato-telefono">[Teléfono y WhatsApp]</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"cd-dato cd-dato-zona","metadata":{"bindings":{"content":{"source":"campodata/contacto","args":{"campo":"zona"}}}}} -->
				<p class="cd-dato cd-dato-zona">[Zona]</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:group {"className":"is-style-cristal cd-tarjeta-formulario","layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-cristal cd-tarjeta-formulario"><!-- wp:html -->
<form class="cd-formulario" novalidate>
	<p><label for="cd-nombre">Tu nombre</label><input id="cd-nombre" name="nombre" type="text" autocomplete="name" placeholder="Nombre y apellido" required></p>
	<p><label for="cd-predio">Predio o empresa (opcional)</label><input id="cd-predio" name="predio" type="text" autocomplete="organization" placeholder="Fundo, lechería o empresa"></p>
	<fieldset class="cd-opciones">
		<legend>¿Quién eres?</legend>
		<div>
			<label><input type="radio" name="perfil" value="Dueño de lechería" data-perfil="lecheria" checked><span>Dueño de lechería</span></label>
			<label><input type="radio" name="perfil" value="Ganadero" data-perfil="ganadero"><span>Ganadero</span></label>
			<label><input type="radio" name="perfil" value="Asesor" data-perfil="asesor"><span>Asesor</span></label>
			<label><input type="radio" name="perfil" value="Otro" data-perfil="otro"><span>Otro</span></label>
		</div>
	</fieldset>
	<p class="cd-error" role="alert" hidden>Escribe tu nombre para armar el mensaje.</p>
	<button type="submit" class="wp-element-button">Pedir mi demo por WhatsApp</button>
	<p class="cd-nota">Al enviar se abre WhatsApp con tu mensaje ya escrito. No guardamos tus datos.</p>
</form>
<!-- /wp:html --></div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
