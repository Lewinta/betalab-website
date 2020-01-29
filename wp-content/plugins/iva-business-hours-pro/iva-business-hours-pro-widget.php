<?php
// Register Widget
function iva_businesshours() {
	register_widget( 'IVA_BHRS_WIDGET' );
}
// Define the Widget as an extension of WP_Widget
class IVA_BHRS_WIDGET extends WP_Widget {

	/* constructor */
	public function __construct() {

		/* Widget settings. */
		$widget_ops = array(
			'classname'		=> 'ivabh-businesshours',
			'description'	=> esc_html( 'Display Business Hours.', 'iva_business_hours' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'		=> 300,
			'height'	=> 350,
			'id_base'	=> 'iva_business_hrs',
		);
		/* Create the widget. */
		parent::__construct( 'iva_business_hrs','Business Hours Pro', $widget_ops, $control_ops );

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_enqueue_scripts', array( &$this, 'iva_business_enqueue_styles' ) );
		}

	}
	function iva_business_enqueue_styles() {
		wp_enqueue_style( 'iva-bhrs-front' , IVA_BH_URL . 'assets/css/iva-bh-front.css', false,false,'all' );
		wp_enqueue_script( 'jQuery' );
		wp_enqueue_script( 'iva-bhrs-custom', IVA_BH_URL . 'assets/js/iva-business-hours-pro-front.js', array( 'jquery' ), '', true );
	}

	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$iva_bhrs_title 		= $instance['iva_bhrs_title'];
		$iva_bhrs_id 	 			= $instance['iva_bhrs_id'];
		$iva_bhrs_class 		= isset( $instance['iva_bhrs_class'] ) ? $instance['iva_bhrs_class'] : '';
		$iva_grouping_hrs   = ( $instance['iva_grouping_hrs'] == 'on' ) ? $instance['iva_grouping_hrs'] : '';
		$iva_disable_dots   = ( $instance['iva_disable_dots'] == 'on' ) ? $instance['iva_disable_dots'] : '';
		$iva_days_shortname = ( $instance['iva_days_shortname'] == 'on') ? $instance['iva_days_shortname'] : '';

		// Fetch Data
		global $wpdb;

		$ivbh_title = $ivbh_day_open = $ivbh_day_close = $output = $today_output = $iva_singleday_show = $out = $toggle_output = $iva_algncenter_hrs = $iva_bh_algn_class = $iva_holidays_date_text = '';
		$iva_bh_class = 'show' . rand( '10','1000' );
		$iva_bh_sql 		= "SELECT * FROM $wpdb->iva_businesshours where id='" . $iva_bhrs_id . "'" ;
		$iva_bh_results = $wpdb->get_results( $iva_bh_sql,ARRAY_A );

		if ( $iva_bh_results ) {
			$iva_bh_time_format = get_option( 'iva_bh_time_format' ) ? get_option( 'iva_bh_time_format' ) : 'H:i';
			$ivbh_today_hrs_array = array();

			foreach ( $iva_bh_results as $iva_bh_data ) {
				$iva_descripion_prefix = $iva_descripion_enable = $iva_descripion = $iva_todaydate_enable = $iva_grouping_enable = $iva_closed_bg_color = $iva_current_day_color = $iva_closedays_hide = $iva_oc_text_hide = '';
				$iva_toggle_enable = $closed_css = $iva_oc_css = $iva_oc_class = $iva_open_image = $iva_close_image = $iva_oc_img = $today_color = $iva_bh_start_hrs = $iva_bh_end_hrs = $iva_oc_text = $iva_singleday_disable = $holiday_closed = $holiday_name = $holidays_extras = '';
				$iva_oc_title = $iva_open_title = $iva_close_title = '';
				$iva_bh_rem_zeros_from_time = $iva_singleday_off_text = $iva_multidays_off_text = $iva_week_day_min = $iva_today_text = $iva_see_more_text = $iva_hide_time_on_holiday = '';

				$holiday_list_days = $iva_today_timings = $iva_bh_oc_timings = array();
				$holiday_result = iva_bhp_holidays_close( $iva_bh_data['alias'] );

				if ( ! function_exists( 'iva_bhp_store_dates' ) ) {
					function iva_bhp_store_dates( $from, $to, $value ) {
						global $iva_bh_date_format;
							$from_date 	= strtotime( $from );
							$to_date 		= strtotime( $to );
							$current 		= $from_date;
							$days 			= array();
							while ( $current <= $to_date ) {
								$days[ date_i18n( $iva_bh_date_format, $current ) ] = $value;
								$current = $current + 86400;
							}
							return $days;
					}
				}

				foreach ( $holiday_result as $key => $value ) {
					if ( ! empty( $value ) ) {
					 	$from_date = $value['startdate'];
						$to_date = $value['enddate'];
						array_push( $holiday_list_days,iva_bhp_store_dates( $from_date, $to_date,$value ) );
					}
				}

				$iva_title	= $iva_bh_data['title'];

				if ( $iva_bh_data['closedtext'] ) {
					$iva_closed_text = $iva_bh_data['closedtext'];
				} else {
					$iva_closed_text = esc_html__( 'Closed','iva_business_hours' );
				}
				if ( $iva_bh_data['opentext'] ) {
					$iva_open_text = $iva_bh_data['opentext'];
				} else {
					$iva_open_text = esc_html__( 'Open','iva_business_hours' );
				}
				if ( $iva_bh_data['timeseparator'] ) {
					$iva_time_separator	 = $iva_bh_data['timeseparator'];
				} else {
					$iva_time_separator	 = '-';
				}
				if ( $iva_bh_data['description'] ) {
					$iva_descripion	 = $iva_bh_data['description'];
				}
				if ( $iva_bh_data['descriptionprefix'] ) {
					$iva_descripion_prefix	 = $iva_bh_data['descriptionprefix'];
				}
				if ( $iva_bh_data['descriptionenable'] ) {
					$iva_descripion_enable	 = $iva_bh_data['descriptionenable'];
				}
				if ( $iva_bh_data['todaydate'] ) {
					$iva_todaydate_enable	 = $iva_bh_data['todaydate'];
				}
				if ( isset( $iva_bh_data['grouping_enable'] ) ) {
					$iva_grouping_enable = $iva_bh_data['grouping_enable'];
				}
				if ( isset( $iva_bh_data['closed_bg_color'] ) ) {
					$iva_closed_bg_color = $iva_bh_data['closed_bg_color'];
				}
				if ( isset( $iva_bh_data['open_bg_color'] ) ) {
					$iva_open_bg_color = $iva_bh_data['open_bg_color'];
				}
				if ( isset( $iva_bh_data['current_day_color'] ) ) {
					$iva_current_day_color = $iva_bh_data['current_day_color'];
				}
				if ( isset( $iva_bh_data['toggle_enable'] ) ) {
					$iva_toggle_enable = $iva_bh_data['toggle_enable'];
				}
				if ( isset( $iva_bh_data['open_image'] ) ) {
					$iva_open_image = $iva_bh_data['open_image'];
				}
				if ( isset( $iva_bh_data['close_image'] ) ) {
					$iva_close_image = $iva_bh_data['close_image'];
				}
				if ( isset( $iva_bh_data['closedays_hide'] ) ) {
					$iva_closedays_hide = $iva_bh_data['closedays_hide'];
				}
				if ( isset( $iva_bh_data['oc_text_hide'] ) ) {
					$iva_oc_text_hide = $iva_bh_data['oc_text_hide'];
				}
				if ( isset( $iva_bh_data['singleday_show'] ) ) {
					$iva_singleday_show = $iva_bh_data['singleday_show'];
				}
				if ( isset( $iva_grouping_hrs ) && '' != $iva_grouping_hrs ) {
					$iva_grouping_enable = $iva_grouping_hrs;
				}

				if ( isset( $iva_bh_data['algncenter_hrs'] ) ) {
					$iva_algncenter_hrs = $iva_bh_data['algncenter_hrs'];
				}
				if ( isset( $iva_bh_data['singleday_disable'] ) ) {
					$iva_singleday_disable = $iva_bh_data['singleday_disable'];
				}
				if ( isset( $iva_bh_data['customwidth'] ) ) {
					$iva_custom_width = $iva_bh_data['customwidth'];
				}
				if ( isset( $iva_bh_data['open_title'] ) ) {
					$iva_open_title = $iva_bh_data['open_title'];
				}
				if ( isset( $iva_bh_data['close_title'] ) ) {
					$iva_close_title = $iva_bh_data['close_title'];
				}

				if ( isset( $iva_bh_data['seemore_text'] ) ) {
					$iva_see_more_text = $iva_bh_data['seemore_text'];
				}
				if ( isset( $iva_bh_data['today_text'] ) ) {
					$iva_today_text = $iva_bh_data['today_text'];
				}
				if ( isset( $iva_bh_data['rem_zeros_from_time'] ) ) {
					$iva_bh_rem_zeros_from_time = $iva_bh_data['rem_zeros_from_time'];
				}
				if ( isset( $iva_bh_data['singleday_off_text'] ) ) {
					$iva_singleday_off_text = $iva_bh_data['singleday_off_text'];
				}
				if ( isset( $iva_bh_data['multidays_off_text'] ) ) {
					$iva_multidays_off_text = $iva_bh_data['multidays_off_text'];
				}
				if ( isset( $iva_bh_data['hide_time_on_holiday'] ) ) {
					$iva_hide_time_on_holiday = $iva_bh_data['hide_time_on_holiday'];
				}
				if ( isset( $iva_bh_data['week_day_min'] ) ) {
					$iva_days_shortname = $iva_bh_data['week_day_min'];
				}
				if ( isset( $iva_days_shortname ) && '' != $iva_days_shortname ) {
					$iva_days_shortname = $iva_days_shortname;
				}
				$iva_see_more_text				= $iva_see_more_text ? stripslashes( $iva_see_more_text ) : esc_html__( 'See more','iva_business_hours' );
				$iva_today_text 					= $iva_today_text ? stripslashes( $iva_today_text ) : esc_html__( 'Today','iva_business_hours' );
				$iva_latenight_hrs_enable = get_option( 'iva_bh_latenight_hrs_enable' );
				$iva_latenight_hrs 				= get_option( 'iva_bh_latenight_hrs' );

				// Open Close Image
				$iva_current_day = date_i18n( 'N', strtotime( date( 'N' ) ) );
				$timezone_format = _x( 'H:i', 'timezone date format' );
				$iva_curent_time = date_i18n( $timezone_format );
				$iva_bh_today    = date_i18n( 'l', strtotime( date( 'N' ) ) );

				if ( 'on' == $iva_latenight_hrs_enable ) {
					if ( ( strtotime( $iva_curent_time ) >= strtotime( '0:00' )	&& strtotime( $iva_curent_time ) <= strtotime( $iva_latenight_hrs ) ) ) {
						$iva_bh_current_time = date_i18n( 'Y-m-d H:i:s' );
						$iva_bh_today       = date_i18n( 'l', strtotime( $iva_bh_current_time . ' - ' . intval( $iva_latenight_hrs ) . ' hours' ) );
						$iva_current_day  	= date_i18n( 'N', strtotime( $iva_bh_current_time . ' - ' . intval( $iva_latenight_hrs ) . ' hours' ) );
					}
				}
				global $iva_bh_date_format;
				$todaydate 				= date_i18n( $iva_bh_date_format, strtotime( 'today' ) );
				$todayfollowdate 	= iva_bhp_holiday_name( $todaydate, $holiday_list_days );

				if ( '7' == $iva_current_day ) { $iva_current_day = 0; }
				$iva_weekday 		= 'weekday' . $iva_current_day;
				$iva_today_data 	= json_decode( $iva_bh_data[ $iva_weekday ] );
				if ( $iva_today_data ) {
					foreach ( $iva_today_data as $key => $value ) {
						$iva_today_timings = $value;
					}
					$today_timings_count = count( $iva_today_timings );
					if ( ! empty( $iva_today_timings ) ) {
						foreach ( $iva_today_timings as $key => $value ) {
								$iva_bh_oc_timings['open'][] = $value->open;
								$iva_bh_oc_timings['close'][] = $value->close;
						}
						$max_value 				= max( $iva_bh_oc_timings['close'] );
						$min_value 				= min( $iva_bh_oc_timings['open'] );
						$timezone_format 	= esc_html_x( 'H:i', 'timezone date format' );
						$iva_curent_time 	= date_i18n( $timezone_format );

						if ( ! empty( $iva_bh_oc_timings ) ) {
							$iva_bhrs_oc_display_result = iva_bhrs_oc_display( $value->open, $value->close );
						  if ( $iva_bhrs_oc_display_result == 'open' ) {
								// Open text and image
								$iva_oc_text  	= $iva_open_text;
								$iva_oc_class 	= 'iva_oc_open';
								$open_bgcolor 	= ! empty( $iva_open_bg_color ) ? 'background-color:' . $iva_open_bg_color . ';' : '';
								$open_css 		= ( '' != $open_bgcolor ) ? ' style="' . $open_bgcolor . '"':'';
								$iva_oc_css 	= $open_css;
								if (  ! empty($iva_open_image) ) {
									$iva_oc_img = '<figure><img class="ivabh_open_img" src="' . $iva_open_image . '" width="470" height="300"></figure>';
								} elseif ( ! empty( $iva_open_title ) ) {
									$iva_oc_img = '<div class="iva_open_title">' . $iva_open_title . '</div>';
								}
							}
							// Close text and image
							if ( $iva_bhrs_oc_display_result == 'close' ) {
								$iva_oc_text  	= $iva_closed_text;
								$iva_oc_class 	= 'iva_oc_close';
								$closed_bgcolor = ! empty( $iva_closed_bg_color ) ? 'background-color:' . $iva_closed_bg_color . ';':'';
								$closed_css 	= ( '' != $closed_bgcolor ) ? ' style="' . $closed_bgcolor . '"':'';
								$iva_oc_css 	= $closed_css;
								if ( ! empty( $iva_close_image ) ) {
									$iva_oc_img = '<figure><img class="ivabh_close_img" src="' . $iva_close_image . '" width="470" height="300"></figure>';
								} elseif ( ! empty( $iva_close_title ) ) {
									$iva_oc_img = '<div class="iva_close_title">' . $iva_close_title . '</div>';
								}
							}

							// late night closing timings
							if ( 'on' == $iva_latenight_hrs_enable ) {
								if ( $iva_bhrs_oc_display_result == 'open' ) {
										$iva_oc_text  	= $iva_open_text;
										$iva_oc_class 	= 'iva_oc_open';
										$open_bgcolor 	= ! empty( $iva_open_bg_color ) ? 'background-color:' . $iva_open_bg_color . ';':'';
										$open_css 		= ( '' != $open_bgcolor ) ? ' style="' . $open_bgcolor . '"':'';
										$iva_oc_css 	= $open_css;
										if ( !empty($iva_open_image) ) {
											$iva_oc_img = '<figure><img class="ivabh_open_img" src="' . $iva_open_image . '" width="470" height="300"></figure>';
										} elseif ( ! empty( $iva_open_title ) ) {
											$iva_oc_img = '<div class="iva_open_title">' . $iva_open_title . '</div>';
										}
								}
							}
							// starting time and ending time empty
							if ( ( $max_value == '' ) && ( $min_value == '' ) || ( in_array( 'Closed', $holiday_result ) ) || ( ! empty( $todayfollowdate[$todaydate]['closed'] ) ) ) {
								if ( ! empty( $iva_close_image ) ) {
									$iva_oc_img = '<figure><img class="ivabh_close_img" src="' . $iva_close_image . '" width="470" height="300"></figure>';
								} elseif ( ! empty( $iva_close_title ) && empty( $iva_close_image ) ) {
									$iva_oc_img = '<div class="iva_close_title">' . $iva_close_title . '</div>';
								}
								$iva_oc_text  	= $iva_closed_text;
								$iva_oc_class 	= 'iva_oc_close';
								$closed_bgcolor = ! empty( $iva_closed_bg_color ) ? 'background-color:' . $iva_closed_bg_color . ';':'';
								$closed_css 	= ( '' != $closed_bgcolor ) ? ' style="' . $closed_bgcolor . '"':'';
								$iva_oc_css 	= $closed_css;
							}
						}
					}
				}// Open Close Image

				// title
				if ( 'true' == $iva_title || 'on' == $iva_title ) {
					$today_output .= '<h3 class="ivabh-title">' . $iva_title . '</h3>';
				} else {
					$today_output .= '';
				}

				// Open Close Image
				if (  ! empty( $iva_oc_img ) ) {
					$today_output .= $iva_oc_img;
				}

				$j = $k = 0;
				// Current day color
				if ( isset( $current_day_color ) && ! empty( $current_day_color ) ) {
					$iva_current_day_color = $current_day_color;
					$today_color = 'color:' . $iva_current_day_color;
				} else {
					$today_color = 'color:' . $iva_current_day_color;
				}

				// Width and inline styles
				$iva_bh_custom_width 	= $iva_custom_width ? 'width:' . (int) $iva_custom_width . 'px;':'';
				$custom_width_css	= ( '' != $iva_bh_custom_width ) ? ' style="' . $iva_bh_custom_width . '"':'';
				$toggle_css 	= ( 'on' == $iva_toggle_enable )  ? 'style="display:none;"':'';
				$closed_bgcolor = ! empty( $iva_closed_bg_color ) ? 'background-color:' . $iva_closed_bg_color . ';':'';
				$closed_css 	= ( '' != $closed_bgcolor ) ? ' style="' . $closed_bgcolor . '"':'';
				if ( isset( $iva_grouping_hrs ) && '' != $iva_grouping_hrs ) {
					$iva_grouping_enable = $iva_grouping_hrs;
				}
				// description
				if ( 'on' != $iva_descripion_enable && '' != $iva_descripion ) {
					if ( 'on' == $iva_descripion_prefix ) {
						$out .= '<div class="ivabh-desc">' . $iva_descripion . '</div>';
					}
				}
				$out .= '<div class="ivabh-hours ' . $iva_bh_class . '" ' . $toggle_css . '>';
				// Toggle
				if ( 'on' == $iva_toggle_enable && 'on' != $iva_singleday_show ) {
					$toggle_output = '<span id="' . $iva_bh_class . '" class="iva-bh-tg">';
					$toggle_output .= '<span class="ivbh-seemore">' . $iva_see_more_text . '<span class="arrow"></span></span>';
					$toggle_output .= '</span>';//iva-bh-tg
				}

				global $iva_bh_date_format;
				$iva_startday = array();
				$weekday = iva_bh_get_weekdays();
				$iva_startday = array_values( $weekday );
				$startday = $iva_startday[0];

				$todaydate = date_i18n( $iva_bh_date_format, strtotime( 'today' ) );
				if ( $startday == date( 'l', strtotime( 'today' ) ) ) {
					$weekstart = strtotime( 'today' );
				} else {
				 	$weekstart = strtotime( 'last ' . $startday, strtotime( $todaydate ) );
				}

				$c = 0;
				foreach ( iva_bh_get_weekdays() as $key => $day ) {
					$day_names = $weekstart + (86400 * $c);
					$c++;

					$followdate = date_i18n( $iva_bh_date_format, $day_names );

					if (  $iva_days_shortname == 'on' ) {
						$day = substr( $day,0,3 );
					} else {
						$day = $day;
					}
					$week_day_key  	= 'weekday' . $key;
					$iva_bh_day 	= json_decode( $iva_bh_data[ $week_day_key ] );
					$iva_bh_hrs	 	= array();

					foreach ( $iva_bh_day as $key => $value ) {
						$iva_row_count = count( $value );
						$split_hours_inc = 1;
						foreach ( $value as $time ) {
							$ivbh_day_open	 = iva_bh_format_time( $time->open,$iva_bh_time_format );
							$ivbh_day_close	 = iva_bh_format_time( $time->close,$iva_bh_time_format );
							$ivbh_day_start  = isset( $time->starttime ) ? $time->starttime : '';
							$ivbh_day_end    = isset( $time->latetime ) ? $time->latetime : '';

							if ( '' != $ivbh_day_start ) {
								$ivbh_day_start = '<span class="iva-bh-stext">' . $ivbh_day_start . '</span>';
							}
							if ( '' != $ivbh_day_end ) {
								$ivbh_day_end = '<span class="iva-bh-etext">' . $ivbh_day_end . '</span>';
							}
							//Removes trailing zeros from time
							if ( $iva_bh_rem_zeros_from_time == 'on' ) {
								$iva_bh_timeformat = get_option( 'iva_bh_time_format' ) ? get_option( 'iva_bh_time_format' ) : 'H:i';
								if ( $iva_bh_timeformat != 'H:i' ) {
										$close_day_explode = explode( ':', $ivbh_day_close );
										if ( isset( $ivbh_day_close ) && ! empty( $ivbh_day_close ) ){
												$ivbh_day_close_test = substr( $close_day_explode[1],  0, 2 );
												if( $ivbh_day_close_test == '00' ) {
													$ivbh_day_close_test = '';
													$ivbh_day_close = $close_day_explode[0] . $ivbh_day_close_test . substr( $close_day_explode[1], -2 );
												} else {
													$ivbh_day_close = $close_day_explode[0] . ':' . $ivbh_day_close_test . substr( $close_day_explode[1], -2 );
												}
										}
										$open_day_explode = explode( ':', $ivbh_day_open );
										if ( isset( $ivbh_day_open ) && ! empty( $ivbh_day_open ) ){
												$ivbh_day_open_test = substr( $open_day_explode[1],  0, 2 );
												if( $ivbh_day_open_test == '00' ) {
													$ivbh_day_open_test = '';
													$ivbh_day_open = $open_day_explode[0] . $ivbh_day_open_test . substr( $open_day_explode[1], -2 );
												} else {
													$ivbh_day_open = $open_day_explode[0] . ':' . $ivbh_day_open_test . substr( $open_day_explode[1], -2 );
												}
										}
								}
							}

							// Today hours array
							if ( ( '' == $ivbh_day_open ) && ( '' == $ivbh_day_close ) && ( '' == $ivbh_day_end ) && ( '' == $ivbh_day_start ) ) {
								$ivbh_today_hrs_array[ $day ] = '<span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span>';
							} elseif ( ( '' != $ivbh_day_open || '' != $ivbh_day_start ) && ( '' != $ivbh_day_close || '' != $ivbh_day_end ) ) {
								$ivbh_today_hrs_array[ $day ] = $ivbh_day_open . $ivbh_day_start . $iva_time_separator . $ivbh_day_close . $ivbh_day_end;
							} elseif ( ( '' != $ivbh_day_start ) && ( '' == $ivbh_day_open && '' == $ivbh_day_close && '' == $ivbh_day_end ) ) {
								$ivbh_today_hrs_array[ $day ] = $ivbh_day_start;
							} elseif ( ( '' != $ivbh_day_end ) && ( '' == $ivbh_day_open && '' == $ivbh_day_start && '' == $ivbh_day_close ) ) {
								$ivbh_today_hrs_array[ $day ] = $ivbh_day_end;
							} elseif ( ( '' != $ivbh_day_end ) && ( '' != $ivbh_day_close ) ) {
								$ivbh_today_hrs_array[ $day ] = $ivbh_day_close . $iva_time_separator . $ivbh_day_end;
							} elseif ( ( '' != $ivbh_day_start ) && ( '' != $ivbh_day_open ) ) {
								$ivbh_today_hrs_array[ $day ] = $ivbh_day_open . $iva_time_separator . $ivbh_day_start;
							}

							// without group hours array
							if ( ( '' == $ivbh_day_open ) && ( '' == $ivbh_day_close ) && ( '' == $ivbh_day_end ) && ( '' == $ivbh_day_start ) ) {
								if ( isset( $iva_closedays_hide ) && 'on' != $iva_closedays_hide ) {
									$ivbh_arr[ $day ] = '<span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span>';
								} elseif ( 'on' == $iva_closedays_hide ) {
									if ( 'on' == $iva_grouping_enable ) {
										$day = $day;
									} else {
										$day = '';
									}
								}
							} elseif ( '' != $ivbh_day_open || '' != $ivbh_day_start || '' != $ivbh_day_close || '' != $ivbh_day_end ) {
								$iva_bh_start_hrs = $iva_bh_end_hrs = '';
								// Start hours
								if ( $ivbh_day_open && $ivbh_day_start ) {
									$iva_bh_start_hrs = $ivbh_day_open . $ivbh_day_start;
								} else {
									if ( '' != $ivbh_day_open ) {
										$iva_bh_start_hrs = $ivbh_day_open;
									} elseif ( '' != $ivbh_day_start ) {
										$iva_bh_start_hrs = $ivbh_day_start;
									}
								}

								// End hours
								if ( $ivbh_day_close && $ivbh_day_end ) {
									$iva_bh_end_hrs = $ivbh_day_close . $ivbh_day_end;
								} else {
									if ( '' != $ivbh_day_close ) {
										$iva_bh_end_hrs = $ivbh_day_close;
									} elseif ( '' != $ivbh_day_end ) {
										$iva_bh_end_hrs = $ivbh_day_end;
									}
								}
								if ( '' != $iva_bh_start_hrs && '' != $iva_bh_end_hrs ) {
									$ivbh_arr[ $day ] = $iva_bh_start_hrs . $iva_time_separator . $iva_bh_end_hrs;
								} elseif ( '' != $iva_bh_start_hrs && '' == $iva_bh_end_hrs ) {
									$ivbh_arr[ $day ] = $iva_bh_start_hrs ;
								} elseif ( '' != $iva_bh_end_hrs && '' == $iva_bh_start_hrs ) {
									$ivbh_arr[ $day ] = $iva_bh_end_hrs;
								}
							}
							//
							if ( ( 'on' == $iva_toggle_enable || 'on' == $iva_singleday_show || isset( $iva_oc_text_hide ) ) && 'on' != $iva_singleday_disable ) {
								// Today result
								if ( 'on' == $iva_days_shortname ) {
									 $iva_bh_today = substr( $iva_bh_today, 0,3 );
								} else {
									 $iva_bh_today = $iva_bh_today;
								}

								if ( $iva_bh_today == $day ) {
									if ( $k == 0 ) {
										$today_output .= '<div class="today-result">';
										$today_output .= '<div class="iva_bhp_hours_row"><span class="days">' . stripslashes( $iva_today_text );
										if ( 'on' != $iva_oc_text_hide || 'off' == $iva_oc_text_hide ) {
											$today_output .= '<span class="iva-bh-oc-text ' . $iva_oc_class . '" ' . $iva_oc_css . '>' . $iva_oc_text . '</span>';
										}
										$today_output .= '</span><span class="hours">';
									}
									if ( ( '' == $ivbh_day_open ) && ( '' == $ivbh_day_close ) && ( '' == $ivbh_day_end ) && ( '' == $ivbh_day_start ) ) {
										$today_output .= '<span class="hours-row"><span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span></span></div>';
									} else {
										if (  empty( $holiday_result ) || ( empty( $holiday_result['closed'] ) )  ) {
											$today_output .= '<span class="hours-row">';
											$iva_bhrs_oc_display_result = iva_bhrs_oc_display( $time->open, $time->close );
											if ( $iva_bhrs_oc_display_result == 'open' && ( empty( $todayfollowdate[ $todaydate ]['closed'] ) ) ) {
												$today_output .= '<span>' . $ivbh_today_hrs_array[ $iva_bh_today ] . '</span>';
												if ( $iva_disable_dots != 'on' ) {
													$today_output .= '<span class="iva-bh-oc-dot iva_oc_open"></span>';
												}
											} else {
												if ( ! empty( $todayfollowdate ) ) {
													if ( isset( $todayfollowdate )
														&& isset( $todayfollowdate[ $todaydate ]['time_disable'] )
														&& ( $todayfollowdate[ $todaydate ]['time_disable'] == 'off' )
														&& $iva_hide_time_on_holiday != 'on'
													) {
														$today_output .= '<span class="past-hours">' . $ivbh_today_hrs_array[ $iva_bh_today ] . '</span>';
													}
													if ( $split_hours_inc == $iva_row_count ) {
														if ( isset( $todayfollowdate )
															&& isset( $todayfollowdate[ $todaydate ]['time_disable'] )
															&& ( $todayfollowdate[ $todaydate ]['time_disable'] == 'on' )
															|| $iva_hide_time_on_holiday == 'on'
														) {
																$today_output .= '<span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span>';
																$today_output .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
														}
													}
													if ( isset( $todayfollowdate )
														&& isset( $todayfollowdate[ $todaydate ]['time_disable'] )
														&& ( $todayfollowdate[ $todaydate ]['time_disable'] == 'off' )
														&& $iva_hide_time_on_holiday != 'on'
													) {
														$today_output .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
													}
												} else {
													$today_output .= '<span class="past-hours">' . $ivbh_today_hrs_array[ $iva_bh_today ] . '</span>';
													if ( $iva_disable_dots != 'on' && $today_timings_count == 1 ) {
															$today_output .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
													}
												}
											}
											$today_output .= '</span>';
										}
										$k++;
										if ( $iva_row_count == $k ) {
											if ( ! empty( $todayfollowdate[$todaydate]['startdate'] ) && ! empty( $todayfollowdate[$todaydate]['enddate'] ) ) {
												$iva_holiday_start_date = strtotime( $todayfollowdate[$todaydate]['startdate'] );
												$iva_holiday_end_date 	= strtotime( $todayfollowdate[$todaydate]['enddate'] );
												$offset 	= $iva_holiday_end_date - $iva_holiday_start_date;
												$iva_holiday_date_diff = floor( $offset / 24 / 60 / 60 );
												if ( $iva_holiday_date_diff == 0 ) {
													$iva_holidays_date_text = $iva_multidays_off_text;
												}
												if ( $iva_holiday_date_diff > 1 ) {
													$iva_holidays_date_text = $iva_singleday_off_text;
												}
											}
											if ( ! empty( $todayfollowdate ) && ( ! empty( $todayfollowdate[$todaydate]['closed'] ) ) && isset( $todayfollowdate[$todaydate]['name'] ) ) {
												$holidays_color = ! empty( $todayfollowdate[$todaydate]['color'] ) ? 'color:' . $todayfollowdate[$todaydate]['color'] . ';':'';
												$holidays_bgcolor = ! empty( $todayfollowdate[$todaydate]['bgcolor'] ) ? 'background-color:' . $todayfollowdate[$todaydate]['bgcolor'] . ';':'';
												$holidays_extras = ( '' !== $holidays_color || '' != $holidays_bgcolor ) ? ' style="' . $holidays_color . $holidays_bgcolor . '"':'';
												$today_output .= '<span class="iva_holiday_name" ' . $holidays_extras . '>' . $todayfollowdate[$todaydate]['name'] . '</span>';
												if ( ! empty( $iva_holiday_start_date ) && ! empty( $iva_holiday_end_date ) ) {
													if ( $iva_holiday_date_diff == 0 ){
														$today_output .= '<span class="iva_holiday_to">' . $iva_holidays_date_text.'&nbsp;<span>'.date_i18n('d,M',$iva_holiday_start_date) .'</span></span>';
													}
													if ( $iva_holiday_date_diff > 1 ){
														$today_output .= '<span class="iva_holiday_to">' . $iva_holidays_date_text.'&nbsp;<span>'.date_i18n('d,M',$iva_holiday_start_date) .'</span> - <span>'.date_i18n('d,M',$iva_holiday_end_date). '</span></span>';
													}
												}
											}
											$k = 0;
											$today_output .= '</span></div>';//.iva_bhp_hours_row
										}
									}
									if ( $k == 0 ) {
										$today_output .= '</div>'; //.today-result
									}
								}
							}
							if ( isset( $iva_grouping_enable ) && 'on' != $iva_grouping_enable ) {
								// Get Current Day output
								$iva_bh_today = iva_bhrs_day_short_names( $iva_bh_today, $iva_days_shortname );
								if ( $iva_bh_today == $day && 'on' == $iva_todaydate_enable ) {
									$select_today = 'ivabh-current-day';
									$today_css 	  = ( '' != $today_color ) ? ' style="' . $today_color . '"':'';
								} else {
									$select_today = $today_css = '';
								}
								if ( '0' == $j ) {
									if ( '' != $day ) {
										$out .= '<div class="iva_bhp_hours_row ' . $select_today . '" ' . $today_css . '>';
										$iva_bh_day = '&nbsp;' . $day;
									}
								} else {
									$iva_bh_day = '';
								}
								if ( '' != $iva_bh_day ) {
									if ( '' != $day ) {
										$out .= '<span class="days">' . $iva_bh_day . '</span>';
										$out .= '<span class="hours">';
									}
								}

								if ( iva_bhp_is_holiday( $followdate, $holiday_list_days ) ) {
									$holiday_name_var = iva_bhp_holiday_name( $followdate, $holiday_list_days );
									$bgcolor = ( ! empty( $holiday_name_var[ $followdate ]['bgcolor'] ) ) ? 'background-color:' . $holiday_name_var[ $followdate ]['bgcolor'] . ';' : '';
									$color = ( ! empty( $holiday_name_var[ $followdate ]['color'] ) ) ? 'color:' . $holiday_name_var[ $followdate ]['color'] . ';' : '';
									$extra = ( ! empty( $bgcolor ) || ! empty( $color ) ) ? 'style="' . $bgcolor . $color . '"': '';
								}

								// without group hours array
								if ( isset( $ivbh_arr[ $day ] ) && '' != $ivbh_arr[ $day ] ) {
									if ( iva_bhp_is_holiday( $followdate, $holiday_list_days ) ) {
										if ( empty( $holiday_result ) || ( empty( $holiday_result['closed'] ) ) ) {
											$iva_bhrs_oc_display_result = iva_bhrs_oc_display( $time->open, $time->close );
											if ( $iva_bhrs_oc_display_result == 'open' && ( empty( $todayfollowdate[ $todaydate ]['closed'] ) ) ) {
												$out .= '<span class="hours-row">';
												$out .= '<span class="iva-bh-time">';
												if ( $holiday_name_var[ $followdate ]['time_disable'] == 'off' ) {
													$out .= $ivbh_arr[ $day ];
												}
												if ( $split_hours_inc == $iva_row_count ) {
													if ( $holiday_name_var[ $followdate ]['time_disable'] == 'on' || $iva_hide_time_on_holiday == 'on' ) {
														$out .= '<span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span>';
													}
													if ( $iva_disable_dots != 'on' ) {
														$out .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
													}
												}
												$out .= '</span>';
											} else {
												$out .= '<span class="hours-row">';
												$out .= '<span class="iva-bh-time">';
												if ( $holiday_name_var[ $followdate ]['time_disable'] == 'off' && $iva_hide_time_on_holiday != 'on' ) {
													$out .= $ivbh_arr[ $day ];
												}
												if ( $split_hours_inc == $iva_row_count ) {
													if ( $holiday_name_var[ $followdate ]['time_disable'] == 'on' || $iva_hide_time_on_holiday == 'on' ) {
															$out .= '<span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span>';
														if ( $iva_disable_dots != 'on' ) {
															$out .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
														}
													}
												}
												if ( $holiday_name_var[ $followdate ]['time_disable'] == 'off' && $iva_hide_time_on_holiday != 'on' ) {
													if ( $iva_disable_dots != 'on' ) {
														$out .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
													}
												}
												$out .= '</span>';
											}
											if ( $split_hours_inc == $iva_row_count ) {
												$out .= '<span class="iva_bh_holiday-hrs" ' . $extra . '>' . $holiday_name_var[ $followdate ]['name'] . '</span>';
											}
										}
										if ( $iva_row_count == $j + 1 ) {
											if ( ! empty( $holiday_result ) && ( in_array( 'Closed', $holiday_result ) ) && isset( $holiday_result['name'] ) ) {
												$holidays_color = ! empty( $holiday_result['color'] ) ? 'color:' . $holiday_result['color'] . ';':'';
												$holidays_bgcolor = ! empty( $holiday_result['bgcolor'] ) ? 'background-color:' . $holiday_result['bgcolor'] . ';':'';
												$holidays_extras = ( '' !== $holidays_color || '' != $holidays_bgcolor ) ? ' style="' . $holidays_color . $holidays_bgcolor . '"':'';
												$out .= '<span class="iva_holiday_name" ' . $holidays_extras . '>';
												$out .= '<span class="iva-bh-time">' . $ivbh_arr[ $day ] . '</span>';
												$out .= '<span>' . $holiday_result['name'] . '</span>';
												$out .= '</span>';
											}
										}
									} else {
										$out .= '<span class="hours-row">' . $ivbh_arr[ $day ];
										if ( $iva_bh_today == $day ) {
											$iva_bhrs_oc_display_result = iva_bhrs_oc_display( $time->open, $time->close );
											if ( $iva_bhrs_oc_display_result == 'open' && ( empty( $todayfollowdate[$todaydate]['closed'] ) ) ) {
												 if ( $iva_disable_dots != 'on' ) {
														$out .= '<span class="iva-bh-oc-dot iva_oc_open"></span>';
												}
											} else {
												if ( $iva_disable_dots != 'on' && ( $iva_bhrs_oc_display_result != 'close' ) ) {
														if ( $today_timings_count == 1 ) {
															$out .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
														}
												}
											}
										}
										$out .= '</span>';
									}
								}
								$j++;
								if ( $iva_row_count == $j ) {
									$j = 0;
									if ( '' != $day ) {
										$out .= '</span>';//.hours-row
										$out .= '</div>';//.iva_bhp_hours_row
									}
								}
							} else {
								$iva_bh_colsedvar = false;
								$iva_bh_holiday_name = $iva_bh_time_disable_check = '';
								if ( iva_bhp_is_holiday( $followdate, $holiday_list_days ) ) {
									$holiday_name_var = iva_bhp_holiday_name( $followdate, $holiday_list_days );
									if ( $iva_disable_dots != 'on' ) {
										$iva_bh_holiday_name .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
									}
									if( $split_hours_inc == $iva_row_count ) {
										$iva_bh_holiday_name .= '<span class="iva_holiday_name">' . $holiday_name_var[ $followdate ]['name'] . '</span>';
									}
									if ( $holiday_name_var[ $followdate ]['time_disable'] == 'on' || $iva_hide_time_on_holiday == 'on' ) {
										$iva_bh_time_disable_check .= 'timeoff';
									}
								} else {

									if ( $iva_bh_today == $day ) {
										$iva_bhrs_oc_display_result = iva_bhrs_oc_display( $time->open, $time->close );
										if ( $iva_bhrs_oc_display_result == 'open' && ( empty( $todayfollowdate[$todaydate]['closed'] ) ) ) {
												if ( $iva_disable_dots != 'on' ) {
													$iva_bh_holiday_name .= '<span class="iva-bh-oc-dot iva_oc_open"></span>';
												}
										} else {
											if ( $iva_disable_dots != 'on' ) {
												if ( $today_timings_count == 1 ) {
													$iva_bh_holiday_name .= '<span class="iva-bh-oc-dot iva_oc_close"></span>';
												}
											}
										}
									}
								}
								// grouping hours array
								if ( ( '' == $ivbh_day_open ) && ( '' == $ivbh_day_close ) && ( '' == $ivbh_day_end ) && ( '' == $ivbh_day_start ) ) {
									$iva_bh_hrs[] = '<span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span>';
									if ( isset( $iva_closedays_hide ) && 'on' == $iva_closedays_hide ) {
										$iva_bh_colsedvar = true;
									}
								} elseif ( ( '' != $ivbh_day_open || '' != $ivbh_day_start ) || ( '' != $ivbh_day_close || '' != $ivbh_day_end ) ) {
									// Start hours
									if ( $ivbh_day_open && $ivbh_day_start ) {
										$iva_bh_start_hrs = $ivbh_day_open . '&nbsp;' . $ivbh_day_start;
									} else {
										if ( '' != $ivbh_day_open ) {
											$iva_bh_start_hrs = $ivbh_day_open;
										} elseif ( '' != $ivbh_day_start ) {
											$iva_bh_start_hrs = $ivbh_day_start;
										}
									}
									// End hours
									if ( $ivbh_day_close && $ivbh_day_end ) {
										$iva_bh_end_hrs = $ivbh_day_close . '&nbsp;' . $ivbh_day_end;
									} else {
										if ( '' != $ivbh_day_close ) {
											$iva_bh_end_hrs = $ivbh_day_close;
										} elseif ( '' != $ivbh_day_end ) {
											$iva_bh_end_hrs = $ivbh_day_end;
										}
									}
									if ( $iva_bh_time_disable_check == 'timeoff' ) {
										if ( $split_hours_inc == $iva_row_count ) {
											$iva_bh_hrs[] = '<span class="closed iva-bh-oc-text iva_oc_close" ' . $closed_css . '>' . $iva_closed_text . '</span>'. $iva_bh_holiday_name;
										}
									}
									else {
										if ( '' != $iva_bh_start_hrs && '' != $iva_bh_end_hrs ) {
											$iva_bh_hrs[] = '<span>' . $iva_bh_start_hrs . $iva_time_separator . $iva_bh_end_hrs . '</span>' . $iva_bh_holiday_name;
										} elseif ( '' != $iva_bh_start_hrs && '' == $iva_bh_end_hrs ) {
											$iva_bh_hrs[] = $iva_bh_start_hrs;
										} elseif ( '' != $iva_bh_end_hrs && '' == $iva_bh_start_hrs ) {
											$iva_bh_hrs[] = $iva_bh_end_hrs;
										}
									}
								}
								$ivbh_hours_array[ $day ] = $iva_bh_hrs;
							}
							$split_hours_inc++;
						}
					}
				}
				// Grouping hours
				if ( 'on' == $iva_grouping_enable ) {
					$out .= iva_bhp_grouping_hours( $ivbh_hours_array, $iva_todaydate_enable, $today_color, $iva_oc_class, $iva_closedays_hide, $iva_closed_text, $closed_css, $iva_days_shortname, $holiday_result );
				}
				$out .= '</div>';

				// Description
				if ( 'on' != $iva_descripion_enable && '' != $iva_descripion ) {
					if ( 'on' != $iva_descripion_prefix ) {
						$out .= '<div class="ivabh-desc">' . $iva_descripion . '</div>';
					}
				}
			}
		}
		// Singleday class
		if ( 'on' == $iva_singleday_show ) {
			 $iva_bh_single_day = 'iva_bh_singleday';
		}
		if ( 'on' == $iva_algncenter_hrs ) {
			$iva_bh_algn_class = 'centeraligned';
		}


		$before_widget = preg_replace( '/class="/', 'class="' . $iva_bhrs_class . ' ' . $iva_bh_algn_class . ' ', $before_widget );
		echo wp_kses_post( $before_widget );
		if ( '' != $iva_bhrs_title ) {
			echo wp_kses_post( $before_title . $iva_bhrs_title . $after_title );
		}
		echo wp_kses_post( $today_output );
		echo wp_kses_post( $toggle_output );
		if ( isset( $iva_singleday_show ) && 'on' != $iva_singleday_show ) {
			$allowed_tags = wp_kses_allowed_html( 'post' );
			echo wp_kses_post( $out );
		}
		echo wp_kses_post( $after_widget );
	}
	//processes widget options to be saved

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['iva_bhrs_title']  	  = strip_tags( $new_instance['iva_bhrs_title'] );
		$instance['iva_bhrs_id'] 	 	    = strip_tags( $new_instance['iva_bhrs_id'] );
		$instance['iva_bhrs_class'] 	  = strip_tags( $new_instance['iva_bhrs_class'] );
		$instance['iva_grouping_hrs']   = strip_tags( $new_instance['iva_grouping_hrs'] );
		$instance['iva_disable_dots']   = strip_tags( $new_instance['iva_disable_dots'] );
		$instance['iva_days_shortname'] = strip_tags( $new_instance['iva_days_shortname'] );
		return $instance;
	}

	// Outputs the options form on admin
	function form( $instance ) {
		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance,
			array(
				'iva_bhrs_title'  	=> '',
				'iva_bhrs_id' 	  	=> '',
				'iva_bhrs_class' 	  => '',
				'iva_grouping_hrs' 	=> '',
				'iva_disable_dots' 	=> '',
				'iva_days_shortname' => '',
			)
		);
		$iva_bhrs_title  		= strip_tags( $instance['iva_bhrs_title'] );
		$iva_bhrs_id 	 			= strip_tags( $instance['iva_bhrs_id'] );
		$iva_bhrs_class  		= strip_tags( $instance['iva_bhrs_class'] );
		$iva_grouping_hrs 	= strip_tags( $instance['iva_grouping_hrs'] );
		$iva_disable_dots 	= strip_tags( $instance['iva_disable_dots'] );
		$iva_days_shortname = strip_tags( $instance['iva_days_shortname'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'iva_bhrs_title' ) ); ?>"><?php esc_html_e( 'Title', 'iva_business_hours' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'iva_bhrs_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iva_bhrs_title' ) ); ?>" value="<?php echo esc_attr( $iva_bhrs_title ); ?>" type="text" style="width:100%;" />
		</p>

		<?php
		global $wpdb;
		$ivbh_select_query  = "SELECT title,id FROM $wpdb->iva_businesshours";
		$ivbh_fetch_results = $wpdb->get_results( $ivbh_select_query );

		if ( $ivbh_fetch_results ) {
			echo '<p><label for="' . esc_attr( $this->get_field_id( 'iva_bhrs_id' ) ) . '">' . esc_html_e( 'Select Hours:', 'iva_business_hours' ) . '</label> ';
			echo '<select id="' . esc_attr( $this->get_field_id( 'iva_bhrs_id' ) ) . '" name="' . esc_attr( $this->get_field_name( 'iva_bhrs_id' ) ) . '">';
			foreach ( $ivbh_fetch_results as $value ) {
				if ( $iva_bhrs_id == $value->id ) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				echo'<option value="' . esc_attr( $value->id ) . '" ' . esc_attr( $selected ) . '>' . esc_attr( $value->title ) . '</option>';
			}
			echo '</select></p>';
		}
		?>
		<p>
			<input class="checkbox" value="on" type="checkbox" <?php if ( 'on' == $iva_days_shortname ) { echo 'checked'; } ?> id="<?php echo esc_attr( $this->get_field_id( 'iva_days_shortname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iva_days_shortname' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'iva_days_shortname' ) ); ?>"><?php esc_html_e( 'Check this if you wish to display shortnames for the days with 3 characters only.','iva_theme_admin' ); ?></label>
		</p>
		<p>
			<input class="checkbox" value="on" type="checkbox" <?php if ( 'on' == $iva_grouping_hrs ) { echo 'checked'; } ?> id="<?php echo esc_attr( $this->get_field_id( 'iva_grouping_hrs' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iva_grouping_hrs' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'iva_grouping_hrs' ) ); ?>"><?php esc_html_e( 'Check this if you wish to group the hours if timings are same.','iva_theme_admin' ); ?></label>
		</p>
		<p>
			<input class="checkbox" value="on" type="checkbox" <?php if ( 'on' == $iva_disable_dots ) { echo 'checked'; } ?> id="<?php echo esc_attr( $this->get_field_id( 'iva_disable_dots' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iva_disable_dots' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'iva_disable_dots' ) ); ?>"><?php esc_html_e( 'Check this if you wish to disable dots.','iva_theme_admin' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'iva_bhrs_class' ) ); ?>"><?php esc_html_e( 'CSS: Additional CSS Class Name', 'iva_business_hours' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'iva_bhrs_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iva_bhrs_class' ) ); ?>" value="<?php echo esc_attr( $iva_bhrs_class ); ?>" type="text" style="width:100%;" />
		</p>
		<?php
	}
}
/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'iva_businesshours' );
