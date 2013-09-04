<?php while ( have_posts() ) : the_post(); ?>			

<section data-magellan-destination="<?php the_title(); ?>" id="<?php the_title(); ?>" class="screen screen-<?php echo $post->post_name; ?>" data-magellan-destination="<?php echo $post->post_name; ?>">
	<div class="inner">
		<article id="post-<?php the_ID(); ?>" >
			<header class="entry-header">
				<?php if (has_post_thumbnail( $post->ID )) : 
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
				?>				
		    	<div class="entry-thumbnail ">
		    		<div class="main-image-container">
		    			<div class="image" style="background-image:url(<?php echo $image[0];  ?>)" title="<?php the_title(); ?>">
		    				<div class="frame">
		    					<div class="triangle"></div>
		    				</div>
		    			</div>
		    		</div>
		    	</div>
		    	<?php endif; ?>
		    	<div class="title-container <?php if (has_post_thumbnail( $post->ID )) : ?>circle<?php endif; ?>">
	    			<div class="circle-inner">
		    			<h1 class="entry-title">
		    				<?php the_title(); ?>
		    			</h1>
	    			</div>
	    		</div>
			</header>
			<div class="row">
				<div <?php post_class('twelve columns'); ?>>
		            <div class="entry-content">
		            	<?php the_content(); ?>
		        	</div>
				</div>
			</div>
		</article>

		<?php if($post->post_name == "dokument"): ?>

	 		<?php       $args = array(
                        'post_type' => 'document',
                        'posts_per_page' => 5,
                        'order' => 'ASC',
                        'orderby' => 'menu_order'
                        );     
            ?>
            <?php $superiors = new WP_Query($args);
            if($superiors->have_posts()):?>
            <div class="row document-list">
	            <table class="eight columns">
	            	<thead>
	            		<th><?php _e("Document", "maskinsektionen"); ?></th>
	            		<th><?php _e("Category", "maskinsektionen"); ?></th>
						<th><?php _e("Published", "maskinsektionen"); ?></th>
						<th><?php _e("Description", "maskinsektionen") ?></th>
	            	</thead>
	            	<?php while ($superiors->have_posts()) : $superiors->the_post(); ?>
	            	<tr>
	            		<td><a title="<?php the_title(); ?>" href="<?php echo get_field("document"); ?>"><?php the_title(); ?></a></td>
						<td><?php echo get_the_term_list( get_the_ID(), "document_type", '', ', ' ); ?></td>
						<td><?php required_posted_on(); ?></td>
						<td><?php the_content(); ?></td>
					</tr>
					<?php endwhile; wp_reset_postdata(); // end of the loop. ?> 
	            </table>
	            <aside id="sidebar" class="four columns" role="complementary">
					<div class="sidebar-box">
						<?php get_sidebar(); ?>
					</div>
				</aside><!-- /#sidebar -->
            </div>	
			<?php endif; ?>
		<?php endif; ?>

	</div>
</section>

<?php endwhile; // end of the loop. ?>

<?php $parent = $post->ID; ?>
<?php $parent_name = $post->post_name; ?>

<?php
query_posts('post_type=page&order=ASC&orderby=menu_order&post_parent='.$parent);
 while (have_posts()) : the_post();
?>

<section data-magellan-destination="<?php echo $post->post_name; ?>" id="<?php echo $post->post_name; ?>" class="screen screen-<?php echo $post->post_name; ?>" data-magellan-destination="<?php echo $post->post_name; ?>">
	<div class="inner">
		<article id="post-<?php the_ID(); ?>" >
			<header class="entry-header">
				<?php if (has_post_thumbnail( $post->ID )) : 
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
				?>				
		    	<div class="entry-thumbnail ">
		    		<div class="main-image-container">
		    			<div class="image" style="background-image:url(<?php echo $image[0];  ?>)" title="<?php the_title(); ?>">
		    				<div class="frame">
		    					<div class="triangle"></div>
		    				</div>
		    			</div>
		    		</div>
		    	</div>
		    	<?php endif; ?>
		    	<div class="title-container <?php if (has_post_thumbnail( $post->ID )) : ?>circle<?php endif; ?>">
	    			<div class="circle-inner">
		    			<h1 class="entry-title">
		    				<?php the_title(); ?>
		    			</h1>
	    			</div>
	    		</div>
			</header>
			<div class="row">
				<div <?php post_class('twelve columns'); ?>>
		            <div class="entry-content">
		            	<?php the_content(); ?>
		        	</div>
				</div>
			</div>
		</article>

		<?php if($post->post_name == "organisation"): ?>

	 		<?php       $args = array(
                        'post_type' => 'organisation',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                        'orderby' => 'menu_order'
                        );     
            ?>
            <?php $superiors = new WP_Query($args);
            if($superiors->have_posts()):?>
            <div class="row">
            	<div class="twelve columns company-container">
					<ul class="block-grid four-up mobile-two-up">
						<?php while ($superiors->have_posts()) : $superiors->the_post(); ?>
						<li class="company">
							<?php if (has_post_thumbnail( $post->ID )) :  ?>
								<?php the_post_thumbnail("square"); ?>
			            	<?php else: ?>
			            		<div class="placeholder">
			            			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.jpg" />
			            		</div>
			            	<?php endif; ?>
						</li>
						<?php endwhile; wp_reset_postdata(); // end of the loop. ?> 
					</ul>
				</div>	
			</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if($post->post_name == "projektgruppen"): ?>

	 		<?php       $args = array(
                        'post_type' => 'superior',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                        'orderby' => 'menu_order'
                        );     
            ?>
            <?php $superiors = new WP_Query($args);
            if($superiors->have_posts()):?>
            <div class="row">
            	<div class="twelve columns company-container">
					<ul class="block-grid four-up mobile-two-up">
						<?php while ($superiors->have_posts()) : $superiors->the_post(); ?>
						<li class="superior">
							<?php if (has_post_thumbnail( $post->ID )) :  
									$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
							?>
			            		<div class="superior-container image-container">
			            			<div class="superior-image" style="background-image:url(<?php echo $image[0];?>)">
			            				<div class="overlay">
			            					<div class="inner">
				            					<div class="email"><span><?php echo str_replace("@", "(at)", get_field("contact-email")); ?></span></div>
				            					<div class="phone"><span><?php echo get_field("contact-phone"); ?></span></div>
				            					<div class="name"><span><?php the_title() ?></span></div>
				            					<div class="title"><span><?php echo get_field("contact-title"); ?></span></div>
			            					</div>
			            				</div>
			            			</div>
			            		</div>
			            	<?php endif; ?>
						</li>
						<?php endwhile; wp_reset_postdata(); // end of the loop. ?> 
					</ul>
				</div>	
			</div>
			<?php endif; ?>
		<?php endif; ?>		

	</div>
</section>

<?php endwhile; // end of the loop. ?>			