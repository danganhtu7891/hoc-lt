<?php /*
   		Template Name: Contact
       **/
 ?>

 <?php get_header(); ?>

<div class="content">
	<div class="main-content">
		<div class="contact-info">
			<h4>Địa Chỉ liên hệ</h4>
			<p>Kungua 13, Swe</p>
			<p>076.222.222</p>
		</div>
		<div class="contact-form">
			<?php echo do_shortcode('[contact-form-7 id="1390" title="Contact form 1"]'); ?>
		</div>
	</div>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div>

</div>


<?php get_footer(); ?>