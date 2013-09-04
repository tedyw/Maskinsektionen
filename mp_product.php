<?php

get_header(); ?>

	<!-- Row for main content area -->
	<div id="content" class="row">

		<div id="main" class="twelve columns" role="main">
			<div class="post-box">

				<?php while ( have_posts() ) : the_post(); ?>

                    <?php if (has_post_thumbnail( $post->ID)) 
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "square");
                    ?>
                    <?php 
                        $thumbs = array(
                          '1' => get_field("picture_1"),
                          '2' => get_field("picture_2"),  
                          '3' => get_field("picture_3"),  
                          '4' => get_field("picture_4"),  
                          '5' => get_field("picture_5"), 
                        )


                    ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class("product row"); ?>>
                        <div class="entry-image six columns">
                            <div id="active-product-image">
                                <img class="product-thumbnail" src="<?php echo $image[0]; ?>" />   
                            </div>
                            <?php if (!empty($thumbs)){ ?>
                            <div class="product-thumbnails" id="gallery">
                                <ul class="block-grid six-up mobile-three-up">
                                    <?php foreach ($thumbs as $thumb) {?>
                                        <?php if (!empty($thumb)){ ?>
                                        <li><a class="product-thumbnail-link" href="<?php echo $thumb["sizes"]["square"];  ?>"><img class="product-thumbnail" src="<?php echo $thumb["sizes"]["square"];  ?>" data-zoom-image="<?php echo $thumb["sizes"]["square"];  ?>"/></a></li>
                                        <?php } ?>
                                    <?php } ?>
                                    <li>
                                        <a class="product-thumbnail-link" href="<?php echo $image[0]; ?>"><img class="product-thumbnail" src="<?php echo $image[0]; ?>" data-zoom-image="<?php echo $image[0];  ?>"/></a>
                                    </li>
                                </ul>
                            </div>
                            <?php } ?>  
                        </div>  
                        <div class="entry-content six columns">
                            <div class="entry-header">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </div>
                            <?php mp_product_price(); ?>
                            <?php mp_buy_button(); ?>
                            <div class="category-box">
                                <span><?php _e("In Category", "mp")?>: </span><?php echo mp_category_list(); ?>
                            </div>
                            <?php the_content(); ?>
                            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'requiredfoundation' ) . '</span>', 'after' => '</div>' ) ); ?>
                        </div><!-- .entry-content -->
                    </div><!-- #post-<?php the_ID(); ?> -->
                    
                    <aside class="row">
                        <div class="twelve columns">
                            <h3>You might also be interested in...</h3>
                            <?php mp_list_products(true, true, 0, 6, 'sales', 'DESC'); ?>
                        </div>
                    </aside>

				<?php endwhile; // end of the loop. ?>

			</div>
		</div><!-- /#main -->

	</div><!-- End Content row -->

<?php get_footer(); ?>