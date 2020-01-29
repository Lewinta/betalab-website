/*-----------------------------------------------------------------------------------*/
/* WooFramework Media Library-driven AJAX File Uploader Module
/* JavaScript Functions (2010-11-05)
/*
/* The code below is designed to work as a part of the WooFramework Media Library-driven
/* AJAX File Uploader Module. It is included only on screens where this module is used.
/*
/* Used with (very) slight modifications for Options Framework.
/*-----------------------------------------------------------------------------------*/
( function ($) {

	shortcode_upload = {
	mediaUpload: function () {
		jQuery.noConflict();
		
		$( 'input.upload_sc' ).removeAttr('style');
		var formfield,formID,btnContent = true,tbframe_interval,custom_uploader;
		
		// On Click
		$('input.upload_sc').live("click", function () {
			formfield =  $(this).prev('input').attr('id');
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}
			
			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose This',
				button: {
				text: 'Choose This'
				},
					multiple: false
			});
			
			//
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				if(typeof(attachment.sizes)  != "undefined") {
					jQuery( '#' + formfield).val(attachment.url);
				}else{
					jQuery( '#' + formfield).val(attachment.url);
				}
			});

			//Open the uploader dialog
			custom_uploader.open();
			return false;
		});
     } // End mediaUpload
   }; 
	$(document).ready(function () {
		shortcode_upload.mediaUpload();
	});
})(jQuery);