function svc_woo_add_animation($this, animation) {
	$this.removeClass('animated '+animation).addClass('animated '+animation).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function (e) {
		$this.css({
			'-webkit-animation':'none',
	   '-webkit-animation-name':'none',
			   'animation-name':'none',
					'animation':'none'
		});
		$this.removeClass('animated '+animation).removeAttr('svc-animation');
	});
}
function svc_woo_imag_animation(){
	jQuery('[svc-animation]').each(function () {
		var animation_style = jQuery(this).attr('svc-animation');
		svc_woo_add_animation(jQuery(this), animation_style);
	});
}
