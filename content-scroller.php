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
            	<div class="eight columns">
            	<h1><?php _e("Latest Documents", "maskinsektionen"); ?></h1>
	            <table>
	            	<thead>
	            		<th><?php _e("Document", "maskinsektionen"); ?></th>
	            		<th><?php _e("Category", "maskinsektionen"); ?></th>
						<th><?php _e("Published", "maskinsektionen"); ?></th>
						<th class="hide-for-small"><?php _e("Description", "maskinsektionen") ?></th>
	            	</thead>
	            	<?php while ($superiors->have_posts()) : $superiors->the_post(); ?>
	            	<tr>
	            		<td><a title="<?php the_title(); ?>" href="<?php echo get_field("document"); ?>"><?php the_title(); ?></a></td>
						<td><?php echo get_the_term_list( get_the_ID(), "document_category", '', ', ' ); ?></td>
						<td><?php required_posted_on(); ?></td>
						<td class="hide-for-small"><?php the_content(); ?></td>
					</tr>
					<?php endwhile; wp_reset_postdata(); // end of the loop. ?> 
	            </table>
	            <p><a href="<?php echo get_post_type_archive_link( 'document' ); ?>"><button class="button"><?php _e("Browse all here", "maskinsektionen"); ?></button></a></p>
	        	</div>
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
            <?php $organisations = new WP_Query($args);
            if($organisations->have_posts()):?>
            <div class="row">
            	<div class="twelve columns organisation-container">
					<ul class="block-grid four-up mobile-two-up">
						<?php while ($organisations->have_posts()) : $organisations->the_post(); ?>
						<li class="organisation">
							<a class="organisation-link" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
								<?php if (has_post_thumbnail( $post->ID )) :  ?>
									<?php the_post_thumbnail("square"); ?>
				            	<?php else: ?>
				            		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.jpg" />
				            	<?php endif; ?>
				            	<div class="organisation-title"><?php the_title(); ?></div>
			            	</a>
						</li>
						<?php endwhile; wp_reset_postdata(); // end of the loop. ?> 
					</ul>
				</div>	
			</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if($post->post_name == "funktionarer"): ?>

	 		<?php       $args = array(
                        'post_type' => 'steward',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                        'orderby' => 'menu_order'
                        );     
            ?>
            <?php $stewards = new WP_Query($args);
            if($stewards->have_posts()):?>
            <div class="row">
            	<div class="twelve columns organisation-container">
					<ul class="block-grid four-up mobile-two-up">
						<?php while ($stewards->have_posts()) : $stewards->the_post(); ?>
						<li class="organisation">
							<a class="organisation-link" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
				            	<div class="organisation-title"><?php the_title(); ?></div>
			            	</a>
						</li>
						<?php endwhile; wp_reset_postdata(); // end of the loop. ?> 
					</ul>
				</div>	
			</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if($post->post_name == "styrelsen"): ?>

	 		<?php       $args = array(
                        'post_type' => 'board_member',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                        'orderby' => 'menu_order'
                        );     
            ?>
            <?php $superiors = new WP_Query($args);
            if($superiors->have_posts()):?>
            <div class="row">
            	<div class="twelve columns organisation-container">
					<ul class="block-grid four-up mobile-two-up">
						<?php while ($superiors->have_posts()) : $superiors->the_post(); ?>
						<li class="organisation">
							<a class="organisation-link" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
								<?php if (has_post_thumbnail( $post->ID )) :  ?>
									<?php the_post_thumbnail("square"); ?>
				            	<?php else: ?>
				            		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder.jpg" />
				            	<?php endif; ?>
				            	<div class="organisation-title"><?php the_title(); ?></div>
			            	</a>
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