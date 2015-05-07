					</div> <!-- close footer -->
					
					<div id="footer-asides" class="clearfix">

			      <?php dynamic_sidebar( 'footer-sidebar' ); ?>

			    </div>

			    <footer class="footer  clearfix" role="contentinfo">

					<nav role="navigation">
						<?php dropshop_footer_links(); ?>
					</nav>

					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>

			</footer>

		</div> <!-- close wrapper -->

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

</html>
