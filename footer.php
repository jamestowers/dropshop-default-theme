				</div> <!-- close wrapper -->
					
			<div id="footer-asides" class="group">

			  <?php dynamic_sidebar( 'footer-sidebar' ); ?>

			</div>

			<nav role="navigation" id="nav-footer">
				<?php dropshop_nav_footer(); ?>
			</nav>

			<footer class="footer group">

				<p class="small source-org">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>

			</footer>

		</div> <!-- close wrapper -->

		<?php wp_footer(); ?>

	</body>

</html>
