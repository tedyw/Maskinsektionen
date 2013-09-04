<?php 
	query_posts( array(
	'numberposts' => -1,
	'orderby'=> 'menu_order',
	'post__in' =>	array(getpostid("Priser och öppettider")),
	'post_type'=>	'page') 
	); 
?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'background' );
			$url = $thumb['0'];
		?>	
		<?php if (has_post_thumbnail()) : ?>
		<div class="post-box autocolor image top t" style="background-image:url(<?php echo $url?>)"></div>
		<?php endif; ?>
		<div id="<?php echo $post->post_name; ?>" data-magellan-destination="<?php echo $post->post_name; ?>" class="post-box t presentation white-bg">
			<div class="tc vm">
				<div class="row">
				    <article id="post-<?php the_ID(); ?>" <?php post_class("twelve columns"); ?>>
				        <div class="entry-content">
				        	<?php the_content(); ?>
				        </div>	
				    </article>
				</div>
			</div>
		</div>
	<?php endwhile; // end of the loop. ?>
<?php wp_reset_query() ?>