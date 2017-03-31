<?php
/*khai bao hang gia tri
	@THEME_URL
	@CORE
*/
define('THEME_URL', get_stylesheet_directory_uri());
define('CORE',THEME_URL."/core");

/**
@Nhung file /core/init.php
**/

require_once(CORE."/init.php");

/**
Thiet lap chieu rong noi dung 
**/
if(!isset($content_width)){
	$content_width = 620;
}

/**
Khai bao chuc nang theme
**/
if (!function_exists('thachpham_theme_setup')) {
	function thachpham_theme_setup() {
		/** thiet lap textdomain */
		$language_folder = THEME_URL.'/languages';
		load_theme_textdomain( 'thachpham', $language_folder );

		/**tu dong them link rss len the head*/
		add_theme_support( 'automatic-feed-links' );

		/**them post thumbnail **/
		add_theme_support( 'post-thumbnails' );

		/** post format  **/
		add_theme_support( 'post-formats', array( 'aside', 'gallery','image','link', 'quote', 'status', 'video', 'audio' ,'chat') );

		/**them title tag**/
		add_theme_support( 'title-tag' );

		/**custom background**/
		add_theme_support( 'custom-background', array('default-color'=> '#7c7c7c'));

		/**them menu**/
		register_nav_menu('primary-menu' ,__('Primary Menu', 'thachpham') );

		/**tao sidebar**/
		register_sidebar( array(
								'name'          => __( 'Main Sidebar', 'thachpham' ),
								'id'            => 'main-sidebar',
								'description'   => __('Default Sidebar'),
							    'class'         => 'main-sidebar',
								//'before_widget' => '<li id="%1$s" class="widget %2$s">',
								//'after_widget'  => '</li>',
								'before_title'  => '<h3 class="widgettitle">',
								'after_title'   => '</h3>' ));
	}

	add_action('init','thachpham_theme_setup');
}

/**thachpham_header**/
if (!function_exists('thachpham_header')) {
	function thachpham_header() { ?>
		<div class="site-name">
			<?php if(is_home()){
			 printf('<h1><a href="%1$s" title="%2$s">%3$s</a></h1>', get_bloginfo('url'),get_bloginfo('description'),get_bloginfo('name')); 
				} else {
					printf('<h3><a href="%1$s" title="%2$s">%3$s</a></h3>', get_bloginfo('url'),get_bloginfo('description'),get_bloginfo('name')); 
				}

			?> 
		</div>
		<div class="site-description">
			<?php bloginfo('description') ?>
		</div>

		<?php }}

/**lap menu**/
if (!function_exists('thachpham_menu')) {
	function thachpham_menu($menu) { 
		$menu = array(
			'theme_location'=> $menu,
			'container' => 'nav',
			'container_class'=>$menu,
			'items_wrap'=>'<ul id="%1$s" class="%2$s sf-menu">%3$s</ul>'
			);

		wp_nav_menu($menu);
	}}
/**phan trang**/
if (!function_exists('thachpham_pagination')) {
	function thachpham_pagination() {
		if($GLOBALS['wp_query']->max_num_pages < 2) {
			return '';
		} ?>
	
	<nav class="pagination" role="navigation">
		<?php if(get_next_posts_link() ):?>
			<div class="prev">
				<?php next_posts_link(__('Older Post','thachpham')); ?>
			</div>
		<?php endif ?>

		<?php if(get_previous_posts_link() ):?>
			<div class="next">
				<?php previous_posts_link(__('News Post','thachpham')); ?>
			</div>
		<?php endif ?>
	</nav>

<?php
	 }}

/** Hien thi thumbnail */

if (!function_exists('thachpham_thumbnail')) {
	function thachpham_thumbnail($size) { 

		if (!is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('image')) :?>
		
				<figure class="post-thumbnail">
					<?php the_post_thumbnail($size); ?>

				</figure>
		<?php endif; ?>

		<?php 
	}}

/** Hien thi tieu de post */

if (!function_exists('thachpham_entry_header')) {
	function thachpham_entry_header() { ?>
			<?php if (is_single()): ?>
				<h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

			<?php else: ?>

				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<?php endif ?>


		<?php 
	}}
/** lay du lieu post */
if (!function_exists('thachpham_entry_meta')) {
	function thachpham_entry_meta() { ?>
			<?php  if (!is_page()) :?>
				<div class="entry-meta">
					<?php  printf(__('<span class="author">Posted by %1$s </span>','thachpham'),
					get_the_author( )
					);

					printf(__('<span class="date-published">at %1$s </span>','thachpham'),
					get_the_modified_date() // get_the_modified_date()
					);

					printf(__('<span class="category">in %1$s</span>','thachpham'),
					get_the_category_list(', ') 
					);

					if(comments_open()): 
						echo '<span class="meta-reply">';
						comments_popup_link(__('Leave a comment','thachpham'),
							__('One comment','thachpham'),
							__('% comment','thachpham'),
							__('One comment','thachpham'),
							__('Read all comments','thachpham') );
						echo "</span>";
					endif
					?>
				</div>
			<?php endif ?>

		<?php 
	}}
/** hien thi noi dung post,page */	

if (!function_exists('thachpham_entry_content')) {
	function thachpham_entry_content() { ?>
			<?php if(!is_single() && !is_page()){
				the_excerpt();
				}else{
					the_content( );
					/** phan trang trong single */
					$link_pages  = array(
						'before' => __('<p>Page: ','thachpham'),
						'after' => '</p>',
						'nextpagelink' => __('Next Page','thachpham'),
						'previouspagelink' => __('Previous Page','thachpham')
						 );
					wp_link_pages( $link_pages );
					} ?>
		<?php 
	}}

/** nut read more */

function thachpham_readmore(){
	return '<a class="read-more" href="'.get_permalink(get_the_ID()).'">'.__('[Read more...]','thachpham').'</a>';
}

add_filter('excerpt_more','thachpham_readmore')	;

/** hien thi tag */

if (!function_exists('thachpham_entry_tag')) {
	function thachpham_entry_tag() { 
					if (has_tag()):
						echo '<div class="entry-tag">';
						printf(__('Tagged in %1$s','thachpham'),get_the_tag_list('', ','));
						echo '</div>';
						endif;
				
	}}

/**Nhung CSS**/
function thachpham_style(){
	wp_register_style('main-style',THEME_URL.'/style.css', 'all');
	wp_enqueue_style('main-style');

	wp_register_style('reset-style',THEME_URL.'/reset.css', 'all');
	wp_enqueue_style('reset-style');

/*supperfish menu*/
	wp_register_style('superfish-style',THEME_URL.'/superfish.css', 'all');
	wp_enqueue_style('superfish-style');

	wp_register_script('superfish-script',THEME_URL.'/superfish.js', array('jquery'));
	wp_enqueue_script('superfish-script');


	/*Custom script */
		wp_register_script('custom-script',THEME_URL.'/custom.js', array('jquery'));
	wp_enqueue_script('custom-script');
}

add_action('wp_enqueue_scripts','thachpham_style');




















