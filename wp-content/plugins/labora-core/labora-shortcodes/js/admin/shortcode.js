var es_shortcode = {
    init: function () {
		//jQuery('.primary_select select').val('');
        jQuery('.primary_select select').change(function () {
            jQuery('.secondary_select').hide();
            if (this.value != '') {
                if (jQuery('#secondary_' + this.value).show().children('.tertiary_select').size() == 0) {
                    jQuery('#secondary_' + this.value).show();
                }
            }
        }).change();

        jQuery('#sendtoeditor').click(function () {
            es_shortcode.sendToEditor();
        });

       // jQuery('.secondaryselect select').val('');
        jQuery('.secondaryselect select').change(function () {
            jQuery(this).closest('.secondary_select').children('.tertiary_select').hide();
            if (this.value != '') {
                jQuery('#atp-' + this.value).show();
            }
        }).change();
    },
    es_generate: function () {
        var type = jQuery('.primary_select select').val();
        switch (type) {

            // C O L U M N   L A Y O U T S
            //--------------------------------------------------------
        case 'Columns':

            var types = jQuery('[name="Columns_type"]').val();
            if (types != '') {
                var content = jQuery('[name="Columns_content"]').val();
                return '\n[' + types + ']\n' + content + '\n[/' + types + ']\n';
            } else {
                return '';
            }
            break;

           // Layouts
		case 'Layouts':
			var secondary_type = jQuery('#secondary_Layouts select').val();
			switch (secondary_type) {
			// 1/2 - 1/2
			case 'one_half_layout':
				return '[one_half no_margin="false"]' + 'Content here' + '[/one_half]\n[one_half_last no_margin="false"]' + 'Content here' + '[/one_half_last]';
				break;
			// 1/3 - 1/3 - 1/3
			case 'one_third_layout':
				return '[one_third no_margin="false"]' + 'Content here' + '[/one_third]\n[one_third no_margin="false"]' + 'Content here' + '[/one_third]\n[one_third_last no_margin="false"]' + 'Content here' + '[/one_third_last]\n';

				break;
			// 1/4 - 1/4 - 1/4 - 1/4
			case 'one_fourth_layout':
				return '[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[one_fourth_last no_margin="false"]' + 'Content here' + '[/one_fourth_last]\n';
				break;
			// 1/5 - 1/5 - 1/5 - 1/5 - 1/5
			case 'one5thlayout':
				return '[one_fifth no_margin="false"]' + 'Content here' + '[/one_fifth]\n[one_fifth no_margin="false"]' + 'Content here' + '[/one_fifth]\n[one_fifth no_margin="false"]' + 'Content here' + '[/one_fifth]\n[one_fifth no_margin="false"]' + 'Content here' + '[/one_fifth]\n[one_fifth_last no_margin="false"]' + 'Content here' + '[/one_fifth_last]\n';
				break;
			//  1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6
			case 'one6thlayout':
				return '[one_sixth no_margin="false"]' + 'Content here' + '[/one_sixth]\n[one_sixth no_margin="false"]' + 'Content here' + '[/one_sixth]\n[one_sixth no_margin="false"]' + 'Content here' + '[/one_sixth]\n[one_sixth no_margin="false"]' + 'Content here' + '[/one_sixth]\n[one_sixth no_margin="false"]' + 'Content here' + '[/one_sixth]\n[one_sixth_last no_margin="false"]' + 'Content here' + '[/one_sixth_last]\n';
				break;
			// 1/3 - 2/3
			case 'one_3rd_2rd':
				return '[one_third no_margin="false"]' + 'Content here' + '[/one_third]\n[two_third_last no_margin="false"]' + 'Content here' + '[/two_third_last]\n';
				break;
			// 2/3 - 1/3
			case 'two_3rd_1rd':
				return '[two_third no_margin="false"]' + 'Content here' + '[/two_third]\n[one_third_last no_margin="false"]' + 'Content here' + '[/one_third_last]\n';
				break;
			// 1/4 - 3/4
			case 'One_4th_Three_4th':
				return '[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[three_fourth_last no_margin="false"]' + 'Content here' + '[/three_fourth_last]\n';
				break;
			// 3/4 - 1/4
			case 'Three_4th_One_4th':
				return '[three_fourth no_margin="false"]' + 'Content here' + '[/three_fourth]\n[one_fourth_last no_margin="false"]' + 'Content here' + '[/one_fourth_last]\n';
				break;
			// 1/4 - 1/4 - 1/2
			case 'One_4th_One_4th_One_half':
				return '[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[one_half_last no_margin="false"]' + 'Content here' + '[/one_half_last]\n';
				break;
			//  1/2 - 1/2 - 1/4 -
			case 'One_half_One_4th_One_4th':
				return '[one_half no_margin="false"]' + 'Content here' + '[/one_half]\n[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[one_fourth_last no_margin="false"]' + 'Content here' + '[/one_fourth_last]\n';
				break;
			//  1/4 - 1/2 - 1/4
			case 'One_4th_One_half_One_4th':
				return '[one_fourth no_margin="false"]' + 'Content here' + '[/one_fourth]\n[one_half no_margin="false"]' + 'Content here' + '[/one_half]\n[one_fourth_last no_margin="false"]' + 'Content here' + '[/one_fourth_last]\n';
				break;
			//  1/5 - 4/5
			case 'One_5th_Four_5th':
				return '[one_fifth no_margin="false"]' + 'Content here' + '[/one_fifth]\n[four_fifth_last no_margin="false"]' + 'Content here' + '[/four_fifth_last]\n';
				break;
			//  4/5 - 1/5
			case 'Four_5th_One_5th':
				return '[four_fifth no_margin="false"]' + 'Content here' + '[/four_fifth]\n[one_fifth_last no_margin="false"]' + 'Content here' + '[/one_fifth_last]\n';
				break;
			// 2/5 - 3/5
			case 'Two_5th_Three_5th':
				return '[two_fifth no_margin="false"]' + 'Content here' + '[/two_fifth]\n[three_fifth_last no_margin="false"]' + 'Content here' + '[/three_fifth_last]\n';
				break;
			// 3/5 - 2/5
			case 'Three_5th_Two_5th':
				return '[three_fifth no_margin="false"]' + 'Content here' + '[/three_fifth]\n[two_fifth_last no_margin="false"]' + 'Content here' + '[/two_fifth_last]\n';
				break;
			}
			break;


		// Partial Section
        //--------------------------------------------------------
		 case 'partial_section':
			var ps_align 				= jQuery('[name="partial_section_align"]').val();
			var ps_bgimage       		= jQuery('[name="partial_section_bg_image"]').val();
			var ps_attachment 			= jQuery('[name="partial_section_bg_attachment"]').val();
			var ps_repeat     	 		= jQuery('[name="partial_section_bg_repeat"]').val();
			var ps_position   	 		= jQuery('[name="partial_section_bg_position"]').val();
			var ps_bgcolor    	 		= jQuery('[name="partial_section_bg_color"]').val();
			var ps_content  		  	= jQuery('[name="partial_section_content"]').val();
			var ps_content_bgcolor   	= jQuery('[name="partial_section_content_bg_color"]').val();
			var ps_content_text_color	= jQuery('[name="partial_section_content_text_color"]').val();

			if (ps_align !== '') {
				ps_align = ' ps_align="' + ps_align + '"';
			}

			if ( ps_bgimage !== '' ) {
				ps_bgimage = ' ps_image="' + ps_bgimage + '"';
			}
			if ( ps_bgcolor !== '') {
				ps_bgcolor = ' ps_bgcolor="' + ps_bgcolor + '"';
			}else { ps_bgcolor =''};

			if ( ps_attachment !== '' ) {
				ps_attachment = ' ps_attachment="' + ps_attachment + '"';
			}
			if ( ps_repeat !== '' ) {
				ps_repeat = ' ps_repeat="' + ps_repeat + '"';
			}
			if ( ps_position !== '') {
				ps_position = ' ps_position="' + ps_position + '"';
			}

			if ( ps_content !== '') {
				ps_content =  ps_content;
			}else{
				ps_content =  'Content Here...';
			}

			if ( ps_content_bgcolor !== '') {
				ps_content_bgcolor = ' ps_content_bgcolor="' + ps_content_bgcolor + '"';
			}else { ps_content_bgcolor =''};

			if ( ps_content_text_color !== '') {
				ps_content_text_color = ' ps_content_text_color="' + ps_content_text_color + '"';
			}else { ps_content_text_color =''};

			return '\n[partial_section' + ps_align + ps_bgimage + ps_bgcolor + ps_attachment + ps_repeat + ps_position +  ps_content_bgcolor + ps_content_text_color +']'+ ps_content +'[/partial_section]';
			break;

            // D R O P C A P
            //--------------------------------------------------------
        case 'dropcap':
			var type			= jQuery('[name="dropcap_type"]').val();
			var text			= jQuery('[name="dropcap_text"]').val();
			var text_color		= jQuery('[name="dropcap_textcolor"]').val();
			var bgcolor			= jQuery('[name="dropcap_bgcolor"]').val();
			var droptype		= jQuery('#dropcap_type').val();

			if ( type )			{ type = ' type="' + type + '"'; }
			if ( text )			{ text = ' letter="' + text + '"'; }
			if ( text_color )	{ text_color = ' text_color="' + text_color + '"'; }
			if ( bgcolor )		{ bgcolor = ' bgcolor="' + bgcolor + '"'; }

			if(droptype == 'dropcap3'){
				return '[dropcap'+ type + text_color + text +']';
			}else{
				return '[dropcap'+ type + bgcolor + text_color + text +']';
			}
			break;

            // G O O G L E   F O N T
            //--------------------------------------------------------
        case 'googlefont':
			var font	= jQuery('[name="googlefont_font"]').val();
			var size	= jQuery('[name="googlefont_size"]').val();
			var margin	= jQuery('[name="googlefont_margin"]').val();
			var text	= jQuery('[name="googlefont_text"]').val();
			var weight	= jQuery('[name="googlefont_weight"]').val();
			var extend	= jQuery('[name="googlefont_extend"]').val();
			var fontstyle	= jQuery('[name="googlefont_font_style"]');
			var color	= jQuery('[name="googlefont_color"]').val();

			if ( font ) 	{ font = ' font="' + font + '"'; }
			if ( size ) 	{ size = ' size="' + size + '"'; }
			if ( margin ) 	{ margin = ' margin="' + margin + '"'; }
			if( weight ) 	{ weight = ' weight="' + weight + '"'; }
			if( extend ) 	{ extend = ' extend="' + extend + '"'; }
			if ( text ) 	{ text = '' + text + ''; }
			if ( color ) 	{ color = ' color="' + color + '"'; }
			if (fontstyle.is(':checked')) {
				fontstyle = ' fontstyle="true"';
			} else {
				fontstyle = ' fontstyle="false"';
			}

			return '[googlefont' + font + size + margin + weight + color + extend + fontstyle + ']' + text + '[/googlefont]';
			break;

            // H I G H L I G H T
            //--------------------------------------------------------
        case 'highlight':
            var text_color 		= jQuery('[name="highlight_textcolor"]').val();
			var bgcolor 		= jQuery('[name="highlight_bgcolor"]').val();
			var text 			= jQuery('[name="highlight_text"]').val();
			var type 			= jQuery('[name="highlight_type"]').val();
			var highlight_type 	= jQuery('#highlight_type').val();

			if ( text )				{ text = '' + text + ''; }
			if ( bgcolor )			{ bgcolor = ' bgcolor="' + bgcolor + '" '; }
			if ( type )				{ type = ' type="' + type + '" '; }
			if ( text_color )		{ text_color = ' text_color="' + text_color + '" '; }

			if(highlight_type == 'highlight1'){
				return '[highlight' + bgcolor + text_color + type +']' + text + '[/highlight]';
			}else{
				return '[highlight' +  text_color + type +']'+text +'[/highlight]';
			}
			break;

 			// F A N C Y   H E A D I N G
            //--------------------------------------------------------
        case 'fancyheading':
			var fancy_style       = jQuery('[name="fancyheading_styles"]').val();
            var headingcolor 		= jQuery('[name="fancyheading_headingcolor"]').val();
			var sepcolor 			= jQuery('[name="fancyheading_sepcolor"]').val();
			var fancy_icon_color  = jQuery('[name="fancyheading_fancy_icon_color"]').val();
			var fancy_border_color  = jQuery('[name="fancyheading_border_color"]').val();
			var heading 			= jQuery('[name="fancyheading_heading"]').val();
			var align 				= jQuery('[name="fancyheading_align"]').val();
			var title 				= jQuery('[name="fancyheading_title"]').val();
			var subtitle 			= jQuery('[name="fancyheading_subtitle"]').val();
			var heading_style       = jQuery('[name="fancyheading_heading_style"]').val();
			var margin_bottom 		= jQuery('[name="fancyheading_marginbottom"]').val();
			var fancy_border_v6 		= jQuery('[name="fancyheading_fancy_border_v6"]').val();

			if ( fancy_style !== '' ) {
				fancy_style = ' fancy_style="' + fancy_style + '"';
			}
			if ( fancy_border_color !== '' ) {
				fancy_border_color = ' border_color="' + fancy_border_color + '"';
			}
			if ( fancy_border_v6 !== '' ) {
				fancy_border_v6 = ' fancy_border="' + fancy_border_v6 + '"';
			}
			if (title !== '') {
				title = ' title="' + title + '"';
			}
			if (subtitle !== '') {
				subtitle = ' subtitle="' + subtitle + '"';
			}
			if (headingcolor !== '') {
				headingcolor = ' headingcolor="' + headingcolor + '"';
			}

			if (sepcolor !== '') {
				sepcolor = ' sepcolor="' + sepcolor + '"';
			}
			if ( fancy_icon_color !== '' ) {
				fancy_icon_color = ' icon_color="' + fancy_icon_color + '"';
			}
			

			if(border_width !== ''){
				border_width = ' border_width="' + border_width + '"';
			}
			if(border_color !== ''){
				border_color = ' border_color="' + border_color + '"';
			}
			if (heading !== '') {
				heading = ' heading="' + heading + '"';
			}
			if (align !== '') {
				align = ' align="' + align + '"';
			}
			if (margin_bottom !== '') {
				margin_bottom = ' margin_bottom="' + margin_bottom + '"';
			}
				return '\n[fancyheading' + fancy_style + headingcolor + sepcolor + heading + align  + title + margin_bottom + subtitle + fancy_icon_color + fancy_border_v6 + fancy_border_color +']\n';
			break;

			// F u n  F a c t
			//--------------------------------------------------------
		case 'funfact':
			var main_title 	= jQuery('[name="funfact_main_title"]').val();
			var icon_style 	= jQuery('[name="funfact_funfact_iconstyle"]').val();
			var icon_color 	= jQuery('[name="funfact_icon_color"]').val();
			var data_value 	= jQuery('[name="funfact_data_value"]').val();
			var title_color = jQuery('[name="funfact_title_color"]').val();
			var data_number = jQuery('[name="funfact_data_number"]').val();
			var position 	= jQuery('[name="funfact_position"]').val();

			if (icon_style !== '') {
				icon_style = ' icon_style="' + icon_style + '"';
			}
			if (icon_color !== '') {
				icon_color = ' icon_color="' + icon_color + '"';
			}
			if (main_title !== '') {
				main_title = ' main_title="' + main_title + '"';
			}
			if (data_value !== '') {
				data_value = ' data_value="' + data_value + '"';
			}
			if ( title_color !== '') {
				title_color = ' title_color="' + title_color + '"';
			}
			if (data_number !== '') {
				data_number = '  data_number="' + data_number + '"';
			}
			if (position !== '') {
				position = '  position="' + position + '"';
			}
			return '\n[funfact' + icon_style + icon_color + data_value + data_number + main_title + title_color + position+ ']\n';
			break;

            // Section Row
            //--------------------------------------------------------
        case 'section':
         	var textcolor   = jQuery('[name="section_textcolor"]').val();
			var bgcolor     = jQuery('[name="section_bgcolor"]').val();
			var text        = jQuery('[name="section_text"]').val();
			var padding     = jQuery('[name="section_padding"]').val();
			var video       = jQuery('[name="section_video"]').val();

			var bgimage     = jQuery('[name="section_bgimage"]').val();
			var attachment  = jQuery('[name="section_bg_attachment"]').val();
			var repeat      = jQuery('[name="section_bg_repeat"]').val();
			var position    = jQuery('[name="section_bg_position"]').val();

			var opacity     = jQuery('[name="section_opacity"]').val();
			var parallax    = jQuery('[name="section_parallax"]');
			var border_width  = jQuery('[name="section_border_width"]').val();
			var border_color  = jQuery('[name="section_border_color"]').val();
			var pattern     =jQuery("input[name='section_videopattern']:checked").val();
			if (text !== '') {
				text = '' + text + '';
			}
			if (textcolor !== '') {
				textcolor = ' textcolor="' + textcolor + '"';
			}
			if (padding !== '') {
				padding = ' padding="' + padding + '"';
			}

			if (bgcolor !== '') {
				bgcolor = ' bgcolor="' + bgcolor + '"';
			}
			else {bgcolor =''};

			if (bgimage !== '') {
				bgimage = ' image="' + bgimage + '"';
			}

			if (position !== '') {
				position = ' position="' + position + '"';
			}

			if (attachment !== '') {
				attachment = ' attachment="' + attachment + '"';
			}

			if (repeat !== '') {
				repeat = ' repeat="' + repeat + '"';
			}

			if (border_width !== '') {
				border_width = ' border_width="' + border_width + '"';
			}
			if (border_color !== '') {
				border_color = ' border_color="' + border_color + '"';
			}
			if (pattern) {
				pattern = ' pattern="' + pattern + '"';
			}else{
				pattern='';
			}
			if (video !== '') {
					video = ' video="' + video + '"';
				}
			if (opacity !== '') {
					opacity = ' opacity="' + opacity + '"';
				}			if (parallax.is('.iva-button')){
			if (parallax.is(':checked')) {
				parallax = ' parallax="true"';
			} else {
				parallax = ' parallax="false"';
				}
			}
			return '\n[section' + bgcolor + textcolor + padding + bgimage + video + opacity +border_width + border_color + parallax + pattern + position + repeat + attachment +  ']Content Here[/section]\n';
			break;

            // B L O C K Q U O T E
            //--------------------------------------------------------
        case 'blockquote':
			var qalign				= jQuery('[name="blockquote_qalign"]').val();
			var cite 				= jQuery('[name="blockquote_cite"]').val();
			var citelink 			= jQuery('[name="blockquote_citelink"]').val();
			var content				= jQuery('[name="blockquote_content"]').val();
			var width 				= jQuery('[name="blockquote_width"]').val();
			var animation   		= jQuery('[name="blockquote_animation"]').val();
			var background_color 	= jQuery('[name="blockquote_background_color"]').val();
			var text_color 			= jQuery('[name="blockquote_text_color"]').val();

			var bg_color = txt_color = '';

			if (content !== '') {
				content = '' + content + '';
			}

			if( qalign !== '') {
				qalign = ' align="' + qalign + '"';
			}

			if (animation !== '') {
				animation = ' animation="' + animation + '"';
			}

			if (cite !== '') {
				cite = ' cite="' + cite + '"';
			}
			if (citelink !== '') {
				citelink = ' citelink="' + citelink + '"';
			}
			if (width !== '') {
				width = ' width="' + width + '"';
			}
			if (background_color !== '') {
				bg_color = ' bg_color="' + background_color + '"';
			}
			if (text_color !== '') {
				txt_color = ' txt_color="' + text_color + '"';
			}
			return '[blockquote' + qalign + width + cite + citelink + animation + bg_color + txt_color + ']' + content + '[/blockquote]\n';
			break;

			// C U S T O M   A N I M A T I O N
            //--------------------------------------------------------
			case 'custom_animation':
				var animation 	= jQuery('[name="custom_animation_animation"]').val();
				var content 	= jQuery('[name="custom_animation_content"]').val();
				var position 	= jQuery('[name="custom_animation_tooltip_position"]').val();
				var caption     = jQuery('[name="custom_animation_caption"]').val();
				if(position){
					position = ' position="' + position + '"';
				}
				if(caption){
					caption = ' caption="' + caption + '"';
				}
				if (animation !== '') {
					animation = ' animation="' + animation + '"';
				}
				if (content !== '') {
					content = '' + content + '';
				}
				return '[custom_animation' + position + caption + animation + ']' + content + '[/custom_animation]\n';
				break;

			// S T Y L E D   L I S T S
            //--------------------------------------------------------
				case 'styledlist':
					var icon = jQuery('[name="styledlist_icon"]').val();
					var color = jQuery('[name="styledlist_color"]').val();
					var icon_type = jQuery('[name="styledlist_type"]').val();
					var faicon  = jQuery('[name="styledlist_faicon"]').val();
					var peicon  = jQuery('[name="styledlist_peicon"]').val();
					var circle_bg = jQuery('[name="styledlist_circle_bg"]').val();
							var liststyle = jQuery('[name="styledlist_liststyle"]').val();
					var content = jQuery('[name="styledlist_content"]').val();

							cont = content.split("\n");
							var  html ='';
							for( i = 0; i < cont.length; i++ ) {
								html += "<li>"+cont[i]+"</li>\n"; ;
							}

							if ( content ) { content = '' + content + ''; }
							if ( icon ) { icon = ' icon="' + icon + '"';
							}
							if (color ) {
								color = ' color="' + color + '"';
							}
					if (circle_bg ) {
								circle_bg = ' bgcolor="' + circle_bg + '"';
							}
							if (liststyle ) {
								liststyle = ' liststyle="' + liststyle + '"';
							}
					if ( icon_type ) {
					icon_type = ' icon_type="' + icon_type + '"';
					}
					if ( faicon ) {
					faicon = ' faicon="' + faicon + '"';
					}
					if ( peicon ) {
					peicon = ' peicon="' + peicon + '"';
					}

					return '\n[list' + icon_type + faicon + peicon + color + circle_bg + liststyle +  ']\n' + "<ul>\n" +html+"</ul>" +'\n[/list]\n';
					break;

					// I c o n  L i s t  I t e m
					//--------------------------------------------------------
						case 'list_icon_item':
							var icon_color		= jQuery('[name="list_icon_item_icon_color"]').val();
							var icon_bgcolor	= jQuery('[name="list_icon_item_icon_bgcolor"]').val();
							var icon_type		= jQuery('[name="list_icon_item_icon_type"]').val();
							var icon_list_style		= jQuery('[name="list_icon_item_icon_list_style"]').val();
							var faicon			= jQuery('[name="list_icon_item_faicon"]').val();
							var peicon			= jQuery('[name="list_icon_item_peicon"]').val();
							var title_color		= jQuery('[name="list_icon_item_title_color"]').val();
							var title_txt		= jQuery('[name="list_icon_item_title_txt"]').val();
							var title_txt_size	= jQuery('[name="list_icon_item_title_txt_size"]').val();

							if ( icon_type ) {
							icon_type = ' icon_type="' + icon_type + '"';
							}
							if ( icon_color ) {
							icon_color = ' icon_color="' + icon_color + '"';
							}
							if ( icon_bgcolor ) {
							icon_bgcolor = ' icon_bgcolor="' + icon_bgcolor + '"';
							}
							if ( faicon ) {
							faicon = ' faicon="' + faicon + '"';
							}
							if ( peicon ) {
							peicon = ' peicon="' + peicon + '"';
							}
							if (icon_list_style ) {
								icon_list_style = ' icon_list_style="' + icon_list_style + '"';
							}
							if ( title_color ) {
							title_color = ' title_color="' + title_color + '"';
							}
							if ( title_txt ) {
							title_txt = ' title_txt="' + title_txt + '"';
							}
							if ( title_txt_size ) {
							title_txt_size = ' title_txt_size="' + title_txt_size + '"';
							}

							return '\n[list_icon_item'  + icon_type + icon_color + icon_bgcolor + faicon + peicon + icon_list_style + title_color + title_txt + title_txt_size + ']\n';
							break;

		// I C O N S  S T Y L E S
		//---------------------------------------------------------
		case 'icons':
			var icon_type = jQuery('[name="icons_type"]').val();
			var faicon 	= jQuery('[name="icons_faicon"]').val();
			var peicon 	= jQuery('[name="icons_peicon"]').val();
			var size = jQuery('[name="icons_size"]').val();
			var color = jQuery('[name="icons_color"]').val();

			if ( faicon ) {
				faicon = ' faicon="' + faicon + '"';
			}
			if ( peicon ) {
				peicon = ' peicon="' + peicon + '"';
			}
			if (icon_type !== '') {
				icon_type = ' icon_type="' + icon_type + '"';
			}
			if (size !== '') {
				size = '  size="' + size + '"';
			}
			if (color !== '') {
				color = ' color="' + color + '"';
			}
			return '\n[icons' + icon_type + faicon + peicon +  size + color + ']\n';
			break;

			// Icon Box - Services
			//--------------------------------------------------------
		case 'iconbox':
			var style 			= jQuery('[name="iconbox_style"]').val();
			var icon_type 		= jQuery('[name="iconbox_type"]').val();
			var faicon 			= jQuery('[name="iconbox_faicon"]').val();
			var peicon 			= jQuery('[name="iconbox_peicon"]').val();
			var text 			= jQuery('[name="iconbox_text"]').val();
			var title 			= jQuery('[name="iconbox_title"]').val();
			var def_icon_color 	= jQuery('[name="iconbox_def_icon_color"]').val();
			var icon_color 		= jQuery('[name="iconbox_icon_color"]').val();
			var title_color 	= jQuery('[name="iconbox_title_color"]').val();
			var style_type      = jQuery('#iconbox_style').val();
			var animation   	= jQuery('[name="iconbox_animation"]').val();
			var align 			= jQuery('[name="iconbox_align"]').val();
			var font_size 		= jQuery('[name="iconbox_font_size"]').val();

			if ( animation ) {
				animation = ' animation="' + animation + '"';
			}
			if ( style  ) {
				style = ' style="' + style + '"';
			}

			if ( icon_type  ) {
				icon_type = ' icon_type="' + icon_type + '"';
			}

			if ( text ) {
				text = '' + text + '';
			}
			if ( title ) {
				title = ' title="' + title + '"';
			}
			if ( def_icon_color ) {
				def_icon_color = ' def_icon_color="' + def_icon_color + '"';
			}
			if ( faicon ) {
				faicon = ' faicon="' + faicon + '"';
			}
			if ( peicon ) {
				peicon = ' peicon="' + peicon + '"';
			}

			if ( icon_color ) {
				icon_color = ' icon_color="' + icon_color + '"';
			}
			if ( title_color ) {
				title_color = ' title_color="' + title_color + '"';
			}
			if ( align  ) {
				align = ' align="' + align + '"';
			}

			if ( font_size  ) {
				font_size = ' font_size="' + font_size + '"';
			}

			if( style_type == 'style1'){
				return '[iconbox' + icon_type + style + align + faicon + peicon + font_size + icon_color + title_color + title + animation + ']' + text + '[/iconbox]\n';
			}else if( style_type == 'style4' || style_type == 'style5'){
				return '[iconbox' + icon_type + style + faicon + peicon + font_size + icon_color + title_color + title + animation + ']' + text + '[/iconbox]\n';
			}else{
				return '[iconbox' + icon_type + style + faicon + peicon + font_size + def_icon_color + title_color + title + animation + ']' + text + '[/iconbox]\n';
			}
			break;

			// Services
			//--------------------------------------------------------
		case 'services':

			var imagesrc 	= jQuery('[name="services_image"]').val();
			var title 		= jQuery('[name="services_title"]').val();
			var desc 		= jQuery('[name="services_s_desc"]').val();
			var link 		= jQuery('[name="services_link"]').val();
			var animation 	= jQuery('[name="services_animation"]').val();

			if (style !== '') {
				style = ' style="' + style + '"';
			}
			if (title !== '') {
				title = ' title="' + title + '"';
			}
			if ( desc !== '' ) {
				desc = ' desc="' + desc + '"';
			}

			if (link !== '') {
				link = ' link="' + link + '"';
			}

			if (imagesrc !== '') {
				imagesrc = ' image="' + imagesrc + '"';
			}
			if (animation !== '') {
				animation = ' animation="' + animation + '"';
			}

			return '\n[services' +  animation + imagesrc + title + desc + link + '][/services]\n';
			break;

            // F A N C Y   A M P E R S A N D
            //--------------------------------------------------------
        case 'fancy_ampersand':
            var size = jQuery('[name="fancy_ampersand_size"]').val();
            var color = jQuery('[name="fancy_ampersand_color"]').val();
            if (size !== '') {
                size = ' size="' + size + '"';
            }
            if (color !== '') {
                color = ' color="' + color + '"';
            }

            return '[fancy_ampersand' + size + color + ']';
            break;

            // I C O N   L I N K S
            //--------------------------------------------------------
        case 'iconlinks':
            var style = jQuery('[name="iconlinks_style"]').val();
            var color = jQuery('[name="iconlinks_color"]').val();
            var href = jQuery('[name="iconlinks_href"]').val();
            var target = jQuery('[name="iconlinks_target"]').val();
            var text = jQuery('[name="iconlinks_text"]').val();
            if (text !== '') {
                text = '' + text + '';
            }
            if (style !== '') {
                style = ' style="' + style + '"';
            }
            if (color !== '') {
                color = ' color="' + color + '"';
            }
            if (href !== '') {
                href = ' href="' + href + '"';
            }
            if (target !== '') {
                target = ' target="' + target + '"';
            }

            return '\n[icon' + style + color + href + target + ']' + text + '[/icon]\n';
            break;
		// CAROUSEL SLIDER
		//--------------------------------------------------------
		case 'carouselslider':
			var carouselslider_cat 			= jQuery('[name="carouselslider_category_cat[]"]').val();
			var carouselslider_max 			= jQuery('[name="carouselslider_category_limit"]').val();
			var carouselslider_cat_items 	= jQuery('[name="carouselslider_category_items"]').val();

			if(carouselslider_cat!="")			{ cat = ' cat="'+carouselslider_cat+'"';	}else{	cat = '';}
			if(carouselslider_max!="")			{ max = ' limit="'+carouselslider_max+'"';}else{max	 = '';}
			if(carouselslider_cat_items!="")			{ items = ' items="'+carouselslider_cat_items+'"';	}else{	items = '';}

			return '[carousel_list'+cat+max+items+']';
			break;

            // B U T T O N
            //--------------------------------------------------------
        case 'button':

			var btn_text               = jQuery('[name="button_btn-text"]').val();
			var btn_sub_text           = jQuery('[name="button_btn-sub-text"]').val();
			var btn_link               = jQuery('[name="button_btn-link"]').val();
			var btn_link_target        = jQuery('[name="button_btn-link-target"]');
			var btn_size               = jQuery('[name="button_btn-size"]').val();
			var btn_align              = jQuery('[name="button_btn-align"]').val();
			var btn_icon               = jQuery('[name="button_btn-icon"]').val();
			var btn_fa_icon            = jQuery('[name="button_btn-fa-icon"]').val();
			var btn_pe_icon            = jQuery('[name="button_btn-pe-icon"]').val();
			var btn_icon_pos           = jQuery('[name="button_btn-icon-pos"]').val();
			var btn_style              = jQuery('[name="button_btn-style"]').val();
			var btn_full_width         = jQuery('[name="button_btn-full-width"]');
			var btn_width              = jQuery('[name="button_btn-width"]').val();
			var btn_margin             = jQuery('[name="button_btn-margin"]').val();
			var btn_bg_color           = jQuery('[name="button_btn-bg-color"]').val();
			var btn_hover_bg_color     = jQuery('[name="button_btn-hover-bg-color"]').val();
			var btn_text_color         = jQuery('[name="button_btn-text-color"]').val();
			var btn_hover_text_color   = jQuery('[name="button_btn-hover-text-color"]').val();
			var btn_border_color       = jQuery('[name="button_btn-border-color"]').val();
			var btn_hover_border_color = jQuery('[name="button_btn-hover-border-color"]').val();
			var btn_icon_color       = jQuery('[name="button_btn-icon-color"]').val();
			var btn_hover_icon_color = jQuery('[name="button_btn-hover-icon-color"]').val();

			btn_sub_text = btn_sub_text ? ' sub_text="' + btn_sub_text + '"' : '';
			btn_link = btn_link ? ' link="' + btn_link + '"' : '';
			btn_link_target = ( btn_link_target.is(':checked') ) ? ' link_target="true"' : ' link_target="false"';
			btn_size = btn_size ? ' size="' + btn_size + '"' : '';
			btn_align = btn_align ? ' align="' + btn_align + '"' : '';
			btn_icon = btn_icon ? ' icontype="' + btn_icon + '"' : '';
			btn_fa_icon = btn_fa_icon ? ' fa_icon="' + btn_fa_icon + '"' : '';
			btn_pe_icon = btn_pe_icon ? ' pe_icon="' + btn_pe_icon + '"' : '';
			btn_icon_pos = btn_icon_pos ? ' icon_pos="' + btn_icon_pos + '"' : '';
			btn_style = btn_style ? ' style="' + btn_style + '"' : '';
			btn_full_width = ( btn_full_width.is(':checked') ) ? ' full_width="true"' : ' full_width="false"';
			btn_width = btn_width ? ' width="' + btn_width + '"' : '';
			btn_margin = btn_margin ? ' margin="' + btn_margin + '"' : '';
			btn_bg_color = btn_bg_color ? ' bg_color="' + btn_bg_color + '"' : '';
			btn_hover_bg_color = btn_hover_bg_color ? ' hover_bg_color="' + btn_hover_bg_color + '"' : '';
			btn_text_color = btn_text_color ? ' text_color="' + btn_text_color + '"' : '';
			btn_hover_text_color = btn_hover_text_color ? ' hover_text_color="' + btn_hover_text_color + '"' : '';
			btn_border_color = btn_border_color ? ' border_color="' + btn_border_color + '"' : '';
			btn_hover_border_color = btn_hover_border_color ? ' hover_border_color="' + btn_hover_border_color + '"' : '';
			btn_icon_color = btn_icon_color ? ' icon_color="' + btn_icon_color + '"' : '';
			btn_hover_icon_color = btn_hover_icon_color ? ' hover_icon_color="' + btn_hover_icon_color + '"' : '';

			return '[button' + btn_sub_text + btn_link + btn_link_target + btn_size + btn_align + btn_icon + btn_icon_pos + btn_fa_icon + btn_pe_icon + btn_style + btn_full_width + btn_width + btn_margin + btn_bg_color + btn_hover_bg_color + btn_text_color + btn_hover_text_color + btn_border_color + btn_hover_border_color + btn_icon_color + btn_hover_icon_color + ']' + btn_text + '[/button]\n';

			break;

            // D I V I D E R S
            //--------------------------------------------------------
        case 'divider':
            var shortcodesub_type = jQuery('#secondary_divider select').val();
			if (shortcodesub_type == 'custom_divider') {
				var img 			= jQuery("[name=divider_custom_divider_dividerimg]").val();
				var align 			= jQuery("[name=divider_custom_divider_align]").val();
				var margin_bottom 	= jQuery("[name=divider_custom_divider_margin_btm]").val();

				if (img != '') {
					img = ' img="' + img + '"';
				} else {
					img = '';
				}

				if ( margin_bottom !== '' ) {
					margin_bottom = ' margin_bottom="' + margin_bottom + '"';
				}

				if ( align !== '' ) {
					align = ' align="' + align + '"';
				}
				return '\n[custom_divider' + img + margin_bottom + align + ']\n';
			} else if (shortcodesub_type == 'demo_space') {
				var height = jQuery("[name=divider_demo_space_height]").val();
				if (height != '') {
					height = ' height="' + height + '"';
				} else {
					height = '';
				}
				return '\n[demo_space' + height + ']\n';
			} else if (shortcodesub_type == 'hr_space') {
				var type 			= jQuery("[name=divider_hr_space_type]").val();
				var icon			= jQuery("[name=divider_hr_space_icon]").val();
				var icon_color 		= jQuery("[name=divider_hr_space_icon_color]").val();
				var position 		= jQuery("[name=divider_hr_space_position]").val();
				var border_color 	= jQuery("[name=divider_hr_space_border_color]").val();
				var fa_icon         = jQuery('[name="divider_hr_space_fa-icon"]').val();
				var pe_icon         = jQuery('[name="divider_hr_space_pe-icon"]').val();

				position = position ? ' position="' + position + '"' : '';
				type = type ? ' icon_type="' + type + '"' : '';
				icon = icon ? ' icon="' + icon + '"' : '';
				fa_icon = fa_icon ? ' fa_icon="' + fa_icon + '"' : '';
				pe_icon = pe_icon ? ' pe_icon="' + pe_icon + '"' : '';
				icon_color = icon_color ? ' icon_color="' + icon_color + '"' : '';
				border_color = border_color ? ' border_color="' + border_color + '"' : '';

				return '\n[hr_space' + type + icon + icon_color + border_color + position + fa_icon + pe_icon + ']\n';
			} else if (shortcodesub_type == 'divider') {
				var margin = jQuery("[name=divider_divider_margin]").val();
				var dividertype = jQuery('[name="divider_divider_dividertype"]').val();
				var bordercolor = jQuery('[name="divider_divider_bordercolor"]').val();
				if (margin != '') {
					margin = ' margin="' + margin + '"';
				} else {
					margin = '';
				}
				if (bordercolor != '') {
					bordercolor = ' bordercolor="' + bordercolor + '"';
				}
				if (dividertype !== '') {
					dividertype = ' style="' + dividertype + '"';
				}
				return '\n[divider' + dividertype + margin + bordercolor + ']\n';
			} else {
				return '\n[' + jQuery('#secondary_divider select').val() + ']\n';
			}


			// F A N C Y  B O X
			//--------------------------------------------------------
		case 'fancybox':
			var title 			= jQuery('[name="fancybox_title"]').val();
			var animation 		= jQuery('[name="fancybox_animation"]').val();
			var title_bgcolor 	= jQuery('[name="fancybox_titlebgcolor"]').val();
			var title_color 	= jQuery('[name="fancybox_titlecolor"]').val();
			var box_textcolor 	= jQuery('[name="fancybox_boxtextcolor"]').val();
			var box_bgcolor 	= jQuery('[name="fancybox_boxbgcolor"]').val();
			var ribbon 			= jQuery('[name="fancybox_ribbon"]').val();
			var text 			= jQuery('[name="fancybox_text"]').val();
			//var box_rib_check 	= jQuery('[name="fancybox_box_ribbon"]').val();
			var ribbon_text 	= jQuery('[name="fancybox_rib_text"]').val();
			var rib_custom_color= jQuery('[name="fancybox_rib_custom_color"]').val();
			var default_color 	= jQuery('[name="fancybox_rib_color"]').val();
			var def_color_type  = jQuery('#fancybox_rib_color').val();
			var ribbon_size 	= jQuery('[name="fancybox_rib_size"]').val();
			var ribbon_check 	= jQuery('[name="fancybox_box_ribbon"]');

			var rib_check 		= jQuery("#fancybox_box_ribbon").is(':checked');



			if ( text  ) {
				text = '' + text + '';
			}
			if ( title ) {
				title = ' title="' + title + '"';
			}
			if ( animation ) {
				animation = ' animation="' + animation + '"';
			}
			if ( title_bgcolor  ) {
				title_bgcolor = ' title_bgcolor="' + title_bgcolor + '"';
			}

			if (ribbon_check.is(':checked')) {
				ribbon_check = ' ribbon_check="true"';
			} else {
				ribbon_check = ' ribbon_check="false"';
			}
			/*
			if ( ribbon_check  ) {
				ribbon_check = ' ribbon_check="' + ribbon_check + '"';
			}
			*/
			if ( title_color ) {
				title_color = ' title_color="' + title_color + '"';
			}
			if ( box_textcolor ) {
				box_textcolor = ' box_textcolor="' + box_textcolor + '"';
			}
			if ( box_bgcolor ) {
				box_bgcolor = ' box_bgcolor="' + box_bgcolor + '"';
			}
			if( ribbon_text ){
				ribbon_text = ' ribbon_text="' + ribbon_text + '"';
			}
			if( rib_custom_color ){
                rib_custom_color = ' rib_custom_color="' + rib_custom_color + '"';
            }
			if( default_color ){
				default_color = ' default_color="' + default_color + '"';
			}
			if( ribbon_size ){
				ribbon_size = ' ribbon_size="' + ribbon_size + '"';
			}

			if( rib_check == false ){
				return '\n[fancybox' + title + title_bgcolor + title_color + box_textcolor + box_bgcolor + ribbon_check + animation +']' + text + '[/fancybox]\n';
			}else{
				if(def_color_type == 'custom'){
					return '\n[fancybox' + title + title_bgcolor + title_color + box_textcolor + box_bgcolor +  ribbon_text + rib_custom_color + default_color + ribbon_size + ribbon_check + animation +']' + text + '[/fancybox]\n';
				}else if(def_color_type != 'custom'){
					return '\n[fancybox' + title + title_bgcolor + title_color + box_textcolor + box_bgcolor +  ribbon_text +  default_color + ribbon_size + ribbon_check + animation +']' + text + '[/fancybox]\n';
				}
			}
			break;


            // T A B S
            //--------------------------------------------------------
        case 'Tabs':

			var shortcodesub_tabs = jQuery('#secondary_Tabs select').val();
			count = shortcodesub_tabs.replace('t', '');
			var stabstype = jQuery('[name="Tabs_' + shortcodesub_tabs + '_ctabs' + '"]').val();
			var animation = jQuery('[name="Tabs_' + shortcodesub_tabs + '_animation' + '"]').val();
			if (animation !== '') {
					animation = ' animation="' + animation + '"';
				}
			var outputs = '[minitabs ' +animation+ ' tabtype="' + stabstype + '"]';
			for (var i = 1; i <= count; i++) {

				var title 		= jQuery('[name="Tabs_' + shortcodesub_tabs + '_title_' + i + '"]').val();
				var bgcolor 	= jQuery('[name="Tabs_' + shortcodesub_tabs + '_titlebgcolor_' + i + '"]').val();
				var color 		= jQuery('[name="Tabs_' + shortcodesub_tabs + '_titlecolor_' + i + '"]').val();
				var content 	= jQuery('[name="Tabs_' + shortcodesub_tabs + '_text_' + i + '"]').val();
				var stabstype 	= jQuery('[name="Tabs_' + shortcodesub_tabs + '_ctabs' + '"]').val();

				if (title !== '') {
					title = ' title="' + title + '"';
				}
				if (bgcolor !== '') {
					bgcolor = ' tabcolor="' + bgcolor + '"';
				}
				if (color !== '') {
					color = ' textcolor="' + color + '"';
				}
				if (content !== '') {
					content = '' + content + '';
				}
				outputs += '[tab' + title + color + bgcolor + ']\n' + content + '\n[/tab]\n';
			}
			outputs += '[/minitabs]';
			return outputs;
			break;
      		// T A B Sn NAV
            //--------------------------------------------------------
        case 'Tabsnav':

			var shortcodesub_tabs = jQuery('#secondary_Tabsnav select').val();
			counts = shortcodesub_tabs.replace('tn', '');
			var animation = jQuery('[name="Tabsnav_' + shortcodesub_tabs + '_animation' + '"]').val();
			if (animation !== '') {
					animation = ' animation="' + animation + '"';
				}
			var outputs = '[tabs_container ' +animation+ ']';
			for (var i = 1; i <= counts; i++) {

				var title 		= jQuery('[name="Tabsnav_' + shortcodesub_tabs + '_title_' + i + '"]').val();
				var bgcolor 	= jQuery('[name="Tabsnav_' + shortcodesub_tabs + '_bgcolor_' + i + '"]').val();
				var color 		= jQuery('[name="Tabsnav_' + shortcodesub_tabs + '_color_' + i + '"]').val();
				var content 	= jQuery('[name="Tabsnav_' + shortcodesub_tabs + '_text_' + i + '"]').val();

				if (title !== '') {
					title = ' title="' + title + '"';
				}
				if (bgcolor !== '') {
					bgcolor = ' bgcolor="' + bgcolor + '"';
				}
				if (color !== '') {
					color = ' textcolor="' + color + '"';
				}
				if (content !== '') {
					content = '' + content + '';
				}
				outputs += '[tab_section' + title + color + bgcolor + ']\n' + content + '\n[/tab_section]\n';
			}
			outputs += '[/tabs_container]';
			return outputs;
			break;

            // A C C O R D I O N
            //--------------------------------------------------------
        case 'accordion':
           	var type 			= jQuery('[name="accordion_accordion_type"]').val();
			var accordion_col 	= jQuery('[name="accordion_accordion_col"]').val();
			var iva_anim 		= jQuery('[name="accordion_animation"]').val();
			var mode 			= jQuery('[name="accordion_accordion_mode"]').val();
			var accordion_type  = jQuery("#accordion_accordion_type").val();
			//var accordion_mode  = jQuery("#accordion_accordion_mode").val();

			if ( type )			{ type = ' type="' + type + '"'; }
			if ( iva_anim )		{ iva_anim = ' animation="' + iva_anim + '"'; }
			if ( mode )			{ mode = ' mode="' + mode + '"';	}

			if( accordion_type == 'normal' ){
				var outputs = '[accordion-wrap' + iva_anim + type  + mode +']\n';

				for ( var i = 1; i <= accordion_col; i++ ) {
					outputs += '[accordion title="Title Here" icon="fa-leaf" active="false"]Content Here[/accordion]\n';
				}
				outputs += '[/accordion-wrap]';
			}
			if( accordion_type == 'faq' ){
				var outputs = '[accordion-wrap' + iva_anim + type +  mode + ']\n';
				for ( var i = 1; i <= accordion_col; i++ ) {
					outputs += '[accordion title="Title Here" icon="fa-leaf" active="false"]Content Here[/accordion]\n';
				}
				outputs += '[/accordion-wrap]';
			}
			return outputs;
            break;
    	// I M A G E
        //-------------------------------------------------------------
		case 'image':
			var imagesrc 		= jQuery('[name="image_src"]').val();
			var imagesize 		= jQuery('[name="image_size"]').val();
			var width 			= jQuery('[name="image_width"]').val();
			var height 			= jQuery('[name="image_height"]').val();
			var lightbox 		= jQuery('[name="image_lightbox"]');
			var lightbox_url 	= jQuery('[name="image_lightbox_url"]').val();
			var link 			= jQuery('[name="image_link"]').val();
			var target 			= jQuery('[name="image_target"]');
			var frame_style 	= jQuery('[name="image_frame_style"]').val();
			var title 			= jQuery('[name="image_title"]').val();
			var caption 		= jQuery('[name="image_caption"]').val();
			var caption_location = jQuery('[name="image_caption_location"]').val();
			var align 			= jQuery('[name="image_align"]').val();
			var margin_bottom 	= jQuery('[name="image_margin_bottom"]').val();
			var imgclass 		= jQuery('[name="image_class"]').val();
			var animation 		= jQuery('[name="image_animation"]').val();

			if ( animation != '' ) {
				animation = ' animation="' + animation + '"';
			}
			if ( imagesrc != '' ) {
				imagesrc = ' src="' + imagesrc + '"';
			}
			if ( imagesize !='' ) {
				imagesize = ' size="' + imagesize + '"';
			}
			if ( width != '') {
				width = ' width="' + width + '"';
			}
			if ( height != '') {
				height = ' height="' + height + '"';
			}
			if ( link != '' ) {
				link = ' link="' + link + '"';
			}
			if (target.is(':checked')) {
				target = ' target="true"';
			} else {
				target = ' target="false"';
			}
			if ( frame_style != '') {
				frame_style = ' frame_style="' + frame_style + '"';
			}
			if (title != '') {
				title = ' title="' + title + '"';
			}
			if (caption != '') {
				caption = ' caption="' + caption + '"';
			}
			if (caption_location != '') {
				caption_location = ' caption_location="' + caption_location + '"';
			}
			if (align != '') {
				align = ' align="' + align + '"';
			}
			if (margin_bottom != '') {
				margin_bottom = ' margin_bottom="' + margin_bottom + '"';
			}
			if (imgclass != '') {
				imgclass = ' class="' + imgclass + '"';
			}

			if (lightbox.is('.iva-button')) {
				if (lightbox.is(':checked')) {
					lightbox = ' lightbox="true"';
				} else {
					lightbox = ' lightbox="false"';
				}
			}
			if ( lightbox_url != '' ) {
				lightbox_url = ' lightbox_url="' + lightbox_url + '"';
			}
			return '\n[image' + imagesrc + imagesize + width + height + link + target + frame_style + lightbox + lightbox_url + title + caption + caption_location + align + margin_bottom + imgclass + animation + ']\n';
			break;
            // F L I C K R
            //--------------------------------------------------------
        case 'flickr':
            var id = jQuery('[name="flickr_id"]').val();
            var limit = jQuery('[name="flickr_limit"]').val();
            var type = jQuery('[name="flickr_type"]').val();
            var display = jQuery('[name="flickr_display"]').val();
            if (id != '') {
                id = ' id="' + id + '"';
            }
            if (limit != '') {
                limit = ' limit="' + limit + '"';
            }
            if (type != '') {
                type = ' type="' + type + '"';
            }
            if (display != '') {
                display = ' display="' + display + '"';
            }

            return '\n[flickr' + id + limit + display + type + ']\n';
            break;
            // P O P U L A R   P O S T S
            //--------------------------------------------------------
        case 'popularposts':
            var thumb = jQuery('[name="popularposts_thumb"]');
            var limit = jQuery('[name="popularposts_limit"]').val();
            if (thumb.is('.iva-button')) {
                if (thumb.is(':checked')) {
                    thumb = ' thumb="true"';
                } else {
                    thumb = ' thumb="false"';
                }
            }
            if (limit != '') {
                limit = ' limit="' + limit + '"';
            }

            return '\n[popularpost ' + thumb + limit + ']\n';
            break;
            // R E C E N T   P O S T S
            //--------------------------------------------------------
        case 'recentposts':
            var thumb = jQuery('[name="recentposts_thumb"]');
            var limit = jQuery('[name="recentposts_limit"]').val();
            var cat_id = jQuery('[name="recentposts_cat_id[]"]').val();
            if (thumb.is('.iva-button')) {
                if (thumb.is(':checked')) {
                    thumb = ' thumb="true"';
                } else {
                    thumb = ' thumb="false"';
                }
            }
            if (limit != '') {
                limit = ' limit="' + limit + '"';
            }
            if (cat_id != '') {
                cat_id = ' cat_id="' + cat_id + '"';
            }

            return '\n[recentpost ' + thumb + limit + cat_id + ']\n';
            break;

       	 	// C O N T A C T   I N F O
			//--------------------------------------------------------
		case 'contactinfo':
			var animation 	= jQuery('[name="contactinfo_animation"]').val();
			var name 		= jQuery('[name="contactinfo_name"]').val();
			var address 	= jQuery('[name="contactinfo_address"]').val();
			var email 		= jQuery('[name="contactinfo_email"]').val();
			var phone 		= jQuery('[name="contactinfo_phone"]').val();
			var website_name = jQuery('[name="contactinfo_website_name"]').val();
            var website_url = jQuery('[name="contactinfo_website_url"]').val();
			var fax = jQuery('[name="contactinfo_fax"]').val();

			if (animation != '') {
				animation = ' animation="' + animation + '"';
			}
			if (name != '') {
				name = ' name="' + name + '"';
			}
			if (address != '') {
				address = ' address="'+ address + '"';
			}
			if (email != '') {
				email = ' email="' + email + '"';
			}
			if (phone != '') {
				phone = ' phone="' + phone + '"';
			}
			if (website_name != '') {
                website_name = ' website_name="' + website_name + '"';
            }
			if (website_url != '') {
                website_url = ' website_url="' + website_url + '"';
            }
			if (fax != '') {
                fax = ' fax="' + fax + '"';
            }
			return '\n[contactinfo '+ animation + name + address + email + phone + website_name + website_url + fax + ']\n';
			break;
            // V I M E O
            //--------------------------------------------------------
        case 'vimeo':
            var clip_id = jQuery('[name="vimeo_clipid"]').val();
            var autoplay = jQuery('[name="vimeo_autoplay"]');
            if (clip_id != '') {
                clip_id = ' clip_id="' + clip_id + '"';
            }
            if (autoplay.is('.iva-button')) {
                if (autoplay.is(':checked')) {
                    autoplay = ' autoplay="1"';
                } else {
                    autoplay = ' autoplay="0"';
                }
            }

            return '\n[vimeo' + clip_id + autoplay + ']\n';
            break;
            // Y O U T U B E
            //--------------------------------------------------------
        case 'youtube':
            var clipid = jQuery('[name="youtube_clipid"]').val();
            var autoplay = jQuery('[name="youtube_autoplay"]');
            if (clipid != '') {
                clip_id = ' clipid="' + clipid + '"';
            }
            if (autoplay.is('.iva-button')) {
                if (autoplay.is(':checked')) {
                    autoplay = ' autoplay="1"';
                } else {
                    autoplay = ' autoplay="0"';
                }
            }

            return '\n[youtube' + clip_id + autoplay + ']\n';
            break;

            // B L O G
            //--------------------------------------------------------
        case 'blog':
			var blog_styles 	= jQuery('[name="blog_style"]').val();
			var blog_columns	= jQuery('[name="blog_columns"]').val();
			var blog_cat 		= jQuery('[name="blog_cat[]"]').val();
            var blog_max 		= jQuery('[name="blog_limit"]').val();
            var blogpagination 	= jQuery('[name="blog_pagination"]');
            var postmeta 		= jQuery('[name="blog_postmeta"]');
			var carousel_items  = jQuery('[name="blog_items"]').val();
			var thumbnail 		= jQuery('[name="blog_thumbnail"]');
			var content 		= jQuery('[name="blog_content"]');

			var blog_style;
            if (blogpagination.is('.iva-button')) {
                if (blogpagination.is(':checked')) {
                    pagination = ' pagination="true"';
                } else {
                    pagination = ' pagination="false"';
                }
            }
            if (postmeta.is('.iva-button')) {
                if (postmeta.is(':checked')) {
                    postmeta = ' postmeta="true"';
                } else {
                    postmeta = ' postmeta="false"';
                }
            }
			// Style
			if (blog_styles != "") {
                blog_style = ' style="' + blog_styles + '"';
            }
			// columns
			if (blog_columns != "") {
                blog_columns = ' columns="' + blog_columns + '"';
            } else {
                blog_columns = '';
            }

			if( blog_cat  == null ) {
				blog_cat = '';
			}
            if (blog_cat != "") {
                cat = ' cat="' + blog_cat + '"';
            } else {
                cat = '';
            }
            if (blog_max != "") {
                max = ' limit="' + blog_max + '"';
            } else {
                max = '';
            }
			if (carousel_items != "") {
                items = ' items="' + carousel_items + '"';
            } else {
                items = '';
            }
			 if (thumbnail.is('.iva-button')) {
                if (thumbnail.is(':checked')) {
                    thumbnail = ' thumbnail="true"';
                } else {
                    thumbnail = ' thumbnail="false"';
                }
            }
            if (content.is('.iva-button')) {
                if (content.is(':checked')) {
                    content = ' content="true"';
                } else {
                    content = ' content="false"';
                }
            }

			if ( blog_styles == 'style1') {
				return '[blog' + blog_style + cat + max + pagination + postmeta + thumbnail + content + ']';
			} else if( blog_styles == 'style2') {
            	return '[blog' + blog_style + blog_columns + cat + max + pagination + postmeta + thumbnail + content + ']';
			}else if( blog_styles == 'style3') {
            	return '[blog' + blog_style + items + cat + max + pagination + thumbnail + ']';
			}
            break;

             // P R O G R E S S B A R
        case 'progressbar':
			var title 							= jQuery('[name="progressbar_title"]').val();
			var title_color 					= jQuery('[name="progressbar_title_color"]').val();
			var title_tag 						= jQuery('[name="progressbar_title_tag"]').val();
			var txt_percent 					= jQuery('[name="progressbar_txt_percent"]').val();
			var txt_percent_color 				= jQuery('[name="progressbar_txt_percent_color"]').val();
			var txt_percent_font_size 			= jQuery('[name="progressbar_txt_percent_font_size"]').val();
			var txt_percent_font_weight 		= jQuery('[name="progressbar_txt_percent_font_weight"]').val();
			var active_background_color 		= jQuery('[name="progressbar_active_background_color"]').val();
			var active_border_color 			= jQuery('[name="progressbar_active_border_color"]').val();
			var no_active_background_color 		= jQuery('[name="progressbar_no_active_background_color"]').val();
			var no_active_background_transp		= jQuery('[name="progressbar_no_active_background_transp"]').val();
			var border_radius 					= jQuery('[name="progressbar_border_radius"]').val();
			var txt_position 					= jQuery('[name="progressbar_txt_position"]');
			var striped 						= jQuery('[name="progressbar_striped"]');
			var height 							= jQuery('[name="progressbar_height"]').val();

			if (title != '') {
				title = ' title="' + title + '"';
			} else {
				title = '';
			}
			if (title_color != '') {
				color = ' title_color="' + title_color + '"';
			} else {
				color = '';
			}
			if (title_tag != '') {
				tag = ' title_tag="' + title_tag + '"';
			} else {
				tag = '';
			}
			if (txt_percent != '') {
				percent = ' txt_percent="' + txt_percent + '"';
			} else {
				percent = '';
			}
			if (txt_percent_color != '') {
				percent_color = ' txt_percent_color="' + txt_percent_color + '"';
			} else {
				percent_color = '';
			}
			if (txt_percent_font_size != '') {
				percent_size = ' txt_percent_font_size="' + txt_percent_font_size + '"';
			} else {
				percent_size = '';
			}
			if (txt_percent_font_weight != '') {
				percent_weight = ' txt_percent_font_weight="' + txt_percent_font_weight + '"';
			} else {
				percent_weight = '';
			}
			if (active_background_color != '') {
				active_bg_color = ' active_background_color="' + active_background_color + '"';
			} else {
				active_bg_color = '';
			}
			if (active_border_color != '') {
				active_brd_color = ' active_border_color="' + active_border_color + '"';
			} else {
				active_brd_color = '';
			}
			if (no_active_background_color != '') {
				no_active_bg_color = ' no_active_background_color="' + no_active_background_color + '"';
			} else {
				no_active_bg_color = '';
			}
			if (no_active_background_transp != '') {
				no_active_bg_transp = ' no_active_background_transp="' + no_active_background_transp + '"';
			} else {
				no_active_bg_transp = '';
			}
			if (border_radius != '') {
				border_radius = ' border_radius="' + border_radius + '"';
			} else {
				border_radius = '';
			}
			if (txt_position.is('.iva-button')) {
                if (txt_position.is(':checked')) {
                    position = ' txt_position="true"';
                } else {
                    position = ' txt_position="false"';
                }
            }
			if (striped.is('.iva-button')) {
                if (striped.is(':checked')) {
                    striped = ' striped="true"';
                } else {
                    striped = ' striped="false"';
                }
            }
			if (height != '') {
				height = ' height="' + height + '"';
			} else {
				height = '';
			}

			return '\n[progressbar' +  title + color + tag + percent + percent_color + percent_size + percent_weight + active_bg_color + active_brd_color + no_active_bg_color + no_active_bg_transp + border_radius + position + striped +  height +']\n';
			break;

            // P R O G R E S S C I R C L E
            //---------------------------------------------------------
       case 'progresscircle':
			var pcirclecount = jQuery('[name="progresscircle_pcirclecolumns"]').val();
			var animation = jQuery('[name="progresscircle_animation"]').val();
			if (animation != '') {
				animation = ' animation="' + animation + '"';
			}
			var outputs = '[progresscircle ' + animation + ']\n';
			for (var i = 1; i <= pcirclecount; i++) {
				outputs += '[progress title="Content" percent="50" color="#9f5bb4"  trackcolor="#eeeeee"  size="250" linewidth="8"]Text[/progress]\n';
			}
			outputs += '[/progresscircle]';

			return outputs;
			break;

			// C O U N T D O W N
            //---------------------------------------------------------
		case 'countdown':
			var cd_title   	= jQuery('[name="countdown_cd_text"]').val();
			var cd_year    	= jQuery('[name="countdown_cd_year"]').val();
			var cd_month   	= jQuery('[name="countdown_cd_month"]').val();
			var cd_day     	= jQuery('[name="countdown_cd_day"]').val();
			var cd_hour    	= jQuery('[name="countdown_cd_hour"]').val();
			var cd_minute  	= jQuery('[name="countdown_cd_minute"]').val();
			var cd_format = jQuery('[name="countdown_cd_formats"]').val();
			var cd_class	= jQuery('[name="countdown_cd_class"]').val();


			if ( cd_title != '' ) {
				title = ' title="' + cd_title + '"';
			}else {
                title = '';
            }
			if ( cd_year ) {
				year = ' year="' + cd_year + '"';
			}

			if ( cd_month ) {
				month = ' month="' + cd_month + '"';
			}

			if ( cd_day ) {
				day = ' day="' + cd_day + '"';
			}

			if ( cd_hour ) {
				hour = ' hour="' + cd_hour + '"';
			}

			if ( cd_minute ) {
				minute = ' minute="' + cd_minute + '"';
			}


			if ( cd_class ) {
				cd_class = ' class="' + cd_class + '"';
			}
			if ( cd_format != '' ) {
					format = ' format="' + cd_format + '"';
				}else {
					format = '';
				}

			return '\n[countdown' + title + year + month + day + hour  + minute +  cd_class + format + ']\n';
			break;

            // S T A F F
            //-------------------------------------------------------
        case 'staff':
            var staff_photo = jQuery("[name=staff_photo]").val();
			var animation = jQuery('[name="staff_animation"]').val();
            var staff_title = jQuery('[name="staff_title"]').val();
            var staff_role = jQuery('[name="staff_role"]').val();
            var arr = ['blogger', 'delicious', 'digg', 'facebook', 'flickr', 'forrst', 'google', 'linkedin', 'pinterest', 'skype', 'stumbleupon', 'twitter', 'dribbble', 'yahoo', 'youtube'];
            jQuery.each(arr, function (key, value) {
                if (jQuery('[name="staff_' + value + '"]').val() !== 'undefined' && jQuery('[name="staff_' + value + '"]').val() !== '') {
                    jQuery('#atp-sociables-result').val(jQuery('#atp-sociables-result').val() + ' ' + value + '="' + jQuery('[name="staff_' + value + '"]').val() + '"');
                }
            });
            jQuery('#atp-sociables-result').val(jQuery('#atp-sociables-result').val());
            var staff_sociables = jQuery('#atp-sociables-result').val();
            if (staff_photo != '') {
                photo = ' photo="' + staff_photo + '"';
            } else {
                photo = '';
            }
            if (staff_title != '') {
                title = ' title="' + staff_title + '"';
            } else {
                title = '';
            }
            if (staff_role != '') {
                role = ' role="' + staff_role + '"';
            } else {
                role = '';
            }
            if (animation !== '') {
				animation = ' animation="' + animation + '"';
			}
            jQuery('#atp-sociables-result').val('');

            return '[staff' + animation + photo + title + role + staff_sociables + ']\n';
            break;

        	// T E S T I M O N I A L  C A R O U S E L
			//--------------------------------------------------------
		case 'testimonials':
			var tm_select_type					= jQuery('#testimonials_tm_select').val();
			var testimonials_cat				= jQuery('[name="testimonials_category[]"]').val();
			var testimonials_limit				= jQuery('[name="testimonials_limit"]').val();
			var testimonials_speed				= jQuery('[name="testimonials_speed"]').val();
			var testimonials_itemslimit			= jQuery('[name="testimonials_itemslimit"]').val();
			var testimonials_gridcolumns		= jQuery('[name="testimonials_gridcolumns"]').val();
			var tm_pagination 					= jQuery('[name="testimonials_pagination"]');

			if (tm_select_type != "") {
				style = ' style="' + tm_select_type + '"';
			} else {
				style = '';
			}

			if ( testimonials_cat == null ) {
				testimonials_cat = "";
			}


			if (testimonials_cat != "") {
				cat = ' cat="' + testimonials_cat + '"';
			} else {
				cat = '';
			}

			if (testimonials_speed != "") {
				speed = ' speed="' + testimonials_speed + '"';
			} else {
				speed = '';
			}

			if (testimonials_limit != "") {
				limit = ' limit="' + testimonials_limit + '"';
			} else {
				limit = '';
			}

			if (testimonials_itemslimit != "") {
				itemslimit = ' itemslimit="' + testimonials_itemslimit + '"';
			} else {
				itemslimit = '';
			}

			if (testimonials_gridcolumns != "") {
				gridcolumns = ' gridcolumns="' + testimonials_gridcolumns + '"';
			} else {
				gridcolumns = '';
			}

			if (tm_pagination.is('.iva-button')) {
				if (tm_pagination.is(':checked')) {
					pagination = ' pagination="true"';
				} else {
					pagination = ' pagination="false"';
				}
			}

			if ( tm_select_type == 'list') {
				return '[testimonials' + style + cat + limit + pagination +']';
			}else if( tm_select_type == 'fade_tm') {
				return '[testimonials' + style + cat + limit + speed + ']';
			}else if( tm_select_type == 'carousel') {
				return '[testimonials' + style + cat + limit + itemslimit + ']';
			}else if( tm_select_type == 'grid') {
				return '[testimonials' + style + cat + limit + gridcolumns + ']';
			}
			break;

         // C A R O U S E L  S L I D E R
		//--------------------------------------------------------
		case 'blog_carousel':
			var carouselslider_cat 		 = jQuery('[name="blog_carousel_cat[]"]').val();
			var carouselslider_max 		 = jQuery('[name="blog_carousel_limit"]').val();
			var carouselslider_cat_items = jQuery('[name="blog_carousel_items"]').val();

			if ( carouselslider_cat == null ){
				carouselslider_cat = '';
			}
			if( carouselslider_cat !='' ){
				cat = ' cat="'+ carouselslider_cat + '"';
			}else{	cat = ' cat=""';}

			if( carouselslider_max !='' ){
				max = ' limit="'+ carouselslider_max + '"';
			}else{ max = '';}

			if( carouselslider_cat_items !=='' ){
				items = ' items="'+carouselslider_cat_items+'"';
			}else{	items = '';}

			return '[blog_carousel' + cat + max + items + ']';
			break;

        // E V E N T C A R O U S E L
		//--------------------------------------------------------
        case 'eventcarousel':
            var events_cat = jQuery('[name="eventcarousel_cat[]"]').val();
            var eventstitle = jQuery('[name="eventcarousel_title"]').val();
            var events_max = jQuery('[name="eventcarousel_limit"]').val();
            if (events_cat == null) {
                events_cat = "";
            }
            if (events_max != "") {
                max = ' limit="' + events_max + '"';
            } else {
                max = '';
            }
            if (events_cat != "") {
                cat = ' cat="' + events_cat + '"';
            } else {
                cat = ' cat=""';
            }
            if (eventstitle != "") {
                title = ' title="' + eventstitle + '"';
            } else {
                title = "";
            }

            return '[event_carousel' + cat + title + max + ']';
            break;

		// C A L L O U T   B O X
		//--------------------------------------------------------
		case 'callout':
			var type		 				= jQuery('#callout_type').val();
			var icon 						= jQuery('[name="callout_icon"]').val();
			var icon_size 					= jQuery('[name="callout_icon_size"]').val();
			var icon_color		 			= jQuery('[name="callout_icon_color"]').val();
			var background_color 			= jQuery('[name="callout_background_color"]').val();
			var border_color 				= jQuery('[name="callout_border_color"]').val();
			var padding_top		 			= jQuery('[name="callout_padding_top"]').val();
			var padding_bottom 				= jQuery('[name="callout_padding_bottom"]').val();
			var btn_size	 				= jQuery('[name="callout_btn_size"]').val();
			var btn_link 					= jQuery('[name="callout_btn_link"]').val();
			var btn_text 					= jQuery('[name="callout_btn_text"]').val();
			var btn_text_color				= jQuery('[name="callout_btn_text_color"]').val();
			var btn_hover_text_color 		= jQuery('[name="callout_btn_hover_text_color"]').val();
			var btn_background_color 		= jQuery('[name="callout_btn_background_color"]').val();
			var btn_hover_background_color 	= jQuery('[name="callout_btn_hover_background_color"]').val();
			var btn_border_color 			= jQuery('[name="callout_btn_border_color"]').val();
			var btn_hover_border_color 		= jQuery('[name="callout_btn_hover_border_color"]').val();
			var text_color 					= jQuery('[name="callout_text_color"]').val();
			var text_size 					= jQuery('[name="callout_text_size"]').val();
			var text_font_weight 			= jQuery('[name="callout_text_font_weight"]').val();
			var text_letter_spacing 		= jQuery('[name="callout_text_letter_spacing"]').val();
			var title 						= jQuery('[name="callout_title"]').val();
			var subtitle 					= jQuery('[name="callout_subtitle"]').val();
			var subtitle_color 				= jQuery('[name="callout_subtitle_color"]').val();
			var btn_target 					= jQuery('[name="callout_btn_target"]');

 			type = type ? ' type="' + type + '"' : '';
			icon = icon ? ' icon="' + icon + '"' : '';
			icon_size = icon_size ? ' icon_size="' + icon_size + '"' : '';
			icon_color = icon_color ? ' icon_color="' + icon_color + '"' : '';
			background_color = background_color ? ' background_color="' + background_color + '"' : '';
			border_color = border_color ? ' border_color="' + border_color + '"' : '';
			padding_top = padding_top ? ' padding_top="' + padding_top + '"' : '';
			padding_bottom = padding_bottom ? ' padding_bottom="' + padding_bottom + '"' : '';
			btn_link = btn_link ? ' link="' + btn_link +'"' : '';
			btn_size = btn_size ? ' btn_size="' + btn_size + '"' : '';
			btn_text = btn_text ? ' btn_text="' + btn_text + '"' : '';
			btn_text_color = btn_text_color ? '  btn_text_color="' + btn_text_color + '"' : '';
			btn_hover_text_color = btn_hover_text_color ? ' btn_hover_text_color="' + btn_hover_text_color + '"' : '';
			btn_background_color = btn_background_color ? ' btn_background_color="' + btn_background_color + '"' : '';
			btn_hover_background_color = btn_hover_background_color ? ' btn_hover_background_color="' + btn_hover_background_color + '"' : '';
			btn_border_color = btn_border_color ? ' btn_border_color="' + btn_border_color + '"' : '';
			btn_hover_border_color = btn_hover_border_color ? ' btn_hover_border_color="' + btn_hover_border_color + '"' : '';
			text_color = text_color ? ' text_color="' + text_color + '"' : '';
			text_size = text_size ? ' text_size="' + text_size + '"' : '';
			text_font_weight = text_font_weight ? ' text_font_weight="' + text_font_weight + '"' : '';
			text_letter_spacing = text_letter_spacing ? ' text_letter_spacing="' + text_letter_spacing + '"' : '';
			title = title ? ' title="' + title + '"' : '';
			subtitle = subtitle ? ' subtitle="' + subtitle + '"' : '';
			subtitle_color = subtitle_color ? ' subtitle_color="' + subtitle_color + '"' : '';

			return '\n[callout' + type + icon + icon_size + icon_color + background_color + border_color + padding_top + padding_bottom + btn_link  + btn_size + btn_text + btn_text_color + btn_hover_text_color + btn_background_color + btn_hover_background_color + btn_border_color + btn_hover_border_color + text_color + text_size + text_font_weight + text_letter_spacing +  title + subtitle + subtitle_color + ']\n';
			break;

			// M E S S A G E   B O X
			//--------------------------------------------------------
		case 'messagebox':
			var note   		= jQuery('[name="messagebox_note"]').val();
			var text 		= jQuery('[name="messagebox_text"]').val();
			var msg_type 	= jQuery('[name="messagebox_msgtype"]').val();
			var size 		= jQuery('[name="messagebox_size"]').val();
			var border 		= jQuery('[name="messagebox_border"]').val();
			var bgcolor 	= jQuery('[name="messagebox_boxbgcolor"]').val();
			var text_color 	= jQuery('[name="messagebox_txtcolor"]').val();
			var messagetype = jQuery('#messagebox_msgtype').val();
			var close_box 	= jQuery('[name="messagebox_close"]');

			if ( close_box.is('.iva-button') ) {
				if (close_box.is(':checked')) {
					close_box = ' close="true"';
				} else {
					close_box = '';
				}
			}
			if ( text !== '' ) {
				text = '' + text + '';
			}

			if ( note !== '' ) {
				note = ' note="' + note + '"';
			}
			if ( size !== '' ) {
				size = ' size="' + size + '"';
			}
			if ( msg_type !== '' ) {
				msg_type = ' msg_type="' + msg_type + '"';
			}
			if ( border !== '' ) {
				border = ' border="' + border + '"';
			}

			if ( bgcolor !='' ){
				bgcolor =  ' bgcolor="' + bgcolor + '"';
			}
			if ( text_color !='' ){
				text_color =  ' text_color="' + text_color + '"';
			}

		   if ( messagetype == 'custom' ) {
				return '\n[message' + note + size + msg_type + border + bgcolor + text_color + close_box + ']\n' + text + '\n[/message]';
			}else{
				return '\n[message' + note + size + msg_type + border +  close_box + ']\n' + text + '\n[/message]';
			}
			break;
            // F E A T U R E B O X
            //--------------------------------------------------------
        case 'featurebox':
            var imagesrc = jQuery('[name="featurebox_image"]').val();
            var text = jQuery('[name="featurebox_text"]').val();
            var color = jQuery('[name="featurebox_color"]').val();
            if (text !== '') {
                text = '' + text + '';
            }
            if (color !== '') {
                color = ' bgcolor="' + color + '"';
            }
            if (imagesrc !== '') {
                imagesrc = ' image="' + imagesrc + '"';
            }

            return '\n[featurebox' + color + imagesrc + ']\n' + text + '\n[/featurebox]\n';
            break;

            // S O U N D   C L O U D M A W K S T A R T
            //--------------------------------------------------------
        case 'soundcloud':
            var width 		= jQuery('[name="soundcloud_width"]').val();
            var height 		= jQuery('[name="soundcloud_height"]').val();
            var type 		= jQuery('[name="soundcloud_type"]').val();
            var show_art 	= jQuery('[name="soundcloud_show_art"]');
            var color 		= jQuery('[name="soundcloud_color"]').val();
            var audio_id 	= jQuery('[name="soundcloud_audio_id"]').val();
            var autoplay 	= jQuery('[name="soundcloud_autoplay"]');
            if (width != '') {
                width = ' width="' + width + '"';
            }
            if (height != '') {
                height = ' height="' + height + '"';
            }
            if (type != '') {
                type = ' type="' + type + '"';
            }
            if (color != '') {
                color = ' color="' + color + '"';
            }
            if (audio_id != '') {
                audio_id = ' audio_id="' + audio_id + '"';
            }
            if (autoplay.is('.iva-button')) {
                if (autoplay.is(':checked')) {
                    autoplay = ' autoplay="true"';
                } else {
                    autoplay = ' autoplay="false"';
                }
            }
            if (show_art.is('.iva-button')) {
                if (show_art.is(':checked')) {
                    show_art = ' show_art="true"';
                } else {
                    show_art = ' show_art="false"';
                }
            }

            return '\n[soundcloud' + type + width + height + audio_id + autoplay + color + show_art + ']\n';
            break;

			// P R I C I N G  T A B L E
			//--------------------------------------------------------
		case 'pricing':
			var pt = jQuery('[name="pricing_price"]').val();

			var outputs = '[pricingcolumns]\n';
			for (var i = 1; i <= pt; i++) {

				outputs += '[col title="Title Here" headingbgcolor="" headingcolor="" textcolor="" price="" ]Content Here[/col]\n';
			}
			outputs += '[/pricingcolumns]';

			return outputs;
			break;

			// Fancy Image Box
			//--------------------------------------------------------
		case 'fancyboximage':
			var imagesrc 	= jQuery('[name="fancyboximage_image"]').val();
			var title 		= jQuery('[name="fancyboximage_title"]').val();
			var s_desc 		= jQuery('[name="fancyboximage_s_desc"]').val();
			var link 		= jQuery('[name="fancyboximage_link"]').val();
			var link_target = jQuery('[name="fancyboximage_link_target"]');
			var link_text 	= jQuery('[name="fancyboximage_link_text"]').val();
			var animation 	= jQuery('[name="fancyboximage_animation"]').val();

			if (style !== '') {
				style = ' style="' + style + '"';
			}
			if (title !== '') {
				title = ' title="' + title + '"';
			}
			if ( s_desc !== '' ) {
				s_desc = ' s_desc="' + s_desc + '"';
			}
			if (link_target.is(':checked')) {
				link_target = ' link_target="true"';
			} else {
				link_target = '';
			}
			if (link !== '') {
				link = ' link="' + link + '"';
			}
			if (link_text !== '') {
				link_text = ' link_text="' + link_text + '"';
			}
			if (imagesrc !== '') {
				imagesrc = ' image="' + imagesrc + '"';
			}
			if (animation !== '') {
				animation = ' animation="' + animation + '"';
			}

			return '\n[fancyboximage' +  animation + imagesrc + title + s_desc + link + link_target + link_text + ']\n';
			break;

			// Twenty Twenty
			//--------------------------------------------------------
			case 'twenty_twenty':
				var before_image 	= jQuery('[name="twenty_twenty_before_image"]').val();
				var after_image 	= jQuery('[name="twenty_twenty_after_image"]').val();
				var width 			= jQuery('[name="twenty_twenty_width"]').val();
				var height 			= jQuery('[name="twenty_twenty_height"]').val();
				var animation 		= jQuery('[name="twenty_twenty_animation"]').val();

				if (before_image !== '') {
					before_image = ' before_image="' + before_image + '"';
				}
				if (after_image !== '') {
					after_image = ' after_image="' + after_image + '"';
				}
				if (width !== '') {
					width = ' width="' + width + '"';
				}
				if (height !== '') {
					height = ' height="' + height + '"';
				}
				if (animation !== '') {
					animation = ' animation="' + animation + '"';
				}

				return '\n[twenty_twenty' + before_image + after_image + width + height + animation + ']\n';
				break;

			// Table Sorting
			case 'vacant_table':
			    var header_txt_color 	= jQuery('[name="vacant_table_header_txt_color"]').val();
			    var animation    	 	= jQuery('[name="vacant_table_animation"]').val();
			    var vacantt_columns    	= jQuery('[name="vacant_table_columns"]').val();
			    var columns;

			    if( vacantt_columns )  {
				    columns = ' columns="' + vacantt_columns + '"';
				}

			    if( header_txt_color ){
			    	header_txt_color = ' header_txt_color="' + header_txt_color + '"';
			    }

			    if( animation ){
			    	animation = ' animation="' + animation + '"';
			    }

			    var arr = [];
			    for ( var i = 0; i < vacantt_columns; i++ ) {
			    	j = i + 1;
			    	arr[i]='heading'+j;
			    }
			    arr.toString(',');
			    var outputs = '[vacant_table' + header_txt_color + ' heading="'+ arr +'"' + animation +']\n';

			    var column = '';
			    for ( var i = 1; i <= vacantt_columns; i++ ) {
			    	column += ' column'+i+'="Column Content"';
			    }
			    for ( var i = 1; i <= vacantt_columns; i++ ) {
			    	outputs += '[vacant '+ column +']\n';
			    }
			   outputs += '[/vacant_table]';
			   return outputs;
			   break;

			// Service Box
			//--------------------------------------------------------
			case 'service_box':
				var bg_image 		= jQuery('[name="service_box_bg_image"]').val();
				var bg_color 		= jQuery('[name="service_box_bg_color"]').val();
				var icon 			= jQuery('[name="service_box_icon"]').val();
				var icon_color 		= jQuery('[name="service_box_icon_color"]').val();
				var heading 		= jQuery('[name="service_box_heading"]').val();
				var heading_color 	= jQuery('[name="service_box_heading_color"]').val();
				var content 		= jQuery('[name="service_box_content"]').val();
				var content_color 	= jQuery('[name="service_box_content_color"]').val();
				var link_text 		= jQuery('[name="service_box_link_text"]').val();
				var link 			= jQuery('[name="service_box_link"]').val();
				var link_target 	= jQuery('[name="service_box_link_target"]');
				var animation 		= jQuery('[name="service_box_animation"]').val();

				if ( bg_image !== '' ) {
					bg_image = ' bg_image="' + bg_image + '"';
				}
				if ( bg_color !== '' ) {
					bg_color = ' bg_color="' + bg_color + '"';
				}
				if ( icon !== '' ) {
					icon = ' icon="' + icon + '"';
				}
				if ( icon_color !== '' ) {
					icon_color = ' icon_color="' + icon_color + '"';
				}
				if ( heading !== '' ) {
					heading = ' heading="' + heading + '"';
				}
				if ( heading_color !== '' ) {
					heading_color = ' heading_color="' + heading_color + '"';
				}
				if ( content !== '' ) {
					content = ' content="' + content + '"';
				}
				if ( content_color !== '' ) {
					content_color = ' content_color="' + content_color + '"';
				}
				if ( link_text !== '' ) {
					link_text = ' link_text="' + link_text + '"';
				}
				if ( link_target.is(':checked') ) {
					link_target = ' link_target="true"';
				} else {
					link_target = '';
				}
				if ( link !== '' ) {
					link = ' link="' + link + '"';
				}
				if ( animation !== '' ) {
					animation = ' animation="' + animation + '"';
				}

				return '\n[service_box' + bg_image + bg_color + icon + icon_color + heading + heading_color + content + content_color + link_text + link_target + link + animation + ']\n';
				break;

			// Image Icon Box
			//--------------------------------------------------------
			case 'image_icon_box':
				var icon 			= jQuery('[name="image_icon_box_icon"]').val();
				var icon_color 		= jQuery('[name="image_icon_box_icon_color"]').val();
				var heading 		= jQuery('[name="image_icon_box_heading"]').val();
				var heading_color 	= jQuery('[name="image_icon_box_heading_color"]').val();
				var content 		= jQuery('[name="image_icon_box_content"]').val();
				var content_color 	= jQuery('[name="image_icon_box_content_color"]').val();
				var bg_image 		= jQuery('[name="image_icon_box_bg_image"]').val();
				var bg_color 		= jQuery('[name="image_icon_box_bg_color"]').val();
				var border_color 	= jQuery('[name="image_icon_box_border_color"]').val();
				var link_text 		= jQuery('[name="image_icon_box_link_text"]').val();
				var link 			= jQuery('[name="image_icon_box_link"]').val();
				var link_target 	= jQuery('[name="image_icon_box_link_target"]');
				var animation 		= jQuery('[name="image_icon_box_animation"]').val();

				if ( icon !== '' ) {
					icon = ' icon="' + icon + '"';
				}
				if ( icon_color !== '' ) {
					icon_color = ' icon_color="' + icon_color + '"';
				}
				if ( heading !== '' ) {
					heading = ' heading="' + heading + '"';
				}
				if ( heading_color !== '' ) {
					heading_color = ' heading_color="' + heading_color + '"';
				}
				if ( content !== '' ) {
					content = ' content="' + content + '"';
				}
				if ( content_color !== '' ) {
					content_color = ' content_color="' + content_color + '"';
				}
				if ( bg_image !== '' ) {
					bg_image = ' bg_image="' + bg_image + '"';
				}
				if ( bg_color !== '' ) {
					bg_color = ' bg_color="' + bg_color + '"';
				}
				if ( border_color !== '' ) {
					border_color = ' border_color="' + border_color + '"';
				}
				if ( link_text !== '' ) {
					link_text = ' link_text="' + link_text + '"';
				}
				if ( link_target.is(':checked') ) {
					link_target = ' link_target="true"';
				} else {
					link_target = '';
				}
				if ( link !== '' ) {
					link = ' link="' + link + '"';
				}
				if ( animation !== '' ) {
					animation = ' animation="' + animation + '"';
				}

				return '\n[image_icon_box' + icon + icon_color + heading + heading_color + content + content_color + bg_image + bg_color + border_color + link_text + link_target + link + animation + ']\n';
				break;

		// LOGO Carousel
		//--------------------------------------------------------
		case 'logocarousel':
			var logo_items			= jQuery('[name="logocarousel_items"]').val();
			var logo_speed			= jQuery('[name="logocarousel_speed"]').val();
			var logo_title 			= jQuery('[name="logocarousel_title"]').val();
			var logo_images_count 	= jQuery('[name="logocarousel_images_count"]').val();
			var images;
			
			if ( logo_speed !== '' ) {
				speed = ' speed="' + logo_speed + '"';
			}
			if( logo_title )  { 
				title = ' title="' + logo_title + '"';
			} else {
				title = '';
			}
			if (logo_items != "") {
				items = ' items="' + logo_items + '"';
			} else {
			   items = '';
			}
			var outputs = '[logocarousel' + items + speed + ']\n';
			var image = '';	    
			for ( var i = 1; i <= logo_images_count; i++ ) {	
				image = ' image'+'="#"';    	 
				outputs += '\n[logo '+ image +' link="#"  link_target="true"' + title + ']\n';
			}
		    outputs += '\n[/logocarousel]';
		    return outputs; 
		    break;
			
		   // Expandable
		   //--------------------------------------------------------
	   		case 'expandable':
	   			var morelabel	= jQuery('[name="expandable_morelabel"]').val();
				var lesslabel	= jQuery('[name="expandable_lesslabel"]').val();
	   			var content	= jQuery('[name="expandable_content"]').val();
				var bgcolor = jQuery('[name="expandable_bgcolor"]').val();
				var textcolor = jQuery('[name="expandable_textcolor"]').val();

	   			if ( morelabel !== '' ) {
	   				morelabel = ' morelabel="' + morelabel + '"';
	   			} else {
	   				morelabel = '';
	   			}
				if ( lesslabel !== '' ) {
	   				lesslabel = ' lesslabel="' + lesslabel + '"';
	   			} else {
	   				lesslabel = '';
	   			}
				if ( bgcolor !== '' ) {
	   				bgcolor = ' bgcolor="' + bgcolor + '"';
	   			} else {
	   				bgcolor = '';
	   			}
				if ( textcolor !== '' ) {
	   				textcolor = ' textcolor="' + textcolor + '"';
	   			} else {
	   				textcolor = '';
	   			}
	   		   return '\n[expandable' + morelabel + lesslabel + bgcolor + textcolor + ']'+content+'[/expandable]\n';
	         break;
		
			// G A L L E R Y
		//--------------------------------------------------------
		case 'gallery':   
			var columns 			= jQuery('[name="gallery_gal_column"]').val();
			var gallery_cat 		= jQuery('[name="gallery_gal_cat[]"]').val();
			var gallery_limit 		= jQuery('[name="gallery_gal_limit"]').val();
			var gallerypagination 	= jQuery('[name="gallery_gal_pagination"]');
			var gallerypostid 		= jQuery('[name="gallery_gal_postid"]').val();
			var gallery_select 		= jQuery('#gallery_gal_select').val();
			var gallery_orderby 	= jQuery('[name="gallery_orderby"]').val();
			var gallery_order 		= jQuery('[name="gallery_order"]').val();
			
			if (gallery_orderby != "") {
				orderby = ' orderby="' + gallery_orderby + '"';
			} else {
				orderby = '';
			}
			if (gallery_order != "") {
				order = ' order="' + gallery_order + '"';
			} else {
				order = '';
			}
			if (columns != "") {
				columns = ' columns="' + columns + '"';
			} else {
				columns = ' columns="4"';
			}
			
			if (gallery_cat == null) {
				gallery_cat = "";
			}
			
			if (gallery_cat != "") {
				cat = ' cat="' + gallery_cat + '"';
			} else {
				cat = ' cat=""';
			}
			
			if (gallerypostid != "") {
				postid_g = ' postid_g="' + gallerypostid + '"';
			} else {
				postid_g = '';
			}
			
			if (gallery_limit != "") {
				limit = ' limit="' + gallery_limit + '"';
			} else {
				limit = '';
			}
		   
			if (gallerypagination.is('.iva-button')) {
				if (gallerypagination.is(':checked')) {
					pagination = ' pagination="false"';
				} else {
					pagination = ' pagination="true"';
				}
			}  
			if ( gallery_select == 'gallery_postids') {
				return '[gallery'  + postid_g +']';
			}else if( gallery_select == 'gallery_cat') {
				return '[gallery' + columns + cat + limit + orderby + order +  pagination + ']';
			} else {
				return '[gallery' + columns + cat + limit + orderby + order +  pagination + ']';
			}
		
			break;
		default:
			return extra();

        }
    },
    sendToEditor: function () {
        send_to_editor( es_shortcode.es_generate() );
    }
}

jQuery(document).ready(function () {
    jQuery('.staff_delete').on("click", function () {
        jQuery(this).closest('tr').hide();
        e.preventDefault();
    });
    es_shortcode.init();
    jQuery("select[name=staff_selectsociable]").on('change', function (e) {
        jQuery('#secondary_staff table').find("." + this.value).show();
        e.preventDefault();
    });

	//List Style
	 jQuery("#styledlist_liststyle").on('change',function (){
		jQuery('.circle').hide();
		var styledlist_liststyle = jQuery('#styledlist_liststyle option:selected').val();
		if( styledlist_liststyle !=''){
			jQuery("."+styledlist_liststyle).show();
		}
	}).change();

	//Fancy Heading
	 jQuery("#fancyheading_heading").on('change',function (){
		jQuery('.border_heading').hide();
		var fancy_heading_select = jQuery('#fancyheading_heading option:selected').val();
		if( fancy_heading_select == 'border_heading'){
			jQuery("."+fancy_heading_select).show();
		}
	}).change();
	jQuery("#fancyheading_styles").on('change',function (){
	   jQuery('.fancyhide').hide();
	   var fancy_heading_select = jQuery('#fancyheading_styles option:selected').val();
	    jQuery("."+fancy_heading_select).show();
   });


	//Callout Box
	jQuery("#calloutbox_callout_button_style").change( function () {
		jQuery('.callout_button').hide();
		var call_select = jQuery('#calloutbox_callout_button_style option:selected').val();
		if( call_select != ''){
			jQuery("."+call_select).show();
		}
	}).change();


	//Testimonial Select
	jQuery("#testimonials_tm_select").change( function () {
	jQuery('tr.showtestimonials').hide();
		var tm_select = jQuery('#testimonials_tm_select option:selected').val();
		if( tm_select!=''){
			jQuery('.'+tm_select).show();
		}
	}).change();


	//fancy box
	jQuery("tr.fancy_box_custom").hide();
	jQuery("tr.fancy_box").hide();
	jQuery("#fancybox_box_ribbon").click(function () {
		if(jQuery(this).is(':checked') == false){
			jQuery("tr.fancy_box").hide();
		}else{
			jQuery("tr.fancy_box").show();
			jQuery("tr.fancy_box_custom").hide();
			jQuery("#fancybox_rib_color").change(function () {
				var selected_divider = jQuery("#fancybox_rib_color option:selected").val();
				jQuery("tr.fancy_box_custom").hide();
				if(selected_divider == 'custom'){
					jQuery("tr.fancy_box_custom").show();
				}
			});
		}
	});

	 // Iconbox Shortcode
	 jQuery("#iconbox_style").change(function () {
	  jQuery(".iconbox").hide();
	  jQuery(".icontype").hide();

	  var selected_iconbox = jQuery("#iconbox_style option:selected").val();
	  if(selected_iconbox){
	   jQuery("tr."+selected_iconbox).show();
	  }
	 }).change();

	  // Iconbox Shortcode
	 jQuery("#iconbox_type").change(function () {
	  jQuery(".icontype").hide();
	  var selected_icontype = jQuery("#iconbox_type option:selected").val();
	  if(selected_icontype){
	   jQuery("tr."+selected_icontype).show();
	  }
	 }).change();



	// Dropcap Shortcode
	jQuery("#dropcap_type").change(function () {
		jQuery(".iva-dropcap").hide();
		var selected_dropcap = jQuery("#dropcap_type option:selected").val();
		if(selected_dropcap){
			jQuery("tr."+selected_dropcap).show();
		}
	}).change();

	//Gallery
	jQuery("tr.shortgallery ").hide();
	jQuery("#gallery_gal_select").on('change', function () {
		jQuery("tr.shortgallery ").hide();
		galleryoption = jQuery("#gallery_gal_select option:selected").val();
		jQuery("."+galleryoption).show();
	});	

	//Message box
	jQuery("#messagebox_msgtype").change(function () {
		jQuery(".custom").hide();
		var selected_messagebox = jQuery("#messagebox_msgtype option:selected").val();
		if(selected_messagebox == 'custom'){
			jQuery("tr."+selected_messagebox).show();
		}
	}).change();

	//Highlight
	jQuery("#highlight_type").change( function () {
	jQuery('tr.highlight').hide();
		var tm_select = jQuery('#highlight_type option:selected').val();
		if( tm_select != ''){
			jQuery("tr."+tm_select).show();
		}
	}).change();

	//Button
	jQuery("#button_btn-style").change(function () {
		jQuery(".button_style").hide();
		var selected_button = jQuery("#button_btn-style option:selected").val();
		if(selected_button == 'flat'){
			jQuery(".flat").show();
			jQuery(".border").hide();
			jQuery("#button_btn-color").change(function(){
				var selected_but_color = jQuery("#button_btn-color option:selected").val();
				if( selected_but_color == 'custom' ){
					jQuery(".btn_custom").show();
				}else{
					jQuery(".btn_custom").hide();
				}
			}).change();
			//jQuery("."+selected_button).show();
		}
		else if(selected_button == 'border'){
			jQuery(".flat").hide();
			jQuery(".border").show();
		}
	}).change();

	// button Shortcode
	 jQuery("#button_btn-icon").change(function () {
	  jQuery(".iconstype").hide();
	  var selected_btnicon = jQuery("#button_btn-icon option:selected").val();
	  if(selected_btnicon){
	   jQuery("tr."+selected_btnicon).show();
	  }
	 }).change();

	//List Style
	jQuery("#styledlist_type").on('change',function (){
	jQuery('.styledlist').hide();
		var styledlist_type = jQuery('#styledlist_type option:selected').val();
		if( styledlist_type !=''){
			jQuery("."+styledlist_type).show();
		}
	}).change();

	// List Icon Item
	jQuery("#list_icon_item_icon_type").on('change',function (){
	jQuery('.list_icon_item').hide();
		var list_icon_type = jQuery('#list_icon_item_icon_type option:selected').val();
		if( list_icon_type !=''){
			jQuery("."+list_icon_type).show();
		}
	}).change();

	jQuery("#list_icon_item_icon_list_style").on('change',function (){
	jQuery('.list_icon_item_style').hide();
		var list_icon_style = jQuery('#list_icon_item_icon_list_style option:selected').val();
		if( list_icon_style !=''){
			jQuery("."+list_icon_style).show();
		}
	}).change();

	// FontAwesome Icons
	jQuery("#icons_type").on('change',function (){
	jQuery('.iconstype').hide();
	var icons_type = jQuery('#icons_type option:selected').val();
	if( icons_type !=''){
		jQuery("."+icons_type).show();
	}
	}).change();

	// divider_hr_space_type
	jQuery("#divider_hr_space_type").on('change',function (){
	jQuery('.iconstype').hide();
	var icons_type = jQuery('#divider_hr_space_type option:selected').val();
	if( icons_type !=''){
		jQuery("."+icons_type).show();
	}
	}).change();
	// Table Sorting
	jQuery('#vacant_table_columns').on('change', function() {
		jQuery('.vacant_heading').hide();
		var colnumber = jQuery('#vacant_table_columns option:selected').val();
		jQuery('#vacant_table_heading').val('heading'+colnumber);
	}).change();

	// Image Shortcode
	jQuery("#image_lightbox").change(function(){
		if(jQuery('#image_lightbox').is(':checked') != true) {
			jQuery("tr.lightbox_url").hide();
		}else{
			jQuery("tr.lightbox_url").show();
		}
	}).change();

	jQuery('#image_size').on('change',function(){
		jQuery('.img_dimenstions').hide();
		var img_size = jQuery('#image_size option:selected').val();
		if( img_size !=''){
			jQuery("tr." + img_size).show();
		}
	}).change();

	// Blog
	jQuery("#blog_style").on('change',function (){
		jQuery('.blog_styles').hide();
		var blog_styles = jQuery('#blog_style option:selected').val();
		if( blog_styles !=''){
			jQuery("."+blog_styles).show();
		}
	}).change();

});
