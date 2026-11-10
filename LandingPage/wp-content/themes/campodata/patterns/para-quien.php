<?php
/**
 * Title: Para quién
 * Slug: campodata/para-quien
 * Categories: campodata
 * Description: Una tarjeta por perfil (dueños de lecherías y asesores). Cada tarjeta lleva a la demo con su perfil ya elegido en el formulario.
 *
 * @package CampoData\Tema
 */

?>
<!-- wp:group {"tagName":"section","anchor":"para-quien","align":"full","className":"is-style-seccion-base cd-para-quien","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section id="para-quien" class="wp-block-group alignfull is-style-seccion-base cd-para-quien" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:paragraph {"align":"wide","className":"is-style-ceja"} -->
	<p class="alignwide is-style-ceja"><strong>01</strong>Para quién</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"align":"wide"} -->
	<h2 class="wp-block-heading alignwide">Hecho para quienes viven del campo</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"wide","className":"cd-intro","fontSize":"large"} -->
	<p class="alignwide cd-intro has-large-font-size">Ya sea que administres tu propio predio o asesores a varios, CampoData ordena tus datos y te muestra, en simple, qué mirar.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"align":"wide","className":"cd-perfiles cd-escalonado","style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"17rem"}} -->
	<div class="wp-block-group alignwide cd-perfiles cd-escalonado" style="margin-top:var(--wp--preset--spacing--60)">
		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-perfil cd-perfil-lecheria","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-perfil cd-perfil-lecheria">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/balde.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Dueños de lecherías</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"contraste"} -->
			<p class="has-contraste-color has-text-color">Sabe cada mañana cómo viene tu predio, sin abrir una planilla.</p>
			<!-- /wp:paragraph -->

			<!-- wp:list {"className":"is-style-lista-check"} -->
			<ul class="wp-block-list is-style-lista-check"><!-- wp:list-item -->
				<li>Producción diaria contra tu meta, con cada cambio de dieta.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Cuántos días de alimento te quedan y cuándo pedir.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Nos adaptamos a los equipos y la maquinaria que ya tienes.</li>
				<!-- /wp:list-item --></ul>
			<!-- /wp:list -->

			<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco"} -->
			<figure class="wp-block-image size-full cd-marco"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/perfil-lecheria-inicio.webp' ) ); ?>" alt="Resumen de una lechería en CampoData: litros, sólidos, animales en ordeña, preñez, ingreso por la leche, gasto y margen"/><figcaption class="wp-element-caption">Litros, calidad, rebaño, reproducción y margen en una pantalla</figcaption></figure>
			<!-- /wp:image -->

			<!-- wp:paragraph {"className":"cd-quiero-demo"} -->
			<p class="cd-quiero-demo"><a href="/#demo">Quiero una demo →</a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-perfil cd-perfil-asesor","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-perfil cd-perfil-asesor">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/portapapeles.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Asesores</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"contraste"} -->
			<p class="has-contraste-color has-text-color">Llega a cada visita con los números del predio ya ordenados.</p>
			<!-- /wp:paragraph -->

			<!-- wp:list {"className":"is-style-lista-check"} -->
			<ul class="wp-block-list is-style-lista-check"><!-- wp:list-item -->
				<li>Producción, dieta y calidad en la misma línea de tiempo.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Explícame: por qué cambió un número, en palabras simples.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Todos tus predios desde una misma cuenta.</li>
				<!-- /wp:list-item --></ul>
			<!-- /wp:list -->

			<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco"} -->
			<figure class="wp-block-image size-full cd-marco"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/perfil-asesor-explicame.webp' ) ); ?>" alt="“Explícame” en CampoData: los kilos bajaron 10 % y la variación se explica por el rebaño, con dos gráficos"/><figcaption class="wp-element-caption">Explícame: por qué cambió un número, en palabras simples</figcaption></figure>
			<!-- /wp:image -->

			<!-- wp:paragraph {"className":"cd-quiero-demo"} -->
			<p class="cd-quiero-demo"><a href="/#demo">Quiero una demo →</a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
