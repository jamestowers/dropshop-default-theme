<div id="sidebar" class="sidebar pad col4 last group" role="complementary">

	<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>

		<?php dynamic_sidebar( 'sidebar' ); ?>

	<?php else : ?>

		<?php // This content shows up if there are no widgets defined in the backend. ?>

		<div class="alert alert-help">
			<p><?php _e( 'Please activate some Widgets.', 'dropshoptheme' );  ?></p>
		</div>

	<?php endif; ?>

</div>