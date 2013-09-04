<?php

get_header(); ?>

	<!-- Row for main content area -->
	<div id="content" class="row">

		<div id="main" class="twelve columns" role="main">
			<div class="post-box">
				<h1>Products</h1>
				<?php echo mp_products_filter(); ?>
				<?php mp_list_products(); ?>

			</div>
		</div><!-- /#main -->

	</div><!-- End Content row -->

<?php get_footer(); ?>