<?php
/**
 * The default template for displaying content single/search/archive
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.3.0
 */
?>
	<!-- START: content.php -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php the_post_thumbnail("full"); ?>
			<?php else : ?>
			<?php the_post_thumbnail("full"); ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'requiredfoundation' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php required_posted_on(); ?>
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="label radius secondary"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'requiredfoundation' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _ex( 'Featured', 'Post format title', 'requiredfoundation' ); ?></a></span>
			<?php endif; ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'requiredfoundation' ) ); ?>
			<a title="<?php the_title(); ?>" href="<?php echo get_field("document"); ?>"><?php _e("Link to document", "maskinekstionen")?></a>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'requiredfoundation' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : ?>
			<?php get_template_part('entry-meta', get_post_format() ); ?>
			<?php endif; ?>
		</footer><!-- #entry-meta -->

	</article><!-- #post-<?php the_ID(); ?> -->
	<!-- END: content.php -->