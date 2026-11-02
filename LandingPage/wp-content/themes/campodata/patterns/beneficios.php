<?php
/**
 * Title: Beneficios
 * Slug: campodata/beneficios
 * Categories: campodata
 * Description: Seis beneficios en una grilla tipo bento de 4 columnas (2 en tablet y 1 en móvil), con un foco de luz que sigue al mouse.
 *
 * @package CampoData\Tema
 */

?>
<!-- wp:group {"tagName":"section","anchor":"beneficios","align":"full","className":"is-style-seccion-base cd-beneficios","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section id="beneficios" class="wp-block-group alignfull is-style-seccion-base cd-beneficios" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:paragraph {"align":"wide","className":"is-style-ceja"} -->
	<p class="alignwide is-style-ceja"><strong>04</strong>Beneficios</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"align":"wide"} -->
	<h2 class="wp-block-heading alignwide">Lo que cambia en tu predio desde el primer mes</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"align":"wide","className":"cd-bento cd-escalonado","style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"top":"var:preset|spacing|60"}},"@tablet":{"layout":{"columnCount":2}},"@mobile":{"layout":{"columnCount":1}}},"layout":{"type":"grid","columnCount":4}} -->
	<div class="wp-block-group alignwide cd-bento cd-escalonado" style="margin-top:var(--wp--preset--spacing--60)">
		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-cielo cd-ancha","style":{"layout":{"columnSpan":2,"rowSpan":1},"@tablet":{"layout":{"columnSpan":2,"rowSpan":1}},"@mobile":{"layout":{"columnSpan":1,"rowSpan":1}},"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-cielo cd-ancha">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/calendario.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Mejor gestión diaria</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Empieza el día sabiendo exactamente en qué lote enfocarte y por qué.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-acento","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-acento">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/rayo.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Recomendaciones para hoy</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>No análisis para el mes que viene. Acciones concretas que puedes aplicar ahora mismo.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-brote","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-brote">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/reloj.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Ahorra tiempo</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Lo que antes tomaba horas de planillas y cálculos, ahora lo tienes en segundos.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-primario","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-primario">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/ampolleta.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Decisiones más inteligentes</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Con datos reales de tu propio predio, dejas de adivinar y empiezas a decidir con certeza.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-pradera","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-pradera">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/espiga.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Optimización alimentaria</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Detecta dónde estás gastando más de lo necesario en soya, maíz o concentrado.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-surco cd-ancha","style":{"layout":{"columnSpan":2,"rowSpan":1},"@tablet":{"layout":{"columnSpan":2,"rowSpan":1}},"@mobile":{"layout":{"columnSpan":1,"rowSpan":1}},"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-surco cd-ancha">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/tendencia.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Mejora continua real</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>No solo mides: identificas oportunidades concretas de subir producción y reducir costos.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
