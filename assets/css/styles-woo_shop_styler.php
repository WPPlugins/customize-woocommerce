.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page #content input.button {
    font-weight: <?php echo implode(", ", (array)$atts['wcb_font_weight']); ?>;
    border-radius: <?php echo implode(", ", (array)$atts['wcb_border_radius']); ?>px;
    color: <?php echo implode(", ", (array)$atts['wcb_font_color']); ?>;
    border: <?php echo implode(", ", (array)$atts['wcb_border_size']); ?>px <?php echo implode(", ", (array)$atts['wcb_border_type']); ?> <?php echo implode(", ", (array)$atts['wcb_border_color']); ?>;
    background: -moz-linear-gradient(center top , <?php echo implode(", ", (array)$atts['first_gradient_color']); ?> 0%, <?php echo implode(", ", (array)$atts['second_gradient_color']); ?> 100%) repeat scroll 0% 0% transparent;
}

.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page #content input.button:hover {
    background: -moz-linear-gradient(center top , <?php echo implode(", ", (array)$atts['hover_gradient_color_1']); ?> 0%, <?php echo implode(", ", (array)$atts['hover_gradient_color_2']); ?> 100%) repeat scroll 0% 0% transparent;
}

.woocommerce span.onsale, .woocommerce-page span.onsale {
    background: -moz-linear-gradient(center top , <?php echo implode(", ", (array)$atts['sale_bg_gradient_color_1']); ?> 0%, <?php echo implode(", ", (array)$atts['sale_bg_gradient_color_2']); ?> 100%) repeat scroll 0% 0% transparent;
}
.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price {
    color: <?php echo implode(", ", (array)$atts['shp_price_color']); ?>;
	font-size: <?php echo implode(", ", (array)$atts['shp_price_font_size']); ?>px;
    font-weight: <?php echo implode(", ", (array)$atts['shp_font_weight']); ?>;
}
.woocommerce ul.products li.product a img, .woocommerce-page ul.products li.product a img {
    box-shadow: 0px 1px 2px 0px {{si_box_shadow_color}};
}
.woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3 {
	color: <?php echo implode(", ", (array)$atts['prn_color']); ?>;
	font-size: <?php echo implode(", ", (array)$atts['prn_sh_font_size']); ?>px;
	font-weight: <?php echo implode(", ", (array)$atts['prn_sh_font_weight']); ?>;
}
<?php if(yes == $atts['style_products_container']){ ?>
.woocommerce .products ul, .woocommerce ul.products, .woocommerce-page .products ul, .woocommerce-page ul.products {
border: <?php echo implode(", ", (array)$atts['prc_border_size']); ?>px <?php echo implode(", ", (array)$atts['prc_border_type']); ?> <?php echo implode(", ", (array)$atts['prc_border_color']); ?>;
padding: 10px 10px 10px 10px;
background-color: <?php echo implode(", ", (array)$atts['prc_background_color']); ?>;
border-radius: <?php echo implode(", ", (array)$atts['prc_border_radius']); ?>px;
}
<?php } ?>
<?php if(yes == $atts['use_custom_css']){ ?>
<?php echo implode(", ", (array)$atts['prc_css_code']); ?>
<?php } ?>