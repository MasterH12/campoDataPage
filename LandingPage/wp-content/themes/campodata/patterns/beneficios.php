<?php
/**
 * Title: Beneficios
 * Slug: campodata/beneficios
 * Categories: campodata
 * Description: Seis beneficios en una grilla tipo bento de 4 columnas (2 en tablet y 1 en móvil), con un foco de luz que sigue al mouse. Solo llevan imagen las tarjetas que tienen una pantalla del sistema que muestra lo mismo que dicen.
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
		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-brote cd-ancha","style":{"layout":{"columnSpan":2,"rowSpan":1},"@tablet":{"layout":{"columnSpan":2,"rowSpan":1}},"@mobile":{"layout":{"columnSpan":1,"rowSpan":1}},"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-brote cd-ancha">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/reloj.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Ahorra tiempo</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Lo que antes tomaba horas de planillas y cálculos, ahora lo tienes en segundos.</p>
			<!-- /wp:paragraph -->

			<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco"} -->
			<figure class="wp-block-image size-full cd-marco"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/beneficio-dias-de-alimento.webp' ) ); ?>" alt="“Cuánto queda”: días de alimento que quedan de concentrado, silo de ballica, heno de alfalfa y silo de maíz"/><figcaption class="wp-element-caption">Los días de alimento que quedan, calculados solos con lo medido y lo que gastan las recetas.</figcaption></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-acento","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-acento">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/rayo.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Qué mirar hoy</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Cada mañana, los avisos de lo que se salió de lo normal, para actuar a tiempo.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-cielo","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-cielo">
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

			<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco"} -->
			<figure class="wp-block-image size-full cd-marco"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/beneficio-sobras.webp' ) ); ?>" alt="Sobras en el comedero: 6 %, cuando lo habitual es 3 %"/><figcaption class="wp-element-caption">Sobras en el comedero de la ordeña: 6 %, cuando lo habitual es 3 %.</figcaption></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-surco","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-surco">
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

		<!-- wp:group {"className":"is-style-tarjeta cd-tarjeta cd-beneficio cd-color-primario cd-ancha","style":{"layout":{"columnSpan":2,"rowSpan":1},"@tablet":{"layout":{"columnSpan":2,"rowSpan":1}},"@mobile":{"layout":{"columnSpan":1,"rowSpan":1}},"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
		<div class="wp-block-group is-style-tarjeta cd-tarjeta cd-beneficio cd-color-primario cd-ancha">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-icono"} -->
			<figure class="wp-block-image size-full cd-icono"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/iconos/ampolleta.svg' ) ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Decisiones con respaldo</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Con datos de tu propio predio, y con la advertencia de cuándo el dato no alcanza para concluir.</p>
			<!-- /wp:paragraph -->

			<!-- wp:image {"lightbox":{"enabled":true},"sizeSlug":"full","linkDestination":"none","className":"cd-marco"} -->
			<figure class="wp-block-image size-full cd-marco"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sistema/beneficio-dato-no-alcanza.webp' ) ); ?>" alt="Datos cruzados de litros contra grasa, con el aviso de que con 9 días medidos no alcanza para concluir si se mueven juntos"/><figcaption class="wp-element-caption">“Con 9 días medidos a la vez no alcanza para decirlo (hacen falta 30).”</figcaption></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
