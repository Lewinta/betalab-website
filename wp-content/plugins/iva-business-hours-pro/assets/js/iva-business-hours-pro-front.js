jQuery(document).ready(function($){
	jQuery( ".iva-bh-tg" ).click(
	function() {
		var id = jQuery(this).attr('id');
		jQuery("."+id ).slideToggle(800);
	});
	jQuery(".iva-bh-tg").click(function () {
		jQuery(this).toggleClass('active');
	});
});	
