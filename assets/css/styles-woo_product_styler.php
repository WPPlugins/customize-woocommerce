.woocommerce div.product .product_title, .woocommerce #content div.product .product_title, .woocommerce-page div.product .product_title, .woocommerce-page #content div.product .product_title {
	color: <?php echo implode(", ", (array)$atts['pp_tt_font_color']); ?>;
	font-size: <?php echo implode(", ", (array)$atts['pp_tt_font_size']); ?>px;
	font-weight: <?php echo implode(", ", (array)$atts['pp_tt_font_weight']); ?>;
}
.woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price {
    color: <?php echo implode(", ", (array)$atts['pp_pr_font_color']); ?>;
    font-size: <?php echo implode(", ", (array)$atts['pp_pr_font_size']); ?>px;
	font-weight: <?php echo implode(", ", (array)$atts['pp_pr_font_weight']); ?>;
}
.woocommerce .woocommerce-tabs {
	width: <?php echo implode(", ", (array)$atts['container_width']); ?>%;
	height: <?php echo implode(", ", (array)$atts['container_height']); ?>%;
	background-color: <?php echo implode(", ", (array)$atts['pp_tabs_bg_color']); ?>;
<?php if(yes == $atts['woo_tabs_show_border']){ ?>
	border: <?php echo implode(", ", (array)$atts['pp_tabs_border_size']); ?>px <?php echo implode(", ", (array)$atts['pp_tab_border_type']); ?> <?php echo implode(", ", (array)$atts['pp_tabs_border_color']); ?>;
	border-radius: <?php echo implode(", ", (array)$atts['pp_tabs_border_radius']); ?>px;
	padding: 10px 10px 10px 10px;
<?php } ?>
}
.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images {
    float: left;
    width: <?php echo implode(", ", (array)$atts['pp_image_width']); ?>%;
	height: <?php echo implode(", ", (array)$atts['pp_image_height']); ?>%;
}
.woocommerce #review_form #respond p, .woocommerce-page #review_form #respond p {
	color: <?php echo implode(", ", (array)$atts['rt_text_color']); ?>;
	font-weight: <?php echo implode(", ", (array)$atts['rt_font_weight']); ?>;
	font-size: <?php echo implode(", ", (array)$atts['rt_font_size']); ?>px;
}
.woocommerce p.stars a.star-1, .woocommerce-page p.stars a.star-1, .woocommerce p.stars a.star-2, .woocommerce-page p.stars a.star-2,.woocommerce p.stars a.star-3, .woocommerce-page p.stars a.star-3,.woocommerce p.stars a.star-4, .woocommerce-page p.stars a.star-4,.woocommerce p.stars a.star-5, .woocommerce-page p.stars a.star-5 {

color: <?php echo implode(", ", (array)$atts['rt_stars_color']); ?>;
font-size: <?php echo implode(", ", (array)$atts['rt_stars_size']); ?>px;
font-weight: <?php echo implode(", ", (array)$atts['thicker_stars']); ?>;
}
