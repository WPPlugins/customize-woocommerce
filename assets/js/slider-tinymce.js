/* Map tinymce scripts */
(function() {
	"use strict";
	tinymce.PluginManager.add( 'woogridshortcodes', function( editor, url ) {
		editor.addButton( 'woogridshortcodes', {
			type	: 'menubutton',
			text	: '',
			icon	: 'swoo-grid',
			tooltip	: 'Customize Woocommerce and Carousel',
			onselect: function(e) {
			},
			menu: wpgel_woo_grid_shortcodes
		});
	});
})();
