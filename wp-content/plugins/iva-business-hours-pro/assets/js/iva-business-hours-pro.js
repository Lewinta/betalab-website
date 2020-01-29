jQuery(document).ready(function($){
	// Delete Holiday
	jQuery("#iva_bh_holiday_wrap").on('click', '.delete_bh_hd', function(){
		addrow = jQuery(this).parent().parent();
		if(jQuery('.iva_bh_holiday_row').length > 1 ){
			addrow.remove();
		}else{
			alert('Insert at-least One Field');
		}
		return false;
	});

	jQuery("#add_bh_holidays").click(function($) {
		$c = jQuery('.iva_bh_holiday_row').length + 1;
		jQuery('input.iva_bh_date').datepicker("destroy");
		jQuery('.iva_bh_holiday_row:first').clone().appendTo( ".iva_bh_holiday_count" );
		// jQuery('.iva_bh_holiday_row:last').find('.wp-color-result').hide();
		jQuery('.iva_bh_holiday_row:last').find('.wpcolorpicker').wpColorPicker();
		jQuery('.iva_bh_holiday_row:last').find('input[type="text"]').val('');
		jQuery('.iva_bh_holiday_row:last').find('input[type="checkbox"]').attr('checked',false);
		jQuery('.iva_bh_holiday_row:last').find('input[type="checkbox"]').attr('id','iva_bh_hd_desc_disable'+ $c );
		jQuery('.iva_bh_holiday_row:last').find('input[type="checkbox"]').next('label').attr('for','iva_bh_hd_desc_disable'+ $c );

		jQuery('.iva_bh_date').each(function(j) {
		this.id = 'date_picker' + j;
		}).datepicker({ dateFormat: iva_bh_panel.date_format,beforeShow: iva_bh_select_date});

		return false;
	});

	//
	jQuery('.iva_bh_date').each(function(j) {
	   this.id = 'date_picker' + j;
	}).datepicker({ dateFormat: iva_bh_panel.date_format,beforeShow: iva_bh_select_date });

	// Date Picker
	function iva_bh_select_date() {
		if( jQuery('#'+this.id).hasClass( 'iva_bh_hd_end') > 0 ){
			var iva_bh_hd_start_id   = ( parseInt(this.id.replace(/[^0-9]/gi, '') )-1);
			var iva_bh_hd_start_date = jQuery( '#date_picker' + iva_bh_hd_start_id ).datepicker( 'getDate' );
			var iva_bh_hd_min_date 	 = $.datepicker.formatDate( iva_bh_panel.date_format ,iva_bh_hd_start_date );
			jQuery(this).datepicker('option', 'minDate', iva_bh_hd_min_date );
		 }
	}
	jQuery(".ui-datepicker").addClass("iva-bh-date-ui");

	// Settings
	jQuery(".update_bh_settings").click(function() {
		var iva_bh_url = jQuery('.update_bh_settings').attr("data_ivbh_url");
		var iva_bhp_setting_nonce = jQuery('#iva_bhp_setting_nonce').val();
		$.ajax({
			url: ajaxurl ,
			type: 'post',
			dataType: 'html',
			data: {
				'action' : 'iva_bh_update_settings',
				'setting_nonce':iva_bhp_setting_nonce,
				'data'   : jQuery(".iva_bh_settings_form").iva_bh_serialize({ checkboxesAsBools: true }),
			},
			success: function( response ){
				jQuery('#settings_success_msg').html(response);
				jQuery('#iva_bh_msg .notice-dismiss').click( function(){
					jQuery("#iva_bh_msg").slideUp("slow");
				});
			}
		});
	}).change();

	// Holidays
	jQuery(".update_bh_holidays").click(function() {
		var iva_bh_url = jQuery('.update_bh_holidays').attr("data_ivbh_url");
		var iva_bhp_holiday_nonce = jQuery('#iva_bhp_holiday_nonce').val();
		$.ajax({
			url: ajaxurl ,
			type: 'post',
			dataType: 'html',
			data: {
				'action' : 'iva_bh_update_holidays',
				'holiday_nonce':iva_bhp_holiday_nonce,
				'data'   : jQuery(".iva_bh_holidays_form").iva_bh_serialize({ checkboxesAsBools: true }),
			},
			success: function( response ){
				jQuery('#holidays_success_msg').html(response);
				jQuery('#iva_bh_msg .notice-dismiss').click( function(){
					jQuery("#iva_bh_msg").slideUp("slow");
				});
				document.location = iva_bh_url;
			}
		});
	}).change();

	// Add Hours
	jQuery(".add_bhrs").click(function() {
		var iva_bh_url = jQuery(this).attr("data_ivbh_url");
		// alert(ajaxurl);
		$.ajax({
			// url: 'http://localhost/wordpress49/wp-admin/admin.php?page=bhrs-operations',
			// url:ajaxurl,
			type: 'post',
			dataType: 'html',
			success: function( response ){
				document.location = iva_bh_url;
			}
		});
	});

	// Create Hours
	jQuery(".create_bhrs").click(function() {
		var iva_bh_url = jQuery(this).attr("data_ivbh_url");
		var iva_bhp_create_nonce = jQuery('#iva_bhp_create_nonce').val();
		$.ajax({
			url: ajaxurl,
			type: 'post',
			dataType: 'html',
			data: {
				'action' : 'iva_bh_insert',
				'create_nonce':iva_bhp_create_nonce,
				'data'   : jQuery(".iva_bh_create_form").serialize()
			},
			success: function( response ){
				jQuery('#create_success_mg').html(response);
				// console.log( response );
				// if( jQuery( '#iva_bh_msg' ).hasClass( "success" ) ){
					// document.location = iva_bh_url;
				// }
			}
		});
	});

	// Delete Hours
	jQuery(".delete_bhrs").click(function() {
		var iva_bh_id	= jQuery(this).attr("data_iva_bhid");
		var iva_bh_url = jQuery(this).attr("data_ivbh_url");
		var iva_bhp_delete_nonce = jQuery('#iva_bhp_delete_nonce').val();
		if(confirm("Are you sure you want to delete this business hours?")){
			$.ajax({
				url: ajaxurl ,
				type: 'post',
				dataType: 'html',
				data: {
					'action' : 'iva_bh_delete',
					'delete_nonce':iva_bhp_delete_nonce,
					'iva_bh_id': iva_bh_id,
				},
				success: function( response ){
					jQuery('#iva_bh_message').html(response);
					if( jQuery( '#iva_bh_msg' ).hasClass( "success" ) ){
						document.location = iva_bh_url;
					}
				}
			});
		}
	});

	//Export hours
	jQuery(".export_bhrs").click(function(){
		var action = 'export_bhrs';
		var iva_bh_id = jQuery(this).attr("data_iva_bhid");
		$.ajax({
			url : iva_bh_panel.plugin_url + 'iva-bhrs-import-export.php',
			data : {
				iva_bh_id:iva_bh_id,
			},
			success: function( response ){
				window.location	= iva_bh_panel.plugin_url + 'iva-bhrs-import-export.php?action=' + action + '&iva_bh_id=' + iva_bh_id;
			}
		});
	});
	jQuery(".iva_bh_close").click(function() {
		var iva_bh_url = jQuery(this).attr("data_ivbh_url");
		$.ajax({
			url: ajaxurl ,
			type: 'post',
			dataType: 'html',
			success: function( response ){
				document.location = iva_bh_url;
			}
		});
	});
	jQuery(".update_bhrs").click(function() {
		var iva_bh_id = jQuery(this).attr("data_iva_bhid");
		var iva_bh_url = jQuery(this).attr("data_ivbh_url");
		var iva_bhp_edit_nonce = jQuery('#iva_bhp_edit_nonce').val();

		$.ajax({
			url: ajaxurl ,
			type: 'post',
			dataType: 'html',
			data: {
				'action' : 'iva_bh_update',
				'iva_bh_id': iva_bh_id,
				'edit_nonce':iva_bhp_edit_nonce,
				'data'	 : jQuery(".iva_bh_update_form").serialize()
			},
			success: function( response ){
				jQuery("#update_success_mg").css( "display", "block" );
				jQuery('#update_success_mg').html(response);
				if( jQuery( '#iva_bh_msg' ).hasClass( "success" ) ){
					document.location = iva_bh_url;
				}
				jQuery('#iva_bh_msg .notice-dismiss').click( function(){
					jQuery("#iva_bh_msg").slideUp("slow");
				});
			}
		});
	});
	//
	jQuery(".iva_bh_latenight_hrs_enable").change(function(){
		if(jQuery('.iva_bh_latenight_hrs_enable').is(':checked') != true) {
			jQuery(".iva_bh_latenight_hrs_div").slideUp();
		}else{
			jQuery(".iva_bh_latenight_hrs_div").slideDown();
		}
	}).change();
});

jQuery(document).ready(function ($) {
	jQuery(".ui-dialog").addClass("iva_bh_dialog");
	// Edit alias
	$('.bhrs-edit-alias').bind('keyup keypress blur', function(){
		var editalias = $(this).val()
		editalias = editalias.toLowerCase();
		editalias = editalias.replace(/ /g, '-');
		editalias = editalias.replace(/(^\s+|[^a-zA-Z0-9-]+|\s+$)/g,"");//this one
		var bhrs_shortcode 	= '[iva_bhrs name="'+editalias+'"]';
		$('.bhrs-edit-shortcode').val( bhrs_shortcode );
	});
	//Alias
	$('.bhrs-alias').bind('keyup keypress blur', function(){
		var alias = $(this).val()
		alias = alias.toLowerCase();
		alias = alias.replace(/ /g, "-");
		alias = alias.replace(/(^\s+|[^a-zA-Z0-9-]+|\s+$)/g,"");//this one
		var bhrs_shortcode 	= '[iva_bhrs name="'+alias+'"]';
		$('.bhrs-shortcode').val( bhrs_shortcode );
	});

	/**
	 * Business Hours Add / Remove period.
	 */
	var iva_bh_Period = {

		init : function() {
			this.clone();
			this.add();
			this.remove();
			this.reindex();
		},
		clone : function( day, period ) {

			// Clone the hidden row.
			clone = $( '#iva_business_row' ).clone( true );

			// Change the id and name attributes to the supplied day/period variable.
			clone.find( 'input' ).each( function() {
				var name = $( this ).attr( 'name' );
				name = name.replace( /(\[day\]\[period\])/, '[' + parseInt( day ) + '][' + parseInt( period ) + ']' );
				$( this ).attr( 'name', name ).attr( 'id', name );
			});

			// add timepicker
			clone.find( 'input:not(".iva_bh_latetime,.iva_bh_starttime")').each( function() {

				var name = $( this ).attr( 'name' );

					name = name.replace( /(\[day\]\[period\])/, '[' + parseInt( day ) + '][' + parseInt( period ) + ']' );

					// Disable manual text entry on the time inputs.
					// Bind the timepicker to the inputs.
					// Set the name and id attributes.

					jQuery("#ui-datepicker-div").addClass("iva_bh_timepicker");

					$( this ).attr( 'name', name ).attr( 'id', name ).addClass('iva_bh_timepicker').iva_timepicker( iva_bh_timepicker_options );

			});

			// Add the data-key attribute to the buttons.
			clone.find('.button').attr( 'data-day', day );

			// Remove the #iva_bh-period id attrribute and add teh iva_bh-day-# class and then unhide the cloned <tr>.
			clone.removeAttr('id').addClass( 'iva_bh-day-' + day ).toggle();

			return clone;
		},
		add : function() {
			$('.iva_bh-add-period').on('click', function() {

				day  = $( this ).attr('data-day');
				row  = $( this ).closest('tr');

				// Increment the period counter for the day.
				data = $('#iva_bh-day-' + day ).iva_bh_Count( 1 ).data();

				// Insert the cloned row after the current row.
				row.after( iva_bh_Period.clone( day, data.count ) );

				// After adding a row, the periods need to be reindexed.
				iva_bh_Period.reindex( day );
			});
		},
		remove : function() {

			$('.iva_bh-remove-period').on('click', function() {
				if( confirm( 'Are you sure you want to delete period?' ) ){
					day = $( this ).attr('data-day'); //
					row = $( this ).closest('tr');

					// Decrement the period counter for the day.
					data = $('#iva_bh-day-' + day ).iva_bh_Count( -1 ).data();

					row.remove();

					// After removing a row, the periods need to be reindexed.
					iva_bh_Period.reindex( day );
				}
			});
		},
		reindex : function( day ) {

			// Process each row of the specified day.
			$( '.iva_bh-day-' + day ).each( function( i, row ) {

				// In each row find the inputs.
				$( row ).find( 'input' ).each( function() {
				// Grab the name of the current row being processed.
					var name = $( this ).attr( 'name' );

					// Replace the name with the current day and index.
					name = name.replace( /\[(\d+)\]\[(\d+)\]/, '[' + parseInt( day ) + '][' + parseInt( i ) + ']' );

					// Update both the name and id attributes with the new day and index.
					$( this ).attr( 'name', name ).attr( 'id', name );
				});
			});
		}
	}

	iva_bh_Period.init();

	iva_bh_timepicker_options.onSelect = function(){
		$(this)[tog(this.value)]('x');
	};

	// Disable manual text entry on the time inputs.
	// Bind the timepicker to the inputs.
	$('.iva_bh_timepicker').iva_timepicker( iva_bh_timepicker_options );

	// @see http://stackoverflow.com/a/6258628
	function tog(v){ return v ? 'addClass' : 'removeClass'; }

	$(document).on('mousemove', '.x', function( e ){

		$(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');
	}).on('click', '.onX', function(){
		$(this).removeClass('x onX').val('');
	});

	// Counter Functions Credit:
	// http://stackoverflow.com/a/5656660
	$.fn.iva_bh_Count = function( val ) {
		return this.each( function() {
			var data = $( this ).data();
			if ( ! ( 'count' in data ) ) {
				data['count'] = 0;
			}
			data['count'] += val;
		});
	};
});
(function ($) {
    $.fn.iva_bh_serialize = function (options) {
        return $.param(this.iva_bh_serializeArray(options));
    };
    $.fn.iva_bh_serializeArray = function (options) {
        var o = $.extend({
        checkboxesAsBools: false
    }, options || {});

    var rselectTextarea = /select|textarea/i;
    var rinput = /text|hidden|password|search/i;

    return this.map(function () {
        return this.elements ? $.makeArray(this.elements) : this;
    })
    .filter(function () {
        return this.name && !this.disabled && (this.checked || (o.checkboxesAsBools && this.type === 'checkbox') || rselectTextarea.test(this.nodeName) || rinput.test(this.type));
        })
        .map(function (i, elem) {
            var val = $(this).val();
            return val == null ?
            null :
            $.isArray(val) ?
            $.map(val, function (val, i) {
                return { name: elem.name, value: val };
            }) :
            {
                name: elem.name,
                value: (o.checkboxesAsBools && this.type === 'checkbox') ? //moar ternaries!
                        (this.checked ? 'on' : 'off') :
                        val
            };
        }).get();
    };
jQuery(document).ready(function(){
	jQuery(".wpcolorpicker").wpColorPicker({
		color: "#0000ff",
		onShow: function (colpkr) {
			jQuery(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			jQuery(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			jQuery(".wpcolorpicker' div").css("backgroundColor", "#" + hex);
			jQuery(".wpcolorpicker").next("input").attr("value","#" + hex);
			jQuery(".wpcolorpicker").val("#" + hex);
		}
	});
});
})(jQuery);
