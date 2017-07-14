<?php
class Settings_Woocommerce_Styler extends Woocommerce_Styler{


	/**
	 * Start up
	 */
	public function __construct(){
		add_action( 'admin_menu', array( $this, 'add_settings_pages' ), 25 );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_settings_pages(){
		// This page will be under "Settings"
		
	

            $this->plugin_screen_hook_suffix['woo_shop_styler'] =  add_submenu_page( 'swoo-grid', __( 'Customize Shop', $this->plugin_slug ), __( 'Customize Shop', $this->plugin_slug ), 'manage_options', 'woo_shop_styler', array( $this, 'create_admin_page' ) );
			add_action( 'admin_print_styles-' . $this->plugin_screen_hook_suffix['woo_shop_styler'], array( $this, 'enqueue_admin_stylescripts' ) );


	

            $this->plugin_screen_hook_suffix['woo_product_styler'] =  add_submenu_page( 'swoo-grid', __( 'Customize Products', $this->plugin_slug ), __( 'Customize Products', $this->plugin_slug ), 'manage_options', 'woo_product_styler', array( $this, 'create_admin_page' ) );
			add_action( 'admin_print_styles-' . $this->plugin_screen_hook_suffix['woo_product_styler'], array( $this, 'enqueue_admin_stylescripts' ) );


	}

	/**
	 * Options page callback
	 */
	public function create_admin_page(){
		// Set class property        
		$screen = get_current_screen();
		$base = array_search($screen->id, $this->plugin_screen_hook_suffix);

		include self::get_path( __FILE__ ) . 'settings-' . $base . '.php';

			// Display the admin form   
			//$configfiles = glob( self::get_path( dirname( __FILE__ ) ) .'configs/' . $base . '-*.php' );
			if(file_exists(self::get_path( dirname( __FILE__ ) ) .'configs/fieldgroups-'.$base.'.php')){
				include self::get_path( dirname( __FILE__ ) ) .'configs/fieldgroups-'.$base.'.php';		
			}else{
				return;
			}

			$groups = array();
			
			$slug = "_" . $base . "_options";

			$instance = get_option( $slug );
			foreach ($configfiles as $key=>$fieldfile) {
				include $fieldfile;
				$group['id'] = uniqid( $base );
				$groups[] = $group;
			}			
			echo "<input type=\"hidden\" name=\"".$slug."[__cur_tab__]\" id=\"__cur_tab__\" value=\"".(!empty($instance['__cur_tab__']) ? $instance['__cur_tab__'] : 0)."\">";
			if(count($groups) > 1){
				echo "<div class=\"woocommerce-styler-settings-config-nav\">\r\n";
				echo "	<ul>\r\n";
					foreach ($groups as $key=>$group) {
						echo "		<li class=\"" . ( !empty($instance['__cur_tab__']) ? ($instance['__cur_tab__'] == $key ? "current" : "") : ($key === 0 ? "current" : "" )) . "\">\r\n";
						echo "			<a data-tabkey=\"".$key."\" data-tabset=\"__cur_tab__\" title=\"".$group['label']."\" href=\"#row".$group['id']."\"><strong>".$group['label']."</strong></a>\r\n";
						echo "		</li>\r\n";
					}
				echo "	</ul>\r\n";
				echo "</div>\r\n";
			}
			echo "<div class=\"woocommerce-styler-settings-config-content " . ( count($groups) > 1 ? "" : "full" ) . "\">\r\n";
			foreach ($groups as $key=>$group) {	
				echo "<div id=\"row".$group['id']."\" class=\"woocommerce-styler-groupbox group\" " . ( !empty($instance['__cur_tab__']) ? ($instance['__cur_tab__'] == $key ? "" : "style=\"display:none;\"") : ($key === 0 ? "" : "style=\"display:none;\"" )) . ">\r\n";
				if(count($groups) > 1){
					echo "<h3>".$group['label']."</h3>";
				}				
				$this->settings_group($group, $instance, "_" . $base . "_options");
				echo "</div>\r\n";
			}
			echo "</div>\r\n";

			submit_button( __('Save Changes', 'woocommerce-styler') ); 

		echo "		</form>\r\n";
		echo "	</div>\r\n";
	}

	/**
	 * Register and add settings
	 */
	public function page_init(){
		register_setting(
			'woo_shop_styler',
			'_woo_shop_styler_options'
		);
register_setting(
			'woo_product_styler',
			'_woo_product_styler_options'
		);

	}

	/**
	 * Generates a group of fields for the settings page.
	 *
	 */
	// build instance
	public function settings_group($group, $instance, $slug){
		
		$depth = 1;

		foreach($group['fields'] as $field=>$settings){         
			if(!empty($instance[$field]) && !empty($group['multiple'])){
				if(count($instance[$field]) > $depth){
					$depth = count($instance[$field]);
				}
			}
		}

		for( $i=0; $i<$depth;$i++ ){
				if($i > 0){
					echo '  <div class="button button-primary right woocommerce-styler-removeRow" style="margin:5px 5px 0;">'.__('Remove', 'woocommerce-styler').'</div>';
				}           
			echo "<div class=\"form-table rowGroup groupitems\" id=\"groupitems\" ref=\"items\">\r\n";
				foreach($group['fields'] as $field=>$settings){
					$id = 'field_'.$field.'_'.$i;
					$groupid = $group['id'];
					$name = $slug . '[' . $field . ']';
					$single = true;
					$value = $settings['default'];
					if(!empty($group['multiple'])){
						$name = $slug . '[' . $field . ']['.$i.']';
						if(isset($instance[$field][$i])){
							$value = $this->sanitize($instance[$field][$i]);
						}
					}else{
						if(isset($instance[$field])){
							$value = $this->sanitize($instance[$field]);
						}
					}
					$label = $settings['label'];
					$caption = (!empty($settings['caption']) ? $settings['caption'] : null);
					
					echo '<div class="woocommerce-styler-field-row"><label class="woocommerce-styler_settings_label" for="'.$id.'">'.$label.'</label>';
					include self::get_path( dirname( __FILE__ ) ) . 'includes/field-'.$settings['type'].'.php';
					if(!empty($caption)){
						echo '<p class="description">'.$caption.'</p>';
					}
					echo '</div>';

				}
			echo "</div>\r\n";
		}
		if(!empty($group['multiple'])){
			echo "<div class=\"woocommerce-styler-addRow\"><button class=\"button woocommerce-styler-add-group-row\" type=\"button\" data-field=\"ref-".$group['id']."\" data-rowtemplate=\"group-".$group['id']."-tmpl\">".__('Add Another', 'woocommerce-styler')."</button></div>\r\n";
		}
		
		// Place html template for repeated fields.
		if(!empty($group['multiple'])){
			echo "<script type=\"text/html\" id=\"group-".$group['id']."-tmpl\">\r\n";
			echo '  <div class="button button-primary right woocommerce-styler-removeRow" style="margin:5px 5px 0;">'.__('Remove', 'woocommerce-styler').'</div>';
			echo "  <div class=\"form-table rowGroup groupitems\" id=\"groupitems\" ref=\"items\">\r\n";
				foreach($group['fields'] as $field=>$settings){
					//dump($settings);
					$id = 'field_{{id}}_'.$field;
					$groupid = $group['id'];
					$name = $slug . '[' . $field . ']';
					$single = true;
					if(!empty($group['multiple'])){
						$name = $slug . '[' . $field . '][__count__]';
					}
					$label = $settings['label'];
					$caption = (!empty($settings['caption']) ? $settings['caption'] : null);
					$value = $settings['default'];
					echo '<div class="woocommerce-styler-field-row"><label class="woocommerce-styler_settings_label" for="'.$id.'">'.$label.'</label>';
					include self::get_path( dirname( __FILE__ ) ) . 'includes/field-'.$settings['type'].'.php';
					if(!empty($caption)){
						echo '<p class="description">'.$caption.'</p>';
					}
					echo '</div>';
				}
			echo "  </div>\r\n";
			echo "</script>";
		}
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ){

		if( is_array( $input )){
			foreach ($input as &$value) {
				$value = htmlentities($value);
			}
		}else{
			$input = htmlentities($input);
		}
		return $input;
	}

	

	/***
	 * Get the current URL
	 *
	 */
	static function get_url($src = null, $path = null) {
		if(!empty($path)){
			return plugins_url( $src, $path);
		}
		return trailingslashit( plugins_url( $path , __FILE__ ) );
	}

	/***
	 * Get the current URL
	 *
	 */
	static function get_path($src = null) {
		return plugin_dir_path( $src );

	}

}

if( is_admin() )
	$settings_woocommerce_styler = new Settings_woocommerce_styler();
