<?php
get_header();
?>


<?php
	require_once('../config.php');
//	$base_dir = '../';
//	include '../db.php';
//	include '../sidebarsql.php';


?>

	<body>
		<header>
			<h1>IIT UBF</h1>
			<nav>
<?
		include('../menu.php');
?>				
			</nav>
		</header>

		<section id="main">

<?php

	include $base_dir.'side.php';

?>


<div id='content'>

	<div id='contentb'>
		<img src='<? echo $root;?>images/blog-sbhdr.jpg' />
		<div id='contentc'>

<!--<h1 id="wp_header"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>-->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php the_date('','<h2>','</h2>'); ?>

<div class="post" id="post-<?php the_ID(); ?>">
	 <h3 class="storytitle"><a class='wp' href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	<div class="meta"><?php _e("Filed under:"); ?> <?php the_category(',') ?> &#8212; <?php the_author_meta('display_name') ?> @ <?php the_time() ?> <?php edit_post_link(__('Edit This')); ?></div>

	<div class="storycontent">
		<?php the_content("Continue reading <b><i>" . the_title('', '', false))."</i></b>"; ?>
	</div>

	<div class="feedback">
		<?php wp_link_pages(); ?>
		<?php //comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
	</div>

</div>

<?php comments_template(); // Get wp-comments.php template ?>

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>



<?php //get_footer(); ?>





		</div>


	</div>




</div>
</section>

<?
	require_once('../footer.php');
?>