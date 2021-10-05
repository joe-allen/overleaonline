<?php
/**
 * Footer
 *
 * Global site footer. Closes <main> that is started in header.php
 *
 * @package Vitamin\Vanilla_Theme\Core_Components
 * @author  Vitamin
 * @version 1.0.0
 */

use Timber\Timber;
use Timber\Menu;

?>

		</main>

		<?php
			$context         = Timber::context();
			$context['menu'] = new Menu( 'footer_nav' );
			Timber::render( 'footer/footer.twig', $context );
		?>

		<?php wp_footer(); ?>
	</body>
</html>
