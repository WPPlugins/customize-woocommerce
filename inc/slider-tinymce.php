<?php
/*	 TinyMCE Shortcode Custom Button Settings
 *   Author: Saragna
 *   Profile: http://codecanyon.net/user/saragna?ref=saragna
 */
/**
 * tinymce external plugin js file
 */
function wpgel_woo_grid_add_tinymce_plugin($plugin_array) {
	$plugin_array['woogridshortcodes'] = plugins_url( ltrim( '../assets/js/slider-tinymce.js', '/' ), __FILE__ );
	return $plugin_array;
}
/**
 * tinymce add buttons
 */
function wpgel_woo_grid_add_tinymce_button($buttons) {
	array_push($buttons, 'woogridshortcodes');
	return $buttons;
}

/**
 * Adding tinymce
 */
function wpgel_woo_grid_add_tinymce() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
		return;
		
	add_filter('mce_external_plugins', 'wpgel_woo_grid_add_tinymce_plugin');
	add_filter('mce_buttons', 'wpgel_woo_grid_add_tinymce_button');
}
add_action('admin_head', 'wpgel_woo_grid_add_tinymce');

function wpgel_woo_grid_print_shortcodes_in_js() {	
	global $wpdb,$woo_grid_table;
	$shortcodes = $wpdb->get_results("select * from ".$wpdb->prefix.$woo_grid_table);
	?>
	<style type="text/css">.mce-i-spost-grid { background:url(<?php echo plugins_url( ltrim( '../assets/image/icon.png', '/' ), __FILE__ );?>) no-repeat !important; }</style>
	<script type="text/javascript">
		var wpgel_woo_grid_shortcodes = [];
		<?php if($shortcodes) {
			$shortcode_count = 0;
			foreach($shortcodes as $shortcode) { ?>
				wpgel_woo_grid_shortcodes[<?php echo $shortcode_count; ?>] = {
					'text'		: '<?php echo ($shortcode_count+1).': '.$shortcode->slider_title; ?>',
					'onclick'	: function() {
						tinymce.execCommand('mceInsertContent', false, '[wpgel_woo_grid id="<?php echo $shortcode->id; ?>"]');
					}
				}
		<?php $shortcode_count++;
			}
		}?>
	</script>
	<?php
}
add_action('admin_head', 'wpgel_woo_grid_print_shortcodes_in_js');