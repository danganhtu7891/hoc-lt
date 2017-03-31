<?php get_header(); ?>

<div id="content">
	<div id="main-content">
			<?php if(have_posts()):while(have_posts()):the_post(); ?>

				<?php get_template_part('content',get_post_format()); ?>
				<?php get_template_part('author-bio'); ?>
				<?php  if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;?>
					

				
			<?php endwhile ?>

				

			<?php else: ?>

			<?php get_template_part('content','none'); ?>

		<?php endif; ?>
	</div>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>

</div>


<?php get_footer(); ?>