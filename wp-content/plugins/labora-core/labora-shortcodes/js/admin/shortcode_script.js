//magnific Popup
jQuery(document).ready(function($){
	jQuery('body').on('click','.iva-event-shortcode-generator',function(){
		jQuery.magnificPopup.open({
			items: {
				src: '#labora-sc-generator'
			},
			type: 'inline',
			/*
			mainClass: 'mfp-fade',
			removalDelay: 300,
			*/

	    }, 0);
	}); 
	jQuery('#sendtoeditor').click(function(){
		jQuery.magnificPopup.close();
		
	});
});	
