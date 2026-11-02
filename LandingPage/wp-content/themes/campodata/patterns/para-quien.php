<?php
/**
 * Title: Para quién
 * Slug: campodata/para-quien
 * Categories: campodata
 * Description: Una tarjeta por perfil (dueños de lecherías, ganaderos y asesores). Cada tarjeta lleva a la demo con su perfil ya elegido en el formulario.
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
	<p class="alignwide cd-intro has-large-font-size">Ya sea que administres tu propio predio o asesores a varios, CampoData ordena tus datos y te dice qué hacer con ellos.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"align":"wide","className":"cd-perfiles cd-escalonado","style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"17rem"}} -->
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
				<li>Producción diaria por turno y por lote.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Dónde se va el gasto en soya, maíz o concentrado.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Nos adaptamos a los equipos y la maquinaria que ya tienes.</li>
				<!-- /wp:list-item --></ul>
			<!-- /wp:list -->

			<!-- wp:paragraph {"className":"cd-quiero-demo"} -->
			<p class="cd-quiero-demo"><a href="/#demo">Quiero una demo →</a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-perfil cd-perfil-ganadero","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-perfil cd-perfil-ganadero">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/vaca.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Ganaderos</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"contraste"} -->
			<p class="has-contraste-color has-text-color">[Qué gana un predio ganadero con CampoData, en una frase. Confirmar qué datos de ganadería de carne se usan]</p>
			<!-- /wp:paragraph -->

			<!-- wp:list {"className":"is-style-lista-check"} -->
			<ul class="wp-block-list is-style-lista-check"><!-- wp:list-item -->
				<li>Inventario al día: salidas, muertes y ventas con causa y lote.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>[Un dato propio de la ganadería de carne que CampoData ordene: por ejemplo, pesajes o ganancia diaria de peso. Confirmar]</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Decisiones con datos reales de tu propio predio.</li>
				<!-- /wp:list-item --></ul>
			<!-- /wp:list -->

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
				<li>Reportes claros para compartir con el productor y su equipo.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>Recomendaciones accionables, no jerga estadística.</li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li>[Si CampoData permite ver varios predios desde una misma cuenta, decirlo aquí. Confirmar]</li>
				<!-- /wp:list-item --></ul>
			<!-- /wp:list -->

			<!-- wp:paragraph {"className":"cd-quiero-demo"} -->
			<p class="cd-quiero-demo"><a href="/#demo">Quiero una demo →</a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
