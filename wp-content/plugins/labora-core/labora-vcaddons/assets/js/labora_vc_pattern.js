/* pattern bg */
jQuery(document).ready(function(){
	jQuery('.vcatp-radio-option').click(function(){
		jQuery(this).parent().parent().find('.vcatp-radio-option').removeClass('vcatp-radio-option-selected');
		jQuery(this).addClass('vcatp-radio-option-selected');
		jQuery(this).siblings('input').val(jQuery(this).attr('rel'));
	});
});