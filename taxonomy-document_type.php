<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */
get_header(); ?>

	<!-- Row for main content area -->
	<div id="content" class="row">

		<div id="main" class="eight columns" role="main">
			<div class="post-box">
			<?php if ( have_posts() ) : ?>

				<h1><?php
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					 *
					 * We reset this later so we can run the loop
					 * properly with a call to rewind_posts().
					 */
					the_post();

					/* Get the archive title for the specific archive we are
					 * dealing with.
					 */
					echo single_term_title("", false);

					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();
				?></h1>

				<div class="category-list">
					<?php _e("Categories", "maskinsektionen"); ?>: 
					<?php 

						$terms = get_terms( "document_category"); 

						$count = count($terms); $i=0;
						if ($count > 0) {
						    $cape_list = '<p class="my_term-archive">';
						    foreach ($terms as $term) {
						        $i++;
						    	$term_list .= '<a href="' . get_term_link( $term ) . '" title="' . sprintf(__('View all post filed under %s', 'maskinsektionen'), $term->name) . '">' . $term->name . '</a>';
						    	if ($count != $i) $term_list .= ', '; else $term_list .= '</p>';
						    }
						    echo $term_list;
						}
					?>
				</div>

				<table>
	            	<thead>
	            		<th><?php _e("Document", "maskinsektionen"); ?></th>
	            		<th><?php _e("Category", "maskinsektionen"); ?></th>
						<th><?php _e("Published", "maskinsektionen"); ?></th>

	            	</thead>
	            	<?php while (have_posts()) : the_post(); ?>
	            	<tr>
	            		<td><a title="<?php the_title(); ?>" href="<?php echo get_field("document"); ?>"><?php the_title(); ?></a></td>
						<td><?php echo get_the_term_list( get_the_ID(), "document_category", '', ', ' ); ?></td>
						<td><?php required_posted_on(); ?></td>

					</tr>
					<?php endwhile; wp_reset_postdata(); // end of the loop. ?> 
	            </table>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			<?php if ( function_exists( 'required_pagination' ) ) {
				required_pagination();
			} ?>

			</div>
		</div>

		<aside id="sidebar" class="four columns" role="complementary">
			<div class="sidebar-box">
				<?php get_sidebar(); ?>
			</div>
		</aside><!-- /#sidebar -->
	</div>
<?php get_footer(); ?>