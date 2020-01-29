<?php
/*
* Add-on Name: Session counter for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Counter' ) ) {
	class Labora_VC_Counter {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_scounter_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_counter_script' ), 1 );
			add_shortcode( 'labora_vc_counter', array( $this, 'labora_vc_counter_shortcode' ) );
		}
		// intialize the  wp enqueue  scripts
		function labora_vc_counter_script() {
			wp_register_script( 'labora_counter', LABORA_VC_ADDON_URL . '/assets/js/labora_vc_countdown.js', false,false,'all' );
		}
		// initialize the mapping function
		function labora_vc_scounter_init() {
			if ( function_exists( 'vc_map' ) ) {
				/**
				 * animation effects array.
				 */
				$labora_anim = array(
					'fadeIn'		=> 'fadeIn',
					'fadeInLeft'	=> 'fadeInLeft',
					'fadeInRight'	=> 'fadeInRight',
					'fadeInUp'      => 'fadeInUp',
					'fadeInDown'    => 'fadeInDown',
				);
				vc_map(
					array(
					   'name' 	=> esc_html__( 'Counter','labora-vc-textdomain' ),
					   'base' 	=> 'labora_vc_counter',
					   'class' 	=> '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' => 'Labora VC Addons',
					   'description' => esc_html__( 'Counter','labora-vc-textdomain' ),
					   'params' => array(
							array(
								'type' 		  => 'textfield',
								'holder' 	  => 'div',
								'class'		  => '',
								'heading'     => esc_html__( 'Date Time', 'labora-vc-textdomain' ),
								'param_name'  => 'counter_date',
								'value'		  => date( 'm/d/Y' ),
								'description' => esc_html__( 'Enter the title you wish to display for the tabs aboveex: 03/25/2016.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'holder' 	  => 'div',
								'class'		  => '',
								'heading'     => esc_html__( 'Start Time', 'labora-vc-textdomain' ),
								'param_name'  => 'counter_start_time',
								'value'		  => date( 'H:i' ),
								'description' => esc_html__( 'Enter the Start time you wish to display for the Counter.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'holder' 	  => 'div',
								'class'		  => '',
								'heading'     => esc_html__( 'Title', 'labora-vc-textdomain' ),
								'param_name'  => 'counter_title',
								'description' => esc_html__( 'Enter the title you wish to display for the Counter.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'colorpicker',
								'class'		  => '',
								'heading'     => esc_html__( 'Title Color', 'labora-vc-textdomain' ),
								'param_name'  => 'title_color',
								'description' => esc_html__( 'Select the color for the title.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Button Text', 'labora-vc-textdomain' ),
								'param_name'  => 'button_url_txt',
								'description' => esc_html__( 'Enter the title URL text you wish to display for the Counter above.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Button color', 'labora-vc-textdomain' ),
								'param_name' 	=> 'button_color',
								'value' 	 	=> array(
														'Gray' 		 => 'gray',
														'Brown' 	 => 'brown',
														'Cyan' 		 => 'cyan',
														'Orange' 	 => 'orange',
														'Red' 	 	 => 'red',
														'Magenta' 	 => 'magenta',
														'Yellow' 	 => 'yellow',
														'Blue' 	 	 => 'blue',
														'Pink' 	  	 => 'pink',
														'Green' 	 => 'green',
														'Black' 	 => 'black',
														'White' 	 => 'white',
													),
								'description' 	=> esc_html__( 'Select the color for the Button.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Button URL', 'labora-vc-textdomain' ),
								'param_name'  => 'button_url',
								'description' => esc_html__( 'Enter the url for the button.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textarea',
								'holder' 	  => 'div',
								'class'		  => '',
								'heading'     => esc_html__( 'Content', 'labora-vc-textdomain' ),
								'param_name'  => 'counter_content',
								'description' => esc_html__( 'Enter the short description for the counter', 'labora-vc-textdomain' ),
							),
						),
					)
				);
			}
		}
		function labora_vc_counter_shortcode( $atts ) {
			extract( shortcode_atts( array(
				'counter_date'	    => '',
				'counter_start_time' => '',
				'counter_title' 	=> '',
				'title_color'		=> '',
				'button_url_txt' 	=> '',
				'button_url' 		=> '',
				'button_color'		=> 'gray',
				'counter_content' 	=> '',
			), $atts ) );

			$out = '';
			$title_color 	= (  $title_color ? 'style="color:' . esc_attr( $title_color ) . ' !important"' : '' );
			$t_id = rand( 1,999 );
			if ( $counter_date != '' ) {
				$countdown_date  = date_i18n( 'm/d/Y' , strtotime( $counter_date ) );
				$countdown_event = explode( '/', $countdown_date );
				$counter_time    = date_i18n( 'H,i,s', strtotime( $counter_start_time ) );

				$month  = $countdown_event['0'];
				$day    = $countdown_event['1'];
				$year   = $countdown_event['2'];

				$out .= '<script type="text/javascript">
				jQuery(function($) {
					enddate = new Date(' . $year . ' , ' . $month . '-1 , ' . $day . ',' . $counter_time . ');
					jQuery("#labora-countdown-wg-' . $t_id . '").countdown({
						until: enddate,
						format: "DHMS",
						padZeroes: true,
						labels:["Yrs","Mns","Wks","Days","Hrs","Min","Sec"],
						labels1:["Yr","Mon","Wks","Day","Hr","Min","Sec"]
					});
				});
				</script>';
			}
			$out .= '<div class="labora_counter_wrap">';
			$out .= '<div class="one_third">';
			if ( $counter_date != '' ) {
				$out .= '<div class="countdown">';
				$out .= '<div id="labora-countdown-wg-' . $t_id . '"></div>';
				$out .= '</div>';// .countdown end
			}
			$out .= '</div>'; // .one third

			$out .= '<div class="two_third labora-counter-details last">';
			$out .= '<div class="labora-counter-text">';
			if ( $counter_title ) {
				$out .= '<h2 class="labora-counter-title" ' . $title_color . '>' . $counter_title . '</h2>';
			}
			$out .= '<h4 class="labora-counter-desc">' . $counter_content . '</h4>';
			$out .= '</div>'; // .countertext end
			if ( $button_url_txt ) {
				$out .= '<div class="labora-counter-button">';
				if ( $button_url  ) {
					$out .= '<a href="' . $button_url . '" class="btn large ' . $button_color . '">';
				}
				$out .= '<span>' . $button_url_txt . '</span>';
				if ( $button_url  ) {
					$out .= '</a>';
				}
				$out .= '</div>';
			}
			$out .= '</div>'; // .two third end
			$out .= '</div>'; // counter wrap

			return $out;
		}//.labora_vc_counter_shortcode
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Counter' ) ) {
		$labora_vc_counter = new Labora_VC_Counter;
	}
	class WPBakeryShortCode_labora_vc_counter extends WPBakeryShortCode {
	}
}
