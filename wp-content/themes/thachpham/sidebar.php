<?php 
if(is_active_sidebar('main-sidebar')):
	dynamic_sidebar('main-sidebar' );
else:
	_e('This is sidebar. you have to add some widgets','thachpham');
endif;
 ?>