<?php
	class swoo_class_grid extends Functions_swoo{
		protected static $table_prefix;
		const TABLE_WOO_NAME = 'wps_woo_grid';
		const ver = '1.0';

		public function __construct(){
			global $wpdb;
			ini_set('error_reporting', E_ALL & ~E_STRICT);
			ini_set('display_errors','Off');
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
			add_action('admin_print_scripts',array( $this, 'animate_load_admin_script'));
			add_action('wp_enqueue_scripts',array($this, 'animate_load_scripts'));
			add_action('init',array($this,'swp_woo_variation_script'));
			self::$table_prefix = $wpdb->base_prefix;
			$this->onActivate();
		}

		public function plugin_action_links( $links ) {
			$action_links = array(
				'settings'	=>	'<a href="' . admin_url( 'admin.php?page=swoo-grid' ) . '" title="' . esc_attr( __( 'View Grid Settings', 'spost-grid' ) ) . '">' . __( 'Settings', 'spost-grid' ) . '</a>',
			);
			self::animate_get_options();
			//return array_merge( $links, $action_links );
		}

		function animate_load_admin_script(){

			//wp_enqueue_style( 'animate-slider-css', $this->animate_plugin_url( '../assets/css/animate.css'), array(), '' );
			//wp_enqueue_style( 'animate-chosen-css', $this->animate_plugin_url( '../assets/css/chosen.min.css'), array(), '' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'my-script-handle', '/wp-includes/js/colorpicker.min', array( 'jquery','wp-color-picker' ), false, true );
			//wp_enqueue_script( 'achosen-js', $this->animate_plugin_url( '../assets/js/chosen.jquery.min.js'), array( 'jquery' ), false, true );
			//wp_enqueue_style ( 'wp-jquery-ui-dialog');
			//wp_enqueue_script( 'jquery-ui-core' );
			//wp_enqueue_script( 'jquery-ui-dialog' );

			//for add medie button

			//wp_enqueue_media();
			wp_enqueue_style( 'swoo-admin-css', $this->animate_plugin_url( '../assets/css/admin.css'), array(), '' );
			//wp_enqueue_style( 'animate-slider-style-css', $this->animate_plugin_url( '../assets/css/slider.css'), array(), self::ver, false );
			//wp_enqueue_script( 'imagesloaded-js',  $this->animate_plugin_url( '../assets/js/imagesloaded.pkgd.min.js' ), array( 'jquery' ), self::ver, true );
			//wp_enqueue_script( 'animate-slider-js',  $this->animate_plugin_url( '../assets/js/animate-slider.js' ), array( 'jquery' ), self::ver, true );
			//wp_enqueue_script( 'animate-slider-modernizr-js',  $this->animate_plugin_url( '../assets/js/modernizr.custom.js' ), array( 'jquery' ), self::ver, true );
			//wp_enqueue_script( 'animate-bxslider-js',  $this->animate_plugin_url( '../assets/js/jquery.bxslider.min.js' ), array( 'jquery' ), self::ver, true );

		}

		

		function animate_load_scripts() {

			wp_enqueue_style( 'spost-bootstrap-css', $this->animate_plugin_url( '../assets/css/bootstrap.css'), array(), self::ver, false );
			wp_enqueue_style( 'spost-animate-css', $this->animate_plugin_url( '../assets/css/animate.css'), array(), self::ver, false );
			wp_register_style( 'swoo-css', $this->animate_plugin_url( '../assets/css/css.css'), array(), '' );
			wp_enqueue_style( 'font-awesome-css', $this->animate_plugin_url( '../assets/css/font-awesome.min.css'), array(), '' );
			wp_enqueue_style( 'magnific-popup-css', $this->animate_plugin_url( '../assets/css/magnific-popup.css'), array(), '' );

			wp_enqueue_script( 'imagesloaded-js',  $this->animate_plugin_url( '../assets/js/imagesloaded.pkgd.min.js' ), array( 'jquery' ), self::ver, true );
			wp_enqueue_script( 'spost-isotope-js',  $this->animate_plugin_url( '../assets/js/isotope.pkgd.min.js' ), array( 'jquery' ), self::ver, true );						
			wp_enqueue_script( 'spost-ddslick-js',  $this->animate_plugin_url( '../assets/js/jquery.ddslick.min.js' ), array( 'jquery' ), self::ver, true );
			wp_enqueue_script( 'spost-megnific-js',  $this->animate_plugin_url( '../assets/js/megnific.js' ), array( 'jquery' ), self::ver, true );
			wp_enqueue_script( 'spost-owl-js',  $this->animate_plugin_url( '../assets/js/owl.carousel.min.js' ), array( 'jquery' ), self::ver, true );
			wp_enqueue_script( 'swoo-script-js',  $this->animate_plugin_url( '../assets/js/script.js' ), array( 'jquery' ), self::ver, true );

		}

		function swp_woo_variation_script(){

			wp_enqueue_script( 'wc-add-to-cart-variation' );
			swp_woo_quick_view_action_template();
		}

		

		/**
		 * a must function. please don't remove it.
		 * process activate event - install the db (with delta).
		 */
		public static function onActivate(){
			self::createTable(self::TABLE_WOO_NAME);
		}
		/**
		 * 
		 * craete tables
		 */
		private function createTable($tableName){

			//if table exists - don't create it.
			$tableRealName = self::$table_prefix.$tableName;
			if(self::isDBTableExists($tableRealName))
				return(false);
			
			switch($tableName){
				case self::TABLE_WOO_NAME:					
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  slider_title tinytext NOT NULL,
							  slider_params text NOT NULL,
							  PRIMARY KEY (id)
							);";
				break;
				default:
					FunctionsAni::throwError("table: $tableName not found");
				break;
			}

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		

		/**
		 * 
		 * check if some db table exists
		 */
		public static function isDBTableExists($tableName){
			global $wpdb;
			if(empty($tableName))
				UniteFunctionsRev::throwError("Empty table name!!!");

			$sql = "show tables like '$tableName'";
			$table = $wpdb->get_var($sql);

			if($table == $tableName)
				return(true);
				
			return(false);
		}		

		protected function animate_plugin_url( $path = '' ) {
			return plugins_url( ltrim( $path, '/' ), __FILE__ );
		}
		

		protected function check_slider(){
			$tableRealName = self::$table_prefix.TABLE_WOO_NAME;
		}

		protected function plugin_root_url(){
			return get_site_url().'/wp-admin/admin.php?page=swoo-grid';
		}
	}