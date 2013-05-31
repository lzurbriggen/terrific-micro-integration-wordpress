<?php
// Include Terrific-Micro
require_once(TEMPLATEPATH."/terrific/index.php");

add_action('wp_print_styles', 'terrific_styles');
//add_action('init', 'terrific_init');
add_action('wp_footer', 'terrific_footer');
add_action('admin_bar_menu', 'terrific_adminbar_menu', 1000);
	
function terrific_styles(){
	// Add terrific css
	wp_register_style('terrific', get_template_directory_uri() . '/terrific/app.css', array(), null);
	wp_enqueue_style('terrific');
}

function terrific_footer(){
	// Add terrific js
?>
	<script src="<?php echo get_template_directory_uri() ?>/terrific/app.js"></script>
	<script>
	(function($) {
		$(document).ready(function() {
			var application = new Tc.Application($('html'), {});
			application.registerModules();
			application.start();
		});
	})(Tc.$);
	</script>
<?php
}

function terrific_adminbar_menu() {
	global $wp_admin_bar;

	$wp_admin_bar->add_menu(
		array(	'id' => 'terrific-flush',
				'title' => __( 'Flush Terrific Cache' ),
				'href' => get_template_directory_uri() . '/terrific/flush.php'
		)
	);
}


?>