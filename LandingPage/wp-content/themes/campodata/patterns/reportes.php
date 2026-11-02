<?php
/**
 * Title: Reportes reales
 * Slug: campodata/reportes
 * Categories: campodata
 * Description: Las capturas de reportes reales en pestañas, dentro de un marco de aplicación. Para reemplazar una captura, cambia su archivo en assets/images/reportes/.
 *
 * @package CampoData\Tema
 */

?>
<!-- wp:group {"tagName":"section","anchor":"reportes","align":"full","className":"is-style-seccion-noche cd-reportes","gradient":"brillo-noche","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section id="reportes" class="wp-block-group alignfull is-style-seccion-noche cd-reportes has-brillo-noche-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:paragraph {"align":"wide","className":"is-style-ceja"} -->
	<p class="alignwide is-style-ceja"><strong>03</strong>Reportes reales</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"align":"wide"} -->
	<h2 class="wp-block-heading alignwide">Mira lo que CampoData puede mostrarte</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"wide","className":"cd-intro","fontSize":"large"} -->
	<p class="alignwide cd-intro has-large-font-size">Estos son reportes reales que usamos con nuestros clientes: producción diaria, distribución de animales, alimentación, inventario y más. Todo en un solo lugar.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"align":"wide","className":"is-style-ventana","style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide is-style-ventana" style="margin-top:var(--wp--preset--spacing--60)">
		<!-- wp:group {"className":"cd-ventana-barra","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group cd-ventana-barra">
			<!-- wp:paragraph {"className":"cd-ventana-titulo","fontSize":"small"} -->
			<p class="cd-ventana-titulo has-small-font-size">CampoData — Reportes interactivos</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"className":"cd-ventana-pildoras","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group cd-ventana-pildoras">
				<!-- wp:paragraph {"className":"is-style-pildora cd-pildora-viva"} -->
				<p class="is-style-pildora cd-pildora-viva">Dashboard activo</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"is-style-pildora cd-sin-punto"} -->
				<p class="is-style-pildora cd-sin-punto">Ene 2023 – Ago 2025</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"is-style-pildora cd-sin-punto"} -->
				<p class="is-style-pildora cd-sin-punto">~2.000 vacas / ejemplo</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:tabs -->
		<div class="wp-block-tabs"><!-- wp:tab-list -->
			<div role="tablist" class="wp-block-tab-list"><button type="button" role="tab">Producción Leche</button><button type="button" role="tab">Distribución Animales</button><button type="button" role="tab">Resumen Diario</button><button type="button" role="tab">Inventario Animal</button></div>
			<!-- /wp:tab-list -->

			<!-- wp:tab-panels -->
			<div class="wp-block-tab-panels">
				<!-- wp:tab-panel {"label":"Producción Leche"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-captura"} -->
				<figure class="wp-block-image size-full cd-captura"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/reportes/produccion-leche.webp' ) ); ?>" alt="Reporte Producción Leche: tabla diaria por turno y gráficos de producción mensual y diaria"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Producción Leche:</strong> Seguimiento diario mañana/tarde, variación porcentual, consumo de maíz y soya, y totales históricos desde 2023. Todo filtrable por período con un slider.</p>
				<!-- /wp:paragraph --></section>
				<!-- /wp:tab-panel -->

				<!-- wp:tab-panel {"label":"Distribución Animales"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-captura"} -->
				<figure class="wp-block-image size-full cd-captura"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/reportes/distribucion-animales.webp' ) ); ?>" alt="Reporte Distribución Animales: vacas en ordeña, en estanque, enfermas, en engorda, cojas y reproductoras"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Distribución Animales:</strong> Vacas en ordeña, vacas estanque, enfermas, engorda, cojas y reproductoras. Partos, calostros y tendencia histórica de 2 años.</p>
				<!-- /wp:paragraph --></section>
				<!-- /wp:tab-panel -->

				<!-- wp:tab-panel {"label":"Resumen Diario"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-captura"} -->
				<figure class="wp-block-image size-full cd-captura"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/reportes/resumen-diario.webp' ) ); ?>" alt="Reporte Resumen Diario: tabla por día con cabezas, porcentaje de ordeña, litros, mortalidad, tratamientos y alimentación"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Resumen Diario:</strong> Tabla completa con cabezas, % ordeño, litros totales, L/C por lote, mortalidad, tratamientos, y detalle de alimentación (soya, maíz, sales, raps, etc.) por cada día.</p>
				<!-- /wp:paragraph --></section>
				<!-- /wp:tab-panel -->

				<!-- wp:tab-panel {"label":"Inventario Animal"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-captura"} -->
				<figure class="wp-block-image size-full cd-captura"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/reportes/inventario-animal.webp' ) ); ?>" alt="Reporte Inventario Animal: estanque completo por categoría y registro de salidas, muertes y ventas"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Inventario Animal:</strong> Seguimiento diario de estanque completo: vacas lecheras, secas, pre-parto, calostro, crianza (H0-H45), más registro de salidas, muertes y ventas con causa y lote.</p>
				<!-- /wp:paragraph --></section>
				<!-- /wp:tab-panel -->
			</div>
			<!-- /wp:tab-panels --></div>
		<!-- /wp:tabs -->
	</div>
	<!-- /wp:group -->

	<!-- wp:buttons {"align":"wide","className":"cd-reportes-accion","layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons alignwide cd-reportes-accion">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/#demo">Quiero ver mis datos así</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
