<?php get_header(); ?>

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
		
			<div class="post">
	
				<h2 class="posttitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			
				<p class="postmeta"> 
				<?php the_time('F j, Y') ?> @ <?php the_time() ?> 
				&#183; <?php _e('Filed under'); ?> <?php the_category(', ') ?>
				<?php edit_post_link(__('Edit'), ' &#183; ', ''); ?>
				</p>
			
				<div class="postentry">
				<?php the_content("<p>Read the rest of this entry &raquo;</p>"); ?>
				</div>
			
				<p class="postfeedback">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>" class="permalink"><?php _e('Permalink'); ?></a>
				<?php comments_popup_link(__('Comments'), __('Comments (1)'), __('Comments (%)'), 'commentslink', __('Comments off')); ?>
				</p>
				
				<!--
				<?php trackback_rdf(); ?>
				-->
			
			</div>
				
		<?php endwhile; ?>
		<div class="footnav">
			<div class="alignleft"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>
		</div>
	<?php else : ?>

		<h2><?php _e('Not Found'); ?></h2>

		<p><?php _e('Sorry, but the page you requested cannot be found.'); ?></p>
		
		<h3><?php _e('Search'); ?></h3>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>