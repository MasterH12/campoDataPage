<?php
/**
 * Title: Reportes
 * Slug: campodata/reportes
 * Categories: campodata
 * Description: Pantallas y recortes del sistema, con datos de un campo de demostración, en pestañas dentro de un marco de aplicación (Producción, Calidad, Ensayos y Equipo). Las imágenes están en assets/images/sistema/ (spec 04).
 *
 * @package CampoData\Tema
 */

?>
<!-- wp:group {"tagName":"section","anchor":"reportes","align":"full","className":"is-style-seccion-noche cd-reportes","gradient":"brillo-noche","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section id="reportes" class="wp-block-group alignfull is-style-seccion-noche cd-reportes has-brillo-noche-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:paragraph {"align":"wide","className":"is-style-ceja"} -->
	<p class="alignwide is-style-ceja"><strong>03</strong>Reportes</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"align":"wide"} -->
	<h2 class="wp-block-heading alignwide">Mira CampoData por dentro</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"wide","className":"cd-intro","fontSize":"large"} -->
	<p class="alignwide cd-intro has-large-font-size">Así se ve CampoData con los datos de un campo de demostración: la producción contra tu meta, con cada cambio de dieta, la calidad de la leche explicada según el contrato con la planta, los ensayos de alimentación y los permisos de tu equipo.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"align":"wide","className":"is-style-ventana","style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide is-style-ventana" style="margin-top:var(--wp--preset--spacing--60)">
		<!-- wp:group {"className":"cd-ventana-barra","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group cd-ventana-barra">
			<!-- wp:paragraph {"className":"cd-ventana-titulo","fontSize":"small"} -->
			<p class="cd-ventana-titulo has-small-font-size">CampoData — El sistema</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"is-style-pildora cd-pildora-viva"} -->
			<p class="is-style-pildora cd-pildora-viva">Datos de demostración</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:tabs -->
		<div class="wp-block-tabs"><!-- wp:tab-list -->
			<div role="tablist" class="wp-block-tab-list"><button type="button" role="tab">Producción</button><button type="button" role="tab">Calidad</button><button type="button" role="tab">Ensayos</button><button type="button" role="tab">Equipo</button></div>
			<!-- /wp:tab-list -->

			<!-- wp:tab-panels -->
			<div class="wp-block-tab-panels">
				<!-- wp:tab-panel {"label":"Producción"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-pantalla-reporte"} -->
				<figure class="wp-block-image size-full cd-pantalla-reporte"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/reportes-produccion.webp' ) ); ?>" alt="Producción en CampoData: litros por día contra la meta de 8.500 y el tope del estanque, con los siete cambios de dieta marcados"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Producción:</strong> los litros de cada día contra tu meta y el tope del estanque. Cada cambio de dieta queda marcado, para ver qué comían las vacas cuando cambió la producción.</p>
				<!-- /wp:paragraph --></section>
				<!-- /wp:tab-panel -->

				<!-- wp:tab-panel {"label":"Calidad"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-pantalla-reporte"} -->
				<figure class="wp-block-image size-full cd-pantalla-reporte"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/reportes-calidad.webp' ) ); ?>" alt="Calidad de la leche en CampoData: grasa, proteína, UFC, RCS y urea, y la explicación de cuándo la leche no cumple el contrato con la planta"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Calidad:</strong> grasa, proteína, UFC, RCS y urea, y cuántos análisis quedaron fuera del contrato con la planta, explicado en simple.</p>
				<!-- /wp:paragraph --></section>
				<!-- /wp:tab-panel -->

				<!-- wp:tab-panel {"label":"Ensayos"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:group {"className":"cd-panel-doble","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"18rem"}} -->
				<div class="wp-block-group cd-panel-doble"><!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco"} -->
				<figure class="wp-block-image size-full cd-marco"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/reportes-ensayo-resultados.webp' ) ); ?>" alt="Resultado de un ensayo de alimentación: la muestra C con -0,5 % y la muestra B con +5,3 % de litros contra el rebaño en ordeña"/></figure>
				<!-- /wp:image -->

				<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco"} -->
				<figure class="wp-block-image size-full cd-marco"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/reportes-ensayo-indice.webp' ) ); ?>" alt="Índice de litros por vaca de las muestras A, B y C, antes y después del inicio del ensayo"/></figure>
				<!-- /wp:image --></div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Ensayos de alimentación:</strong> prueba una receta en un grupo de vacas y compárala con el resto del rebaño en ordeña, con las muestras identificadas solo por letra.</p>
				<!-- /wp:paragraph --></section>
				<!-- /wp:tab-panel -->

				<!-- wp:tab-panel {"label":"Equipo"} -->
				<section role="tabpanel" tabindex="0" class="wp-block-tab-panel"><!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco cd-panel-equipo"} -->
				<figure class="wp-block-image size-full cd-marco cd-panel-equipo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/reportes-equipo-permisos.webp' ) ); ?>" alt="Permisos del equipo en CampoData: por cada perfil, qué módulos puede ver, crear, editar o borrar"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"cd-leyenda","fontSize":"small"} -->
				<p class="cd-leyenda has-small-font-size"><strong>Equipo:</strong> tú eliges qué módulos puede ver, crear o editar cada persona del predio, según su perfil.</p>
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
