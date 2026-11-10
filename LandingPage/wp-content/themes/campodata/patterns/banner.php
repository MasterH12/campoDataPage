<?php
/**
 * Title: Banner
 * Slug: campodata/banner
 * Categories: campodata
 * Description: Banner oscuro con el campo de píxeles animado: el título, los botones y una pantalla del sistema con el celular encima, que flota y se inclina con el mouse.
 *
 * @package CampoData\Tema
 */

?>
<!-- wp:group {"tagName":"section","anchor":"inicio","align":"full","className":"is-style-seccion-noche cd-banner","gradient":"brillo-noche","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section id="inicio" class="wp-block-group alignfull is-style-seccion-noche cd-banner has-brillo-noche-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"cd-banner-columnas","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center cd-banner-columnas">
		<!-- wp:column {"verticalAlignment":"center","width":"56%","className":"cd-banner-texto"} -->
		<div class="wp-block-column is-vertically-aligned-center cd-banner-texto" style="flex-basis:56%">
			<!-- wp:paragraph {"className":"is-style-pildora"} -->
			<p class="is-style-pildora">Nueva tecnología para el campo</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"className":"is-style-titulo-marca"} -->
			<h1 class="wp-block-heading is-style-titulo-marca">Gestión <strong>simple y efectiva</strong> para tu predio lechero</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"large"} -->
			<p class="has-large-font-size">Nos adaptamos a la tecnología y la maquinaria que ya tiene tu predio. Ordenamos sus datos y te mostramos, en simple, qué mirar hoy, cuánto alimento te queda y cómo va la producción contra tu meta.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/#demo">Solicitar demo gratis</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"is-style-outline"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/#reportes">Ver el sistema</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"44%","className":"cd-banner-panel"} -->
		<div class="wp-block-column is-vertically-aligned-center cd-banner-panel" style="flex-basis:44%">
			<!-- wp:group {"className":"cd-panel","layout":{"type":"default"}} -->
			<div class="wp-block-group cd-panel">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-pantalla cd-sin-diferir cd-prioridad"} -->
				<figure class="wp-block-image size-full cd-pantalla cd-sin-diferir cd-prioridad"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/banner-hoy.webp' ) ); ?>" alt="Pantalla Hoy de Producción en CampoData: dos avisos de qué mirar hoy y los días de alimento que quedan"/></figure>
				<!-- /wp:image -->

				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-telefono cd-banner-telefono cd-sin-diferir"} -->
				<figure class="wp-block-image size-full cd-telefono cd-banner-telefono cd-sin-diferir"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/banner-movil-inicio.webp' ) ); ?>" alt="Inicio de CampoData en el celular: litros totales, litros por cabeza y calidad de la leche"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-chip cd-chip-fuentes","fontSize":"x-small"} -->
				<p class="cd-chip cd-chip-fuentes has-x-small-font-size">Se adapta a la tecnología de tu predio</p>
				<!-- /wp:paragraph -->

				<!-- wp:group {"className":"cd-chip cd-chip-recomendacion","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group cd-chip cd-chip-recomendacion">
					<!-- wp:paragraph {"className":"cd-chip-rotulo","fontSize":"x-small"} -->
					<p class="cd-chip-rotulo has-x-small-font-size">Qué mirar hoy</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"cd-chip-texto"} -->
					<p class="cd-chip-texto">Ordeña primavera-verano: sobró 6 % en el comedero (lo habitual es 3 %).</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->
