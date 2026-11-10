<?php
/**
 * Title: Apoyos del proyecto
 * Slug: campodata/apoyos
 * Inserter: no
 * Description: Los logos de quienes apoyan el proyecto, en el pie: Instituto 3IE, Red de Mentores 3IE y "Proyecto apoyado por Corfo". Son los archivos oficiales en su versión para fondo oscuro; van sin marco ni sombra y con aire alrededor, como pide el manual de marca (DECISIONS D27).
 *
 * @package CampoData\Tema
 */

?>
<!-- wp:group {"align":"wide","className":"cd-pie-apoyos","style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group alignwide cd-pie-apoyos">
	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-logo-apoyo cd-logo-3ie"} -->
	<figure class="wp-block-image size-full cd-logo-apoyo cd-logo-3ie"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/apoyos/logo-3ie.svg' ) ); ?>" alt="Instituto 3IE: Instituto Internacional para la Innovación Empresarial, Universidad Técnica Federico Santa María"/></figure>
	<!-- /wp:image -->

	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-logo-apoyo cd-logo-red-de-mentores"} -->
	<figure class="wp-block-image size-full cd-logo-apoyo cd-logo-red-de-mentores"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/apoyos/logo-red-de-mentores-3ie.svg' ) ); ?>" alt="Red de Mentores 3IE"/></figure>
	<!-- /wp:image -->

	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"cd-logo-apoyo cd-logo-corfo"} -->
	<figure class="wp-block-image size-full cd-logo-apoyo cd-logo-corfo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/apoyos/logo-corfo.svg' ) ); ?>" alt="Proyecto apoyado por Corfo"/></figure>
	<!-- /wp:image -->
</div>
<!-- /wp:group -->
