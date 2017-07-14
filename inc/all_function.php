<?php
add_action('wp_head','swoo_inline_css_for_imageloaded');
function swoo_inline_css_for_imageloaded(){
	?>
    <style>
	.svc_post_grid_list_container{ display:none;}
	#loader {background-image: url("<?php echo plugins_url('../assets/css/loader.GIF',__FILE__);?>");}
	</style>
    <?php	
}
function swp_woo_quick_view_action_template() {

	// Image
	//add_action( 'svc_woo_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	//add_action( 'svc_woo_product_summary', 'woocommerce_show_product_images', 20 );

	// Summary
	add_action( 'swp_woo_product_summary', 'woocommerce_template_single_title', 5 );
	add_action( 'swp_woo_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'swp_woo_product_summary', 'woocommerce_template_single_price', 15 );
	add_action( 'swp_woo_product_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'swp_woo_product_summary', 'woocommerce_template_single_add_to_cart', 25 );
	add_action( 'swp_woo_product_summary', 'woocommerce_template_single_meta', 30 );
}
function swp_woo_layout_excerpt($excerpt,$limit) {
	$excerpt = strip_tags($excerpt);
	$excerpt = explode(' ', $excerpt, $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

add_action('wp_ajax_swp_layout_woo','swp_layout_woo');
add_action('wp_ajax_nopriv_swp_layout_woo','swp_layout_woo');
function swp_layout_woo(){
	extract($_POST);
	echo do_shortcode('[wpgel_woo_layout query_loop="'.$query_loop.'" grid_link_target="'.$grid_link_target.'" grid_layout_mode="'.$grid_layout_mode.'" grid_columns_count_for_desktop="'.$grid_columns_count_for_desktop.'" grid_columns_count_for_tablet="'.$grid_columns_count_for_tablet.'" grid_columns_count_for_mobile="'.$grid_columns_count_for_mobile.'" grid_thumb_size="'.$grid_thumb_size.'" multi_img="'.$multi_img.'" svc_excerpt_length="'.$svc_excerpt_length.'" skin_type="'.$skin_type.'" title="'.$title.'" effect="'.$effect.'" read_more="'.$read_more.'" quick_view_text="'.$quick_view_text.'" svc_class="'.$svc_class.'" dexcerpt="'.$dexcerpt.'" dcategory="'.$dcategory.'" drating="'.$drating.'" pbgcolor="'.$pbgcolor.'" pbghcolor="'.$pbghcolor.'" tcolor="'.$tcolor.'" thcolor="'.$thcolor.'" load_more_color="'.$load_more_color.'" popup_bgcolor="'.$popup_bgcolor.'" popup_line_color="'.$popup_line_color.'" popup_max_width="'.$popup_max_width.'" paged="'.$paged.'" svc_grid_id="'.$svc_grid_id.'" ajax="1"]');
	die();
}

add_action('wp_ajax_swp_woo_layout_carousel','swp_woo_layout_carousel');
add_action('wp_ajax_nopriv_swp_woo_layout_carousel','swp_woo_layout_carousel');
function swp_woo_layout_carousel(){
	extract($_POST);
	echo do_shortcode('[wpgel_woo_layout svc_type="'.$svc_type.'" query_loop="'.$query_loop.'" grid_link_target="'.$grid_link_target.'" grid_layout_mode="'.$grid_layout_mode.'" grid_thumb_size="'.$grid_thumb_size.'" multi_img="'.$multi_img.'" svc_excerpt_length="'.$svc_excerpt_length.'" skin_type="'.$skin_type.'" title="'.$title.'" read_more="'.$read_more.'" quick_view_text="'.$quick_view_text.'" svc_class="'.$svc_class.'" dexcerpt="'.$dexcerpt.'" dcategory="'.$dcategory.'" drating="'.$drating.'" pbgcolor="'.$pbgcolor.'" pbghcolor="'.$pbghcolor.'" tcolor="'.$tcolor.'" thcolor="'.$thcolor.'" paged="'.$paged.'" svc_grid_id="'.$svc_grid_id.'" ajax="1"]');
	die();
}

add_action('wp_ajax_swp_inline_woo_popup','swp_inline_woo_popup');
add_action('wp_ajax_nopriv_swp_inline_woo_popup','swp_inline_woo_popup');
function swp_inline_woo_popup(){
	extract($_GET);
	$post = get_post($pid);
	$post_type = $post->post_type;
    $content = apply_filters('the_content', $post->post_content);
	?>
	<div class="svc-magnific-popup-countainer svc-magnific-popup-countainer-<?php echo $pid;?>">
	<script src="<?php echo plugins_url('../assets/js/add-to-cart-variation.js', __FILE__);?>"></script>
    <style type="text/css">
	.svc-magnific-popup-countainer p{margin-bottom:10px;}
	<?php if($bgcolor != ''){?>
	.svc-magnific-popup-countainer{background-color:#<?php echo $bgcolor;?> !important;}
	<?php }
	if($line_color != ''){?>
	.svc-magnific-popup-countainer{border-bottom-color:#<?php echo $line_color;?> !important;}
	<?php }
	if($max_width != ''){?>
	.svc-magnific-popup-countainer{max-width:<?php echo $max_width;?>px !important;}
	<?php }?>
	.svc-popup-img-div{ text-align:center; line-height:0;}
	.svc-content-countainer{padding:2% 4% 3%; width:auto;}
	.svc-magnific-popup-countainer .svc_post_cat{ margin-bottom:10px;}
	.svc-magnific-popup-countainer .svc_social_share > ul li{margin-right: 0px !important;padding: 3px 6px;float:left;margin-bottom:0px; list-style:none;}
	@media screen and (min-width:769px){
		.svc-magnific-popup-countainer .svc_social_share{display: inline-block;float: none;position: absolute;margin-top:0px;left:100%; top:0px;}
	}
	@media screen and (max-width:768px){
		.svc-magnific-popup-countainer .svc_social_share{display: inline-block;float: none;position: absolute;margin-top:0px;right:0; bottom:0px;}
	}
	.svc-magnific-popup-countainer .svc_social_share ul{ padding:0px !important; text-indent:0 !important;margin-top: 0;}
	.svc-magnific-popup-countainer .svc_social_share > ul li a {font-size: 13px;color:#fff !important;}
	.svc-magnific-popup-countainer .svc_social_share > ul li:first-child{background:#6CDFEA;}
	.svc-magnific-popup-countainer .svc_social_share > ul li:nth-child(2){background:#3B5998;padding:3px 8.5px !important;}
	.svc-magnific-popup-countainer .svc_social_share > ul li:nth-child(3){background:#E34429;}
	.svc_owl_slider img,.svc_owl_slider_thum img{width:100%;}
	.owl-wrapper .owl-item.synced::before {
		border-bottom: 3px solid #869791;
		content: "";
		margin-top: -3px;
		position: absolute;
		top: 0;
		left:0;
		width: 100%;
	}
	.owl-wrapper .owl-item.synced::after {
		border-bottom: 8px solid #869791;
		border-left: 8px solid rgba(0, 0, 0, 0);
		border-right: 8px solid rgba(0, 0, 0, 0);
		content: "";
		height: 0;
		left: 50%;
		margin-left: -8px;
		position: absolute;
		top: -10px;
		width: 0;
	}
	#sync2 .owl-item {
		line-height: 0;
		margin-top: 15px;
	}
	</style>
	<div>
	<div class="svc-col-md-5 svc-sm-col-12">
		<div style="width:100%;">
		<?php if($fi != 'yes'){?>
		<div class="svc-popup-img-div">
			<div id="sync1" class="owl-carousel">
				<div class="svc_owl_slider">
				<?php echo get_the_post_thumbnail( $pid, 'full');?>
				</div>
				<?php 
				$imgs = explode(',',get_post_meta($pid,'_product_image_gallery',true));
				if(count($imgs)>0 && !empty($imgs[0])){
					foreach($imgs as $img){
						$image_attributes = wp_get_attachment_image_src($img,'full');
						if( $image_attributes ) {?>
						<div class="svc_owl_slider"><img src="<?php echo $image_attributes[0]; ?>"></div>
						<?php }
					}
				}?>
			</div>
			
			<?php if(count($imgs)>0 && !empty($imgs[0])){?>
			<div id="sync2" class="owl-carousel">
				<div class="svc_owl_slider_thum">
				<?php echo get_the_post_thumbnail( $pid, 'thumbnail');?>
				</div>
				<?php 
				if(count($imgs)>0){
					foreach($imgs as $img){
						$image_attributes = wp_get_attachment_image_src($img,'thumbnail');
						if( $image_attributes ) {?> 
						<div class="svc_owl_slider_thum"><img src="<?php echo $image_attributes[0]; ?>"></div>
						<?php }
					}
				}?>
			</div>
			<?php }?>
		</div>
		<?php }?>
		</div>
    </div>
    <div class="svc-col-md-7 svc-sm-col-12">
		<div class="svc-content-countainer">
		<?php 
		wp( 'p=' . $pid . '&post_type=product' );
		while ( have_posts() ) : the_post(); ?>
		<div class="product">
		<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="summary entry-summary woocommerce">
			<?php do_action( 'swp_woo_product_summary' ); ?>
		</div>
		</div>
		</div>
		<?php endwhile;?>
		</div>
	</div>
	</div>
	<div class="svc_social_share">
		<ul>
		  <li><a href="https://twitter.com/intent/tweet?text=&url=<?php echo get_the_permalink($pid);?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
		  <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink($pid);?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
		  <li><a href="https://plusone.google.com/share?url=<?php echo get_the_permalink($pid);?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
		</ul>
	</div>
	<div style="clear:both"></div>
	</div>
	<script>
    jQuery(function($) {
	var j = 0;
	var variation_a = setInterval(function(){
		$( '.variations_form' ).wc_variation_form();
		$( '.variations_form .variations select' ).change();
		//console.log(wc_add_to_cart_variation_params);
		/*if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
		$( '.variations_form' ).each( function() {
			$( this ).wc_variation_form().find('.variations select:eq(0)').change();
		});
		}*/
		if(j == 2){clearInterval(variation_a);}
		j++;
	},1000);
      var sync1 = $("#sync1");
      var sync2 = $("#sync2");
     
      sync1.owlCarousel({
        singleItem : true,
        slideSpeed : 1000,
        navigation: true,
        pagination:false,
        afterAction : syncPosition,
        responsiveRefreshRate : 200,
        navigationText: [
			"<i class='fa fa-chevron-left icon-white'></i>",
			"<i class='fa fa-chevron-right icon-white'></i>"
		],
      });
     
      sync2.owlCarousel({
        items : 4,
        itemsDesktop      : [1199,4],
        itemsDesktopSmall     : [979,4],
        itemsTablet       : [768,4],
        itemsMobile       : [479,4],
        pagination:false,
        responsiveRefreshRate : 100,
        afterInit : function(el){
          el.find(".owl-item").eq(0).addClass("synced");
        }
      });
     
      function syncPosition(el){
        var current = this.currentItem;
        $("#sync2")
          .find(".owl-item")
          .removeClass("synced")
          .eq(current)
          .addClass("synced")
        if($("#sync2").data("owlCarousel") !== undefined){
          center(current)
        }
      }
     
      $("#sync2").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo",number);
      });
     
      function center(number){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for(var i in sync2visible){
          if(num === sync2visible[i]){
            var found = true;
          }
        }
     
        if(found===false){
          if(num>sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", num - sync2visible.length+2)
          }else{
            if(num - 1 === -1){
              num = 0;
            }
            sync2.trigger("owl.goTo", num);
          }
        } else if(num === sync2visible[sync2visible.length-1]){
          sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
          sync2.trigger("owl.goTo", num-1)
        }
        
      }
     
    });
	</script>
	<?php
	die();
}
function swoo_kriesi_pagination($pages = '',$svc_grid_id, $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='svc_pagination svc_pagination_".$svc_grid_id."'>";
         //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             //if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                 echo ($paged == $i)? "<a href='".get_pagenum_link($i)."' class='current' page='".$i."'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' page='".$i."'>".$i."</a>";
             //}
         }

         //if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."' page='".($paged + 1)."'>&rsaquo;</a>";  
         //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."' page='".($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

function wpgel_woo_grid_delete(){
	global $wpdb,$woo_grid_table;
	$slider_table = $wpdb->base_prefix.$woo_grid_table;
	$id = intval($_POST['id']);
	$wpdb->delete($slider_table,array('id'=>$id));
die();
}
add_action('wp_ajax_wpgel_woo_grid_delete', 'wpgel_woo_grid_delete' );


add_action('wp_ajax_wpgel_woo_grid_title_update', 'wpgel_woo_grid_title_update' );


function swoo_animate_hex2rgba($hex,$opacity) {
   $hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	}else{
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgba = array($r, $g, $b, $opacity);
	return 'rgba('.implode(",", $rgba).')';
}?>
