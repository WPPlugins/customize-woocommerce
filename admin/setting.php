<script type="text/javascript">
jQuery(function($){
	$('.my-color-field').wpColorPicker();
	$(".handlediv,.hndle").click(function(){
		$(this).next('h3').next('.inside').toggle();
		if($(this).parent('.postbox').hasClass('closed')){
			$(this).parent('.postbox').removeClass('closed');
		}else{
			$(this).parent('.postbox').addClass('closed');
		}
	});

});
</script>
<?php
$msg = false;
$mcode = 0;
$error = false;
if(isset($_POST['create_wpgel_woo_grid_title'])){
	extract($_POST);
	if($anew_slider_title == '' || empty($anew_slider_title)){
		$msg = true; $error = true;
		$mcode = 1;
	}elseif (isset( $_POST['animate_new_slider_nonce_field'] ) && wp_verify_nonce( $_POST['animate_new_slider_nonce_field'], 'animate_new_slider_action' )) {
		$ins = array(
			'slider_title' => $anew_slider_title
		);
		$wpdb->insert( self::$table_prefix.self::TABLE_WOO_NAME, $ins );
		wp_redirect( 'admin.php?page=swoo-grid' );exit;
	}
}
if(isset($_POST['swoo_save_Setting'])){
	extract($_POST);
	$ins = array(
		'slider_title' => $title,
		'slider_params' => serialize($_POST)
	);
	$wpdb->insert( self::$table_prefix.self::TABLE_WOO_NAME, $ins );
	wp_redirect( 'admin.php?page=swoo-grid' );exit;
}
if(isset($_POST['swoo_Update_Setting'])){
	extract($_POST);
	$ins = array(
		'slider_title' => $title,
		'slider_params' => serialize($_POST)
	);
	$wpdb->update( self::$table_prefix.self::TABLE_WOO_NAME, $ins, array('id' => $_GET['sid']) );
	wp_redirect( 'admin.php?page=swoo-grid&view=setting&sid='.$_GET['sid'] );exit;
}
?>
<style type="text/css">
a,a:focus,a:active{ outline:none !important; box-shadow:none !important;}
.animate_slider_popup_loader{background:url(<?php echo $this->animate_plugin_url('../assets/image/default.gif');?>) no-repeat center #fff;}
.h2_logo{
	background:url(<?php echo $this->animate_plugin_url('../assets/image/round.png');?>) !important;
	background-repeat:no-repeat !important;
	box-shadow:none !important;
	background-size:42px 42px;
	display:table;
	font-size: 23px;
    font-weight: 400;
    line-height: 29px;
    padding: 6px 15px 7px 48px !important;
	margin:0 !important;
	border-bottom:0px !important;
}
.widefat td{border-bottom: 1px solid #f1f1f1;}
.aslider_required{ color:red; font-size:18px; vertical-align:middle; margin-left:2px;}
.help_btn{position: absolute; right: 15px; top: 7px;}
.afr{ float:right;}.afl{ float:left;}.apadl0{padding-left:0px !important;}.atal{text-align:left;}
.anew_slider{ margin-bottom:10px;}
.anew_slider th{ width:200px; vertical-align:top; text-align:left;}
.anew_slider1 th{ width:175px; text-align:left; vertical-align:top;}
.anew_slider_setting th{ width:176px; vertical-align:top; text-align:left;}
.delete_level,.delete_level:hover {
    background-color: #fb6f6f;
    border: 1px solid #c10f0f;
    border-radius: 3px;
    color: #fff;
	display:inline-table;
    font-size: 12px;
    font-weight: bold;
    padding: 1px 10px;
    text-shadow: 0 1px #100f0f;
}
.edit_layers,.edit_layers:hover {
    background-color: #37c536;
    border: 1px solid green;
    border-radius: 3px;
    color: #fff;
	cursor:pointer;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 10px;
    text-shadow: 0 1px #5f5959;
}
.spl_tabs{ display:none;}
#grid_query{
	border: 1px solid #ccc;
    border-radius: 3px;
    cursor: pointer;
    font-size: 13px;
    padding: 5px 18px;
    text-shadow: 1px 1px #f2f2f2;
}
#grid_query_div:before{
	border-bottom: 8px solid #ccc;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    content: "";
    height: 0;
    left: 48px;
    position: absolute;
    top: -9px;
    width: 0;
}
#grid_query_div{
	background: #f2f2f2 none repeat scroll 0 0;
    border: 1px solid #ccc;
    border-radius: 3px;
    display: none;
    padding: 10px;
	position:relative;
}
.vertical-top th{vertical-align:top;}
.spost_hidden{ display:none;}
</style>

<div class="wrap">

<div class="meta-box-sortables ui-sortable">

	<div class="postbox" style="margin-bottom:10px;">

		<div class="inside" style="padding:0 12px;">

			<h3 class="h2_logo"><a href="<?php echo self::plugin_root_url();?>" style="text-decoration:none; color:#222;"><?php echo esc_html( 'Customize Woocommerce Layout with Carousel' ); ?></a></h3>

		</div>

	</div>

</div>

<?php if($msg == true && $mcode > 0 ){?>

<div class="<?php echo ($error == true) ? 'error' : 'updated';?>">

	<p><strong>

	<?php echo self::error_msg($mcode);?>

	</strong></p>

</div>

<?php }
$animations = array(
	'None' => '',
	'bounce'		=>	'bounce',
	'flash'			=>	'flash',
	'pulse'			=>	'pulse',
	'rubberBand'	=>	'rubberBand',
	'shake'			=>	'shake',
	'swing'			=>	'swing',
);?>
<form method="post">
<?php 

if(isset($_GET['view']) && $_GET['view'] == 'slide'){

	include('slides.php');

}elseif(isset($_GET['view']) && $_GET['view'] == 'setting'){
$difault_grid_array = array(
    'title' => '',
	'svc_type' => 'post_layout',
	'post_type' => array('product'),
    'post_count' => '10',
    'order_by' => 'date',
    'order' => 'DESC',
    'cat_id' => '',
    'tag_id' => '',
    'taxonomi_name' => '',
    'post_id' => '',
	'skin_type' => 's1',
	'car_display_item' => '4',
	'car_pagination' => '',
	'car_pagination_num' => '',
	'car_navigation' => '',
	'car_autoplay' => '',
	'car_autoplay_time' => '5',
	'car_loadmore' => '',
	'synced' => '',
	'synced_display' => '10',
	'car_transition' => '',
	'grid_columns_count_for_desktop' => 'svc-col-md-4',
	'grid_columns_count_for_tablet' => 'svc-col-sm-6',
	'grid_columns_count_for_mobile' => 'svc-col-xs-12',
	'grid_link_target' => 'sw',
	'filter' => '',
	'sort_filter' => '',
	'grid_list_filter' => '',
	'exclude_texo' => '',
	'filter_type' => 'dropdown',
	'count_display' => '',
	'grid_layout_mode' => 'fitRows',
	'grid_thumb_size' => 'full',
	's5_min_height' => '150',
	'svc_excerpt_length' => '20',
	'load_more' => 'loadmore',
	'multi_img' => '',
	'hide_showmore' => '',
	'effect' => '',
	'read_more' => '',
	'loadmore_text' => '',
	'car_loadmore_text' => '',
	'quick_view_text' => '',
	'svc_class' => '',
	'dexcerpt' => '',
	'dcategory' => '',
	'drating' => '',
	'dquick_view' => '',
	'pbgcolor' => '',
	'pbghcolor' => '',
	'line_color' => '',
	'tcolor' => '',
	'thcolor' => '',
	'load_more_color' => '',
	'filter_text_color' => '',
	'filter_text_active_color' => '',
	'filter_text_active_bgcolor' => '',
	'pagination_bgcolor' => '',
	'pagination_active_bgcolor' => '',
	'pagination_number_color' => '',
	'car_navigation_color' => '',
	'rating_color' => '',
	'dfeatured' => '',
	'popup_bgcolor' => '',
	'popup_line_color' => '',
	'popup_max_width' => '900',
	'popup_effect' => '',
);
	include('grid-setting.php');

}elseif(isset($_GET['view']) && $_GET['view'] == 'grid'){

	include('grid-name.php');

}else{

	include('main.php');

}?>
</form>
<script>
jQuery(function($){
	function spost_dependency_check(){
		$('[data-depen-set]').each(function(index, element) {
			var this_tr = $(this);
			var field_value = '';
			var data_attr = this_tr.attr('data-attr');
			var data_id = this_tr.attr('data-id');
			var data_value = this_tr.attr('data-value');
			var data_value1 = this_tr.attr('data-value1');
			var data_value2 = this_tr.attr('data-value2');
			
			if(data_attr == 'checkbox'){
				if ($('#'+data_id).is(":checked")){
					field_value = $('#'+data_id).val();
				}
				if(field_value == data_value){
					this_tr.removeClass('spost_hidden');	
				}else{
					this_tr.addClass('spost_hidden');	
				}
			}
			
			if(data_attr == 'select'){
				field_value = $('#'+data_id).val();
				if(field_value == data_value || field_value == data_value1 || field_value == data_value2){
					this_tr.removeClass('spost_hidden');	
				}else{
					this_tr.addClass('spost_hidden');
				}
			}
			
			if(data_attr == 'number'){
				field_value = $('#'+data_id).val();
				if(field_value == data_value){
					this_tr.removeClass('spost_hidden');	
				}else{
					this_tr.addClass('spost_hidden');	
				}
			}
		});
		
		setTimeout(function(){
			$('.spost_hidden').each(function(index, element) {
				var this_input = $(this);
				var closesr_id = this_input.children('td').children('input').attr('id');
				$('[data-id]').each(function(index, element) {
					var this_sss = $(this);
					if(this_sss.attr('data-id') == closesr_id){
						this_sss.addClass('spost_hidden');
					}
				});						
			});
		},800);
	}
	spost_dependency_check();
	
	$('[data-check-depen]').not('select').click(function(){
		spost_dependency_check();
	});
	$('[data-check-depen]').change(function(){
		spost_dependency_check();
	});
});
</script>

<div style="float:right; margin-top:10px; clear:both; font-weight:bold;">Customize Woocommerce Version <?php echo $anisliderVersion;?></div>

</div>
