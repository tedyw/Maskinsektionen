<?php
/**
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.3.0
 *
 * Template Name: Scroller
 *
 */

get_header(); ?>

<?php if(is_front_page()): ?>
<section data-magellan-destination="news" id="news" class="screen news">
	<div class="inner">
		<div class="row">	
			<?php       $args = array(
	                        'post_type' => 'post',
	                        'posts_per_page' => 4,
	                        'order' => 'DESC',
	                        'orderby' => 'date'
	                        );
	                    $news = new WP_Query($args);
            			if($news->have_posts()):
            ?>
        	<div class="twelve columns"><h1><?php _e("Latest", "maskinsektionen") ?></h1></div>
            <?php while ($news->have_posts()) : $news->the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class("twelve columns"); ?>>
				<div class="row">
					<div class="six columns">
						<?php if(has_post_thumbnail()): the_post_thumbnail("wide"); else: ?>
						<div class="placeholder hide-for-small">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/placeholder-wide.jpg" />
						</div>
						<?php endif; ?>
					</div>
					<div class="six columns">
						<header class="entry-header">
							<?php if ( is_single() ) : ?>
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<?php else: ?>
							<h1 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'requiredfoundation' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h1>
							<?php endif; // is_single() ?>
						</header><!-- .entry-header -->
						<div class="entry-meta">
							<?php required_posted_on(); ?>
							<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
							<span class="label radius secondary"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'requiredfoundation' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _ex( 'Featured', 'Post format title', 'requiredfoundation' ); ?></a></span>
							<?php endif; ?>
						</div><!-- .entry-meta -->
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
					</div>
				</div>
			</article><!-- #post-<?php the_ID(); ?> -->
			<?php
				endwhile;
				endif; 
				wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>
<?php get_template_part("content", "scroller"); ?>
<?php get_footer(); ?>
	