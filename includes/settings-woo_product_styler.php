        <div class="wrap">
            <h2><?php echo __( 'Customize Products', 'woocommerce-styler'); ?></h2>
            <?php
            	if( !empty( $_GET['settings-updated'] ) && $screen->parent_base != 'options-general' ){
					echo '<div class="updated settings-error" id="setting-error-settings_updated">';
					echo '<p><strong>' . __('Settings saved.', 'woocommerce-styler') . '</strong></p></div>';
				}
            ?>            
            <p><?php echo __("Style WooCommerce Product Page.","woocommerce-styler"); ?></p>
            <form method="post" action="options.php" class="woocommerce-styler-options-form">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'woo_product_styler' );
                do_settings_sections( 'woo_product_styler' );
