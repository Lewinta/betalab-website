<?php
//  shortcodes  generator
add_action('admin_footer','labora_sc_shortcodes');
function labora_sc_shortcodes(){

	global $labora_sc_obj;

	/**
	 * sociable icons array.
	 */
	$staff_social = array(
		'' => 'Select Sociable',
		'blogger'	 => 'Blogger',
		'delicious'	 => 'Delicious',
		'digg'		 => 'Digg',
		'facebook'	 => 'Facebook',
		'flickr'	 => 'Flickr',
		'forrst'	 => 'Forrst',
		'google'	 => 'Goolge',
		'linkedin'	 => 'Linkedin',
		'pinterest'	 => 'Pinterest',
		'skype'		 => 'Skype',
		'stumbleupon' => 'Stumbleupon',
		'dribbble'	  => 'Dribbble',
		'yahoo'		  => 'Yahoo',
		'youtube'	  => 'Youtube',
		'instagram'	  => 'instagram'
	);
	ksort( $staff_social );//sort alphabetical order.

	$iva_allowed_html_array = array(
		'a' 	=> array('href' => array (),'title' => array ()),
		'b' 	=> array(),
		'em'	=> array (),
		'i' 	=> array (),
		'strong'=> array(),
		'span'	=> array(),
		'small' => array(),
		'br' 	=> array()
	);

	/**
	 * animation effects array.
	 */
	$labora_animation = array(
		''  			=> 'Select Animation',
		'fadeIn'		=>	'fadeIn',
		'fadeInLeft'	=> 	'fadeInLeft',
		'fadeInRight'	=>	'fadeInRight',
		'fadeInUp'	  =>  'fadeInUp',
		'fadeInDown'	=>  'fadeInDown'
	);


// Background Position
	$bg_position = array(
		'left top'		=> 'Left Top',
		'left center'	=> 'Left Center',
		'left bottom'	=> 'Left Bottom',
		'right top'		=> 'Right Top',
		'right center'	=> 'Right Center',
		'right bottom'	=> 'Right Bottom',
		'center top'	=> 'Center Top',
		'center center'	=> 'Center Center',
		'center bottom'	=> 'Center Bottom'
	);

	$labora_sc['Column Layouts'] = array(
		'name'		=> esc_html__('Column Layouts','labora_shortcodes'),
		'value'		=>'Layouts',
		'subtype'	=> true,
		'options'	=> array(
			// L A Y O U T (1/2 - 1/2)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/2 + 1/2','labora_shortcodes'),
				'value'		=>'one_half_layout',
				'options'	=> array(

				)
			),
			// L A Y O U T (1/3 -1/3)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/3 + 1/3 + 1/3','labora_shortcodes'),
				'value'		=> 'one_third_layout',
				'options'	=> array(

				)
			),
			// L A Y O U T (1/4 -1/4 - 1/4 - 1/4)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/4 + 1/4 + 1/4 + 1/4','labora_shortcodes'),
				'value'		=> 'one_fourth_layout',
				'options'	=> array(

				)
			),
			// L A Y O U T (1/5 - 1/5 - 1/5 - 1/5 - 1/5 - 1/5)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/5 + 1/5 + 1/5 + 1/5 + 1/5','labora_shortcodes'),
				'value'		=> 'one5thlayout',
				'options'	=> array(

				)
			),
			// L A Y O U T (1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6','labora_shortcodes'),
				'value'		=> 'one6thlayout',
				'options'	=> array(

				)
			),
			// L A Y O U T (1/3 -2/3)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/3 + 2/3','labora_shortcodes'),
				'value'		=> 'one_3rd_2rd',
				'options'	=> array(

				)
			),
			// L A Y O U T (2/3 -1/3)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('2/3 + 1/3','labora_shortcodes'),
				'value'		=> 'two_3rd_1rd',
				'options'	=> array(

				)
			),
			// L A Y O U T  (1/4 -3/4)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/4 + 3/4','labora_shortcodes'),
				'value'		=> 'One_4th_Three_4th',
				'options'	=> array(

				)
			),
			// L A Y O U T (3/4 -1/4)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('3/4 + 1/4','labora_shortcodes'),
				'value'		=> 'Three_4th_One_4th',
				'options'	=> array(

				)
			),
			// L A Y O U T (1/4 - 1/4 - 1/2)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/4 + 1/4 + 1/2','labora_shortcodes'),
				'value'		=> 'One_4th_One_4th_One_half',
				'options'	=> array(

				)
			),
			// L A Y O U T  (1/2 - 1/4 - 1/4)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/2 + 1/4 + 1/4','labora_shortcodes'),
				'value'		=> 'One_half_One_4th_One_4th',
				'options'	=> array(

				)
			),
			// L A Y O U T  (1/4 - 1/2 - 1/4)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/4 + 1/2 + 1/4','labora_shortcodes'),
				'value'		=> 'One_4th_One_half_One_4th',
				'options'	=> array(

				)
			),
			// L A Y O U T (1/5 - 4/5)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('1/5 + 4/5','labora_shortcodes'),
				'value'		=> 'One_5th_Four_5th',
				'options'	=> array(

				)
			),
			// L A Y O U T (4/5 - 1/5)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('4/5 + 1/5','labora_shortcodes'),
				'value'		=> 'Four_5th_One_5th',
				'options'	=> array(

				)
			),
			// L A Y O U T (2/5 - 3/5)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('2/5 + 3/5','labora_shortcodes'),
				'value'		=> 'Two_5th_Three_5th',
				'options'	=> array(

				)
			),
			// L A Y O U T (3/5 - 2/5)
			//--------------------------------------------------------
			array(
				'name'		=> esc_html__('3/5 + 2/5','labora_shortcodes'),
				'value'		=> 'Three_5th_Two_5th',
				'options'	=> array(

				)
			),
		),
	);
	// E N D   - Column Layouts

	// B L O C K Q U O T E
	//--------------------------------------------------------
	$labora_sc['Block Quotes'] = array(
		'name' => esc_html__('Block Quotes', 'labora_shortcodes'),
		'value' => 'blockquote',
		'options' => array(
			array(
				'name'	=> esc_html__('Content','labora_shortcodes'),
				'desc'	=> esc_html__('Type the text you wish to display as a Blockquote.', 'labora_shortcodes'),
				'id'	=> 'content',
				'std'	=> '',
				'type'	=> 'textarea'
			),
			array(
				'name'	=> esc_html__('Align','labora_shortcodes'),
				'desc'	=> esc_html__('Select the alignment for your Blockquote.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'qalign',
				'std'	=> '',
				'options'=> array(
								''		=> 'Choose Alignment',
								'left'		=> 'Left',
								'right'		=> 'Right',
								'center'	=> 'Center',
							),
				'type' => 'select',
			),
			array(
				'name'	=> esc_html__('Cite','labora_shortcodes'),
				'desc'	=> esc_html__('Type the name of the author which displays at the end of the Blockquote.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'cite',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=>'53',
				),
			array(
				'name'	=> esc_html__('Cite Link','labora_shortcodes'),
				'desc'	=> esc_html__('The link displays after the Citation.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'citelink',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=>'53',
			),
			array(
				'name'	=> esc_html__('Width','labora_shortcodes'),
				'desc'	=> esc_html__('Type the width in % or px, if you wish to use the Blockquote in a specific width.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'width',
				'std'	=> '50%',
				'type'	=> 'text',
				'inputsize'=>'53',
				),

			array(
				'name' 		=> esc_html__('Background Color','labora_shortcodes'),
				'desc'  	=> esc_html__('background color', 'labora_shortcodes'),
				'info'   	=> '(Optional)',
				'id'  		=> 'background_color',
				'class'  	=> '',
				'std'  		=> '',
				'type'  	=> 'color',
				'inputsize' => '',
			),
			array(
				'name' 		=> esc_html__('Text Color','labora_shortcodes'),
				'desc'  	=> esc_html__('text color', 'labora_shortcodes'),
				'info'   	=> '(Optional)',
				'id'  		=> 'text_color',
				'class'  	=> '',
				'std'  		=> '',
				'type'  	=> 'color',
				'inputsize' => '',
			),
			array(
				'name'		=> esc_html__('Animations', 'labora_shortcodes'),
				'desc' 		=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
				'info' 		=> '(Optional)',
				'id' 		=> 'animation',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> $labora_animation
			),
		)
	);
	// E N D   - Block Quotes

	// D R O P  C A P
	//--------------------------------------------------------
	$labora_sc['Drop Cap']= array(
		'name' 		=> esc_html__('Drop Cap', 'labora_shortcodes'),
		'value' 	=> 'dropcap',
		'options' 	=> array(
			array(
				'name'	=> esc_html__('Dropcap Type','labora_shortcodes'),
				'desc'	=> esc_html__('Use Predefined Color for the Dropcap Background', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'type',
				'std'	=> '',
				'options'	=> array(
								'dropcap1'	=> 'Drop cap 1',
								'dropcap2'	=> 'Drop cap 2',
								'dropcap3'	=> 'Drop cap 3',

				),
				'type' => 'select',
			),
			array(
				'name'	=> esc_html__('DropCap Text','labora_shortcodes'),
				'desc'	=>  esc_html__('Type the letter you want to display as Dropcap', 'labora_shortcodes'),
				'id'	=> 'text',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=> '30',
			),

			array(
				'name'	=> esc_html__('DropCap BG Color','labora_shortcodes'),
				'desc'	=>  esc_html__('Use Colorpicker to choose your desired color for the DropCap Background', 'labora_shortcodes'),
				'id'	=> 'bgcolor',
				'info'	=> '(optional)',
				'std'	=> '',
				'class' => 'iva-dropcap dropcap1 dropcap2',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__('DropCap Text Color','labora_shortcodes'),
				'desc'	=>  esc_html__('Use Colorpicker to choose your desired color for the DropCap Text', 'labora_shortcodes'),
				'id'	=> 'textcolor',
				'info'	=> '(optional)',
				'std'	=> '',
				'class' => 'iva-dropcap dropcap1 dropcap2 dropcap3',
				'type'	=> 'color',
			),
		)
	);
	// E N D   - Drop Cap

	// G O O G L E   F O N T
	//--------------------------------------------------------
	 $labora_sc['Google Font'] = array(
		'name'		=> esc_html__('Google Font','labora_shortcodes'),
		'value'		=> 'googlefont',
		'options'	=> array (
			array(
				'name'	=> esc_html__('Google Font Name','labora_shortcodes'),
				'desc'	=> esc_html__('Type the font you want to display.', 'labora_shortcodes'),
				'id'	=> 'font',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=> '53',
			),
			array(
				'name'	=> esc_html__('Google Font Size','labora_shortcodes'),
				'desc'	=> esc_html__('Type the font size in px.', 'labora_shortcodes'),
				'id'	=> 'size',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=> '53',
			),
			array(
				'name'	=> esc_html__('Font Margin','labora_shortcodes'),
				'desc'	=> esc_html__('Type the font margin in px.', 'labora_shortcodes'),
				'id'	=> 'margin',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=> '53',
			),
			array(
				'name'	=> esc_html__('Font weight','labora_shortcodes'),
				'desc'	=> esc_html__('Type the font weight (optional).', 'labora_shortcodes'),
				'id'	=> 'weight',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=> '53',
			),
			array(
				'name'	=> esc_html__('Font style','labora_shortcodes'),
				'desc'	=> esc_html__('Check this if u want to display in Italic.', 'labora_shortcodes'),
				'id'	=> 'font_style',
				'std'	=> '',
				'type'	=> 'checkbox',
				'inputsize'=> '53',
			),
			array(
				'name'	=> esc_html__('Font extend','labora_shortcodes'),
				'desc'	=> esc_html__('Type the font extendibility (optional).', 'labora_shortcodes'),
				'id'	=> 'extend',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'=> '53',
			),
			array(
				'name'	=> esc_html__('Content Here','labora_shortcodes'),
				'desc'	=> esc_html__('Type the text you wish to display .', 'labora_shortcodes'),
				'id'	=> 'text',
				'std'	=> '',
				'type'	=> 'textarea',
			),
			array(
				'name'	=> esc_html__('Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color you wish to display .', 'labora_shortcodes'),
				'id'	=> 'color',
				'std'	=> '',
				'type'	=> 'color',
			),
		)
	);
	// E N D   - Google Font

	// F O N T  A W E S O M E  I C O N S
	//--------------------------------------------------------
	$labora_sc['Font Awesome Icons'] = array(
		'name'		=> esc_html__('Font Awesome Icons','labora_shortcodes'),
		'value'		=> 'icons',
		'options'	=> array(

			array(
				'name'		=> esc_html__( 'Icon Type','labora_shortcodes'),
				'desc'  	=> esc_html__('choose the style to wish display.','labora_shortcodes'),
				'id'		=> 'type',
				'class'	 => 'icons ',
				'std'		=> '',
				'options'	=> array(
								''				=> 'Choose one...',
								'faicon'		=> 'FontAwesome Icon',
								'peicon'	  	=> 'Pe Line Icon',
							),
				'type'	=> 'select',
			),

			array(
				'name'	=> esc_html__('Add Font Awesome Icon Name','labora_shortcodes'),
				'desc'  => esc_html__('Go to Example: http://fortawesome.github.io/Font-Awesome/icons/', 'labora_shortcodes'),
				'id'	=> 'faicon',
				'std'	=> '',
				'class' => 'icons faicon iconstype ',
				'type'	=> 'text',
			),

			array(
				'name'	=> esc_html__('Add Pe Line Icon Name','labora_shortcodes'),
				'desc'  => esc_html__('Go to Example: http://themes-pixeden.com/font-demos/7-stroke/index.html', 'labora_shortcodes'),
				'id'	=> 'peicon',
				'std'	=> '',
				'class' => 'icons peicon iconstype',
				'type'	=> 'text',
			),
			array(
				'name' 	=> esc_html__('Color','labora_shortcodes'),
				'desc'	=> esc_html__('Select the color variation', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id' 	=> 'color',
				'std' 	=> '',
				'type' 	=> 'color',
			),
			array(
				'name'	=> esc_html__('Select Icon Size','labora_shortcodes'),
				'desc'	=> esc_html__('Enter the size of the icon in px. Ex:20px', 'labora_shortcodes'),
				'id'	=> 'size',
				'std'	=> '',
				'type'	=> 'text',
			),
		)
	);
	// E N D   - Font Awesome Icons

	// ICON BOX - SEEVICES ICON BOXES
	//--------------------------------------------------------
	$labora_sc['Icon Box'] = array(
		'name'		=> esc_html__('Icon Box','labora_shortcodes'),
		'value'		=> 'iconbox',
		'options'	=> array(
			array(
				'name'		=> esc_html__( 'Style Type','labora_shortcodes'),
				'desc'  	=> esc_html__('choose the style to wish display.','labora_shortcodes'),
				'id'		=> 'style',
				'std'		=> '',
				'options'	=> array(
								''			=> 'Choose one...',
								'style1'	=> 'Style1',
								'style2'	=> 'Style2',
								'style3'	=> 'Style3',
								'style4'	=> 'Style4',
								'style5'	=> 'Style5',
							),
				'type'	=> 'select',
			),

			array(
				'name'		=> esc_html__( 'Icon Type','labora_shortcodes'),
				'desc'  	=> esc_html__('choose the style to wish display.','labora_shortcodes'),
				'id'		=> 'type',
				'class'	 => 'iconbox style1 style2 style3 style4 style5',
				'std'		=> '',
				'options'	=> array(
								''				=> 'Choose one...',
								'faicon'		=> 'FontAwesome Icon',
								'peicon'	  	=> 'Pe Line Icon',
							),
				'type'	=> 'select',
			),

			array(
				'name'	=> esc_html__('Add Font Awesome Icon Name','labora_shortcodes'),
				'desc'  => esc_html__('Go to Example: http://fortawesome.github.io/Font-Awesome/examples/', 'labora_shortcodes'),
				'id'	=> 'faicon',
				'std'	=> '',
				'class' => 'icontype faicon iconbox ',
				'type'	=> 'text',
			),

			array(
				'name'	=> esc_html__('Add Pe Line Icon Name','labora_shortcodes'),
				'desc'  => esc_html__('Go to Example: http://themes-pixeden.com/font-demos/7-stroke/index.html', 'labora_shortcodes'),
				'id'	=> 'peicon',
				'std'	=> '',
				'class' => 'icontype peicon iconbox',
				'type'	=> 'text',
			),

			array(
				'name'	=> esc_html__('Icon Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose Icon Color', 'labora_shortcodes'),
				'id'	=> 'icon_color',
				'std'	=> '',
				'class' => 'iconbox style1 style4 style5',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__('Title Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose Title Color', 'labora_shortcodes'),
				'id'	=> 'title_color',
				'std'	=> '',
				'class' => 'iconbox style1 style2 style3 style4 style5',
				'type'	=> 'color',
			),

			array(
				'name' 		=> esc_html__('Align', 'labora_shortcodes'),
				'desc' 		=> esc_html__('Select the alignment for Icon.', 'labora_shortcodes'),
				'info'		=> '(optional)',
				'id' 		=> 'align',
				'std' 		=> '',
				'class' 	=> 'iconbox style1',
				'options' 	=> array(
								'' => 'Choose one...',
								'left' 	=> 'Left',
								'right' => 'Right',
								'center'=> 'Center'
							),
				'type' => 'select'
			),
			array(
				'name'	=> esc_html__('Default Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose Icon Color', 'labora_shortcodes'),
				'id'	=> 'def_icon_color',
				'std'	=> '',
				'class' => 'iconbox style2 style3',
				'options' => array(
					''			=> 'Choose one...',
					'gray'		=> 'Gray',
					'brown'		=> 'Brown',
					'cyan'		=> 'Cyan',
					'orange'	=> 'Orange',
					'red'		=> 'Red',
					'magenta'	=> 'Magenta',
					'yellow'	=> 'Yellow',
					'blue'		=> 'Blue',
					'pink'		=> 'Pink',
					'green'		=> 'Green',
					'black'		=> 'Black',
					'white'		=> 'White'
				),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__('Title','labora_shortcodes'),
				'desc'	=> esc_html__('Type the title you wish to display for the service', 'labora_shortcodes'),
				'id'	=> 'title',
				'std'	=> '',
				'class' => 'iconbox style1 style2 style3 style4 style5',
				'type'	=> 'text',
			),

			array(
				'name'	=> esc_html__('Font Size','labora_shortcodes'),
				'desc'	=> esc_html__('Type the font size you wish to use for the title. <br>( Make sure you write only numbers no pixels or percentages)<br> Default value for the font size is 16px.', 'labora_shortcodes'),
				'id'	=> 'font_size',
				'std'	=> '',
				'class' => 'iconbox style1 style2 style3 style4 style5',
				'type'	=> 'text',
			),

			array(
				'name'	=> esc_html__('Content','labora_shortcodes'),
				'desc'	=> esc_html__('Type the content you wish to display for the service', 'labora_shortcodes'),
				'id'	=> 'text',
				'std'	=> '',
				'class' => 'iconbox style1 style2 style3 style4 style5',
				'type'	=> 'textarea',
			),
			array(
				'name'	=> esc_html__('Animations', 'labora_shortcodes'),
				'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	  => 'animation',
				'std'	 => '',
				'type'	=> 'select',
				'options' => $labora_animation
			),
		)
	);
	// E N D   - Icon Box

	// S E R V I C E S
	//--------------------------------------------------------
	$labora_sc['Services'] = array(
		'name'		=> esc_html__('Services','labora_shortcodes'),
		'value'		=> 'services',
		'options'	=> array(
			array(
				'name'	=> esc_html__('Upload Image','labora_shortcodes'),
				'desc'	=> esc_html__('Image / Icon to represent the services box', 'labora_shortcodes'),
				'id'	=> 'image',
				'std'	=> '',
				'type'	=> 'upload',
			),
			array(
				'name'	=> esc_html__('Title','labora_shortcodes'),
				'desc'	=> esc_html__('Type the title you wish to display for the service', 'labora_shortcodes'),
				'id'	=> 'title',
				'std'	=> '',
				'type'	=> 'text',
			),



			array(
				'name'	=> esc_html__('Desc','labora_shortcodes'),
				'desc'	=> 'Type the Desc you wish to display for the service',
				'id'	=> 's_desc',
				'std'	=> '',
				'type'	=> 'textarea',
			),

			array(
				'name'	=> esc_html__('Link','labora_shortcodes'),
				'desc'	=> esc_html__('Type the title you wish to display for the service', 'labora_shortcodes'),
				'id'	=> 'link',
				'std'	=> '',
				'type'	=> 'text',
			),

			array(
				'name'	=> esc_html__('Animations', 'labora_shortcodes'),
				'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	  => 'animation',
				'std'	 => '',
				'type'	=> 'select',
				'options' => $labora_animation
			),
		)
	);
	// E N D  - SERVICES

	// S T Y L E D   L I S T S
	//--------------------------------------------------------
	$labora_sc['List'] = array(
		'name' => esc_html__('List', 'labora_shortcodes'),
		'value' => 'styledlist',
		'options' => array(
			array(
				'name'		=> esc_html__( 'Icon Type','labora_shortcodes'),
				'desc'  	=> esc_html__('choose the style to wish display.','labora_shortcodes'),
				'id'		=> 'type',
				'std'		=> '',
				'options'	=> array(
								''				=> 'Choose one...',
								'faicon'		=> 'FontAwesome Icon',
								'peicon'	  	=> 'Pe Line Icon',
							),
				'type'	=> 'select',
			),

			array(
				'name'	=> esc_html__('Add Font Awesome Icon Name','labora_shortcodes'),
				'desc'  => esc_html__('Go to Example http://fortawesome.github.io/Font-Awesome/examples/', 'labora_shortcodes'),
				'id'	=> 'faicon',
				'std'	=> '',
				'class' => 'styledlist faicon',
				'type'	=> 'text',
			),

			array(
				'name'	=> esc_html__('Add Pe Line Icon Name','labora_shortcodes'),
				'desc'  => esc_html__('Go to Example http://themes-pixeden.com/font-demos/7-stroke/index.html', 'labora_shortcodes'),
				'id'	=> 'peicon',
				'std'	=> '',
				'class' => 'styledlist peicon',
				'type'	=> 'text',
			),

			array(
				'name' 	=> esc_html__('List Style', 'labora_shortcodes'),
				'desc' 	=> esc_html__('Select the list styles', 'labora_shortcodes'),
				'id' 	=> 'liststyle',
				'std' 	=> '',
				'type' 	=> 'select',
				'options' => array(
					'default' => 'Default',
					'circle'  => 'Circle'
				)
			),

			array(
				'name'		=> esc_html__('Icon Color','labora_shortcodes'),
				'desc'		=> esc_html__('Choose Icon Color', 'labora_shortcodes'),
				'id'		=> 'color',
				'std'		=> '',
				'class'	=> 'default',
				'type'	=> 'color',
			),

			array(
				'name'		=> esc_html__('Icon bgColor','labora_shortcodes'),
				'desc'		=> esc_html__('Choose Icon bgColor', 'labora_shortcodes'),
				'id'		=> 'circle_bg',
				'std'		=> '',
				'class'		=> 'circle',
				'type'		=> 'color',
			),

			array(
				'name'	=> esc_html__('Content','labora_shortcodes'),
				'desc'	=> esc_html__('For List Items use HTML Elements ex:List item1(press enter)', 'labora_shortcodes'),
				'id'	=> 'content',
				'std'	=> '',
				'type'	=> 'textarea'
			),
		)
	);
	// E N D   - List

	// S T Y L E D   L I S T S
	//--------------------------------------------------------
	$labora_sc['List Icon Item'] = array(
		'name' => esc_html__('List Icon Item', 'labora_shortcodes'),
		'value' => 'list_icon_item',
		'options' => array(
			array(
				'name'		=> esc_html__( 'Icon Type', 'labora_shortcodes' ),
				'id'		=> 'icon_type',
				'std'		=> '',
				'options'	=> array(
								'faicon'		=> 'FontAwesome Icon',
								'peicon'	  	=> 'Pe Line Icon',
							),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__( 'Add Font Awesome Icon Name', 'labora_shortcodes' ),
				'desc'  => esc_html__( 'Go to Example http://fortawesome.github.io/Font-Awesome/examples/', 'labora_shortcodes' ),
				'id'	=> 'faicon',
				'std'	=> '',
				'class' => 'list_icon_item faicon',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__( 'Add Pe Line Icon Name', 'labora_shortcodes' ),
				'desc'  => esc_html__( 'Go to Example http://themes-pixeden.com/font-demos/7-stroke/index.html', 'labora_shortcodes' ),
				'id'	=> 'peicon',
				'std'	=> '',
				'class' => 'list_icon_item peicon',
				'type'	=> 'text',
			),
			array(
				'name' 	=> esc_html__( 'List Style', 'labora_shortcodes' ),
				'id' 	=> 'icon_list_style',
				'std' 	=> '',
				'type' 	=> 'select',
				'options' => array(
					'transparent' => 'Transparent',
					'circle'  => 'Circle',
				),
			),
			array(
				'name'		=> esc_html__( 'Icon Color', 'labora_shortcodes' ),
				'id'		=> 'icon_color',
				'std'		=> '',
				'class'		=> 'list_icon_item_style transparent circle',
				'type'		=> 'color',
			),
			array(
				'name'		=> esc_html__( 'Icon bg Color', 'labora_shortcodes' ),
				'id'		=> 'icon_bgcolor',
				'std'		=> '',
				'class'		=> 'list_icon_item_style circle',
				'type'		=> 'color',
			),
			array(
				'name'		=> esc_html__( 'Title', 'labora_shortcodes' ),
				'id'		=> 'title_txt',
				'std'		=> '',
				'type'		=> 'text',
			),
			array(
				'name'		=> esc_html__( 'Title Color', 'labora_shortcodes' ),
				'id'		=> 'title_color',
				'std'		=> '',
				'type'		=> 'color',
			),
			array(
				'name'		=> esc_html__( 'Title Size(px)', 'labora_shortcodes' ),
				'id'		=> 'title_txt_size',
				'std'		=> '',
				'type'		=> 'text',
			),
		),
	);
	// E N D   - List


	// P A R T I A L  S E C T I O N
	// -----------------------------------------------------
	$labora_sc['Partial Section'] = array(

		'name' 		=> __('Partial Section', 'aivah_shortcodes'),
		'value' 	=> 'partial_section',
		'options' 	=> array(

			array(
				'name'	=> __('Partail Section ','aivah_shortcodes'),
				'desc'	=> '',
				'info'	=> '(Optional)',
				'id'	=> 'align',
				'std'	=> '',
				'options'=> array(
					''		=> 'Choose one...',
					'left'	=> 'Left',
					'right' => 'Right',
				),
				'type'	=> 'select',
			),

			array(
				'name'	=> __('BG Image', 'aivah_shortcodes'),
				'desc'	=> 'Upload Image you want to display for the Section background.',
				'id'	=> 'bg_image',
				'class'	=> 'partial_section pleft',
				'std'	=> '',
				'type'	=> 'upload'
			),

			array(
				'name' 		=> __('Bg Attachment', 'aivah_shortcodes'),
				'desc' 		=> 'The background-attachment property .',
				'id' 		=> 'bg_attachment',
				'class'		=> 'partial_section pleft',
				'std' 		=> '',
				'options'	=> array(
									''			=> 'Select Option',
									'fixed'		=> 'fixed',
									'scroll'	=> 'scroll'
								),
				'type' => 'select'
			),

			array(
				'name'		=> __('Bg Repeat', 'aivah_shortcodes'),
				'desc'		=> 'The Background Repeat .',
				'id'		=> 'bg_repeat',
				'class'		=> 'partial_section pleft',
				'std'		=> '',
				'options'	=> array(
									'repeat'	=> 'Repeat',
									'no-repeat'	=> 'No Repeat',
									'repeat-x'	=> 'Repeat X',
									'repeat-y'	=> 'Repeat Y'
									),
				'type' => 'select'
			),
			array(
				'name' 		=> __('Bg Position', 'aivah_shortcodes'),
				'desc' 		=> 'The Background Position .',
				'id' 		=> 'bg_position',
				'class'		=> 'partial_section pleft',
				'std' 		=> '',
				'options' 	=> array(
									'left top'			=> 'Left Top',
									'left center'		=> 'Left Center',
									'left bottom'		=> 'Left Bottom',
									'right top'			=> 'Right Top',
									'right center'		=> 'Right Center',
									'right bottom'		=> 'Right Bottom',
									'center top'		=> 'Center Top',
									'center center'		=> 'Center Center',
									'center bottom'		=> 'Center Bottom'
									),
				'type'		=> 'select'
			),

			array(
				'name' 		=> __('BG Color', 'aivah_shortcodes'),
				'desc' 		=> 'Choose the color you want to display for the Section background.',
				'id' 		=> 'bg_color',
				'class'		=> 'partial_section pleft',
				'std' 		=> '',
				'type'		=> 'color'
			),
			array(
				'name' => esc_html__(' BG Height ', 'labora_shortcodes'),
				'desc' => esc_html__(' Use px as units for height', 'labora_shortcodes'),
				'id' => 'img_height',
				 'class'	=> 'img_dimenstions crop',
				'std' => '',
				'type' => 'text',
				'inputsize' => '53'
			),
			array(
				'name' 	=> __('Content', 'aivah_shortcodes'),
				'desc' 	=> '',
				'id' 	=> 'content',
				'class'	=> 'partial_section pleft',
				'std' 	=> '',
				'type' 	=> 'textarea'
			),

			array(
				'name' 		=> __('Content BG Color', 'aivah_shortcodes'),
				'desc' 		=> 'Choose the color you want to display for the Section background.',
				'id' 		=> 'content_bg_color',
				'class'		=> 'partial_section pleft',
				'std' 		=> '',
				'type'		=> 'color'
			),

			array(
				'name' 	=> __('Content Text Color', 'aivah_shortcodes'),
				'desc' 	=> 'Choose the color you want to display for the text.',
				'id' 	=> 'content_text_color',
				'class'	=> 'partial_section pleft',
				'std' 	=> '',
				'type' 	=> 'color'
			),

		)
	);
	// S E C T I O N
	// -----------------------------------------------------
	$labora_sc['Section Fullwidth'] = array(
		'name' => __('Section Fullwidth', 'aivah_shortcodes'),
		'value' => 'section',
		'options' => array(
				array(
				    'name'	=> __('Section BG Image', 'aivah_shortcodes'),
				    'desc'	=> 'Upload Image you want to display for the Section background.',
				    'id'	=> 'bgimage',
				    'std'	=> '',
				    'type'	=> 'upload'
				),

				array(
				    'name' 		=> __('Background Attachment', 'aivah_shortcodes'),
				    'desc' 		=> 'The background-attachment property .',
				    'id' 		=> 'bg_attachment',
				    'std' 		=> '',
					'options'	=> array(
										''			=> 'Select Option',
			 							'fixed'		=> 'fixed',
					 					'scroll'	=> 'scroll'
						 			),
					'type' => 'select'
				),

				array(
					'name'		=> __('Background Repeat', 'aivah_shortcodes'),
					'desc'		=> 'The Background Repeat .',
					'id'		=> 'bg_repeat',
					'std'		=> '',
					'options'	=> array(
										'repeat'	=> 'Repeat',
										'no-repeat'	=> 'No Repeat',
										'repeat-x'	=> 'Repeat X',
										'repeat-y'	=> 'Repeat Y'
									    ),
					'type' => 'select'
				),
				array(
					'name' 		=> __('Background Position', 'aivah_shortcodes'),
					'desc' 		=> 'The Background Position .',
					'id' 		=> 'bg_position',
					'std' 		=> '',
					'options' 	=> $bg_position,
					'type'		=> 'select'
				    ),
				array(
					'name' 		=> __('patterns', 'aivah_shortcodes'),
					'desc' 		=> 'Enter video url.',
					'id' 		=> 'videopattern',
					'std' 		=> '',
					'options'  => array(
							  ''    => LABORA_SC_IMG_URI . '/patterns/no-pat.png',
							  'pat_01.png' => LABORA_SC_IMG_URI . '/patterns/pattern-1-Preview.jpg',
							  'pat_02.png' => LABORA_SC_IMG_URI . '/patterns/pattern-2-Preview.jpg',
							  'pat_03.png' => LABORA_SC_IMG_URI . '/patterns/pattern-3-Preview.jpg',
							  'pat_04.png' => LABORA_SC_IMG_URI . '/patterns/pattern-4-Preview.jpg',
							  'pat_05.png' => LABORA_SC_IMG_URI . '/patterns/pattern-5-Preview.jpg',
							  'pat_06.png' => LABORA_SC_IMG_URI . '/patterns/pattern-6-Preview.jpg',
							  'pat_07.png' => LABORA_SC_IMG_URI . '/patterns/pattern-7-Preview.jpg',
							  'pat_08.png' => LABORA_SC_IMG_URI . '/patterns/pattern-8-Preview.jpg'
							  ),
					'type'		=> 'pattern_bg'
					),
				array(
					'name' 		=> __('Section Opacity', 'aivah_shortcodes'),
					'desc' 		=> 'Choose Opactity Section background.',
					'id' 		=> 'opacity',
					'std' 		=> '0.2',
					'options' 	=> array(
										'' => 'Select Option',
										'0.0' => '0.0',
										'0.1' => '0.1',
										'0.2' => '0.2',
										'0.3' => '0.3',
										'0.4' => '0.4',
										'0.5' => '0.5',
										'0.6' => '0.7',
										'0.8' => '0.8',
										'0.9' => '0.9',
										'1.0' => '1.0'
									),
					'type'		=> 'select'
					),

				array(
					'name'		=> __('Background Video?', 'aivah_shortcodes'),
					'desc'		=> 'Background Video Select.',
					'id'		=> 'videobg',
					'std'		=> '',
					'options'	=>array(
											''	=>'Select Option',
										'bgyes'	=>'yes',
										'bgno'	=>'No'
								),
					'type'		=> 'select'
				),

				array(
					'name'		=> __('Section Video URL', 'aivah_shortcodes'),
					'desc'		=> 'Enter video url.',
					'class'		=> 'video_bg bgyes',
					'id'		=> 'video',
					'std'		=> '',
					'type'		=> 'text'
				),
				 array(
					'name'		=> __('Parallax Background', 'aivah_shortcodes'),
					'desc'		=> 'Check this if you wish Parallax Background',
					'id'		=> 'parallax',
					'std'		=> '',
					'type'		=> 'checkbox',
					'inputsize'	=> '53'
				),

				array(
					'name' 		=> __('Section BG Color', 'aivah_shortcodes'),
					'desc' 		=> 'Choose the color you want to display for the Section background.',
					'id' 		=> 'bgcolor',
					'std' 		=> '',
					'type'		=> 'color'
				),

				array(
					'name' 	=> __('Section Text Color', 'aivah_shortcodes'),
					'desc' 	=> 'Choose the color you want to display for the text.',
					'id' 	=> 'textcolor',
					'std' 	=> '',
					'type' 	=> 'color'
				),

				array(
					'name' 		=> __('Section Border color', 'aivah_shortcodes'),
					'desc' 		=> 'Choose the color you want to display for the border color.',
					'id' 		=> 'border_color',
					'std' 		=> '',
					'type'		=> 'color'
				),

				array(
					'name' 		=> __('Section Border width', 'aivah_shortcodes'),
					'desc' 		=> 'Enter the border width.For ex:1px or 1.',
					'id' 		=> 'border_width',
					'std' 		=> '',
					'type'		=> 'text'
				),

				array(
					'name' 	=> __('Section Padding', 'aivah_shortcodes'),
					'desc' 	=> 'Enter padding ex: 20px 0px 20px 0px. Make sure you don\'t use padding on left and right side. If you don\'t want padding then make it 0px not just 0',
					'id' 	=> 'padding',
					'std' 	=> '',
					'type' 	=> 'text'
				)
		)
	);
	// E N D   - Section Fullwidth

	// B U T T O N
//--------------------------------------------------------
 $labora_sc['Button'] =  array(
	'name' => esc_html__('Button', 'labora_shortcodes'),
	'value' => 'button',
	'options' => array(
		array(
			'name' 		=> esc_html__('Button Text', 'labora_shortcodes'),
			'desc' 		=> esc_html__('Type the text you wish to display for Button.', 'labora_shortcodes'),
			'id' 		=> 'btn-text',
			'std' 		=> '',
			'type' 		=> 'text',
			'class'		=> '',
			'inputsize' => '53'
		),
		array(
			'name' 		=> esc_html__('Button Sub Text', 'labora_shortcodes'),
			'desc' 		=> esc_html__('Type the text you wish to display below button Main Text.', 'labora_shortcodes'),
			'id' 		=> 'btn-sub-text',
			'std' 		=> '',
			'type' 		=> 'text',
			'class'		=> '',
			'inputsize' => '53'
		),
		array(
			'name' 		=> esc_html__('Link URL', 'labora_shortcodes'),
			'id' 		=> 'btn-link',
			'std' 		=> '',
			'type' 		=> 'text',
			'inputsize' => '53'
		),
		array(
			'name' 	=> esc_html__('Link Target ', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Check this if you wish to open the link in a new tab', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-link-target',
			'std' 	=> '',
			'type' => 'checkbox'
		),
		array(
			'name' => esc_html__('Button Size', 'labora_shortcodes'),
			'desc' => esc_html__('Select the button size.', 'labora_shortcodes'),
			'id' => 'btn-size',
			'std' => '',
			'type' => 'select',
			'options' => array(
				'' => 'Choose one...',
				'xsmall' => 'Extra Small',
				'small'  => 'Small',
				'medium' => 'Medium',
				'large'  => 'Large',
				'xlarge' => 'Extra Large',
			)
		),
		array(
			'name' 	=> esc_html__('Align', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Select alignment for Button.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-align',
			'std' 	=> '',
			'options' => array(
				'' 		=> 'Choose one...',
				'left' 	=> 'Left',
				'right' => 'Right',
				'center'=> 'Center'
			),
			'type' => 'select'
		),
		array(
			'name'		=> esc_html__( 'Icon Type','labora_shortcodes'),
			'desc'  	=> esc_html__('choose the style to wish display.','labora_shortcodes'),
			'id'		=> 'btn-icon',
			'class'	 => 'icons ',
			'std'		=> '',
			'options'	=> array(
							''				=> 'Choose one...',
							'faicon'		=> 'FontAwesome Icon',
							'peicon'	  	=> 'Pe Line Icon',
						),
			'type'	=> 'select',
		),
		array(
			'name'	=> esc_html__('Add Font Awesome Icon Name','labora_shortcodes'),
			'desc'  => esc_html__('Go to Example: http://fortawesome.github.io/Font-Awesome/icons/', 'labora_shortcodes'),
			'id'	=> 'btn-fa-icon',
			'std'	=> '',
			'class' => 'icons faicon iconstype ',
			'type'	=> 'text',
		),
		array(
			'name'	=> esc_html__('Add Pe Line Icon Name','labora_shortcodes'),
			'desc'  => esc_html__('Go to Example: http://themes-pixeden.com/font-demos/7-stroke/index.html', 'labora_shortcodes'),
			'id'	=> 'btn-pe-icon',
			'std'	=> '',
			'class' => 'icons peicon iconstype',
			'type'	=> 'text',
		),
		array(
			'name' 	=> esc_html__('Icon Position', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Select the icon position you wish to display.', 'labora_shortcodes'),
			'id' 	=> 'btn-icon-pos',
			'std' 	=> '',
			'type' 	=> 'select',
			'options' => array(
				'' 		=> 'Choose Style...',
				'lefticon' 	=> 'Icon Left',
				'righticon'=> 'Icon Right'
			)
		),
		array(
			'name' 	=> esc_html__('Button Style', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Select the button Style.', 'labora_shortcodes'),
			'id' 	=> 'btn-style',
			'std' 	=> 'square',
			'type' 	=> 'select',
			'options' => array(
				'' 		=> 'Choose Style...',
				'square' 	=> 'Square',
				'rounded' 	=> 'Rounded',
				'fullrounded' 	=> 'Full Rounded',
				'skewed' 	=> 'Skewed',
			)
		),
		array(
			'name' 	=> esc_html__('Full Width', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Check this if you wish to display button in full width and uncheck if you wish to use specific width below.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-full-width',
			'std' 	=> '',
			'type' 	=> 'checkbox'
		),
		array(
			'name' 		=> esc_html__('Custom Width', 'labora_shortcodes'),
			'desc' 		=> esc_html__('Use only percent value for buttons do not use pixels.', 'labora_shortcodes'),
			'info' 		=> '(Optional)',
			'id' 		=> 'btn-width',
			'std' 		=> '',
			'type' 		=> 'text',
			'inputsize' => '53'
		),
		array(
			'name' 		=> esc_html__('Margin', 'labora_shortcodes'),
			'desc' 		=> esc_html__('Use px as units for width, do not leave only integers. Properties in CWD - top right bottom left ( example : 0px 10px 0 10px )', 'labora_shortcodes'),
			'info' 		=> '(Optional)',
			'id' 		=> 'btn-margin',
			'std' 		=> '',
			'type' 		=> 'text',
			'inputsize' => '53'
		),
		array(
			'name'	=> esc_html__('BG Color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Button background color default state.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-bg-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),
		array(
			'name' 	=> esc_html__('Hover BG Color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Button background color on hover state.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-hover-bg-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),
		array(
			'name' 	=> esc_html__('Text Color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Button Text color default state.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-text-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),
		array(
			'name' 	=> esc_html__('Hover Text Color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Button Text color on hover state.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-hover-text-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),
		array(
			'name' 	=> esc_html__('Border color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Button border color.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-border-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),
		array(
			'name' 	=> esc_html__('Border hover color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Border hover color on hover state.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-hover-border-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),
		array(
			'name' 	=> esc_html__('Icon color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Button Icon color.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-icon-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),
		array(
			'name' 	=> esc_html__('Icon hover color', 'labora_shortcodes'),
			'desc' 	=> esc_html__('Icon hover color on hover state.', 'labora_shortcodes'),
			'info' 	=> '(Optional)',
			'id' 	=> 'btn-hover-icon-color',
			'std' 	=> '',
			'type' 	=> 'color',
		),

	)
);
// E N D   - Button

	// C A L L O U T  B O X
	//--------------------------------------------------------
		$labora_sc['Callout'] = array(
			'name'		=> esc_html__( 'Call to Action', 'labora_shortcodes' ),
			'value'		=> 'callout',
			'options'	=> array(
				array(
					'name' 		=> esc_html__( 'Type', 'labora_shortcodes' ),
					'id' 		=> 'type',
					'std' 		=> '',
					'options'	=> array(
										''			=> 'Type',
										'yes_icon'	=> 'Icon',
									),
					'type' => 'select',
				),
				array(
					'name'	=> esc_html__( 'Icon', 'labora_shortcodes' ),
					'info'	=> '(Optional)',
					'id'	=> 'icon',
					'std'	=> '',
					'type' => 'text',
				),
				array(
					'name' 		=> esc_html__( 'Icon Size', 'labora_shortcodes' ),
					'id' 		=> 'icon_size',
					'std' 		=> '',
					'options'	=> array(
										''			=> 'Small',
										'fa-2x'		=> 'Medium',
										'fa-4x'		=> 'Large',
									),
					'type' => 'select',
				),
				array(
					'name'	=> esc_html__( 'Icon Color', 'labora_shortcodes' ),
					'id'	=> 'icon_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Background Color', 'labora_shortcodes' ),
					'id'	=> 'background_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Border Color', 'labora_shortcodes' ),
					'id'	=> 'border_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Padding Top', 'labora_shortcodes' ),
					'id'	=> 'padding_top',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Padding Bottom', 'labora_shortcodes' ),
					'id'	=> 'padding_bottom',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'		=> esc_html__( 'Button Size', 'labora_shortcodes' ),
					'id'		=> 'btn_size',
					'std'		=> '',
					'options'	=> array(
										'small'		=> 'Small',
										'medium'	=> 'Medium',
										'large'		=> 'Large',
										'xlarge'	=> 'Extra Large',
										),
					'type' => 'select',
				),
				array(
					'name'	=> esc_html__( 'Button Link', 'labora_shortcodes' ),
					'id'	=> 'btn_link',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Button Text', 'labora_shortcodes' ),
					'id'	=> 'btn_text',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Button Text Color', 'labora_shortcodes' ),
					'id'	=> 'btn_text_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Button Text Hover Color', 'labora_shortcodes' ),
					'id'	=> 'btn_hover_text_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Button Background Color', 'labora_shortcodes' ),
					'id'	=> 'btn_background_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Button Hover Background Color', 'labora_shortcodes' ),
					'id'	=> 'btn_hover_background_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Button Border Color', 'labora_shortcodes' ),
					'id'	=> 'btn_border_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Button Hover Border Color', 'labora_shortcodes' ),
					'id'	=> 'btn_hover_border_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Text', 'labora_shortcodes' ),
					'id'	=> 'title',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Text Color', 'labora_shortcodes' ),
					'id'	=> 'text_color',
					'std'	=> '',
					'type'	=> 'color',
				),
				array(
					'name'	=> esc_html__( 'Text Size', 'labora_shortcodes' ),
					'id'	=> 'text_size',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Text Font Weight', 'labora_shortcodes' ),
					'id'	=> 'text_font_weight',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Text Letter Spacing', 'labora_shortcodes' ),
					'id'	=> 'text_letter_spacing',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Sub Text', 'labora_shortcodes' ),
					'id'	=> 'subtitle',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__( 'Sub Text Color', 'labora_shortcodes' ),
					'id'	=> 'subtitle_color',
					'std'	=> '',
					'type'	=> 'color',
				),
			)
		);
		//End :Callout Box
		// D I V I D E R S
		//--------------------------------------------------------
		$labora_sc['Divider'] = array(
		'name' => esc_html__( 'Divider', 'labora_shortcodes' ),
		'value' => 'divider',
		'subtype' => true,
		'options' => array(
		   	array(
				'name'		=> esc_html__( 'Clear Both', 'labora_shortcodes' ),
				'value'		=> 'clear',
				'options'	=> array(),
				),
			array(
				'name'		=> esc_html__( 'Divider', 'labora_shortcodes' ),
				'value'		=> 'divider',
				'options'	=> array(
					array(
						'name'	=> esc_html__('Style:','labora_shortcodes'),
						'desc'	=> esc_html__('Select the Style for your Divider.', 'labora_shortcodes'),
						'id'	=> 'dividertype',
						'std'	=> '',
						'options'=> array(
							'thin'		=> 'Thin Divider',
							'fat'		=> 'Fat Divider',
							'dotted'	=> 'Dotted Divider',
							'dashed'	=> 'Dashed Divider',
						),
						'type' => 'select',
					),
					array(
						'name'	=> esc_html__('Margin:','labora_shortcodes'),
						'desc'	=> esc_html__('Enter margin property using px.', 'labora_shortcodes'),
						'id'	=> 'margin',
						'info'	=> '(optional)',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=> '33',
					),
					array(
						'name'	=> esc_html__('Border Color:','labora_shortcodes'),
						'desc'	=> esc_html__('Select the border color', 'labora_shortcodes'),
						'id'	=> 'bordercolor',
						'info'	=> '(optional)',
						'std'	=> '',
						'type'	=> 'color',
					),
				),
			),
			array(
				'name'		=> esc_html__('Demo Space','labora_shortcodes'),
				'value'		=>'demo_space',
				'options'	=> array(
					array(
						'name'	=> esc_html__('Height','labora_shortcodes'),
						'desc'	=> esc_html__('Enter integer value for demo space', 'labora_shortcodes'),
						'id'	=> 'height',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=> '33',
					),
				),
			),
			array(
				'name'		=> esc_html__( 'HR Space', 'labora_shortcodes' ),
				'value'		=>'hr_space',
				'options'	=> array(
					array(
						'name'		=> esc_html__( 'Icon Type', 'labora_shortcodes' ),
						'id'		=> 'type',
						'class'	 => 'icons ',
						'std'		=> '',
						'options'	=> array(
										''				=> 'Choose one...',
										'faicon'		=> 'FontAwesome Icon',
										'peicon'	  	=> 'Pe Line Icon',
									),
						'type'	=> 'select',
					),
					array(
						'name'	=> esc_html__( 'Add Font Awesome Icon Name', 'labora_shortcodes' ),
						'desc'  => esc_html__( 'Go to Example: http://fortawesome.github.io/Font-Awesome/icons/', 'labora_shortcodes' ),
						'id'	=> 'fa-icon',
						'std'	=> '',
						'class' => 'faicon iconstype ',
						'type'	=> 'text',
					),
					array(
						'name'	=> esc_html__( 'Add Pe Line Icon Name', 'labora_shortcodes' ),
						'desc'  => esc_html__( 'Go to Example: http://themes-pixeden.com/font-demos/7-stroke/index.html', 'labora_shortcodes' ),
						'id'	=> 'pe-icon',
						'std'	=> '',
						'class' => 'peicon iconstype',
						'type'	=> 'text',
					),
					array(
						'name' 	=> esc_html__( 'Icon Color', 'labora_shortcodes' ),
						'id' 	=> 'icon_color',
						'std' 	=> '',
						'type' 	=> 'color',
					),
					array(
						'name'	=> esc_html__( 'Align', 'labora_shortcodes' ),
						'id'	=> 'position',
						'std'	=> '',
						'options' => array(
										'' => 'Choose one...',
										'alignleft' => 'Left',
										'alignright' => 'Right',
										'aligncenter' => 'Center',
									),
						'type'	=> 'select',
					),
					array(
						'name'	=> esc_html__( 'Border Color', 'labora_shortcodes' ),
						'id'	=> 'border_color',
						'std'	=> '',
						'type'	=> 'color',
					),
				),
			),
			array(
				'name'		=> esc_html__('Custom Divider','labora_shortcodes'),
				'value'		=>'custom_divider',
				'options'	=> array(
					array(
						'name'	=> esc_html__('Upload Image','labora_shortcodes'),
						'desc'	=> esc_html__('Upload Image for the Divider.','labora_shortcodes'),
						'id'	=> 'dividerimg',
						'std'	=> '',
						'type'	=> 'upload',
						'inputsize'	=> '33',
					),
					array(
						'name'	=> esc_html__('Align','labora_shortcodes'),
						'desc'	=> esc_html__('Choose the alignment you wish to display.', 'labora_shortcodes'),
						'info'	=> '(optional)',
						'id'	=> 'align',
						'std'	=> '',
						'options' => array(
										''=> 'Choose one...',
										'alignleft' => 'Left',
										'alignright' => 'Right',
										'aligncenter' => 'Center'
									),
						'type'	=> 'select',
					),

					array(
						'name'	=> esc_html__('Margin Bottom','labora_shortcodes'),
						'desc'	=> esc_html__('Enter Marign without px.', 'labora_shortcodes'),
						'info'	=> '(optional)',
						'id'	=> 'margin_btm',
						'std'	=> '',
						'type'	=> 'text',
					),
				)
			),

		)
	);
	// End - Dividers

	// A L E R T B O X E S
	//--------------------------------------------------------
	 $labora_sc['Alert Boxes'] = array(
		'name'		=> esc_html__('Alert Boxes','labora_shortcodes'),
		'value'		=> 'messagebox',
		'options'	=> array(
			array(
				'name'	=> esc_html__('Title','labora_shortcodes'),
				'desc'	=> esc_html__('Enter the title you wish to display for the Message Box', 'labora_shortcodes'),
				'id'	=> 'note',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__('Message Type','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the Message Box Type Error, Notice, Success etc', 'labora_shortcodes'),
				'id'	=> 'msgtype',
				'std'	=> '',
				'options'=> array(
					'error'		=> 'Error',
					'info'		=> 'Info',
					'alert'		=> 'Alert',
					'success'	=> 'Success',
					'lightgray'	=> 'Light Gray',
					'dark'		=> 'Dark',
					'custom'	=> 'Custom'
				),
				'type' => 'select',
			),

			array(
				'name'	=> esc_html__('Background Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for background', 'labora_shortcodes'),
				'info'	=> '',
				'class' => 'boxbackgroundcolor custom',
				'id'	=> 'boxbgcolor',
				'std'	=> '',
				'type'  => 'color'
			),

			array(
				'name'	=> esc_html__('Text Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for text', 'labora_shortcodes'),
				'info'	=> '',
				'class' => 'boxtxtcolor custom',
				'id'	=> 'txtcolor',
				'std'	=> '',
				'type' => 'color',
			),

			array(
				'name'	=> esc_html__('Message Text','labora_shortcodes'),
				'desc'	=> esc_html__('Type the content you wish to display for the Message Box', 'labora_shortcodes'),
				'id'	=> 'text',
				'std'	=> '',
				'type'	=> 'textarea',
			),
			array(
				'name'	=> esc_html__('Border','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the Border Type Error, Notice, Success etc', 'labora_shortcodes'),
				'id'	=> 'border',
				'std'	=> '',
				'options'=> array(
					''		=> 'None',
					'solid'	=> 'Solid',
					'dashed'=> 'Dashed'
				),
				'type' => 'select',
			),
			array(
				'name'	=> esc_html__('Size','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the Border Type Error, Notice, Success etc', 'labora_shortcodes'),
				'id'	=> 'size',
				'std'	=> '',
				'options'=> array(
					'large'	=> 'Large',
					'normal'=> 'Normal'
				),
				'type' => 'select',
			),
			array(
				'name'	=> esc_html__('Close','labora_shortcodes'),
				'desc'	=> esc_html__('Check if you wish to display Close Button for Alert Box.', 'labora_shortcodes'),
				'id'	=> 'close',
				'std'	=> '',
				'type'	=> 'checkbox',
			),
		)
	);

	// E N D  - messagebox

	// F A N C Y B O X
	//--------------------------------------------------------
	$labora_sc['Fancy Box'] = array(
		'name'		=> esc_html__('Fancy Box','labora_shortcodes'),
		'value'		=> 'fancybox',
		'options'	=> array(
			array(
				'name'	=> esc_html__('Title','labora_shortcodes'),
				'desc'	=> esc_html__('Type text you wish to display as Title for Fancy Box', 'labora_shortcodes'),
				'id'	=> 'title',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '33',
			),
			array(
				'name'	=> esc_html__('Box Content','labora_shortcodes'),
				'desc'	=> esc_html__('Type content you wish to display for Fancy Box', 'labora_shortcodes'),
				'id'	=> 'text',
				'std'	=> '',
				'type' => 'textarea',
			),
			array(
				'name'	=> esc_html__('Title Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for title', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'titlecolor',
				'std'	=> '',
				'type' => 'color',
			),
			array(
				'name'	=> esc_html__('Title BG Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for title background.','labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'titlebgcolor',
				'std'	=> '',
				'type' => 'color',
			),

			array(
				'name'	=> esc_html__('Content BG Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for Content Background.', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'boxbgcolor',
				'std'	=> '',
				'type' => 'color',
			),
			array(
				'name'	=> esc_html__('Content Text Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for Content Background.', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'boxtextcolor',
				'std'	=> '',
				'type' => 'color',
			),

			array(
				'name'	=> esc_html__('Corner Ribben','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for Box Background', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'box_ribbon',
				'std'	=> '',
				'type'  => 'checkbox',
			),
			array(
				'name'	=> esc_html__('Ribbon Text','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for Box Background', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'rib_text',
				'class' => 'fancy_box',
				'std'	=> '',
				'type'  => 'text',
			),
			array(
				'name'	=> esc_html__('Ribbon Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for Box Background', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'rib_color',
				'class' => 'fancy_box',
				'std'	=> '',
				'options' => array(
					''			=> 'Choose one...',
					'gray'		=> 'Gray',
					'brown'		=> 'Brown',
					'cyan'		=> 'Cyan',
					'orange'	=> 'Orange',
					'red'		=> 'Red',
					'magenta'	=> 'Magenta',
					'yellow'	=> 'Yellow',
					'blue'		=> 'Blue',
					'pink'		=> 'Pink',
					'green'		=> 'Green',
					'black'		=> 'Black',
					'white'		=> 'White',
					'custom'	=> 'Custom',
				),
				'type'  => 'select',
			),
			array(
				'name'	=> esc_html__('Ribbon Custom Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for Box Background', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'rib_custom_color',
				'class' => 'fancy_box_custom',
				'std'	=> '',
				'type'  => 'color',
			),
			array(
				'name'	=> esc_html__('Ribbon Size','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color for Box Background', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'rib_size',
				'class' => 'fancy_box',
				'std'	=> '',
				'options'=> array(
					'small'	=> 'Small',
					'medium'=> 'Medium',
					'large'	=> 'Large',
				),
				'type'  => 'select',
			),

			array(
				'name' => esc_html__('Animations', 'labora_shortcodes'),
				'desc' => esc_html__('Select an animation effect for the element', 'labora_shortcodes'),
				'info' => '(Optional)',
				'id' => 'animation',
				'std' => '',
				'type' => 'select',
				'options' => $labora_animation
			),
		)
	);
	// E N D  - fancybox

	// A C C O R D I O N
	//--------------------------------------------------------
	$labora_sc['Accordion'] = array(
		'name' => esc_html__('Accordion', 'labora_shortcodes'),
		'value' => 'accordion',
		'options' => array(
			array(
				'name' 		=> esc_html__('Accordion Type', 'labora_shortcodes'),
				'desc' 		=> esc_html__('Select Accordion Type.', 'labora_shortcodes'),
				'id' 		=> 'accordion_type',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'normal' => 'Normal',
					'faq'	=> 'FAQ'
				)
			),

			array(
				'name' 		=> esc_html__('Accordion Mode', 'labora_shortcodes'),
				'desc' 		=> esc_html__('Select Accordion Mode.', 'labora_shortcodes'),
				'id' 		=> 'accordion_mode',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> array(
					'toggle' 	=> 'Toggle',
					'accordion' => 'Accordion'
				)
			),
			array(
				'name' 	=> esc_html__('Accordion Limit', 'labora_shortcodes'),
				'desc' 	=> esc_html__('Select how many toggle rows you wish to display.', 'labora_shortcodes'),
				'id' 	=> 'accordion_col',
				'std' 	=> '',
				'type' 	=> 'select',
				'options' => array(
					'02' => 'Two Toggle',
					'03' => 'Three Toggle',
					'04' => 'Four Toggle'
				)
			),
			array(
				'name' 		=> esc_html__('Animations', 'labora_shortcodes'),
				'desc' 		=> esc_html__('Select an animation effect for the element', 'labora_shortcodes'),
				'info' 		=> '(Effects)',
				'id' 		=> 'animation',
				'std' 		=> '',
				'type' 		=> 'select',
				'options' 	=> $labora_animation
			),
		)
	);
	// End - Accordion
	// I M A G E
		//--------------------------------------------------------
		$labora_sc['Image'] = array(
			'name' => esc_html__('Image', 'labora_shortcodes'),
			'value' => 'image',
			'options' => array(
				array(
					'name' 	=> esc_html__('Image URL', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Type the URL of the image from the media library that you wish to use.', 'labora_shortcodes'),
					'id' 	=> 'src',
					'std' 	=> '',
					'type' 	=> 'upload',
					'inputsize' => '53'
				),
				array(
				   'name' 	=> esc_html__( 'Image Size', 'labora_shortcodes'),
				   'desc' 	=> esc_html__( 'Image Size', 'labora_shortcodes'),
				   'std' 	=> '',
				   'id' 	=> 'size',
				   'type' 	=> 'select',
				   'options' 		=> array(
					   'crop' 		=> 'Resize & Crop (Not Recommended)',
					   'full' 		=> 'Default - Original Size',
					   'large'	 	=> 'Default - Large Size',
					   'medium' 	=> 'Default - Medium Size',
				   ),
				   'class' => 'select300'
			   ),
			   array(
				   'name' => esc_html__('Width', 'labora_shortcodes'),
				   'desc' => esc_html__('Use px as units for width', 'labora_shortcodes'),
				   'id' => 'width',
				   'class'	=> 'img_dimenstions crop',
				   'std' => '',
				   'type' => 'text',
				   'inputsize' => '53'
			   ),
			   array(
				   'name' => esc_html__('Height', 'labora_shortcodes'),
				   'desc' => esc_html__('Use px as units for height', 'labora_shortcodes'),
				   'id' => 'height',
					'class'	=> 'img_dimenstions crop',
				   'std' => '',
				   'type' => 'text',
				   'inputsize' => '53'
			   ),
			   array(
				   'name' 	=> esc_html__('Lightbox', 'labora_shortcodes'),
				   'desc' 	=> esc_html__('Check this if you wish to use Lightbox for the image', 'labora_shortcodes'),
				   'info' 	=> '(Optional)',
				   'id' 	=> 'lightbox',
				   'std' 	=> '',
				   'type' 	=> 'checkbox'
			   ),
			   array(
				   'name' 	=> esc_html__('Custom Lightbox URL', 'labora_shortcodes'),
				   'desc' 	=> esc_html__('You can use this field to add your custom lightbox URL to appear in pop up box. it can be image SRC, youtube URL.', 'labora_shortcodes'),
				   'info' 	=> '(Optional)',
				   'id' 	=> 'lightbox_url',
				   'std' 	=> '',
				   'type' 	=> 'text',
				   'inputsize' => '53'
			   ),
			    array(
					  'name' => esc_html__('Image Link', 'labora_shortcodes'),
					  'desc' => esc_html__('Optionally you can link your image.', 'labora_shortcodes'),
					  'id' 	 => 'link',
					  'std'  => '',
					  'type' => 'text',
					  'inputsize' => '53'
			  	),
				array(
					'name' 	=> esc_html__('Link Target', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Choose option when reader clicks on the image linked.', 'labora_shortcodes'),
					'info' 	=> '(Optional)',
					'id' 	=> 'target',
					'std' 	=> '',
					'type' => 'checkbox'
				),
				array(
					'name' 	=> esc_html__('Image Frame Style', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Image Frame Style', 'labora_shortcodes'),
					'std' 	=> 'simple-frame',
					'class' => 'select300',
					'id' 	=> 'frame_style',
					'type' 	=> 'select',
					'options' 		=> array(
						'simple-frame' 		=> 'No Frame',
						'rounded-frame' 		=> 'Rounded Frame',
						'line-frame'	=> 'Line Frame',
						'border-frame' 	=> 'Border Frame',
						'border-shadow-frame' => 'Border Shadow',
						'shadow-frame'	=> 'Shadow',
					),
				),
				array(
					'name' 	=> esc_html__('Title', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Enter the title attribute for the image', 'labora_shortcodes'),
					'id' 	=> 'title',
					'std' 	=> '',
					'type' 	=> 'text',
					'inputsize' => '53'
				),
				array(
					'name' 	=> esc_html__('Caption', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Enter the caption text for the image', 'labora_shortcodes'),
					'info' 	=> '(Optional)',
					'id' 	=> 'caption',
					'std' 	=> '',
					'type' 	=> 'text',
					'inputsize' => '53'
				),
				array(
					'name' 	=> esc_html__('Image Caption Location', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Enter the caption text for the image', 'labora_shortcodes'),
					'info' 	=> '(Optional)',
					'id' 	=> 'caption_location',
					'std' 	=> '',
					'type' 	=> 'select',
					'options' => array(
						'inside-image' => 'Inside Image',
						'outside-image' => 'Outside Image'
					),
				),

				array(
					'name' => esc_html__('Align', 'labora_shortcodes'),
					'desc' => esc_html__('Select the alignment for your image.', 'labora_shortcodes'),
					'info' => '(Optional)',
					'id' => 'align',
					'std' => 'align-left',
					'options' => array(
						'align-left' => 'Left',
						'align-right' => 'Right',
						'align-center' => 'Center'
					),
					'type' => 'select'
				),
				array(
					'name' 	=> esc_html__('Margin Bottom', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Add sub class for the image if you want to assign any new class for the image', 'labora_shortcodes'),
					'info' 	=> '(Optional)',
					'id' 	=> 'margin_bottom',
					'std' 	=> '',
					'type' 	=> 'text',
					'inputsize' => '53'
				),
				array(
					'name' 	=> esc_html__('Class', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Add sub class for the image if you want to assign any new class for the image', 'labora_shortcodes'),
					'info' 	=> '(Optional)',
					'id' 	=> 'class',
					'std' 	=> '',
					'type' 	=> 'text',
					'inputsize' => '53'
				),

				array(
					'name' => esc_html__('Animations', 'labora_shortcodes'),
					'desc' => esc_html__('Select an animation effect for the element', 'labora_shortcodes'),
					'info' => '(Optional)',
					'id' => 'animation',
					'std' => '',
					'type' => 'select',
					'options' => $labora_animation
				)
			)
		);
		// End - Image

	// T E S T I M O N I A L S
	//--------------------------------------------------------
	$labora_sc['Testimonials'] = array(
		'name'		=> esc_html__('Testimonials','labora_shortcodes'),
		'value'		=> 'testimonials',
		'options'	=> array(
				array(
					'name' 	=> esc_html__('Testimonials Select', 'labora_shortcodes'),
					'desc' 	=> esc_html__('Select the Testimonials Type', 'labora_shortcodes'),
					'id' 	=> 'tm_select',
					'std' 	=> '',
					'type' 	=> 'select',
					'options' => array(
						'list'		=> 'List',
						'fade_tm'	=> 'Fade',
						'carousel'	=> 'Carousel',
						'grid'		=> 'Grid',
					)
				),
				array(
					'name'		=> esc_html__('Category','labora_shortcodes'),
					'desc'		=> esc_html__('Hold Control/Command key to select multiple categories', 'labora_shortcodes'),
					'info'		=> '(optional)',
					'id'		=> 'category',
					'class'		=> 'showtestimonials fade_tm carousel list grid',
					'std'		=> '',
					'options'	=> $labora_sc_obj->labora_sc_get_vars('testimonial'),
					'type'		=> 'multiselect',
				),
				array(
					'name'	=> esc_html__('Fade Speed','labora_shortcodes'),
					'desc'	=> esc_html__('Fade speed', 'labora_shortcodes'),
					'class'	=> 'showtestimonials fade_tm',
					'id'	=> 'speed',
					'std'	=> '3000',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__('Testimonial  Limit','labora_shortcodes'),
					'desc'	=> esc_html__('Number of testimonials to display', 'labora_shortcodes'),
					'class'	=> 'showtestimonials fade_tm carousel list grid',
					'id'	=> 'limit',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name' 	=> esc_html__('Column Select', 'labora_shortcodes'),
					'desc' 	=> 'Select the Grid Columns',
					'id' 	=> 'gridcolumns',
					'std' 	=> '',
					'class' => 'showtestimonials grid',
					'type' 	=> 'select',
					'options' => array(
						'2columns'		=> '2 Columns',
						'3columns'		=> '3 COlumns',
					)
				),

				array(
					'name'	=> esc_html__('Testimonial Items Limit','labora_shortcodes'),
					'desc'	=> esc_html__('Number of testimonial items to display', 'labora_shortcodes'),
					'class'	=> 'showtestimonials carousel',
					'id'	=> 'itemslimit',
					'std'	=> '',
					'type'	=> 'text',
				),
				array(
					'name'	=> esc_html__('Pagination','labora_shortcodes'),
					'desc'	=> esc_html__('Check this if you wish to disable the pagination.', 'labora_shortcodes'),
					'id'	=> 'pagination',
					'class'	=> 'showtestimonials list',
					'std'	=> '',
					'type'	=> 'checkbox',
				),
		),
	);
	// E N D   - T E S T I M O N I A L S

	// B L O G
	//--------------------------------------------------------
	$labora_sc['Blog'] = array(
		'name' => esc_html__('Blog', 'labora_shortcodes'),
		'value' => 'blog',
		'options' => array(
			array(
				'name'		=> esc_html__( 'Style Type','labora_shortcodes'),
				'desc'  	=> esc_html__( 'Choose the style to wish display.','labora_shortcodes' ),
				'id'		=> 'style',
				'std'		=> '',
				'options'	=> array(
								'style1'	=> 'Style1',
								'style2'	=> 'Style2',
								'style3'	=> 'Style3',
							),
				'type'	=> 'select',
			),
			array(
				'name' 		=> esc_html__('Carousel Items', 'labora_shortcodes'),
				'desc' 		=> esc_html__('Number of items to show per carousel.', 'labora_shortcodes'),
				'id' 		=> 'items',
				'class' => 'blog_styles style3',
				'std' 		=> '4',
				'type' 		=> 'text'
			),
			array(
				'name'	=> esc_html__( 'Columns', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Choose Blog Columns.', 'labora_shortcodes' ),
				'id'	=> 'columns',
				'class' => 'blog_styles style2',
				'std'	=> '',
				'options' => array(
								'2'	=> 'Column 2',
								'3'	=> 'Column 3',
								'4'	=> 'Column 4',
								'5'	=> 'Column 5',
							),
				'type'	=> 'select',
			),
			array(
				'name' => esc_html__('Category', 'labora_shortcodes'),
				'desc' => esc_html__('Hold Control/Command key to select multiple categories', 'labora_shortcodes'),
				'id' => 'cat',
				'class' => 'blog_styles style2 style1 style3',
				'std' => '',
				'options' => $labora_sc_obj->labora_sc_get_vars('posts'),
				'type' => 'multiselect'
			),
			array(
				'name' => esc_html__('Blog Posts Limit', 'labora_shortcodes'),
				'desc' => esc_html__('Number of items to show per page.', 'labora_shortcodes'),
				'class' => 'blog_styles style2 style1 style3',
				'id' => 'limit',
				'std' => '-1',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Blog Post Meta', 'labora_shortcodes'),
				'desc' => esc_html__('Check this if you wish to display Post Meta for the Blog.', 'labora_shortcodes'),
				'id' => 'postmeta',
				'class' => 'blog_styles style2 style1',
				'std' => true,
				'type' => 'checkbox'
			),
			array(
				'name' => esc_html__('Pagination', 'labora_shortcodes'),
				'desc' => esc_html__('Check this if you wish to display pagination for the Blog.', 'labora_shortcodes'),
				'id' => 'pagination',
				'class' => 'blog_styles style2 style1 style3',
				'std' => true,
				'type' => 'checkbox'
			),
			array(
				'name'	=> esc_html__( 'Thumbnail', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Check this if you wish to disable Thumbnail for the Blog.', 'labora_shortcodes' ),
				'id'	=> 'thumbnail',
				'std'	=> true,
				'type'	=> 'checkbox'
			),
			array(
				'name'	=> esc_html__( 'Content', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'check this if you wish to disable Content for the Blog', 'labora_shortcodes' ),
				'id'	=> 'content',
				'class'	=> 'blog_styles style2 style1',
				'std'	=> true,
				'type'	=> 'checkbox'
			)
		)
	);
	//  End - Blog



	// C A R O U S E L  S L I D E R
	//--------------------------------------------------------
	$labora_sc['Blog Carousel'] = array(
		'name' 		=> esc_html__('Blog Carousel', 'labora_shortcodes'),
		'value' 	=> 'blog_carousel',
		'desc' 		=> '',
		'inputsize' => '',
		'options' 	=> array(
				array(
					'name' 		=> esc_html__('Category', 'labora_shortcodes'),
					'id' 		=> 'cat',
					'std' 		=> '',
					'desc' 		=> esc_html__('Hold Control/Command key to select multiple categories.', 'labora_shortcodes'),
					'options' 	=> $labora_sc_obj->labora_sc_get_vars('posts'),
					'type' 		=> 'multiselect'
				),
				array(
					'name' 		=> esc_html__('Blog Posts Limit', 'labora_shortcodes'),
					'desc' 		=> esc_html__('Number of posts to fetch from database.', 'labora_shortcodes'),
					'id' 		=> 'limit',
					'std'		=> '4',
					'type' 		=> 'text'
				),
				array(
					'name' 		=> esc_html__('Carousel Items', 'labora_shortcodes'),
					'desc' 		=> esc_html__('Number of items to show per carousel.', 'labora_shortcodes'),
					'id' 		=> 'items',
					'std' 		=> '4',
					'type' 		=> 'text'
				),
			),
		);
		// E N D   - Blog Carousel

  	// H I G H L I G H T
	//--------------------------------------------------------
	$labora_sc['Highlight'] = array(
		'name' => esc_html__('Highlight', 'labora_shortcodes'),
		'value' => 'highlight',
		'options' => array(
			array(
				'name'	=> esc_html__('Highlight Types ','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color you want to display for the highlight background.', 'labora_shortcodes'),
				'id'	=> 'type',
				'std'	=> '',
				'options'	=> array(
					''		   => 'Choose',
					'highlight1' => 'Highlight1',
					'highlight2' => 'Highlight2',
					),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__('Highlight BG Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color you want to display for the highlight background.', 'labora_shortcodes'),
				'id'	=> 'bgcolor',
				'std'	=> '',
				'class' => 'highlight highlight1',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__('Highlight Text Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the color you want to display for the text.', 'labora_shortcodes'),
				'id'	=> 'textcolor',
				'std'	=> '',
				'class' => 'highlight highlight1 highlight2',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__('Highlight Text','labora_shortcodes'),
				'desc'	=> esc_html__('Type the text you wish to display as highlight.', 'labora_shortcodes'),
				'id'	=> 'text',
				'std'	=> '',
				'class' => 'highlight highlight1 highlight2',
				'type'	=> 'textarea',
			),
		)
	);
	// E N D   - Highlight

	// F A N C Y   A M P E R S A N D
	//--------------------------------------------------------
	$labora_sc['Fancy Ampersand'] = array(
		'name' => esc_html__('Fancy Ampersand', 'labora_shortcodes'),
		'value' => 'fancy_ampersand',
		'options' => array(
			array(
				'name' => esc_html__('Ampersand Color', 'labora_shortcodes'),
				'desc' => esc_html__('Choose the color you want to use for ampersand.', 'labora_shortcodes'),
				'id' => 'color',
				'std' => '',
				'type' => 'color'
			),
			array(
				'name' => esc_html__('Ampersand Size', 'labora_shortcodes'),
				'desc' => esc_html__('Enter size you want display. Example: 24px', 'labora_shortcodes'),
				'id' => 'size',
				'std' => '',
				'type' => 'text',
				'inputsize' => '44'
			)
		)
	);
	// E N D   - Fancy Ampersand

// F A N C Y   H E A D I N G
	//--------------------------------------------------------
	$labora_sc['Fancy Heading'] = array(
		'name' 		=> esc_html__('Fancy Heading', 'labora_shortcodes'),
		'value' 	=> 'fancyheading',
		'options' 	=> array(
			array(
				'name'	=> esc_html__( 'Heading Style', 'labora_shortcodes' ),
				'id'	=> 'styles',
				'std'	=> '',
				'options' => array( '' => 'Choose Heading Style','v1' => 'Style 1','v2' => 'Style 2','v3' => 'Style 3','v4' => 'Style 4','v5' => 'Style 5','v6' => 'Style 6' ),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__('Heading Size','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the heading size you wish to use.', 'labora_shortcodes'),
				'id'	=> 'heading',
				'class'	=> 'fancyhide v1 v2 v5',
				'std'	=> '',
				'options' => array('' => 'Choose Heading Size','h1' => 'h1','h2' => 'h2','h3' => 'h3','h4' => 'h4','h5' => 'h5','h6' => 'h6','large' => 'large','xlarge' => 'xlarge'),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__('Heading Text Color','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the text color you wish to use.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'headingcolor',
				'std'	=> '',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__('Icon Color','labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'fancy_icon_color',
				'class'	=> 'fancyhide v4',
				'std'	=> '',
				'type'	=> 'color',
			),
			array(
				'name' 	=> esc_html__('Separator Color','labora_shortcodes'),
				'desc'	=> esc_html__('Select the color variation', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'class'	=> 'fancyhide  v1 v5',
				'id' 	=> 'sepcolor',
				'std' 	=> '',
				'type' 	=> 'color',
			),
			array(
				'name' 	=> esc_html__('Border Color','labora_shortcodes'),
				'info'	=> '(optional)',
				'class'	=> 'fancyhide  v6',
				'id' 	=> 'border_color',
				'std' 	=> '',
				'type' 	=> 'color',
			),
			array(
				'name'	=> esc_html__('Boreder','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the Border you wish to display.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'class'	=> 'fancyhide v6',
				'id'	=> 'fancy_border_v6',
				'std'	=> '',
				'options' => array( ''=> 'Choose one...', 'double-top-bottom' => 'Double Border Top & Bottom','double-left-right' => 'Double Border Left & Right','solid-top-bottom' => 'Solid Border Top & Bottom','solid-left-right'=> 'Double Border Left & Right'),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__('Heading Align','labora_shortcodes'),
				'desc'	=> esc_html__('Choose the Heading alignment you wish to display.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'class'	=> 'fancyhide v1 v3  v5 v6',
				'id'	=> 'align',
				'std'	=> '',
				'options' => array( ''=> 'Choose one...', 'textleft' => 'Left','textright' => 'Right','textcenter' => 'Center'),
				'type'	=> 'select',
			),

			array(
				'name'	=> esc_html__('Heading Text','labora_shortcodes'),
				'desc'	=> esc_html__('Type the text you wish to use for Heading.', 'labora_shortcodes'),
				'id'	=> 'title',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__('Heading Description','labora_shortcodes'),
				'desc'	=> esc_html__('Type the text you wish to use for Heading.', 'labora_shortcodes'),
				'id'	=> 'subtitle',
				'class'	=> 'fancyhide v1 v2 v4 v5',
				'std'	=> '',
				'type'	=> 'textarea',
			),

			array(
				'name'	=> esc_html__('Margin Bottom','labora_shortcodes'),
				'desc'	=> esc_html__('Enter Marign without px.', 'labora_shortcodes'),
				'info'	=> '(optional)',
				'id'	=> 'marginbottom',
				'std'	=> '',
				'type'	=> 'text',
			),

		)
	);
	// E N D   - Fancy Heading

	// P R O G R E S S B A R
	//--------------------------------------------------------
	 $labora_sc['Progressbar'] = array(
		'name'		=> esc_html__( 'Progress Bar', 'labora_shortcodes' ),
		'value'		=> 'progressbar',
		'options'	=> array(
			array(
				'name'	=> esc_html__( 'Title', 'labora_shortcodes' ),
				'id'	=> 'title',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize' => '53',
			),
			array(
				'name'	=> esc_html__( 'Title Color','labora_shortcodes' ),
				'id'	=> 'title_color',
				'std'	=> '',
				'type'	=> 'color',
				'inputsize' => '',
			),
			array(
				'name'	=> esc_html__( 'Title Tag', 'labora_shortcodes' ),
				'id'	=> 'title_tag',
				'std'	=> '',
				'options' => array( '' => 'Choose Heading Size','h2' => 'h2','h3' => 'h3','h4' => 'h4','h5' => 'h5','h6' => 'h6' ),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__( 'Percentage', 'labora_shortcodes' ),
				'id'	=> 'txt_percent',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '53',
			),
			array(
				'name'	=> esc_html__( 'Percentage Color','labora_shortcodes' ),
				'id'	=> 'txt_percent_color',
				'std'	=> '',
				'type'	=> 'color',
				'inputsize' => '',
			),
			array(
				'name'	=> esc_html__( 'Percentage Font Size','labora_shortcodes' ),
				'id'	=> 'txt_percent_font_size',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize' => '53',
			),
			array(
				'name'	=> esc_html__( 'Percentage Font Weight','labora_shortcodes' ),
				'id'	=> 'txt_percent_font_weight',
				'std'	=> '',
				'options' => array( '' => 'Default','100' => 'Thin 100','200' => 'Extra-Light 200','300' => 'Light 300','400' => 'Regular 400','500' => 'Medium 500', '600' => 'Semi-Bold 600', '700' => 'Bold 700','800' => 'Extra-Bold 800', '900' => 'Ultra-Bold 900'),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__( 'Active Background Color','labora_shortcodes' ),
				'id'	=> 'active_background_color',
				'std'	=> '',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__( 'Active Border Color','labora_shortcodes' ),
				'id'	=> 'active_border_color',
				'std'	=> '',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__( 'Non Active Background Color','labora_shortcodes' ),
				'id'	=> 'no_active_background_color',
				'std'	=> '',
				'type'	=> 'color',
				'inputsize' => '',
			),
			array(
				'name'	=> esc_html__( 'No Active Background Transparency','labora_shortcodes' ),
				'desc' 	=> esc_html__( 'The transparency value 0 to 1. Ex: 0, 0.5, 0.8, 1', 'labora_shortcodes' ),
				'id'	=> 'no_active_background_transp',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize' => '53',
			),
			array(
				'name'	=> esc_html__( 'Progress Bar Height (px)','labora_shortcodes' ),
				'id'	=> 'height',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize' => '53',
			),
			array(
				'name'	=> esc_html__( 'Progress Bar Border Radius','labora_shortcodes' ),
				'id'	=> 'border_radius',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize' => '53',
			),
			array(
				'name'	=> esc_html__( 'Text Postion Bottom','labora_shortcodes' ),
				'id'	=> 'txt_position',
				'std'	=> '',
				'type'	=> 'checkbox',
			),
			array(
				'name'	=> esc_html__( 'Striped','labora_shortcodes' ),
				'id'	=> 'striped',
				'std'	=> '',
				'type' => 'checkbox',
			),
		),
	);
	// E N D   - Progressbar

	// P R O G R E S S  C I R C L E
	//--------------------------------------------------------
	 $labora_sc['Progress Circle'] = array(
		'name' => esc_html__('Progress Circle', 'labora_shortcodes'),
		'value' => 'progresscircle',
		'options' => array(
			array(
				'name' 	=> esc_html__('Progress Circle Columns', 'labora_shortcodes'),
				'desc' 	=> esc_html__('Progress Circle Columns.', 'labora_shortcodes'),
				'id' 	=> 'pcirclecolumns',
				'std' 	=> '',
				'type' 	=> 'select',
				'options' => array(
					'01' => 'One Columns',
					'02' => 'Two Columns',
					'03' => 'Three Columns',
					'04' => 'Four Columns'
				)
			),
			array(
				'name' 	=> esc_html__('Animations', 'labora_shortcodes'),
				'desc' 	=> esc_html__('Select an animation effect for the element', 'labora_shortcodes'),
				'info' 	=> '(Optional)',
				'id'   	=> 'animation',
				'std' 	=> '',
				'type' 	=> 'select',
				'options' => $labora_animation
			)
		)
	);
	// E N D   - Progress Circle

	//C O U N T D O W N
	//--------------------------------------------------------
	$labora_sc['Count Down'] = array(
		'name'		=> esc_html__('Count Down','labora_shortcodes'),
		'value'		=>'countdown',
		'options'	=> array(
			array(
				'name'	=> esc_html__('Title','labora_shortcodes'),
				'desc'  => esc_html__('Type title.', 'labora_shortcodes'),
				'id'	=> 'cd_text',
				'std'	=> '',
				'type'	=> 'text'
			),
			array(
				'name' 	=> esc_html__('Year','labora_shortcodes'),
				'desc'	=> esc_html__('Type year.', 'labora_shortcodes'),
				'id' 	=> 'cd_year',
				'std' 	=> '',
				'options'=> range(date('Y'),date('Y')+5),
					'type'	=> 'keyselect',
			),
			array(
				'name'	=> esc_html__('Month','labora_shortcodes'),
				'desc'	=> esc_html__('Type month.', 'labora_shortcodes'),
				'id'	=> 'cd_month',
				'std'	=> '',
				'options'=> array(
					'01' 	=> 'January',
					'02' 	=> 'February',
					'03' 	=> 'March',
					'04' 	=> 'April',
					'05' 	=> 'May',
					'06' 	=> 'June',
					'07' 	=> 'July',
					'08' 	=> 'August',
					'09'	=> 'September',
					'10' 	=> 'October',
					'11' 	=> 'November',
					'12' 	=> 'December'
					),
					'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__('Day','labora_shortcodes'),
				'desc'	=> esc_html__('Type Day.', 'labora_shortcodes'),
				'id'	=> 'cd_day',
				'std'	=> '',
				'options'=> range(1,31),
					'type'	=> 'keyselect',
			),
			array(
				'name'	=> esc_html__('Hour','labora_shortcodes'),
				'desc'	=> esc_html__('Type hour.', 'labora_shortcodes'),
				'id'	=> 'cd_hour',
				'std'	=> '',
				'options'=> range(1,24),
					'type'	=> 'keyselect',
			),
			array(
				'name' 	=> esc_html__('Minute','labora_shortcodes'),
				'desc'	=> esc_html__('Type minute.', 'labora_shortcodes'),
				'id' 	=> 'cd_minute',
				'std' 	=> '',
				'options'=> range(1,59),
					'type'	=> 'keyselect',
			),
			array(
				'name' 	=> esc_html__('Formats','labora_shortcodes'),
				'desc'	=> esc_html__('Type Formats.', 'labora_shortcodes'),
				'id' 	=> 'cd_formats',
				'std' 	=> '',
				'options'=> array(
					'HMS'	=> 'Hours:minutes:Seconds',
					'dHM'	=> 'Days:Hours:Months',
					'YOWDHMS' => 'Year:Months:Week: Days: Hours:minutes:Seconds',
					'odHM' => 'Months:Days: Hours:minutes',
					'wdHM' => 'Week:Days: Hours:minutes',

				),
					'type'	=> 'select',
			),
			array(
				'name' 	=> esc_html__('Class name','labora_shortcodes'),
				'desc'	=> esc_html__('Type class', 'labora_shortcodes'),
				'id' 	=> 'cd_class',
				'std' 	=> '',
				'type' 	=> 'text',
			),
		),
	);
	// E N D   - Count Down

	//S T A F F
	//--------------------------------------------------------
	$labora_sc['Staff'] = array(
		'name' => esc_html__('Staff Box', 'labora_shortcodes'),
		'value' => 'staff',
		'options' => array(
			array(
				'name' => esc_html__('Photo', 'labora_shortcodes'),
				'desc' => esc_html__('Select the photo from media library or from your desktop but make sure its width should not be less than 420px to make it responsive.', 'labora_shortcodes'),
				'id' => 'photo',
				'std' => '',
				'type' => 'upload',
				'inputsize' => '53'
			),
			array(
				'name' => esc_html__('Name', 'labora_shortcodes'),
				'desc' => esc_html__('Type the text or title you wish to display as Name', 'labora_shortcodes'),
				'id' => 'title',
				'std' => '',
				'type' => 'text',
				'inputsize' => '53'
			),
			array(
				'name' => esc_html__('Role', 'labora_shortcodes'),
				'desc' => esc_html__('Type the text to resemble to role of a person', 'labora_shortcodes'),
				'id' => 'role',
				'std' => '',
				'type' => 'text',
				'inputsize' => '53'
			),
			array(
				'name' => esc_html__('Sociables', 'labora_shortcodes'),
				'desc' => esc_html__('Add Sociables to the relevant Staff.', 'labora_shortcodes'),
				'id' => 'selectsociable',
				'std' => '',
				'type' => 'select',
				'options' => $staff_social,
				'inputsize' => '70'
			),

			array(
				'name' => esc_html__('Blogger', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Blogger URL ', 'labora_shortcodes'),
				'id' => 'blogger',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Dribbble', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Dribble URL', 'labora_shortcodes'),
				'id' => 'dribbble',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),

			array(
				'name' => esc_html__('Delicious', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Delicous URL', 'labora_shortcodes'),
				'id' => 'delicious',
				'std' => '',
				'class' => 'class_hide',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Digg', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Digg URL', 'labora_shortcodes'),
				'id' => 'digg',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Facebook', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Facebook URL', 'labora_shortcodes'),
				'id' => 'facebook',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Flickr', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Flickr URL', 'labora_shortcodes'),
				'id' => 'flickr',
				'std' => '',
				'class' => 'class_hide',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Forrst', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Forrst URL', 'labora_shortcodes'),
				'id' => 'forrst',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Google', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Google URL', 'labora_shortcodes'),
				'id' => 'google',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Linkedin', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Linkedin URL', 'labora_shortcodes'),
				'id' => 'linkedin',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Pinterest', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Pinterest URL', 'labora_shortcodes'),
				'id' => 'pinterest',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Skype', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Skype URL', 'labora_shortcodes'),
				'id' => 'skype',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Stumbleupon', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Stumbleupon URL', 'labora_shortcodes'),
				'id' => 'stumbleupon',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Twitter', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Twitter URL', 'labora_shortcodes'),
				'id' => 'twitter',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Yahoo', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Yahoo URL', 'labora_shortcodes'),
				'id' => 'yahoo',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),
			array(
				'name' => esc_html__('Youtube', 'labora_shortcodes'),
				'desc' => esc_html__('Enter Youtube URL', 'labora_shortcodes'),
				'id' => 'youtube',
				'class' => 'class_hide',
				'std' => '',
				'type' => 'text_rm',
				'inputsize' => '70'
			),

			 array(
				'name' => esc_html__('Animations', 'labora_shortcodes'),
				'desc' => esc_html__('Select an animation effect for the element', 'labora_shortcodes'),
				'info' => '(Optional)',
				'id' => 'animation',
				'std' => '',
				'type' => 'select',
				'options' => $labora_animation
			)
		)
	);
	// E N D   - Staff

	// F L I C K R
	//--------------------------------------------------------
	$labora_sc['Flickr'] = array(
		'name' => esc_html__('Flickr Photos', 'labora_shortcodes'),
		'value' => 'flickr',
		'options' => array(
			array(
				'name' => esc_html__('Flickr Id', 'labora_shortcodes'),
				'desc' => esc_html__('Flickr ID: Find your Id from http://idgettr.com', 'labora_shortcodes'),
				'id' => 'id',
				'std' => '',
				'type' => 'text',
				'inputsize' => '30'
			),
			array(
				'name' => esc_html__('Limit', 'labora_shortcodes'),
				'desc' => esc_html__('Flickr Photos Limit.', 'labora_shortcodes'),
				'id' => 'limit',
				'std' => '3',
				'type' => 'text',
				'inputsize' => '30'
			),
			array(
				'name' => esc_html__('Type', 'labora_shortcodes'),
				'desc' => esc_html__('Choose Photos Type', 'labora_shortcodes'),
				'id' => 'type',
				'std' => 'user',
				'options' => array(
					'user' => 'User',
					'group' => 'Group'
				),
				'type' => 'select'
			),
			array(
				'name' => esc_html__('Display', 'labora_shortcodes'),
				'desc' => esc_html__('Choose Display Type', 'labora_shortcodes'),
				'id' => 'display',
				'std' => 'random',
				'options' => array(
					'random' => 'Random',
					'latest' => 'Latest'
				),
				'type' => 'select'
			)
		)
	);
	// END - Flickr

	// T A B S
	//------------------------------------------------------------------
	 $labora_sc['Tabs'] = array(
		'name'		=> esc_html__('Tabs','labora_shortcodes'),
		'value'		=>'Tabs',
		'subtype'	=> true,
		'options'	=> array(
			array(
				'name'		=> esc_html__('2 Tabs','labora_shortcodes'),
				'value'		=>'t2',
				'options'	=> array(
					array(
						'name'	=> esc_html__('Tab 1 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 1', 'labora_shortcodes'),
						'id'	=> 'title_1',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 1 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 1', 'labora_shortcodes'),
						'id'	=> 'text_1',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Tab 1 Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlebgcolor_1',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Tab 1 Title Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlecolor_1',
						'std'	=> '',
						'type'	=> 'color',
					),
					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tab 2 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 2', 'labora_shortcodes'),
						'id'	=> 'title_2',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 2 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 2', 'labora_shortcodes'),
						'id'	=> 'text_2',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Tab 2 Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlebgcolor_2',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Tab 2 Title Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlecolor_2',
						'std'	=> '',
						'type'	=> 'color',
					),
					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tabs Type  ','labora_shortcodes'),
						'desc'	=> esc_html__('Choose Tabs Type Horizontal/Vertical', 'labora_shortcodes'),
						'id'	=> 'ctabs',
						'std'	=> '',
						'options'=> array(
									'horitabs' => 'Horizontal',
									'vertabs' => 'Vertical',
						),
						'type'	=> 'select',
					),
					array(
						'name'	=> esc_html__('Animations', 'labora_shortcodes'),
						'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	  => 'animation',
						'std'	 => '',
						'type'	=> 'select',
						'options' => $labora_animation
					),

				),
			),
			// 3 T A B S
			array(
				'name'		=> esc_html__('3 Tabs','labora_shortcodes'),
				'value'		=>'t3',
				'options'	=> array(
					array(
						'name'	=> esc_html__('Tab 1 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 1', 'labora_shortcodes'),
						'id'	=> 'title_1',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 1 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 1', 'labora_shortcodes'),
						'id'	=> 'text_1',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Tab 1 Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlebgcolor_1',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Tab 1 Title Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlecolor_1',
						'std'	=> '',
						'type'	=> 'color',
					),
					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tab 2 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 2', 'labora_shortcodes'),
						'id'	=> 'title_2',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 2 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 2', 'labora_shortcodes'),
						'id'	=> 'text_2',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Tab 2 Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlebgcolor_2',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Tab 2 Title Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlecolor_2',
						'std'	=> '',
						'type'	=> 'color',
					),
					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tab 3 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 3', 'labora_shortcodes'),
						'id'	=> 'title_3',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 3 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 3', 'labora_shortcodes'),
						'id'	=> 'text_3',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Tab 3 Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlebgcolor_3',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Tab 3 Title Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'titlecolor_3',
						'std'	=> '',
						'type'	=> 'color',
					),
					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tabs Type  ','labora_shortcodes'),
						'desc'	=> esc_html__('Choose Tabs Type Horizontal/Vertical', 'labora_shortcodes'),
						'id'	=> 'ctabs',
						'std'	=> '',
						'options'=> array(
									'horitabs' => 'Horizontal',
									'vertabs' => 'Vertical',
						),
						'type'	=> 'select',
					),
					array(
						'name'	=> esc_html__('Animations', 'labora_shortcodes'),
						'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	  => 'animation',
						'std'	 => '',
						'type'	=> 'select',
						'options' => $labora_animation
					),
				),
			),
		)
	);
	// END - Tabs


	// NAV T A B S
	//------------------------------------------------------------------
	 $labora_sc['Tabsnav'] = array(
		'name'		=> esc_html__('Tabsnav','labora_shortcodes'),
		'value'		=>'Tabsnav',
		'subtype'	=> true,
		'options'	=> array(
			array(
				'name'		=> esc_html__('2 Tabs','labora_shortcodes'),
				'value'		=>'tn2',
				'options'	=> array(
					array(
						'name'	=> esc_html__('Tab 1 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 1', 'labora_shortcodes'),
						'id'	=> 'title_1',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 1 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 1', 'labora_shortcodes'),
						'id'	=> 'text_1',
						'std'	=> '',
						'type'	=> 'textarea'
					),

					array(
						'name'	=> esc_html__('Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'bgcolor_1',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'color_1',
						'std'	=> '',
						'type'	=> 'color',
					),



				//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tab 2 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 2', 'labora_shortcodes'),
						'id'	=> 'title_2',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 2 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 2', 'labora_shortcodes'),
						'id'	=> 'text_2',
						'std'	=> '',
						'type'	=> 'textarea'
					),

					array(
						'name'	=> esc_html__('Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'bgcolor_2',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'color_2',
						'std'	=> '',
						'type'	=> 'color',
					),

					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),
					array(
						'name'	=> esc_html__('Animations', 'labora_shortcodes'),
						'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	  => 'animation',
						'std'	 => '',
						'type'	=> 'select',
						'options' => $labora_animation
					),

				),
			),
			// 3 T A B S
			array(
				'name'		=> esc_html__('3 Tabs','labora_shortcodes'),
				'value'		=>'tn3',
				'options'	=> array(
					array(
						'name'	=> esc_html__('Tab 1 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 1', 'labora_shortcodes'),
						'id'	=> 'title_1',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 1 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 1', 'labora_shortcodes'),
						'id'	=> 'text_1',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'bgcolor_1',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'color_1',
						'std'	=> '',
						'type'	=> 'color',
					),

					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tab 2 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 2', 'labora_shortcodes'),
						'id'	=> 'title_2',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 2 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 2', 'labora_shortcodes'),
						'id'	=> 'text_2',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'bgcolor_2',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'color_2',
						'std'	=> '',
						'type'	=> 'color',
					),

					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),

					array(
						'name'	=> esc_html__('Tab 3 Title','labora_shortcodes'),
						'desc'	=> esc_html__('Type the text for Tab 3', 'labora_shortcodes'),
						'id'	=> 'title_3',
						'std'	=> '',
						'type'	=> 'text',
						'inputsize'	=>'53',
					),
					array(
						'name'	=> esc_html__('Tab 3 Content','labora_shortcodes'),
						'desc'	=> esc_html__('Type the content for Tab 3', 'labora_shortcodes'),
						'id'	=> 'text_3',
						'std'	=> '',
						'type'	=> 'textarea'
					),
					array(
						'name'	=> esc_html__('Bgcolor','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'bgcolor_3',
						'std'	=> '',
						'type'	=> 'color',
					),
					array(
						'name'	=> esc_html__('Color','labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	=> 'color_3',
						'std'	=> '',
						'type'	=> 'color',
					),

					//------------------------- S E P A R A T O R
					array('name' => esc_html__('Separator','labora_shortcodes'),'type' => 'separator', ),
					array(
						'name'	=> esc_html__('Animations', 'labora_shortcodes'),
						'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
						'info'	=> '(Optional)',
						'id'	  => 'animation',
						'std'	 => '',
						'type'	=> 'select',
						'options' => $labora_animation
					),
				),
			),
		)
	);
	// END - NAV Tabs



	// C O N T A C T  I N F O
	//--------------------------------------------------------
	$labora_sc['Contact Info'] = array(
		'name'		=> esc_html__('Contact Info','labora_shortcodes'),
		'value'		=>'contactinfo',
		'options'	=> array(
			array(
				'name'	=> esc_html__('Name','labora_shortcodes'),
				'desc'	=> esc_html__('Type the Name or Company Name you wish to display.', 'labora_shortcodes'),
				'id'	=> 'name',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '',
			),
			array(
				'name'	=> esc_html__('Address','labora_shortcodes'),
				'desc'	=> esc_html__('Type the Address you wish to display.', 'labora_shortcodes'),
				'id'	=> 'address',
				'std'	=> '',
				'type'	=> 'textarea',
				'inputsize'	=> '',
			),
			array(
				'name'	=> esc_html__('Phone','labora_shortcodes'),
				'desc'	=> esc_html__('Type the Phone Number you wish to display.', 'labora_shortcodes'),
				'id'	=> 'phone',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '',
			),
			array(
				'name'	=> esc_html__('Email','labora_shortcodes'),
				'desc'	=> esc_html__('Type the Email-ID you wish to display.', 'labora_shortcodes'),
				'id'	=> 'email',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '',
			),
			array(
				'name'	=> esc_html__('Website','labora_shortcodes'),
				'desc'	=> esc_html__('Enter your website name.', 'labora_shortcodes'),
				'id'	=> 'website_name',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '',
			),
			array(
				'name'	=> esc_html__('Website URL','labora_shortcodes'),
				'desc'	=> esc_html__('Type the Link URL you wish to display. excluding http', 'labora_shortcodes'),
				'id'	=> 'website_url',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '',
			),
			array(
				'name'	=> esc_html__('Fax','labora_shortcodes'),
				'desc'	=> esc_html__('Enter your fax number.', 'labora_shortcodes'),
				'id'	=> 'fax',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize'	=> '',
			),
			array(
				'name'	=> esc_html__('Animations', 'labora_shortcodes'),
				'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	  => 'animation',
				'std'	 => '',
				'type'	=> 'select',
				'options' => $labora_animation
			),
		)
	);
	// END Contact Info

	// Fun Facts
	//--------------------------------------------------------
	$labora_sc['funfact'] = array(
		'name'		=> esc_html__( 'Fun Fact','labora_shortcodes' ),
		'value'		=> 'funfact',
		'options'	=> array(
			array(
				'name'	=> esc_html__( 'Fontawesome Icon','labora_shortcodes' ),
				'desc'  => esc_html__( 'Go to Example http://fortawesome.github.io/Font-Awesome/examples/', 'labora_shortcodes' ),
				'id'	=> 'funfact_iconstyle',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name' 	=> esc_html__( 'Icon Color','labora_shortcodes' ),
				'desc'	=> esc_html__( 'Select the color variation', 'labora_shortcodes' ),
				'id' 	=> 'icon_color',
				'std' 	=> '',
				'type' 	=> 'color',
			),
			array(
				'name'	=> esc_html__( 'Number Text','labora_shortcodes' ),
				'desc'	=> esc_html__( 'Type the number that display Ex. 35%, 1000, 50$, etc', 'labora_shortcodes' ),
				'id'	=> 'data_value',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__( 'Only Number','labora_shortcodes' ),
				'desc'	=> esc_html__( 'Type only the numeric value same as above.', 'labora_shortcodes' ),
				'id'	=> 'data_number',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__( 'Title','labora_shortcodes' ),
				'desc'	=> esc_html__( 'Type the text if you wish to display.', 'labora_shortcodes' ),
				'id'	=> 'main_title',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name' 	=> esc_html__( 'Color','labora_shortcodes' ),
				'desc'	=> esc_html__( 'Select the color variation for number', 'labora_shortcodes' ),
				'id' 	=> 'title_color',
				'std' 	=> '',
				'type' 	=> 'color',
			),
			array(
				'name'	=> esc_html__( 'Text Alignment', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Choose the position you want align', 'labora_shortcodes' ),
				'id'	=> 'position',
				'std'	=> '',
				'options'=> array(
							'left' => 'Left Align',
							'center' => 'Center Align',
							'right' => 'Right Align',
				),
				'type'	=> 'select',
			),
		),
	);
	// END - Fun Fact

	// V I M E O
	//--------------------------------------------------------
	$labora_sc['Vimeo']  = array(
		'name' => esc_html__('Vimeo', 'labora_shortcodes'),
		'value' => 'vimeo',
		'options' => array(
			array(
				'name' => esc_html__('Clip id', 'labora_shortcodes'),
				'desc' => wp_kses(__('Enter the ID only from the clips URL (e.g. http://vimeo.com/<span style="color:red">123456</span>)', 'labora_shortcodes'), $iva_allowed_html_array ),
				'id' => 'clipid',
				'std' => '',

				'type' => 'textarea'
			),
			array(
				'name' => esc_html__('Autoplay', 'labora_shortcodes'),
				'desc' => esc_html__('Check this if you wish to enable auto play option.', 'labora_shortcodes'),
				'id' => 'autoplay',
				'std' => 'true',
				'type' => 'checkbox'
			)
		)
	);
	//END - Vimeo

	// Y O U T U B E
	//--------------------------------------------------------
	$labora_sc['Youtube'] = array(
		'name' => esc_html__('Youtube', 'labora_shortcodes'),
		'value' => 'youtube',
		'options' => array(
			array(
				'name' => esc_html__('Clip id', 'labora_shortcodes'),
				'desc' => wp_kses(__('The id from the clip URL after v= (e.g. http://www.youtube.com/watch?v=<span style="color:red">GgR6dyzkKHI</span>)', 'labora_shortcodes'),$iva_allowed_html_array),
				'id' => 'clipid',
				'std' => '',
				'type' => 'textarea'
			),
			array(
				'name' => esc_html__('Autoplay', 'labora_shortcodes'),
				'desc' => esc_html__('Check this if you wish to start playing the video after the player intialized.', 'labora_shortcodes'),
				'id' => 'autoplay',
				'type' => 'checkbox'
			)
		)
	);
	//END - Youtube

	// P R I C I N G T A B L E
	//--------------------------------------------------------
	$labora_sc['Pricing Table'] = array(
		'name' => esc_html__('Pricing Table', 'labora_shortcodes'),
		'value' => 'pricing',
		'options' => array(
			array(
				'name' 	=> esc_html__('Pricing Columns', 'labora_shortcodes'),
				'desc' 	=> esc_html__('Price Columns.', 'labora_shortcodes'),
				'id' 	=> 'price',
				'std' 	=> '',
				'type' 	=> 'select',
				'options' 	=> array(
					'03' 	=> 'Three Columns',
					'04' 	=> 'Four Columns'
				)
			)
		)
	);
	// END PRICING TABLE
	/**
	 * Image Icon Box
	*/
	$labora_sc['Image Icon Box'] = array(
		'name'  => esc_html__( 'Image Icon Box', 'labora_shortcodes' ),
		'value'  => 'image_icon_box',
		'options' => array(
			array(
				'name' => esc_html__( 'Add Font Awesome Icon Name', 'labora_shortcodes' ),
				'desc'  => esc_html__( 'Go to Example: http://fortawesome.github.io/Font-Awesome/icons/', 'labora_shortcodes' ),
				'id' => 'icon',
				'std' => '',
				'type' => 'text',
			),
			array(
				'name' => esc_html__( 'Icon Color', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Choose the Icon Color.', 'labora_shortcodes' ),
				'info' => '(optional)',
				'id' => 'icon_color',
				'std' => '',
				'type' => 'color',
			),
			array(
				'name' => esc_html__( 'Heading', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Type the Heading you wish to display for the Image Icon Box.', 'labora_shortcodes' ),
				'info' => '(optional)',
				'id' => 'heading',
				'std' => '',
				'type' => 'text',
				'inputsize' => '53',
			),
			array(
				'name' => esc_html__( 'Heading Color', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Choose the Heading Color.', 'labora_shortcodes' ),
				'info' => '(optional)',
				'id' => 'heading_color',
				'std' => '',
				'type' => 'color',
			),
			array(
				'name' => esc_html__( 'Content', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Type the Content you wish to display for the Image Icon Box.','labora_shortcodes' ),
				'id' => 'content',
				'std' => '',
				'type' => 'textarea',
			),
			array(
				'name' => esc_html__( 'Content Color', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Choose the Content Color.', 'labora_shortcodes' ),
				'info' => '(optional)',
				'id' => 'content_color',
				'std' => '',
				'type' => 'color',
			),
			array(
				'name' => esc_html__( 'Background Image', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Upload Image you want to display for the Image Icon Box Background  on hover.', 'labora_shortcodes' ),
				'id' => 'bg_image',
				'std' => '',
				'type' => 'upload',
			),
			array(
				'name' => esc_html__( 'Background Color', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Choose the Background Color for Image Icon Box Background  on hover.', 'labora_shortcodes' ),
				'info' => '(optional)',
				'id' => 'bg_color',
				'std' => '',
				'type' => 'color',
			),
			array(
				'name' => esc_html__( 'Border Color', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Choose the Border Color for Image Icon Box on hover.', 'labora_shortcodes' ),
				'info' => '(optional)',
				'id' => 'border_color',
				'std' => '',
				'type' => 'color',
			),
			array(
				'name'  => esc_html__( 'Link Text', 'labora_shortcodes' ),
				'desc'  => esc_html__( 'Type the text you wish to display for the link text else the link will not be displayed.', 'labora_shortcodes' ),
				'info'  => '(Optional)',
				'id'  => 'link_text',
				'std'  => '',
				'type'  => 'text',
			),
			array(
				'name' => esc_html__( 'Link URL', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Type the url including http:// protocal, the whole fancy box will be linked', 'labora_shortcodes' ),
				'id' => 'link',
				'std' => '',
				'type' => 'text',
			),
			array(
				'name'  => esc_html__( 'Link Target ', 'labora_shortcodes' ),
				'desc'  => esc_html__( 'Check this if you wish to open in a new tab.', 'labora_shortcodes' ),
				'info'  => '(Optional)',
				'id'  => 'link_target',
				'std'  => '',
				'type'  => 'checkbox',
			),
			array(
				'name' => esc_html__( 'Animations', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Select an animation effect for the element.', 'labora_shortcodes' ),
				'info' => '(Optional)',
				'id' => 'animation',
				'std' => '',
				'type' => 'select',
				'options' => $labora_animation,
			),
		),
	);
	// EOF
	/**
	  * Service Box
	  */
	$labora_sc['Service Box'] = array(
		'name'  => esc_html__( 'Service Box', 'labora_shortcodes' ),
		'value'  => 'service_box',
		'options' => array(
		    array(
			    'name' => esc_html__( 'Background Image', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Upload Image you want to display for the Service Box Background.', 'labora_shortcodes' ),
			    'id' => 'bg_image',
			    'std' => '',
			    'type' => 'upload',
		    ),
		    array(
			    'name' => esc_html__( 'Background Color', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Choose the Background Color for Service Box on hover.', 'labora_shortcodes' ),
			    'info' => '(optional)',
			    'id' => 'bg_color',
			    'std' => '',
			    'type' => 'color',
		    ),
		    array(
			    'name' => esc_html__( 'Add Font Awesome Icon Name', 'labora_shortcodes' ),
			    'desc'  => esc_html__( 'Go to Example: http://fortawesome.github.io/Font-Awesome/icons/', 'labora_shortcodes' ),
			    'id' => 'icon',
			    'std' => '',
			    'type' => 'text',
		    ),
		    array(
			    'name' => esc_html__( 'Icon Color', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Choose the Icon Color.', 'labora_shortcodes' ),
			    'info' => '(optional)',
			    'id' => 'icon_color',
			    'std' => '',
			    'type' => 'color',
		    ),
		    array(
			    'name' => esc_html__( 'Heading', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Type the Heading you wish to display for the Service Box.', 'labora_shortcodes' ),
			    'info' => '(optional)',
			    'id' => 'heading',
			    'std' => '',
			    'type' => 'text',
			    'inputsize' => '53',
		    ),
		    array(
			    'name' => esc_html__( 'Heading Color', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Choose the Heading Color.', 'labora_shortcodes' ),
			    'info' => '(optional)',
			    'id' => 'heading_color',
			    'std' => '',
			    'type' => 'color',
		    ),
		    array(
			    'name' => esc_html__( 'Content', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Type the Content you wish to display for the Service Box.','labora_shortcodes' ),
			    'id' => 'content',
			    'std' => '',
			    'type' => 'textarea',
		    ),
		    array(
			    'name' => esc_html__( 'Content Color', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Choose the Content Color.', 'labora_shortcodes' ),
			    'info' => '(optional)',
			    'id' => 'content_color',
			    'std' => '',
			    'type' => 'color',
		    ),
		    array(
			    'name'  => esc_html__( 'Link Text', 'labora_shortcodes' ),
			    'desc'  => esc_html__( 'Type the text you wish to display for the link text else the link will not be displayed.', 'labora_shortcodes' ),
			    'info'  => '(Optional)',
			    'id'  => 'link_text',
			    'std'  => '',
			    'type'  => 'text',
		    ),
		    array(
			    'name' => esc_html__( 'Link URL', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Type the url including http:// protocal, the whole fancy box will be linked', 'labora_shortcodes' ),
			    'id' => 'link',
			    'std' => '',
			    'type' => 'text',
		    ),
		    array(
			    'name'  => esc_html__( 'Link Target ', 'labora_shortcodes' ),
			    'desc'  => esc_html__( 'Check this if you wish to open in a new tab.', 'labora_shortcodes' ),
			    'info'  => '(Optional)',
			    'id'  => 'link_target',
			    'std'  => '',
			    'type'  => 'checkbox',
		    ),
		    array(
			    'name' => esc_html__( 'Animations', 'labora_shortcodes' ),
			    'desc' => esc_html__( 'Select an animation effect for the element.', 'labora_shortcodes' ),
			    'info' => '(Optional)',
			    'id' => 'animation',
			    'std' => '',
			    'type' => 'select',
			    'options' => $labora_animation,
		    ),
		),
	 );
	 // EOF
	/**
	 * Fancy Box Image
	 */
	$labora_sc['Fancy Box Image'] = array(
		'name'		=> esc_html__('Fancy Box Image','labora_shortcodes'),
		'value'		=> 'fancyboximage',
		'options'	=> array(
			array(
				'name'	=> esc_html__('Upload Image','labora_shortcodes'),
				'desc'	=> esc_html__('Background Image for the fancy box', 'labora_shortcodes'),
				'id'	=> 'image',
				'std'	=> '',
				'type'	=> 'upload',
			),
			array(
				'name'	=> esc_html__('Heading','labora_shortcodes'),
				'desc'	=> esc_html__('Heading you wish to display for the box', 'labora_shortcodes'),
				'id'	=> 'title',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__('Short Title','labora_shortcodes'),
				'desc'	=> esc_html__( 'Short Title you wish to display below the Heading','labora_shortcodes' ),
				'id'	=> 's_desc',
				'std'	=> '',
				'type'	=> 'textarea',
			),
			array(
				'name'	=> esc_html__('Link URL','labora_shortcodes'),
				'desc'	=> esc_html__('Type the url including http:// protocal, the whole fancy box will be linked', 'labora_shortcodes'),
				'id'	=> 'link',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name' 	=> esc_html__('Link Target ', 'labora_shortcodes'),
				'desc' 	=> esc_html__('Check this if you wish to open in a new tab.', 'labora_shortcodes'),
				'info' 	=> '(Optional)',
				'id' 	=> 'link_target',
				'std' 	=> '',
				'type'  => 'checkbox'
			),
			array(
				'name' 	=> esc_html__('Link Text', 'labora_shortcodes'),
				'desc' 	=> esc_html__('Type the text you wish to display for the link text else the link will not be displayed.', 'labora_shortcodes'),
				'info' 	=> '(Optional)',
				'id' 	=> 'link_text',
				'std' 	=> '',
				'type'  => 'text'
			),
			array(
				'name'	=> esc_html__('Animations', 'labora_shortcodes'),
				'desc'	=> esc_html__('Select an animation effect for the element.', 'labora_shortcodes'),
				'info'	=> '(Optional)',
				'id'	=> 'animation',
				'std'	=> '',
				'type'	=> 'select',
				'options' => $labora_animation,
			),
		)
	);
	// EOF

	/**
	 * Twenty Twenty Before After Image
	 */
	$labora_sc['Twenty Twenty'] = array(
		'name'		=> esc_html__( 'Twenty Twenty', 'labora_shortcodes' ),
		'value'		=> 'twenty_twenty',
		'options'	=> array(
			array(
				'name'	=> esc_html__( 'Upload Before Image', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Upload Image you wish to display it as before image.', 'labora_shortcodes' ),
				'id'	=> 'before_image',
				'std'	=> '',
				'type'	=> 'upload',
			),
			array(
				'name'	=> esc_html__( 'Upload After Image', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Upload Image you wish to display it as after image.', 'labora_shortcodes' ),
				'id'	=> 'after_image',
				'std'	=> '',
				'type'	=> 'upload',
			),
			array(
				'name'	=> esc_html__( 'Width', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Type the width in px, if you wish to use the image in a specific width.', 'labora_shortcodes' ),
				'info'	=> '(optional)',
				'id'	=> 'width',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize' => '53',
			),
			array(
				'name'	=> esc_html__( 'Height', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Type the width in px, if you wish to use the image in a specific width.', 'labora_shortcodes' ),
				'info'	=> '(optional)',
				'id'	=> 'height',
				'std'	=> '',
				'type'	=> 'text',
				'inputsize' => '53',
			),
			array(
				'name'	=> esc_html__( 'Animations', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Select an animation effect for the element.', 'labora_shortcodes' ),
				'info'	=> '(Optional)',
				'id'	=> 'animation',
				'std'	=> '',
				'type'	=> 'select',
				'options' => $labora_animation,
			),
		),
	);
	// EOF

	/**
	 * Table Sorting
	 */
	$labora_sc['Vacant Table'] = array(
		'name'		=> esc_html__( 'Vacant Table', 'labora_shortcodes' ),
		'value'		=> 'vacant_table',
		'options'	=> array(
			array(
				'name'	=> esc_html__( 'Columns', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Choose Table Columns.', 'labora_shortcodes' ),
				'id'	=> 'columns',
				'std'	=> '',
				'options' => array(
								'1'	=> 'Column 1',
								'2'	=> 'Column 2',
								'3'	=> 'Column 3',
								'4'	=> 'Column 4',
								'5'	=> 'Column 5',
							),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__( 'Heading', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Column Headings.', 'labora_shortcodes' ),
				'id'	=> 'heading',
				'std'	=> '',
				'class' => 'vacant_heading',
				'options' => array(
								'heading1'	=> 'Heading 1',
								'heading2'	=> 'Heading 2',
								'heading3'	=> 'Heading 3',
								'heading4'	=> 'Heading 4',
								'heading5'	=> 'Heading 5',
							),
				'type'	=> 'select',
			),
			array(
				'name'	=> esc_html__( 'Header Text Color', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Choose the color you wish to display for the Header.', 'labora_shortcodes' ),
				'info'	=> '(optional)',
				'id'	=> 'header_txt_color',
				'std'	=> '',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__( 'Animations', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Select an animation effect for the element.', 'labora_shortcodes' ),
				'info'	=> '(Optional)',
				'id'	=> 'animation',
				'std'	=> '',
				'type'	=> 'select',
				'options' => $labora_animation,
			),
		),
	);// EOF

	// L O G O  C A R O U S E L
	//--------------------------------------------------------
	$labora_sc['Logo Carousel'] = array(
		'name'		=> __( 'Logo Carousel', 'labora_shortcodes' ),
		'value'		=> 'logocarousel',
		'options'	=> array(
			array(
				'name'	=> esc_html__( 'Images', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Choose no of images to display for Logo Carousel.', 'labora_shortcodes' ),
				'id'	=> 'images_count',
				'std'	=> '',
				'options' => array(
								'3'	=> '3',
								'4'	=> '4',
								'5'	=> '5',
								'6'	=> '6',
							),
				'type'	=> 'select',
			),
			array(
				'name'	=> __( 'Logo Title','labora_shortcodes' ),
				'desc'	=> __( 'Enter the title for the Logo Carousel.', 'labora_shortcodes' ),
				'id'	=> 'title',
				'std'	=> '',
				'type'	=> 'text',
			),
			array(
				'name'	=> __( 'Carousel Speed','labora_shortcodes' ),
				'desc'	=> __( 'Carousel speed', 'labora_shortcodes' ),
				'id'	=> 'speed',
				'std'	=> '3000',
				'type'	=> 'text',
			),
			array(
				'name'	=> __( 'Items display', 'labora_shortcodes' ),
				'desc'	=> __( 'Number of Items to show per carousel', 'labora_shortcodes' ),
				'id'	=> 'items',
				'std'	=> '',
				'type'	=> 'text',
			),
		),
	);
	// E N D   - Logo carousel
	// Expandable
	//--------------------------------------------------------
	$labora_sc['Expandable']  = array(
		'name' => esc_html__('Expandable', 'labora_shortcodes'),
		'value' => 'expandable',
		'options' => array(
			array(
				'name' => esc_html__('More Label', 'labora_shortcodes'),
				'desc' => esc_html__('Enter the More Label', 'labora_shortcodes' ),
				'id' => 'morelabel',
				'std' => '',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Less Label', 'labora_shortcodes'),
				'desc' => esc_html__('Enter the Less Label', 'labora_shortcodes' ),
				'id' => 'lesslabel',
				'std' => '',
				'type' => 'text'
			),
			array(
				'name' => esc_html__('Content', 'labora_shortcodes' ),
				'desc' => esc_html__('Enter The content.', 'labora_shortcodes'),
				'id' => 'content',
				'type' => 'textarea'
			),
			array(
				'name' => esc_html__('Background Color', 'labora_shortcodes' ),
				'desc' => esc_html__('Background Color.', 'labora_shortcodes'),
				'id' => 'color',
				'type' => 'color'
			),
			array(
				'name' => esc_html__('Text Color', 'labora_shortcodes' ),
				'desc' => esc_html__('Text Color.', 'labora_shortcodes'),
				'id' => 'textcolor',
				'type' => 'color'
			)

		),
	);
	// E N D   - Expandable
	
	// Gallery
	//--------------------------------------------------------
	$labora_sc['Gallery']  = array(
		'name' => esc_html__('Gallery', 'labora_shortcodes'),
		'value' => 'gallery',
		'options' => array(
			array(
				'name' 		=> esc_html__('Gallery Select', 'labora_shortcodes'),
				'id' 		=> 'gal_select',
				'std' 		=> '',
				'type'		=> 'select',
				'options' 	=> array(
						'' 			 => 'Choose Type...',
						'gallery_cat' 		=> 'Gallery List',
						'gallery_postids'	=> 'Gallery ID'
				)
			),
			array(
				'name' 		=> esc_html__( 'Style', 'labora_shortcodes' ),
				'desc' 		=> esc_html__( 'Select the Gallery Columns Layout Style', 'labora_shortcodes' ),
				'id' 		=> 'gal_column',
				'std' 		=> '4',
				'class' => 'shortgallery gallery_cat',
				'options'	=> array(
					'3'		=> '3 Columns',
					'4'		=> '4 Columns'
				),
				'type' => 'select',
			),
			array(
				'name' => esc_html__( 'Gallery ID', 'labora_shortcodes' ),
				'desc' => esc_html__( 'Enter the Gallery Post-ID with comma separated if you wish to display more than one post', 'labora_shortcodes' ),
				'id'   => 'gal_postid',
				'std'  => '4',
				'class' => 'shortgallery gallery_postids',
				'type' => 'text',
			),	
			array(
				'name'	=> esc_html__( 'Gallery Limit', 'labora_shortcodes' ),
				'desc' 	=> esc_html__( 'Type the number of items you wish to display per page', 'labora_shortcodes' ),
				'id' 	=> 'gal_limit',
				'class' => 'shortgallery  gallery_cat',
				'std' 	=> '4',
				'type'	=> 'text',
			),
			array(
				'name' 		=> esc_html__( 'Category', 'labora_shortcodes' ),
				'desc' 		=> esc_html__( 'Hold Control/Command key to select multiple categories', 'labora_shortcodes' ),
				'info' 		=> '(optional)',
				'id' 		=> 'gal_cat',
				'std' 		=> '',
				'class' 	=> 'shortgallery gallery_cat',
				'options' 	=> $labora_sc_obj->labora_sc_get_vars( 'gallery' ),
				'type' 		=> 'multiselect',
			),
			array(
				'name' 	=> esc_html__( 'Order By', 'labora_shortcodes' ),
				'desc' 	=> esc_html__( 'Select the orderby  which you want to use  Id ,title,date or menu order in gallery page', 'labora_shortcodes' ),
				'id' 	=> 'orderby',
				'class' => 'shortgallery gallery_cat',
				'std' 	=> '4',
				'options' => array( 
									'ID' 			=> 'ID',
									'title'			=> 'Title',
									'date' 			=> 'Date',
									'rand'			=> 'Random',
									'menu_order'	=> 'Menu Order'
								),
				'type' => 'select',
			),
			array(
				'name' 	=> esc_html__( 'Order', 'labora_shortcodes' ),
				'desc' 	=> esc_html__( 'Select the order which you wish to display in gallery Page', 'labora_shortcodes' ),
				'id' 	=> 'order',
				'class' => 'shortgallery gallery_cat',
				'std' 	=> 'ASC',
				'options' => array(
									'ASC' => 'Ascending',
									'DSC' => 'Descending'
								),
				'type' => 'select',
			),
			array(
				'name'	=> esc_html__( 'Pagination', 'labora_shortcodes' ),
				'desc'	=> esc_html__( 'Check this if you wish to disable the pagination.', 'labora_shortcodes' ),
				'id'	=> 'gal_pagination',
				'class' => 'shortgallery  gallery_cat',
				'std'	=> '',
				'type'	=> 'checkbox',
			),
		),
	);
	// E N D   - Gallery

//Shortcodes generator
$labora_sc = apply_filters('iva_shorcode_meta',$labora_sc );
?>
<div id="labora-sc-generator"  class="mfp-hide mfp-with-anim">
	<div class="atp_meta_options">
		<div class="glowborder">
			<div class="atp_scgen">
				<div class="primary_select">
					<h2>Shortcode Generator</h2>
					<table class="shortcodestab" cellspacing="0"  cellpadding="0">
						<tr>
							<th scope="row">Shortcodes</th>
							<td><div class="meta_page_selectwrap">
								<div><select id="primary_select">
								<option value="">choose</option>
								<?php
								ksort( $labora_sc );
								foreach($labora_sc as $shortcodes) {
									echo '<option value="'.$shortcodes['value'].'">'.$shortcodes['name'].'</option>';
								} ?>
								</select>
							</div></div></td>
						</tr>
					</table>
				</div>
				<?php
				foreach( $labora_sc as $shortcodes ) {
					echo '<div class="secondary_select" id="secondary_'.$shortcodes['value'].'">';

					if( isset( $shortcodes['subtype'] ) ){
						echo '<div class="secondaryselect">';
						echo '<table class="shortcodestab" cellspacing="0" cellpadding="8"><tr><th scope="row">Type:</th><td>';
						// Start Select ----------
						echo '<div class="meta_page_selectwrap"><div><select name="atp_'.$shortcodes['value'].'_selector">';
						echo '<option value=" ">Choose one...</option>';
						foreach( $shortcodes['options'] as $sub_shortcode ) {
							echo '<option value="'.$sub_shortcode['value'].'">'.$sub_shortcode['name'].'</option>';
						}
						echo '</select></div></div>';
						// End Select ----------
						echo '</td></tr>';
						echo '</table></div>';

						foreach( $shortcodes['options'] as $sub_shortcode ) {
							echo '<div id="atp-'.$sub_shortcode['value'].'" class="tertiary_select">';
							echo '<table class="shortcodestab" cellspacing="0"  cellpadding="8">';

							foreach( $sub_shortcode['options'] as $option ){
								if( ! isset( $option['id'] ) ) { $option['id']=''; }
								if( ! isset( $option['class'] ) ) { $option['class']=''; }

								echo '<tr class="'.$option['id'].' '.$option['class'].'">';
								$option['id']=''.$shortcodes['value'].'_'.$sub_shortcode['value'].'_'.$option['id'];
								if( !isset( $option['desc'] ) ) { $option['desc']=''; }

								if( ! isset( $option['inputsize'] ) ) { $option['inputsize']=''; }
								if( ! isset( $option['std']) ) { $option['std']=''; }
								if( ! isset( $option['options']) ) { $option['options']=''; }
								if( ! isset( $option['info']) ) { $option['info']=''; }
								labora_sc_typeeditor($option['type'],$option['id'],$option['options'],$option['name'],$option['desc'],$option['info'],$option['std'],$option['inputsize']);
								echo '</tr>';
							}
							echo '</table></div>';
						}
					}
					else {
					// Options
						if( array_key_exists('options', $shortcodes ) ) {
							echo '<table class="shortcodestab" cellspacing="0" cellpadding="8">';
							foreach( $shortcodes['options'] as $option ){
								if( ! isset( $option['class'] ) ) { $option['class']=''; }
								echo '<tr class="'.$option['id'].'  '.$option['class'].'">';
								$option['id']=''.$shortcodes['value'].'_'.$option['id'];
								if( ! isset( $option['desc'] ) ) { $option['desc']=''; }
								if( ! isset( $option['id'] ) ) { $option['id']=''; }
								if( ! isset( $option['inputsize'] ) ) { $option['inputsize']=''; }
								if( ! isset( $option['std'] ) ) { $option['std']=''; }
								if( ! isset( $option['options'] ) ) { $option['options']=''; }
								if( ! isset( $option['info'] ) ) { $option['info']=''; }
								labora_sc_typeeditor($option['type'],$option['id'],$option['options'],$option['name'],$option['desc'],$option['info'],$option['std'],$option['inputsize']); 	echo '</tr>';
							}
							echo '</table>';
						}
						// Options ends here
					}
					echo'</div>';
				}
				?>
			</div>
			<div class="sendbox">
				<input type="button" id="sendtoeditor" class="button button-primary button-hero" value="Send to Editor"/>
				<input type="hidden" name="atp-sociables-result" id="atp-sociables-result" value="" />
			</div>
		</div>
	</div>
</div>
<?php
}
// E D I T O R   T Y P E S
//--------------------------------------------------------
function labora_sc_typeeditor($type,$id,$ivaoptions,$name,$desc,$info,$std,$inputsize) {

	switch ($type) {
		case 'upload':
				echo '<th scope="row">',$name,'</th>';
				echo '<td><label for="upload_image">';
				echo '<input name="'.$id.'" id="'.$id.'"  type="text" class="custom_upload_image" value="" />';
				echo '<input class="upload_sc button-primary" type="button" value="Choose Image" />';
				echo '</label>';
				echo '<span class="desc">', $desc,'</span></td>';
				break;
		case 'keyselect':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><div class="meta_page_selectwrap"><div class="', $id, '"><select  name="', $id, '" id="', $id, '">';
				echo '<option value=" ">Select Option</option>';
				foreach ($ivaoptions as $optionkey => $option) {
					echo '<option value="',$option,'">', $option, '</option>';
				}
				echo '</select></div></div> <span class="desc">', $desc,'</span></td>';
				break;
		case 'color':
				$inputsize = isset($inputsize) ? $inputsize : '10';
				echo '<script>
				jQuery(document).ready(function(){
					jQuery("#',$id,'").wpColorPicker({
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
							jQuery("#',$id,' div").css("backgroundColor", "#" + hex);
							jQuery("#',$id,'").next("input").attr("value","#" + hex);
							jQuery("#',$id,'").val("#" + hex);
						}
					});
				});
				</script>';
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><div class="meta_page_selectwrap"><input class="color" type="text" name="', $id, '" id="', $id, '" value="', $std, '" size="', $inputsize, '" /><div id="', $id, '" class="wpcolorSelector"><div></div></div></div></td>';
				break;

		case 'text':
				$inputsize = isset($inputsize) ? $inputsize : '10';
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><input type="text" name="', $id, '" id="', $id, '" value="', $std, '" size="', $inputsize, '" /> <span class="desc">', $desc,'</span></td>';
				break;
		case 'text_rm':
				$inputsize = isset($inputsize) ? $inputsize : '10';
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><input type="text" name="', $id, '" id="', $id, '" value="', $std, '" size="', $inputsize, '" /><span class="button-primary staff_delete">remove</span><span class="desc">', $desc,'</span></td>';
				break;
		case 'textarea':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><textarea name="', $id, '" id="', $id, '" cols="60" rows="4" style="width:300px"></textarea><span class="desc">', $desc,'</span></td>';
				break;
		case 'select':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><div class="meta_page_selectwrap"><div class=""><select  name="', $id, '" id="', $id, '" class="">';
				foreach ( $ivaoptions as $optionkey => $option ) {
					echo '<option value="',$optionkey,'">', $option, '</option>';
				}
				echo '</select></div></div> <span class="desc">', $desc,'</span></td>';
				break;
		case 'optgroupselect':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><div class="meta_page_selectwrap"><div class="', $id, '"><select  name="', $id, '" id="', $id, '">';
				foreach ( $ivaoptions as $optiongroupkey => $optiongroup ) {
				 echo '<optgroup label="'.$optiongroupkey.'">';
					foreach( $optiongroup as $optionkey => $option ) {

					echo '<option value="',$optionkey,'">', $option, '</option>';
					}
				echo '</optgroup>';
				}
				echo '</select></div></div> <span class="desc">', $desc,'</span></td>';
				break;
		case 'multiselect':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><div class="', $id, '"><select style="width:300px; height:auto;" multiple="multiple" name="', $id, '[]" id="', $id, '">';
				foreach ($ivaoptions as $optionkey => $option) {
					echo '<option value="',$optionkey,'">', $option, '</option>';
				}
				echo '</select> <span class="desc">', $desc,'</span></td>';
				break;

		case 'checkbox':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td><input class="iva-button" type="checkbox" value="',$std,'" name="', $id, '" id="', $id, '"', $std ? ' checked="checked"' : '', ' />';
				echo '<span class="desc">', $desc,'</span></td>';
				break;
		case 'progressbar':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th>';
				echo '<td>'; ?>
				<div id="circleWrap">
					<div class="CircleCount">
						<div><span>Title: </span> <input type="text" name="title" class="title" id="title"></div>
						<div><span>Percent: </span> <input type="text" name="percent" class="percent" id="percent"></div>
						<div><span>Color: </span> <input class="color" name="color" type="text" class="skill-title color"  name="<?php echo  $id; ?>" id="<?php echo  $id; ?>" value="" size="<?php echo esc_attr($inputsize); ?>" /><div  class="colorSelector"><div ></div></div></br></div>
						<a href="#" class="close button button-primary button-large">Remove</a>
					</div>
				</div>
				<a href="#" id="add-progressbar" class="add button button-primary button-large"><?php esc_html_e('Add More', 'labora_shortcodes'); ?></a>

				<?php
				echo '<span class="desc">', $desc,'</span></td>';
				break;
		case 'radio':
				echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th><td>';
				foreach  ($ivaoptions as $key =>$value ) {
					echo '<label for="', esc_attr($key),'">', $value,'</label><input class="iva-button rb_align" type="radio" id="', $key, '" name="', $id, '" value="', $key, '"/>';
				}
				echo '</td>';
				break;
		case 'pattern_bg':
			echo '<th scope="row">',$name,'<span class="info">',$info,'</span></th><td>';
			$i = 0;
			foreach ( $ivaoptions as $key => $value ) {
				$i++;
				echo '<input value="' . esc_attr( $key ) . '"  class="checkbox atp-radio-img-radio" type="radio" id="' . esc_attr( $id . $i ) . '" name="' . esc_attr( $id ) . '"/>';
				echo '<img width="35" src="' . esc_url( $value ) . '" alt="" class="atp-radio-option" onClick="document.getElementById(\'' . esc_js( $id . $i ) . '\').checked = true;" />';
			}
			echo '</td>';
			break;
		case 'separator':
				echo '<th scope="row" class="sc_separator"></th>';
				echo '<td class="sc_separator"></td>';
				break;
	}
}
