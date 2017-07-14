<script type="text/javascript">
jQuery(function($){
	//on-off start
	$(".on_off label").click(function(){
		var id = $(this).attr('id');
		var data = $(this).attr('data');
		if(data == 'y'){
			$('.'+id).show();
		}
		if(data == 'n'){
			$('.'+id).hide();
		}
        $(this).parent('div').children('label').removeClass("on");
        $(this).addClass("on");
    });
	//on-off end

	$('.post-list-tabs-menu li').click(function(){
		var tab = $(this).attr('data-tab-index');
		$('.post-list-tabs-menu li').removeClass('spl_active');
		$(this).addClass('spl_active');
		$('.spl_tabs').hide();
		$('#'+tab).show();
	});
	
	$('#grid_query').click(function(){
		$('#grid_query_div').slideToggle();	
	});
});
</script>
<style type="text/css">
.new_fields{ background:#fff; margin-top:0px; padding:5px 5px 0; border:1px solid #e7e4e4; border-top:0px;}
.widefat.dataa,.widefat.dataa td{ border:0px; box-shadow:none; cursor:move;}
.post-list-tabs-menu li {
    background: none repeat scroll 0 0 #fff;
    cursor: pointer;
    float: left;
    padding: 0.7%;
    text-align: center;
    width: 23.55%;
}
.post-list-tabs-menu li.spl_active {
    background: #002B36;
	color:#fff;
}
.post-list-tabs-menu {
    clear: both;
    list-style: none outside none;
}
.spost_button {
    background: #002b36 !important;
    border: 1px solid #002b36 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    font-size: 15px !important;
    height: 36px !important;
    line-height: 2em !important;
}
</style>

<?php
$grid = $difault_grid_array;
if(isset($_GET['sid'])){
$id = intval($_GET['sid']);
$grid_data = $wpdb->get_row("select * from ".self::$table_prefix.self::TABLE_WOO_NAME." where id=".$id);
$grid_ori = unserialize($grid_data->slider_params);
$grid = array_merge($difault_grid_array,$grid_ori);
}
//echo "<pre>";print_r($grid);echo "</pre>";?>
<ul class="post-list-tabs-menu">
	<li data-tab-index="general_tab" class="spl_active"><?php _e('General','spost-grid');?></li>
	<li data-tab-index="display_tab" class=""><?php _e('Display Setting','spost-grid');?></li>
	<li data-tab-index="color_tab" class=""><?php _e('Color Setting','spost-grid');?></li>
	<li data-tab-index="popup_tab" class=""><?php _e('Popup Setting','spost-grid');?></li>
</ul>

<div id="general_tab" class="spl_tabs" style="display:block;">
	<div class="metabox-holder" id="dashboard-widgets" style="width:100%;">
		<div class="postbox-container" style="width:100%;">	
			<div class="meta-box-sortables ui-sortable" style="margin:0">	
				<div class="postbox">
				<div class="inside">	
				<table class="anew_slider_setting">
                	<tr>
						<th><strong class="afl"><?php _e('Title','spost-grid');?> :</strong></th>	
						<td>
						<input type="text" name="title" value="<?php echo $grid['title'];?>">
						<p class="description"><?php _e('Enter grid title','spost-grid');?></p>	
						</td>
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Grid Type','spost-grid');?> :</strong></th>	
						<td>	
						<select name="grid_type" id="spost_grid_type" data-check-depen="yes">
							<option value="post_layout" <?php selected( $grid['grid_type'], 'post_layout' ); ?>><?php _e('Post Layout','spost-grid');?></option>
							<option value="carousel" <?php selected( $grid['grid_type'], 'carousel' ); ?>><?php _e('Carousel','spost-grid');?></option>
						</select>
						<p class="description">Select Post Grid Type.</p></td>	
					</tr>	
					<tr>	
						<th><strong class="afl"><?php _e('Build Post Query','spost-grid');?> :</strong></th>	
						<td>
                        <input type="button" value="Build query" id="grid_query">
                        <p class="description"><?php _e('Create WordPress loop, to populate content from your site.','spost-grid');?></p>
                        <div id="grid_query_div">
                            <table style="width:86%">
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Post types','spost-grid');?></strong><br>
                                        <?php 
										$exclu_post_type = array('shop_order','shop_coupon','shop_webhook','wpcf7_contact_form','vc_grid_item');
										$args = array(
										   'public'   => true,
										   'publicly_queryable' => true
										);
										$output = 'names'; // names or objects, note names is the default
										$operator = 'and'; // 'and' or 'or'
										$post_types = get_post_types($args, $output, $operator); 
                                        foreach($post_types as $post_type){
                                        if($post_type != 'attachment' && $post_type != 'revision' && $post_type != 'nav_menu_item' && $post_type != 'product_variation' && $post_type != 'shop_order_refund'){?>
                                        <input type="checkbox" name="post_type[]" value="<?php echo $post_type;?>" <?php if(in_array( $post_type, $grid['post_type'] )){ echo 'checked';} ?>/><?php echo $post_type;?>&nbsp;
                                        <?php if($post_type == 'post'){?>
                                        <input type="checkbox" name="post_type[]" value="page" <?php if(in_array( 'page', $grid['post_type'] )){ echo 'checked';} ?>/>page&nbsp;                                        						
                                        <?php }
											}}?>	
                                    <p class="description"><?php _e('Select post types to populate posts from. Note: If no post type is selected, WordPress will use default "product" value.','spost-grid');?></p>
                                    </td>
                                </tr>
                                <tr>
                                	<td style="width:200px;">
                                    	<strong class="afl"><?php _e('Post Count','spost-grid');?></strong><br>
                                        <input type="text" name="post_count" value="<?php echo $grid['post_count'];?>"/>					
                                    	<p class="description"><?php _e('How many teasers to show? Enter number or word "All".','spost-grid');?></p>
                                    </td>
                                    <td style="width:200px;">
                                    	<strong class="afl"><?php _e('Order By','spost-grid');?></strong><br>
                                        <select name="order_by">
                                            <option value="" <?php selected( $grid['order_by'], '' ); ?>></option>
                                            <option value="date" <?php selected( $grid['order_by'], 'date' ); ?>>Date</option>
                                            <option value="ID" <?php selected( $grid['order_by'], 'ID' ); ?>>ID</option>
                                            <option value="author" <?php selected( $grid['order_by'], 'author' ); ?>>Author</option>
                                            <option value="title" <?php selected( $grid['order_by'], 'title' ); ?>>Title</option>
                                            <option value="modified" <?php selected( $grid['order_by'], 'modified' ); ?>>Modified</option>
                                            <option value="rand" <?php selected( $grid['order_by'], 'rand' ); ?>>Random</option>
                                            <option value="comment_count" <?php selected( $grid['order_by'], 'comment_count' ); ?>>Comment count</option>
                                            <option value="menu_order" <?php selected( $grid['order_by'], 'menu_order' ); ?>>Menu order</option>            
                                        </select>					
                                    	<p class="description"><?php _e('Select how to sort retrieved posts. More at
<a target="_blank" href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters"> WordPress codex page</a>','spost-grid');?></p>
                                    </td>
                                    <td style="width:200px;">
                                    	<strong class="afl"><?php _e('Order','spost-grid');?></strong><br>
                                        <select name="order">
                                            <option value="" <?php selected( $grid['order'], '' ); ?>></option>
                                            <option value="ASC" <?php selected( $grid['order'], 'ASC' ); ?>>Ascending</option>
                                            <option value="DESC" <?php selected( $grid['order'], 'DESC' ); ?>>Descending</option>
                                        </select>					
                                    	<p class="description"><?php _e('Designates the ascending or descending order.','spost-grid');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Categories','spost-grid');?></strong><br>
                                        <input type="text" name="cat_id" value="<?php echo $grid['cat_id'];?>"/>
	                                    <p class="description"><?php _e('Filter output by posts categories, enter category ID here. if you add "-" exlude category id.each category add comma separated.eg. 1,4,-5','spost-grid');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Tags','spost-grid');?></strong><br>
                                        <input type="text" name="tag_id" value="<?php echo $grid['tag_id'];?>"/>
	                                    <p class="description"><?php _e('Filter output by posts tags, enter tag ID here. if you add "-" exlude Tag id.each Tag add comma separated.eg. 6,8,-7','spost-grid');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Taxonomies','spost-grid');?></strong><br>
                                        <input type="text" name="taxonomi_name" value="<?php echo $grid['taxonomi_name'];?>"/>
	                                    <p class="description"><?php _e('Filter output by custom taxonomies categories, enter category names here. if you add "-" exlude taxonomies. each Tag add comma separated.eg. -76,89,-5','spost-grid');?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<strong class="afl"><?php _e('Individual Posts/Pages/Custom Post Types','spost-grid');?></strong><br>
                                        <input type="text" name="post_id" value="<?php echo $grid['post_id'];?>"/>
	                                    <p class="description"><?php _e('Only entered posts/pages will be included in the output. Note: Works in conjunction with selected "Post types".if you add "-" exlude taxonomies.each Post,page add comma separated.eg. 5,8,-1,7','spost-grid');?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>	
					</tr>	
					<tr>		
						<th><strong class="afl"><?php _e('Skin type','spost-grid');?>:</strong></th>	
						<td>	
							<select name="skin_type" id="spost_skin_type" data-check-depen="yes">
                            	<option value="s1" <?php selected( $grid['skin_type'], 's1' ); ?>>Style1</option>
                                <option value="s2" <?php selected( $grid['skin_type'], 's2' ); ?>>Style2</option>
                                <option value="s3" <?php selected( $grid['skin_type'], 's3' ); ?>>Style3</option>
                                <option value="s4" <?php selected( $grid['skin_type'], 's4' ); ?>>Style4</option>
                                <option value="s5" <?php selected( $grid['skin_type'], 's5' ); ?>>Style5</option>
                                <option value="s6" <?php selected( $grid['skin_type'], 's6' ); ?>>Style6 for List View</option>
                           </select>
					<p class="description"><?php _e('Choose skin type for grid layout','spost-grid');?>.</p></td>	
					</tr>
                    <tr data-depen-set="true" data-value="carousel" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Items Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_display_item'];?>" name="car_display_item" max="100" min="1" data-check-depen="yes" id="spost_car_display_item">
						<p class="description"><?php _e('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width','spost-grid');?></p>
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="carousel" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Show pagination','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_pagination" value="yes" id="spost_car_pagination" data-check-depen="yes" <?php checked( $grid['spost_car_pagination'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Show pagination','spost-grid');?></p>	
						</td>
					</tr>
                    <tr data-depen-set="true" data-value="yes" data-id="spost_car_pagination" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Show pagination Numbers','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_pagination_num" value="yes" <?php checked( $grid['car_pagination_num'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Show numbers inside pagination buttons.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="carousel" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Hide navigation','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_navigation" value="yes" <?php checked( $grid['car_navigation'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Display "next" and "prev" buttons.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="carousel" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('AutoPlay','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_autoplay" value="yes" id="spost_car_autoplay" data-check-depen="yes" <?php checked( $grid['car_autoplay'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Set Slider Autoplay.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="yes" data-id="spost_car_autoplay" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('autoPlay Time','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['car_autoplay_time'];?>" name="car_autoplay_time" max="100" min="1"><?php _e('seconds','spost-grid');?>
						<p class="description"><?php _e('Set Autoplay slider speed.','spost-grid');?></p>	
						</td>
					</tr>
                    <tr data-depen-set="true" data-value="carousel" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Show more','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="car_loadmore" id="spost_car_loadmore" data-check-depen="yes" value="yes" <?php checked( $grid['car_loadmore'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('add Show more Post last element of Carousel.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="1" data-id="spost_car_display_item" data-attr="number">	
						<th><strong class="afl"><?php _e('Synced Slider','spost-grid');?> :</strong></th>	
						<td>	
						<input type="checkbox" name="synced" value="yes" id="spost_synced" data-check-depen="yes" <?php checked( $grid['synced'], 'yes' ); ?>><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Set Synced Slider.see Example
<a target="_black" href="http://owlgraphic.com/owlcarousel/demos/sync.html">here</a>.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="yes" data-id="spost_synced" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Synced Display','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['synced_display'];?>" name="synced_display" max="1000" min="1">
						<p class="description"><?php _e('Set Synces Slider Display elements.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="1" data-id="spost_car_display_item" data-attr="number">	
						<th><strong class="afl"><?php _e('Transition effect','spost-grid');?> :</strong></th>	
						<td>	
						<select name="car_transition">
                        	<option value="" <?php selected( $grid['car_transition'], '' ); ?>>None</option>
                            <option value="fade" <?php selected( $grid['car_transition'], 'fade' ); ?>>fade</option>
                            <option value="backSlide" <?php selected( $grid['car_transition'], 'backSlide' ); ?>>backSlide</option>
                            <option value="goDown" <?php selected( $grid['car_transition'], 'goDown' ); ?>>goDown</option>
                            <option value="scaleUp" <?php selected( $grid['car_transition'], 'scaleUp' ); ?>>scaleUp</option>
                        </select>
						<p class="description"><?php _e('Add CSS3 transition style. Works only with one item on screen.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Desktop Columns Count','spost-grid');?> :</strong></th>	
						<td>	
						<select name="grid_columns_count_for_desktop">
                        	<option value="svc-col-md-12" <?php selected( $grid['grid_columns_count_for_desktop'], 'svc-col-md-12' ); ?>><?php _e('1 Column','spost-grid');?></option>
                            <option value="svc-col-md-6" <?php selected( $grid['grid_columns_count_for_desktop'], 'svc-col-md-6' ); ?>><?php _e('2 Columns','spost-grid');?></option>
                            <option value="svc-col-md-4" <?php selected( $grid['grid_columns_count_for_desktop'], 'svc-col-md-4' ); ?>><?php _e('3 Columns','spost-grid');?></option>
                            <option value="svc-col-md-3" <?php selected( $grid['grid_columns_count_for_desktop'], 'svc-col-md-3' ); ?>><?php _e('4 Columns','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('Choose Desktop(PC Mode) Columns Count','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Tablet Columns Count','spost-grid');?> :</strong></th>	
						<td>	
						<select name="grid_columns_count_for_tablet">
                        	<option value="svc-col-sm-12" <?php selected( $grid['grid_columns_count_for_tablet'], 'svc-col-sm-12' ); ?>><?php _e('1 Column','spost-grid');?></option>
                            <option value="svc-col-sm-6" <?php selected( $grid['grid_columns_count_for_tablet'], 'svc-col-sm-6' ); ?>><?php _e('2 Columns','spost-grid');?></option>
                            <option value="svc-col-sm-4" <?php selected( $grid['grid_columns_count_for_tablet'], 'svc-col-sm-4' ); ?>><?php _e('3 Columns','spost-grid');?></option>
                            <option value="svc-col-sm-3" <?php selected( $grid['grid_columns_count_for_tablet'], 'svc-col-sm-3' ); ?>><?php _e('4 Columns','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('Choose Tablet Columns Count','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Mobile Columns Count','spost-grid');?> :</strong></th>	
						<td>	
						<select name="grid_columns_count_for_mobile">
                        	<option value="svc-col-xs-12" <?php selected( $grid['grid_columns_count_for_mobile'], 'svc-col-xs-12' ); ?>><?php _e('1 Column','spost-grid');?></option>
                            <option value="svc-col-xs-6" <?php selected( $grid['grid_columns_count_for_mobile'], 'svc-col-xs-6' ); ?>><?php _e('2 Columns','spost-grid');?></option>
                            <option value="svc-col-xs-4" <?php selected( $grid['grid_columns_count_for_mobile'], 'svc-col-xs-4' ); ?>><?php _e('3 Columns','spost-grid');?></option>
                            <option value="svc-col-xs-3" <?php selected( $grid['grid_columns_count_for_mobile'], 'svc-col-xs-3' ); ?>><?php _e('4 Columns','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('Choose Mobile Columns Count','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr>	
						<th><strong class="afl"><?php _e('Link target','spost-grid');?> :</strong></th>	
						<td>	
						<select name="grid_link_target">
                        	<option value="sw" <?php selected( $grid['grid_link_target'], 'sw' ); ?>><?php _e('Same Window','spost-grid');?></option>
                            <option value="nw" <?php selected( $grid['grid_link_target'], 'nw' ); ?>><?php _e('New Window','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('set Link target','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Show filter','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="filter" id="spost_filter" data-check-depen="yes" <?php checked( $grid['filter'], 'yes' ); ?>/><?php _e('Yes, Please','spost-grid');?>
						<p class="description"><?php _e('Select to add animated category filter to your posts grid.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Show Sorting Filter','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="sort_filter" <?php checked( $grid['sort_filter'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Display Sorting Filter.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Show Grid/List View Type Filter','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="grid_list_filter" <?php checked( $grid['grid_list_filter'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Display Grid/List View Filter.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Exclude taxonomies','spost-grid');?>:</strong></th>	
						<td>	
						<input type="text" name="exclude_texo" value="<?php echo $grid['exclude_texo'];?>">
						<p class="description"><?php _e('Enter Exclude taxonomies slug, Divide each with comm separate.get texonomy slug
<a target="_blank" href="http://plugin.saragna.com/vc-addon/wp-content/uploads/2015/04/slug.png">click here</a>','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">
						<th><strong class="afl"><?php _e('Filter mode','spost-grid');?> :</strong></th>	
						<td>	
						<select name="filter_type">
                        	<option value="linear" <?php selected( $grid['filter_type'], 'linear' ); ?>><?php _e('Linear','spost-grid');?></option>
                            <option value="dropdown" <?php selected( $grid['filter_type'], 'dropdown' ); ?>><?php _e('Dropdown','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('Filter Layout Option.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">	
						<th><strong class="afl"><?php _e('Show Filter value counter','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="count_display" <?php checked( $grid['count_display'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Filter category Count display.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">
						<th><strong class="afl"><?php _e('Layout mode','spost-grid');?> :</strong></th>	
						<td>	
						<select name="grid_layout_mode">
                        	<option value="fitRows" <?php selected( $grid['grid_layout_mode'], 'fitRows' ); ?>><?php _e('Fit rows','spost-grid');?></option>
                            <option value="masonry" <?php selected( $grid['grid_layout_mode'], 'masonry' ); ?>><?php _e('Masonry','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('Select layout template.','spost-grid');?></p>	
						</td>	
					</tr>
                    <tr>
                    	<th><strong class="afl"><?php _e('Thumbnail size','spost-grid');?></strong></th>
                        <td>
							<input type="text" name="grid_thumb_size" value="<?php echo $grid['grid_thumb_size'];?>"/>
                            <p class="description"><?php _e('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="s5" data-value1="s8" data-id="spost_skin_type" data-attr="select">
                    	<th><strong class="afl"><?php _e('Minimum Height','spost-grid');?></strong></th>
                        <td>
							<input type="number" step="1" value="<?php echo $grid['s5_min_height'];?>" name="s5_min_height" max="9000" min="0">
                            <p class="description"><?php _e('if you not set fetured image so set Minimum Height for artical.default:150px','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr>
                    	<th><strong class="afl"><?php _e('Excerpt Length','spost-grid');?></strong></th>
                        <td>
							<input type="number" step="1" value="<?php echo $grid['svc_excerpt_length'];?>" name="svc_excerpt_length" max="900" min="10">
                            <p class="description"><?php _e('set excerpt length.default:20','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Pagination Style','spost-grid');?> :</strong></th>	
						<td>	
						<select name="load_more" id="spost_load_more" data-check-depen="yes">
                        	<option value="loadmore" <?php selected( $grid['load_more'], 'loadmore' ); ?>><?php _e('Show More','spost-grid');?></option>
                            <option value="infinite" <?php selected( $grid['load_more'], 'infinite' ); ?>><?php _e('Infinite Scroll','spost-grid');?></option>
                            <option value="pagination" <?php selected( $grid['load_more'], 'pagination' ); ?>><?php _e('Number Pagination','spost-grid');?></option>
                        </select>
						<p class="description"><?php _e('Select Pagination Style.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Show Product Listing Carousel','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="multi_img" <?php checked( $grid['multi_img'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('Show Product Listing Carousel','spost-grid');?>.</p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Hide Show more Button','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="hide_showmore" <?php checked( $grid['hide_showmore'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide Show more button','spost-grid');?>.</p>	
						</td>	
					</tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Animations','spost-grid');?> :</strong></th>	
						<td>
						<select name="effect">
                        <?php foreach($animations as $animation){?>
                        	<option value="<?php echo $animation;?>" <?php selected( $grid['effect'], $animation ); ?>><?php echo $animation;?></option>
						<?php }?>
                        </select>
						<p class="description"><?php _e('For over 50 additional Animation Options please consider upgrading to the <a href="http://www.wpgel.com/blog/product/customize-woocommerce-pro" target="_blank"><strong><u>Customize Woocommerce Pro Plugin</u></strong></a>','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr>
                    	<th><strong class="afl"><?php _e('Read More translate','spost-grid');?></strong></th>
                        <td>
                            <input type="text" name="read_more" value="<?php echo $grid['read_more'];?>"/>
                            <p class="description"><?php _e('Enter Post Read more text.Default : Read more.','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="post_layout" data-id="spost_grid_type" data-attr="select">
                    	<th><strong class="afl"><?php _e('Show more text','spost-grid');?></strong></th>
                        <td>
                            <input type="text" name="loadmore_text" value="<?php echo $grid['loadmore_text'];?>"/>
                            <p class="description"><?php _e('add Show more button text.Default:Show More','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr data-depen-set="true" data-value="yes" data-id="spost_car_loadmore" data-attr="checkbox">
                    	<th><strong class="afl"><?php _e('Show more text','spost-grid');?></strong></th>
                        <td>
                            <input type="text" name="car_loadmore_text" value="<?php echo $grid['car_loadmore_text'];?>"/>
                            <p class="description"><?php _e('add Show more button text.Default:Show More','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr>
                    	<th><strong class="afl"><?php _e('Quick View text','spost-grid');?></strong></th>
                        <td>
                            <input type="text" name="quick_view_text" value="<?php echo $grid['quick_view_text'];?>"/>
                            <p class="description"><?php _e('add Quick View text.Default:Quick View.','spost-grid');?></p>
                        </td>
                    </tr>
                    <tr>
                    	<th><strong class="afl"><?php _e('Extra class name','spost-grid');?></strong></th>
                        <td>
                            <input type="text" name="svc_class" value="<?php echo $grid['svc_class'];?>"/>
                            <p class="description"><?php _e('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.','spost-grid');?></p>
                        </td>
                    </tr>
				</table>
				</div>	
				</div>	
			</div>	
		</div>
	</div>
</div>

<div id="display_tab" class="spl_tabs">
	<div class="metabox-holder" id="dashboard-widgets" style="width:100%;">
		<div class="postbox-container" style="width:100%;">	
			<div class="meta-box-sortables ui-sortable" style="margin:0">	
				<div class="postbox">
				<div class="inside">	
				<table class="anew_slider_setting">	
					<tr>	
						<th><strong class="afl"><?php _e('Hide Excerpt','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="dexcerpt" <?php checked( $grid['dexcerpt'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide Excerpt content.','spost-grid');?></p>	
						</td>	
					</tr>	
					<tr>
						<th><strong class="afl"><?php _e('Hide Category','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="dcategory" <?php checked( $grid['dcategory'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide category content.','spost-grid');?></p>	
						</td>	
					</tr>	
					<tr>	
						<th><strong class="afl"><?php _e('Hide Rating','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="drating" <?php checked( $grid['drating'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide rating.','spost-grid');?></p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Hide Quick View','spost-grid');?>:</strong></th>	
						<td>	
						<input type="checkbox" value="yes" name="dquick_view" <?php checked( $grid['dquick_view'], 'yes' ); ?>/><?php _e('Yes','spost-grid');?>
						<p class="description"><?php _e('hide Quick View.','spost-grid');?></p>	
						</td>	
					</tr>
				</table>
				</div>	
				</div>	
			</div>	
		</div>
	</div>
</div>

<div id="color_tab" class="spl_tabs">
	<div class="metabox-holder" id="dashboard-widgets" style="width:100%;">
		<div class="postbox-container" style="width:100%;">	
			<div class="meta-box-sortables ui-sortable" style="margin:0">	
				<div class="postbox">
				<div class="inside">	
				<table class="vertical-top">	
					<tr>
						<th><strong class="afl"><?php _e('Post Background Color','spost-grid');?> :</strong></th>	
						<td>	
							<input type="text" class="my-color-field" name="pbgcolor" data-default-color="" value="<?php echo $grid['pbgcolor'];?>"/>	
						<p class="description"><?php _e('set post background color.','spost-grid');?></p></td>	
					</tr>	
					<tr>	
						<th><strong class="afl"><?php _e('Post hover Background Color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="pbghcolor" data-default-color="" value="<?php echo $grid['pbghcolor'];?>"/>	
						<p class="description"><?php _e('set post hover background color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-id="spost_skin_type" data-value="s1" data-value1="s2" data-value2="s4" data-depen-set="true" data-attr="select">	
						<th><strong class="afl"><?php _e('Image below / top line color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="line_color" data-default-color="" value="<?php echo $grid['line_color'];?>"/>	
						<p class="description"><?php _e('set Image below / top color','spost-grid');?>.</p>	
						</td>	
					</tr>	
					<tr>	
						<th><strong class="afl"><?php _e('Title Color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="tcolor" data-default-color="" value="<?php echo $grid['tcolor'];?>"/>	
						<p class="description"><?php _e('Set Title Color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Title Hover Color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="thcolor" data-default-color="" value="<?php echo $grid['thcolor'];?>"/>	
						<p class="description"><?php _e('Set Title Hover Color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="loadmore" data-value1="infinite" data-id="spost_load_more" data-attr="select">	
						<th><strong class="afl"><?php _e('Show More Color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="load_more_color" data-default-color="" value="<?php echo $grid['load_more_color'];?>"/>	
						<p class="description"><?php _e('Set Show More Color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">
						<th><strong class="afl"><?php _e('Filter text and border color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="filter_text_color" data-default-color="" value="<?php echo $grid['filter_text_color'];?>"/>	
						<p class="description"><?php _e('Set Filter text and border color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">
						<th><strong class="afl"><?php _e('Active Filter text color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="filter_text_active_color" data-default-color="" value="<?php echo $grid['filter_text_active_color'];?>"/>	
						<p class="description"><?php _e('Set Active Filter text color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="yes" data-id="spost_filter" data-attr="checkbox">
						<th><strong class="afl"><?php _e('Active Filter text background color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="filter_text_active_bgcolor" data-default-color="" value="<?php echo $grid['filter_text_active_bgcolor'];?>"/>	
						<p class="description"><?php _e('Set Active Filter text background color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="pagination" data-id="spost_load_more" data-attr="select">
						<th><strong class="afl"><?php _e('Pagination background color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="pagination_bgcolor" data-default-color="" value="<?php echo $grid['pagination_bgcolor'];?>"/>	
						<p class="description"><?php _e('Set Pagination background color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="pagination" data-id="spost_load_more" data-attr="select">
						<th><strong class="afl"><?php _e('Pagination active background color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="pagination_active_bgcolor" data-default-color="" value="<?php echo $grid['pagination_active_bgcolor'];?>"/>	
						<p class="description"><?php _e('Set Pagination active background color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="pagination" data-id="spost_load_more" data-attr="select">	
						<th><strong class="afl"><?php _e('Pagination Number color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="pagination_number_color" data-default-color="" value="<?php echo $grid['pagination_number_color'];?>"/>	
						<p class="description"><?php _e('Set Pagination Number color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr data-depen-set="true" data-value="carousel" data-id="spost_grid_type" data-attr="select">	
						<th><strong class="afl"><?php _e('Navigation and Pagination color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="car_navigation_color" data-default-color="" value="<?php echo $grid['car_navigation_color'];?>"/>	
						<p class="description"><?php _e('Set Navigation and Pagination color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Rating color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="rating_color" data-default-color="" value="<?php echo $grid['rating_color'];?>"/>	
						<p class="description"><?php _e('Set Rating color','spost-grid');?>.</p>	
						</td>	
					</tr>
				</table>
				</div>	
				</div>	
			</div>	
		</div>
	</div>
</div>

<div id="popup_tab" class="spl_tabs">
	<div class="metabox-holder" id="dashboard-widgets" style="width:100%;">
		<div class="postbox-container" style="width:100%;">	
			<div class="meta-box-sortables ui-sortable" style="margin:0">	
				<div class="postbox">
				<div class="inside">	
				<table class="vertical-top">
					<tr>	
						<th><strong class="afl"><?php _e('Popup background color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="popup_bgcolor" data-default-color="" value="<?php echo $grid['popup_bgcolor'];?>"/>	
						<p class="description"><?php _e('Set Popup background color','spost-grid');?>.</p>	
						</td>	
					</tr>
					<tr>	
						<th><strong class="afl"><?php _e('Popup bottom line color','spost-grid');?> :</strong></th>	
						<td>	
						<input type="text" class="my-color-field" name="popup_line_color" data-default-color="" value="<?php echo $grid['popup_line_color'];?>"/>	
						<p class="description"><?php _e('Set Popup bottom line color','spost-grid');?>.</p>	
						</td>	
					</tr>	
					<tr>	
						<th><strong class="afl"><?php _e('Max Width For popup','spost-grid');?> :</strong></th>	
						<td>	
						<input type="number" step="1" value="<?php echo $grid['popup_max_width'];?>" name="popup_max_width" max="5000" min="10">px
						<p class="description"><?php _e('set popup max width.default:900px','spost-grid');?></p>	
						</td>	
					</tr>	
					<tr>	
						<th><strong class="afl"><?php _e('Popup Effect','spost-grid');?> :</strong></th>	
						<td>	
						<select name="popup_effect">
							<option value="" <?php selected( $grid['popup_effect'], '' ); ?>>None</option>
							<option value="flip-h-3d" <?php selected( $grid['popup_effect'], 'flip-h-3d' ); ?>>flip-h-3d</option>
							<option value="rotate-carouse-left" <?php selected( $grid['popup_effect'], 'rotate-carouse-left' ); ?>>rotate-carouse-left</option>
							<option value="slide-in-top" <?php selected( $grid['popup_effect'], 'slide-in-top' ); ?>>slide-in-top</option>
							<option value="fade-in-scale" <?php selected( $grid['popup_effect'], 'fade-in-scale' ); ?>>fade-in-scale</option>
							<option value="mfp-newspaper" <?php selected( $grid['popup_effect'], 'mfp-newspaper' ); ?>>mfp-newspaper</option>
							<option value="mfp-zoom-in" <?php selected( $grid['popup_effect'], 'mfp-zoom-in' ); ?>>mfp-zoom-in</option>
							<option value="mfp-move-horizontal" <?php selected( $grid['popup_effect'], 'mfp-move-horizontal' ); ?>>mfp-move-horizontal</option>
							<option value="mfp-3d-unfold" <?php selected( $grid['popup_effect'], 'mfp-3d-unfold' ); ?>>mfp-3d-unfold</option>
							<option value="mfp-zoom-out" <?php selected( $grid['popup_effect'], 'mfp-zoom-out' ); ?>>mfp-zoom-out</option>
						</select>	
						<p class="description"><?php _e(' Inline Post Popup effect','spost-grid');?>.</p>	
						</td>	
					</tr>	
				</table>
				</div>	
				</div>	
			</div>	
		</div>
	</div>
</div>
<?php if(isset($_GET['sid'])){?>
<input type="submit" class="button-primary spost_button" value="<?php _e('Update Setting','spost-grid');?>" name="swoo_Update_Setting" style="width:100%;">
<?php }else{?>
<input type="submit" class="button-primary spost_button" value="<?php _e('Save Setting','spost-grid');?>" name="swoo_save_Setting" style="width:100%;">
<?php }?>

<div id="dialog" title="Edit Level" style="display:none"></div>
