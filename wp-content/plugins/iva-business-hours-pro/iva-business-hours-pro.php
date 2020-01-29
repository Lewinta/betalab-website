<?php
/*
Plugin Name: Business Hours Pro
Plugin URI: https://codecanyon.net/item/business-hours-pro-wordpress-plugin/9414879
Description: Displays Business Hours and opening hours on your website. Useful for Office, Stores, Hotels and Restaurants etc.
Version: 5.2
Author: AivahThemes
Author URI: http://www.aivahthemes.com
Text Domain: iva_business_hours
*/
add_action( 'plugins_loaded', 'iva_business_hours_pro_plugin_load_textdomain' );
function iva_business_hours_pro_plugin_load_textdomain() {
	load_plugin_textdomain( 'iva_business_hours', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

global $wpdb,$iva_bh_db_version;
$wpdb->iva_businesshours = $wpdb->prefix . 'iva_businesshours';

$iva_bh_db_version = '1.0.0'; // Initial Plugin Version

register_activation_hook( __FILE__, 'iva_bhinstall' );
/**
 * function iva_bh_install()
 * installs plugin
 */
function iva_bhinstall() {
	global $wpdb,$iva_bh_db_version;
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$installed_version = get_option( 'iva_bh_db_version' )
						? get_option( 'iva_bh_db_version' )
						: $iva_bh_db_version;

	$iva_bh_plugin_data = iva_bh_plugin_data();
	$update_version     = $iva_bh_plugin_data['Version'];
	$charset_collate    = '';

	if ( method_exists( $wpdb, 'get_charset_collate' ) ) {
		$charset_collate = $wpdb->get_charset_collate();
	} else {
		if ( ! empty( $wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
	}

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$wpdb->iva_businesshours'" ) != $wpdb->iva_businesshours ) {
		$iva_bhp_table = $wpdb->iva_businesshours;

		$sql = "CREATE TABLE $iva_bhp_table (
					id int(10) NOT NULL AUTO_INCREMENT,
					title longtext NOT NULL,
					alias longtext NOT NULL,
					shortcode longtext NOT NULL,
					weekday0 longtext NOT NULL,
					weekday1 longtext NOT NULL,
					weekday2 longtext NOT NULL,
					weekday3 longtext NOT NULL,
					weekday4 longtext NOT NULL,
					weekday5 longtext NOT NULL,
					weekday6 longtext NOT NULL,
					closedtext text NOT NULL,
					timeseparator text NOT NULL,
					description longtext NOT NULL,
					descriptionprefix text NOT NULL,
					descriptionenable text NOT NULL,
					todaydate text NOT NULL,
					PRIMARY KEY (id),
					KEY id (id)
			) $charset_collate;";

			dbDelta( $sql );
	}

	$iva_bh_data_row = $wpdb->get_row( "SELECT * FROM $wpdb->iva_businesshours" );

	$iva_bh_columns = array(
		'closed_bg_color',
		'grouping_enable',
		'toggle_enable',
		'open_image',
		'close_image',
		'current_day_color',
		'open_bg_color',
		'opentext',
		'closedays_hide',
		'oc_text_hide',
		'singleday_show',
		'algncenter_hrs',
		'singleday_disable',
		'customwidth',
		'open_title',
		'close_title',
		'week_day_min',
		'rem_zeros_from_time',
		'today_text',
		'seemore_text',
		'singleday_off_text',
		'multidays_off_text',
		'hide_time_on_holiday',
	);

	foreach ( $iva_bh_columns as $column ) {
		if ( ! in_array( $column, $wpdb->get_col( 'DESC ' . $wpdb->iva_businesshours, 0 ) ) ) {
			$wpdb->query( "ALTER TABLE $wpdb->iva_businesshours ADD $column VARCHAR(255) NOT NULL" );
		}
	}

	if ( $installed_version != $update_version ) {
		update_option( 'iva_bh_db_version', $update_version );
	}
}

/**
 * function iva_bh_uninstall()
 * uninstalls plugin
 */
register_uninstall_hook( __FILE__, 'iva_bh_uninstall' );
function iva_bh_uninstall() {
	global $wpdb;
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}iva_businesshours" );
}

/**
* Defining Plugin Constants
*/
define( 'IVA_BH_PATH', plugin_dir_path( __FILE__ ) );
define( 'IVA_BH_URL', plugin_dir_url( __FILE__ ) );

// Get default date format and add additional date format cases
global $iva_bh_defaultdate;
$iva_bh_date_format = get_option( 'iva_bh_date_format' ) ? get_option( 'iva_bh_date_format' ) : 'Y/m/d';
switch ( $iva_bh_date_format ) {
	case 'Y/m/d':
		$iva_bh_defaultdate = 'yy/mm/dd';
		break;
	case 'm/d/Y':
		$iva_bh_defaultdate = 'mm/dd/yy';
		break;
	case 'd-m-Y':
		$iva_bh_defaultdate = 'dd-mm-yy';
		break;
	default:
		$iva_bh_defaultdate = 'yy/mm/dd';
		break;
}

/**
 * function iva_bh_admin_scripts()
 * admin enqueue scripts
 */

$iva_business_hours = isset( $_GET['page'] ) ? $_GET['page'] : '';

if (
	( 'iva-business-hours-pro' === $iva_business_hours ) ||
	( 'bhrs-holidays' === $iva_business_hours ) ||
	( 'bhrs-settings' === $iva_business_hours ) ||
	( 'bhrs-operations' === $iva_business_hours ) ) {
	add_action( 'admin_enqueue_scripts', 'iva_bh_admin_scripts' );
}


function iva_bh_admin_scripts( $iva_business_hours ) {

	// register scripts
	wp_register_script( 'jquery-ui-timepicker-addon', IVA_BH_URL . 'assets/js/jquery-ui-timepicker-addon.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-slider' ), true, true );

	// enqueue scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'jquery-ui-timepicker-addon' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'iva-business', IVA_BH_URL . 'assets/js/iva-business-hours-pro.js', array( 'jquery' ), true, true );

	// Localize the script with data for time picker
	wp_localize_script( 'jquery-ui-timepicker-addon', 'iva_bh_timepicker_options', iva_bh_timepicker_options() );

	// enqueue the styles for plugin admin area
	wp_enqueue_style( 'iva-bhrs-admin', IVA_BH_URL . 'assets/css/iva-bh-admin.css', false, true, 'all' );
	wp_enqueue_style( 'iva-bhrs-fontello', IVA_BH_URL . 'assets/fontello/css/fontello.css', false, true, 'all' );
	wp_enqueue_style( 'iva-bhrs-jquery-ui', IVA_BH_URL . 'assets/css/jquery-ui.css', false, true, 'all' );
	wp_enqueue_style( 'iva-bhrs-datepicker', IVA_BH_URL . 'assets/css/datepicker.css', false, true, 'all' );

	// Load localized datepicker script based on the wp languages
	global $iva_bh_defaultdate;
	$iva_bh_date_lng = get_option( 'iva_bh_date_lng' ) ? get_option( 'iva_bh_date_lng' ) : '';
	if ( '' !== $iva_bh_date_lng ) {
		wp_enqueue_script( 'iva-bhrs-datepicker-lng', IVA_BH_URL . 'assets/js/i18n/datepicker-' . $iva_bh_date_lng . '.js', false, false, 'all' );
	}

	/** Localize the plugin data
	 * data - plugin_url
	 * data - date_format
	 * data - date_language
	 */
	wp_localize_script('iva-business', 'iva_bh_panel',
		array(
			'plugin_url'    => IVA_BH_URL,
			'date_format'   => $iva_bh_defaultdate,
			'date_language' => $iva_bh_date_lng,
		)
	);

	// enqueue WordPress default media pload
	wp_enqueue_media();
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'iva-bhrs-upload', IVA_BH_URL . 'assets/js/bhrs_upload.js', array( 'jquery' ), true, true );

	// Modal box for the manual update popup box
	wp_enqueue_style( 'iva-modal-component', IVA_BH_URL . 'assets/css/component.css', false, false, 'all' );
	wp_enqueue_script( 'iva-classie', IVA_BH_URL . 'assets/js/classie.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'iva-modalEffects', IVA_BH_URL . 'assets/js/modalEffects.js', array( 'jquery' ), '', true );
}


/**
 * function iva_bh_front_scripts()
 * frontend enqueue scripts
 */
add_action( 'iva_bh_front_scripts', 'iva_bh_enqueue_front_scripts' );
function iva_bh_enqueue_front_scripts() {
	global $wpdb, $post;
	$post_content = $post->post_content;

	// enqueue frontend styles
	wp_enqueue_script( 'jQuery' );
	wp_enqueue_style( 'iva-bhrs-front', IVA_BH_URL . 'assets/css/iva-bh-front.css', false, true, 'all' );
	wp_enqueue_script( 'iva-bhrs-custom', IVA_BH_URL . 'assets/js/iva-business-hours-pro-front.js', array( 'jquery' ), true, true );
}

/**
* function iva_bh_menu()
* adding business hours pro menu to wp admin dashboard
*/
add_action( 'admin_menu', 'iva_bh_menu' );
function iva_bh_menu() {
	add_menu_page( 'Business Hours Pro', 'BH Pro', 'manage_options', 'iva-business-hours-pro', 'iva_bh_page', IVA_BH_URL . 'assets/images/aivah-icon.png', 59 );
	add_submenu_page( 'iva-business-hours-pro', 'BH-Pro', 'All Hours', 'manage_options', 'iva-business-hours-pro' );
	add_submenu_page( 'iva-business-hours-pro', 'Add/Edit Business Hours', 'Add / Edit', 'manage_options', 'bhrs-operations', 'iva_bh_operations' );
	add_submenu_page( 'iva-business-hours-pro', 'Settings', 'Settings', 'manage_options', 'bhrs-settings', 'iva_bh_settings' );
	add_submenu_page( 'iva-business-hours-pro', 'Holidays', 'Holidays', 'manage_options', 'bhrs-holidays', 'iva_bh_holidays' );
}

// Plugin Header Output
function iva_bh_plugin_header() {

	$iva_bh_plugin_data = iva_bh_plugin_data();

	$output  = '<div class="businessHrs-section main-heading">';
	$output .= '<div class="bHrs_icon green businessHrs-logo "><span class="ivaIcon"></span></div>';
	$output .= '<h1>' . esc_html( $iva_bh_plugin_data['Name'] ) . ' <span class="iva_bhp_ver">' . esc_html( $iva_bh_plugin_data['Version'] ) . '</h1>';
	$output .= '<div class="about-text">' . esc_html__( 'The powerful WordPress Plugin suitable for any business globally to display multiple opening hours and holidays.', 'iva_business_hours' ) . '</div>';
	$output .= '</div>';

	return $output;
}

// Plugin Header Output
function iva_bh_section_header( $icon, $title ) {
	$output  = '<div class="bHrs_icon blue"><span class="ivaIcon "><i class="' . $icon . '"></i></span></div>';
	$output .= '<span class="bhp-sub-title">' . $title . '</span>';

	return $output;
}
/**
 * Add Holidays Form
 * function iva_bh_holidays()
 */
function iva_bh_holidays() {

	global $iva_bh_holidays,$wpdb;

	// get holidays array
	$iva_bh_holidays_array = '';

	$iva_bh_holidays = get_option( 'iva_bh_holidays' ) ? get_option( 'iva_bh_holidays' ) : '';
	if ( '' !== $iva_bh_holidays ) {
		$iva_bh_holidays_array = json_decode( $iva_bh_holidays );
	}

	// get plugin metadata
	$iva_bh_plugin_data    = iva_bh_plugin_data();
	$iva_bhp_holiday_nonce = wp_create_nonce( 'iva-bhp-holiday-string' );
	$iva_bh_section_title  = esc_html__( 'Add Holidays', 'iva_business_hours' );
	$iva_bh_section_icon   = 'aicon_cal';

	echo '<div class="bHrs-mainwrap">';
	echo wp_kses_post( iva_bh_plugin_header() );
	echo '<div id="holidays_success_msg"></div>';
	echo '<form method="post" id="iva_bh_holidays_form" class="iva_bh_holidays_form" name="iva_bh_holidays_form" action="#">';
	echo '<input type="hidden" name="iva_bhp_holiday_nonce" id="iva_bhp_holiday_nonce" value="' . esc_attr( $iva_bhp_holiday_nonce ) . '">';
	echo '<div class="businessHrs-section">';
	echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
	echo '<div id="iva_bh_holiday_wrap" class="iva_bh_holiday_wrap">';
	echo '<div class="iva_bh_holiday_count">';

	$c = '0';
	if ( empty( $iva_bh_holidays_array ) ) {

		// Add holiday row after installation
		echo '<div class="iva_bh_holiday_row">';
		echo '
		<div class="ivabh_hd_input"><label>' . esc_html__( 'Name', 'iva_business_hours' ) . '</label>
			<p class="ivabh-desc">' . esc_html__( 'Shortcode and Holiday Name', 'iva_business_hours' ) . '</p>
			<div class="ivabh-input-details">
			<input type="text" class="iva_bh_hd_name" name="iva_bh_hd_name[]" value="">
			</div>
		</div>
		<div class="ivabh_hd_input"><label>' . esc_html__( 'Start Date', 'iva_business_hours' ) . '</label>
			<p class="ivabh-desc">' . esc_html__( 'Holiday Start Date', 'iva_business_hours' ) . '</p>
			<div class="ivabh-input-details">
			<input type="text" class="iva_bh_hd_start iva_bh_date" name="iva_bh_hd_start[]" value="">
			</div>
		</div>
		<div class="ivabh_hd_input"><label>' . esc_html__( 'End Date', 'iva_business_hours' ) . '</label>
			<p class="ivabh-desc">' . esc_html__( 'Holiday End Date', 'iva_business_hours' ) . '</p>
			<div class="ivabh-input-details">
			<input type="text" class="iva_bh_hd_end iva_bh_date" name="iva_bh_hd_end[]" value="">
			</div>
		</div>
		<div class="ivabh_hd_input"><label>' . esc_html__( 'Description', 'iva_business_hours' ) . '</label>
			<p class="ivabh-desc">' . esc_html__( 'Short summary for your holiday (max: 100 characters)', 'iva_business_hours' ) . '</p>
			<div class="ivabh-input-details">
			<input type="text" class="iva_bh_hd_desc" name="iva_bh_hd_desc[]" value="" maxlength="100" size="50">
			</div>
		</div>
		<div class="ivabh_hd_input"><label>' . esc_html__( 'Background Color', 'iva_business_hours' ) . '</label>
			<p class="ivabh-desc">' . esc_html__( 'Holiday Background', 'iva_business_hours' ) . '</p>
			<div class="ivabh-input-details">
			<input type="text" class="iva_bh_hd_bgcolor wpcolorpicker" name="iva_bh_hd_bgcolor[]" value="">
			</div>
		</div>
		<div class="ivabh_hd_input"><label>' . esc_html__( 'Text Color', 'iva_business_hours' ) . '</label>
			<p class="ivabh-desc">' . esc_html__( 'Holiday Text Color', 'iva_business_hours' ) . '</p>
			<div class="ivabh-input-details">
			<input type="text" class="iva_bh_hd_color wpcolorpicker" name="iva_bh_hd_color[]" value="">
			</div>
		</div>
		<div class="ivabh_hd_input"><label>' . esc_html__( 'Opening Hours', 'iva_business_hours' ) . '</label>
			<p class="ivabh-desc">' . esc_html__( 'Assign to Shortcode', 'iva_business_hours' ) . '</p>
			<div class="ivabh-input-details">';

		$ivbh_select_query  = "SELECT title,id FROM $wpdb->iva_businesshours";
		$ivbh_fetch_results = $wpdb->get_results( $ivbh_select_query );

		if ( $ivbh_fetch_results ) {
			echo '<select id="iva_bhrs_id" name="iva_bhrs_id[]">';

			foreach ( $ivbh_fetch_results as $value ) {

				if ( $value->id === $iva_bhrs_id ) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				echo '<option value="' . esc_attr( $value->id ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $value->title ) . '</option>';
			}

			echo '</select></p>';
		}
		echo '</div>';
		echo '</div>';
		// Delete Holiday
		echo '<div class="ivabh_hd_input"><label>&nbsp;</label><p class="ivabh-desc">&nbsp;</p><a title="Delete"  class="delete_bh_hd button button-primary red-bhp">Delete</a></div>
			<div class="ivabh_hd_checkbox">
				<div class="ivabh-input-details">
				<input type="checkbox" class="iva_bh_hd_desc_disable" id="iva_bh_hd_desc_disable"  name="iva_bh_hd_desc_disable[]"><label for="iva_bh_hd_desc_disable">' . esc_html__( 'Check this if you wish to hide this holiday.', 'iva_business_hours' ) . '</label>
				</div>
			</div>';
		echo '</div>';//.iva_bh_holiday_row
	} elseif ( ! empty( $iva_bh_holidays_array ) ) {

		// Edit Holidays and Update
		foreach ( $iva_bh_holidays_array as $key => $value ) {
			global $iva_bh_date_format, $wpdb;
			$iva_start_date = '';
			$iva_end_date   = '';

			if ( 0 !== $value->start ) {
				$iva_start_date = date_i18n( $iva_bh_date_format, $value->start );
			}
			if ( 0 !== $value->end ) {
				$iva_end_date = date_i18n( $iva_bh_date_format, $value->end );
			}

			$ivbh_select_query  = "SELECT title,alias FROM $wpdb->iva_businesshours" ;
			$ivbh_fetch_results = $wpdb->get_results( $ivbh_select_query );

			$name         = isset( $value->name ) ? strip_tags( $value->name ) : '';
			$start        = isset( $value->start ) ? $iva_start_date : '';
			$end          = isset( $value->end ) ? $iva_end_date : '';
			$desc         = isset( $value->desc ) ? stripslashes( $value->desc ) : '';
			$disable      = isset( $value->desc_disable ) ? $value->desc_disable : '';
			$bgcolor      = isset( $value->color ) ? stripslashes( $value->bgcolor ) : '';
			$color        = isset( $value->color ) ? stripslashes( $value->color ) : '';
			$iva_bhrs_id  = isset( $value->iva_bhrs_id ) ? $value->iva_bhrs_id : '';
			$time_disable = isset( $value->time_disable ) ? $value->time_disable : '';

			$time_checked = '';
			$checked      = '';

			if ( 'on' === $disable ) {
				$checked = 'checked="checked"';
			}
			if ( 'on' === $time_disable ) {
				$time_checked = 'checked="checked"';
			}

			echo '<div class="iva_bh_holiday_row">';
			echo '<div class="ivabh_hd_input"><label>' . esc_html__( 'Name', 'iva_business_hours' ) . '</label>
					<p class="ivabh-desc">' . esc_html__( 'Name the Holiday(s)', 'iva_business_hours' ) . '</p>
					<div class="ivabh-input-details">
					<input type="text" class="iva_bh_hd_name" name="iva_bh_hd_name[]" value="' . esc_attr( $name ) . '">
					</div>
				</div>';
			echo '<div class="ivabh_hd_input"><label>' . esc_html__( 'Description', 'iva_business_hours' ) . '</label>
					<p class="ivabh-desc">' . esc_html__( 'Short summary for tyour holiday (max: 100 characters)', 'iva_business_hours' ) . '</p>
					<div class="ivabh-input-details">
					<input type="text" class="iva_bh_hd_desc" name="iva_bh_hd_desc[]" value=\'' . esc_attr( $desc ) . '\' maxlength="150" size="50">
					</div>
				</div>';
			echo '<div class="clear"></div>';
			echo '<div class="ivabh_hd_input"><label>' . esc_html__( 'Start Date', 'iva_business_hours' ) . '</label>
					<p class="ivabh-desc">' . esc_html__( 'Holiday Start Date', 'iva_business_hours' ) . '</p>
					<div class="ivabh-input-details">
					<input type="text" class="iva_bh_hd_start iva_bh_date" name="iva_bh_hd_start[]" value="' . esc_attr( $start ) . '">
					</div>
				</div>';
			echo '<div class="ivabh_hd_input"><label>' . esc_html__( 'End Date', 'iva_business_hours' ) . '</label>
					<p class="ivabh-desc">' . esc_html__( 'Holiday End Date', 'iva_business_hours' ) . '</p>
					<div class="ivabh-input-details">
					<input type="text" class="iva_bh_hd_end iva_bh_date" name="iva_bh_hd_end[]" value="' . esc_attr( $end ) . '">
					</div>
				</div>';
			echo '<div class="ivabh_hd_input"><label>' . esc_html__( 'Background Color', 'iva_business_hours' ) . '</label>
					<p class="ivabh-desc">' . esc_html__( 'Holiday Background', 'iva_business_hours' ) . '</p>
					<div class="ivabh-input-details">
					<input type="text" class="iva_bh_hd_bgcolor wpcolorpicker" name="iva_bh_hd_bgcolor[]" value="' . esc_attr( $bgcolor ) . '">
					</div>
				</div>';
			echo '<div class="ivabh_hd_input"><label>' . esc_html__( 'Text Color', 'iva_business_hours' ) . '</label>
					<p class="ivabh-desc">' . esc_html__( 'Holiday Text Color', 'iva_business_hours' ) . '</p>
					<div class="ivabh-input-details">
					<input type="text" class="iva_bh_hd_color wpcolorpicker" name="iva_bh_hd_color[]" value="' . esc_attr( $color ) . '">
					</div>
				</div>';

			echo '<div class="ivabh_hd_input"><label>' . esc_html__( 'Opening Hours', 'iva_business_hours' ) . '</label>
					<p class="ivabh-desc">' . esc_html__( 'Assign to Shortcode', 'iva_business_hours' ) . '</p>
					<div class="ivabh-input-details">';
					echo '<span class="ivabh-selectwrap">';
			if ( $ivbh_fetch_results ) {
				echo '<select id="iva_bhrs_id" name="iva_bhrs_id[]">';
				echo '<option value="">' . esc_html__( 'Select Hours', 'iva_business_hours' ) . '</option>';
				foreach ( $ivbh_fetch_results as $value ) {
					if ( $value->alias === $iva_bhrs_id ) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					echo '<option value="' . esc_attr( $value->alias ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $value->title ) . '</option>';
				}
				echo '</select>';
			}
			echo '</span>';
			echo '</div>';
			echo '</div>';
			echo '<div class="clear"></div>';
			echo '<div class="ivabh_hd_checkbox leftalign">
					<div class="ivabh-input-details">
					<input type="checkbox" class="iva_bh_hd_desc_disable" id="iva_bh_hd_desc_disable' . esc_attr( $c ) . '"  name="iva_bh_hd_desc_disable[]"  ' . esc_attr( $checked ) . '><label for="iva_bh_hd_desc_disable' . esc_attr( $c ) . '">' . esc_html__( 'Check this if you wish to hide this holiday on frontend.', 'iva_business_hours' ) . '</label>
					</div>
				</div>';
			echo '<div class="ivabh_hd_checkbox leftalign">
					<div class="ivabh-input-details">
					<input type="checkbox" class="iva_bh_hd_time_disable" id="iva_bh_hd_time_disable' . esc_attr( $c ) . '"  name="iva_bh_hd_time_disable[]"  ' . esc_attr( $time_checked ) . '><label for="iva_bh_hd_time_disable' . esc_attr( $c ) . '">' . esc_html__( 'Check this if you wish to hide time for this holiday on frontend.', 'iva_business_hours' ) . '</label>
					</div>
				</div>';
			// Delete Holiday
			echo '<div class="ivabh_hd_input rightalign"><a title="Delete" class="delete_bh_hd button button-primary red-bhp">' . esc_html__( 'Delete', 'iva_business_hours' ) . '</a></div>';
			echo '<div class="ivabh-input-details iva_bh_sc_clipboard"><span>[iva_bhrs_holidays id="' . esc_attr( $name ) . '"]</span><span class="green-bhp copyToClipboard">shortcode</span></div>';
			echo '</div>';//.iva_bh_holiday_row
			$c = $c + 1;
		} // End foreach().
	} // End if().

	echo '</div>'; // .iva_bh_holiday_count
	echo '<a data_ivbh_hd_url = "' . esc_url( admin_url( 'admin.php?page=bhrs-holidays' ) ) . '" id="add_bh_holidays" class="add_bh_holidays button blue-bhp"><i class="icon-add"></i>' . esc_html__( 'Add New', 'iva_business_hours' ) . '</a>';
	echo '</div>';// #iva_bh_holiday_wrap
	echo '</div>';// end of .business-title
	echo '</form>';
	echo '</div>';// end of .bHrs-mainwrap
	echo '<a data_ivbh_url = "' . esc_url( admin_url( 'admin.php?page=bhrs-holidays' ) ) . '" class="update_bh_holidays button button-hero green-bhp">' . esc_html__( 'Save Holidays', 'iva_business_hours' ) . '</a>';

} // End iva_bh_holidays().

/**
 * Update Holidays
 */
add_action( 'wp_ajax_iva_bh_update_holidays', 'iva_bh_update_holidays' );
add_action( 'wp_ajax_nopriv_iva_bh_update_holidays', 'iva_bh_update_holidays' );

function iva_bh_update_holidays() {
	global $wpdb;
	check_ajax_referer( 'iva-bhp-holiday-string', 'holiday_nonce' );
	$postform = isset( $_POST['data'] ) ? $_POST['data'] : '';

	/**
	 * function parse_str
	 * @param 'str' inpput string
	 * @param 'arr' If the second parameter arr is present, variables are stored in this variable as array elements instead.
	 * @return No value is returned.
	 */
	parse_str( $postform, $formdata );

	$error    = '';
	$iva_post = ( ! empty( $_POST ) ) ? true : false;

	// Holidays
	if ( isset( $formdata['iva_bh_hd_name'] ) && '' !== $formdata['iva_bh_hd_name'] ) {

		$iva_bh_holidays = array();
		$holidaycounts   = count( $formdata['iva_bh_hd_name'] );

		for ( $i = 0; $i <= $holidaycounts; $i++ ) {

			// checks the fields not empty before the holiday add/update
			if (
				! empty( $formdata['iva_bh_hd_name'][ $i ] ) &&
				! empty( $formdata['iva_bh_hd_start'][ $i ] ) &&
				! empty( $formdata['iva_bh_hd_end'][ $i ] )
			) {
				$iva_bhrs_id       = isset( $formdata['iva_bhrs_id'][ $i ] ) ? $formdata['iva_bhrs_id'][ $i ] : '';
				$iva_bh_hd_name    = isset( $formdata['iva_bh_hd_name'][ $i ] ) ? stripslashes( $formdata['iva_bh_hd_name'][ $i ] ) : '';
				$iva_bh_hd_start   = isset( $formdata['iva_bh_hd_start'][ $i ] ) ? strtotime( $formdata['iva_bh_hd_start'][ $i ] ) : '';
				$iva_bh_hd_end     = isset( $formdata['iva_bh_hd_end'][ $i ] ) ? strtotime( $formdata['iva_bh_hd_end'][ $i ] ) : '';
				$iva_bh_hd_desc    = isset( $formdata['iva_bh_hd_desc'][ $i ] ) ? stripslashes( $formdata['iva_bh_hd_desc'][ $i ] ) : '';
				$iva_bh_hd_bgcolor = isset( $formdata['iva_bh_hd_bgcolor'][ $i ] ) ? $formdata['iva_bh_hd_bgcolor'][ $i ] : '';
				$iva_bh_hd_color   = isset( $formdata['iva_bh_hd_color'][ $i ] ) ? $formdata['iva_bh_hd_color'][ $i ] : '';

				$iva_bh_hd_desc_disable = isset( $formdata['iva_bh_hd_desc_disable'][ $i ] ) ? $formdata['iva_bh_hd_desc_disable'][ $i ] : '';
				$iva_bh_hd_time_disable = isset( $formdata['iva_bh_hd_time_disable'][ $i ] ) ? $formdata['iva_bh_hd_time_disable'][ $i ] : '';

				// Get enter values to update
				$iva_bh_holidays[] = array(
					'name'         => $iva_bh_hd_name,
					'start'        => $iva_bh_hd_start,
					'end'          => $iva_bh_hd_end,
					'desc'         => $iva_bh_hd_desc,
					'bgcolor'      => $iva_bh_hd_bgcolor,
					'color'        => $iva_bh_hd_color,
					'desc_disable' => $iva_bh_hd_desc_disable,
					'time_disable' => $iva_bh_hd_time_disable,
					'iva_bhrs_id'  => $iva_bhrs_id,
				);
			}
		}
		// If has holidays data available then update the options
		if ( $iva_bh_holidays ) {
			update_option( 'iva_bh_holidays', wp_json_encode( $iva_bh_holidays ) );
		}
	} // End if().

	$response = '<div id="iva_bh_msg" class="updated notice success is-dismissible clearfix">
	<p>' . esc_html__( 'Holidays updated successfully.', 'iva_business_hours' ) . '</p>
	<button class="notice-dismiss" type="button">
	<span class="screen-reader-text">Dismiss this notice.</span>
	</button></div>';

	echo wp_kses_post( $response );

	wp_die();
} // End of iva_bh_update_holidays().

/**
* function iva_bh_settings()
* fetching plugin data
*/
function iva_bh_settings() {
	global $wpdb;

	// Week Days
	$week_days_array = array(
		'0' => 'Sunday',
		'1' => 'Monday',
		'2' => 'Tuesday',
		'3' => 'Wednesday',
		'4' => 'Thursday',
		'5' => 'Friday',
		'6' => 'Saturday',
	);

	// Time formats
	$time_formats_array = array(
		'H:i'   => '24 Hours',
		'g:i a' => 'am/pm',
		'g:i A' => 'AM/PM',
	);

	// Date formats
	$date_formats_array = array(
		'Y/m/d' => 'yyyy/mm/dd',
		'm/d/Y' => 'mm/dd/yyyy',
		'd-m-Y' => 'dd-mm-yyyy',
	);

	// Languages
	$date_languages = array(
		''      => 'English',
		'sq'    => 'Albanian',
		'ar'    => 'Arabic',
		'bg'    => 'Bulgarian',
		'zh-CN' => 'Chinese',
		'zh-TW' => 'Chinese Traditiona',
		'da'    => 'Danish',
		'fr'    => 'French',
		'fa'    => 'Farsi',
		'fi'    => 'Finnish',
		'de'    => 'German',
		'ka'    => 'Georgian',
		'he'    => 'Hebrew',
		'id'    => 'Indonesian',
		'is'    => 'Icelandic',
		'it'    => 'Italian',
		'ja'    => 'Japanese',
		'lt'    => 'Lithuanian',
		'lv'    => 'Latvian',
		'ms'    => 'Malaysian',
		'ml'    => 'Malayalam',
		'mk'    => 'Macedonian',
		'nn'    => 'Norwegian Nynorsk',
		'no'    => 'Norwegian',
		'pl'    => 'Polish',
		'pt'    => 'Portuguese',
		'pt-BR' => 'Brazilian',
		'rm'    => 'Romansh',
		'ro'    => 'Romanian',
		'ru'    => 'Russian',
		'sk'    => 'Slovak',
		'sl'    => 'Slovenian',
		'sr'    => 'Serbian',
		'sv'    => 'Swedish',
		'ta'    => 'Tamil',
		'th'    => 'Thai',
		'tj'    => 'Tajiki',
		'tr'    => 'Turkish',
		'uk'    => 'Ukrainian',
		'vi'    => 'Vietnamese',
	);

	// Timezone
	$current_offset  = get_option( 'gmt_offset' );
	$tzstring        = get_option( 'timezone_string' );
	$check_zone_info = true;

	// Remove old Etc mappings. Fallback to gmt_offset.
	if ( false !== strpos( $tzstring, 'Etc/GMT' ) ) {
		$tzstring = '';
	}

 	// Create a UTC+- zone if no timezone string exists
	if ( empty( $tzstring ) ) {
		$check_zone_info = false;
		if ( 0 === $current_offset ) {
			$tzstring = 'UTC+0';
		} elseif ( $current_offset < 0 ) {
			$tzstring = 'UTC' . $current_offset;
		} else {
			$tzstring = 'UTC+' . $current_offset;
		}
	}

	// Late Night Hours
	$iva_bh_latenight_hrs = array( '2:00', '3:00', '4:00', '5:00' );

	// Defined variables
	$iva_bh_holidays_array = '';

	$iva_bh_latenight_hrs_enable_checked = '';

	$iva_bh_time_format = get_option( 'iva_bh_time_format' )
						? get_option( 'iva_bh_time_format' ) : 'H:i';

	$iva_bh_date_format = get_option( 'iva_bh_date_format' )
						? get_option( 'iva_bh_date_format' ) : 'Y/m/d';

	$iva_bh_date_lng = get_option( 'iva_bh_date_lng' )
						? get_option( 'iva_bh_date_lng' ) : '';

	$iva_bh_holidays = get_option( 'iva_bh_holidays' )
					? get_option( 'iva_bh_holidays' ) : '';

	$iva_bh_week_day = get_option( 'iva_bh_start_of_week' )
					? get_option( 'iva_bh_start_of_week' ) : 0;

	$iva_bh_latenight_hours = get_option( 'iva_bh_latenight_hrs' );

	$iva_bh_customcss = get_option( 'iva_bh_customcss' )
					? stripslashes( get_option( 'iva_bh_customcss' ) ) : '';

	$iva_bh_latenight_hrs_enable = get_option( 'iva_bh_latenight_hrs_enable' );

	if ( '' !== $iva_bh_holidays ) {
		$iva_bh_holidays_array = json_decode( $iva_bh_holidays );
	}
	if ( 'on' === $iva_bh_latenight_hrs_enable ) {
		$iva_bh_latenight_hrs_enable_checked = 'checked=checked';
	}

	// get plugin metadata
	$iva_bh_plugin_data    = iva_bh_plugin_data();
	$iva_bhp_setting_nonce = wp_create_nonce( 'iva-bhp-setting-string' );

	$iva_bh_section_title = esc_html__( 'General Settings', 'iva_business_hours' );
	$iva_bh_section_icon  = 'aicon_setings';

	echo '<div class="bHrs-mainwrap">';
	echo wp_kses_post( iva_bh_plugin_header() );

	echo '<form method="post" id="iva_bh_settings_form" class="iva_bh_settings_form" name="iva_bh_settings_form" action="#">';

	echo '<input type="hidden" name="iva_bhp_setting_nonce" id="iva_bhp_setting_nonce" value="' . esc_attr( $iva_bhp_setting_nonce ) . '">';
	echo '<div class="businessHrs-section">';
	echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
	//  Week Starts On
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Week Start On', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<span class="ivabh-selectwrap">';
	echo '<select name="iva_bh_start_of_week" id="iva_bh_start_of_week" class="iva_bh_start_of_week">';
	foreach ( $week_days_array as $key => $value ) {
		$selected = '';
		if ( $key === $iva_bh_week_day ) {
			$selected = "selected= 'selected'";
		}
		echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '"><span>' . esc_html( $value ) . '</span></option>';
	}
	echo '</select>';
	echo '</span>';
	echo '<p class="ivabh-desc">' . esc_html__( 'Select your week starts on', 'iva_business_hours' ) . '</p>';
	echo '</div></div>';

	// Time zone
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Timezone', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<span class="ivabh-selectwrap">';
	echo '<select id="timezone_string" name="timezone_string" aria-describedby="timezone-description">';
	echo wp_timezone_choice( $tzstring );
	echo '</select>';
	echo '</span>';
	echo '<p class="ivabh-desc">' . esc_html__( 'Please setup the time zone to make sure your business hours work according to your time zone. Set proper UTC Time zone only.', 'iva_business_hours' ) . '</p>';
	echo '</div></div>';

	// Time Format
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Time Format', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<span class="ivabh-selectwrap">';
	echo '<select name="iva_bh_time_format" id="iva_bh_time_format" class="iva_bh_time_format">';
	foreach ( $time_formats_array as $key => $value ) {
		$selected = '';
		if ( $key === $iva_bh_time_format ) {
			$selected = "selected= 'selected'";
		}
		echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '"><span>' . esc_html( $value ) . '</span></option>';
	}
	echo '</select>';
	echo '</span>';
	echo '<p class="ivabh-desc">' . esc_html__( 'Select the time format you wish to display.', 'iva_business_hours' ) . '</p>';
	echo '</div></div>';

	// Date Format
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Date Format', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<span class="ivabh-selectwrap">';
	echo '<select name="iva_bh_date_format" id="iva_bh_date_format" class="iva_bh_date_format">';
	foreach ( $date_formats_array as $key => $value ) {
		$selected = '';
		if ( $key === $iva_bh_date_format ) {
			$selected = "selected= 'selected'";
		}
		echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '"><span>' . esc_html( $value ) . '</span></option>';
	}
	echo '</select>';
	echo '</span>';
	echo '<p class="ivabh-desc">' . esc_html__( ' Select the date format you wish to display for the Holidays Shortcode.', 'iva_business_hours' ) . '</p>';
	echo '</div></div>';

	// Date Languages
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Languages', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<span class="ivabh-selectwrap">';
	echo '<select name="iva_bh_date_lng" id="iva_bh_date_lng" class="iva_bh_date_lng">';
	foreach ( $date_languages as $key => $value ) {
		$selected = '';
		if ( $key === $iva_bh_date_lng ) {
			$selected = "selected= 'selected'";
		}
		echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $key ) . '"><span>' . esc_html( $value ) . '</span></option>';
	}
	echo '</select>';
	echo '</span>';
	echo '<p class="ivabh-desc">' . esc_html__( ' Select the language for jquery calender inputs ( This applies only for the admin side ).', 'iva_business_hours' ) . '</p>';
	echo '</div></div>';

	// Late Night Hours
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Late Night Hours', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<input type="checkbox" class="iva_bh_latenight_hrs_enable" id="iva_bh_latenight_hrs_enable" name="iva_bh_latenight_hrs_enable" ' . esc_attr( $iva_bh_latenight_hrs_enable_checked ) . '>';
	echo '<label for="iva_bh_latenight_hrs_enable" class="ivabh-desc">' . esc_html__( 'Check this if you wish to display late night hours. This will work display on or off display according to the time but the current day highlight will be different which is not according to standards.', 'iva_business_hours' ) . '</label>';
	echo '</div>';
	echo '</div>';

	// Late Night Timing
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="iva_bh_latenight_hrs_div">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Select Late Timing', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<span class="ivabh-selectwrap">';
	echo '<select name="iva_bh_latenight_hrs" id="iva_bh_latenight_hrs" class="iva_bh_latenight_hrs">';
	foreach ( $iva_bh_latenight_hrs as $value ) {
		$selected = '';
		if ( $value === $iva_bh_latenight_hours ) {
			$selected = "selected= 'selected'";
		}
		echo '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $value ) . '"><span>' . esc_html( $value ) . '</span></option>';
	}
	echo '</select>';
	echo '</span>';
	echo '<p class="ivabh-desc">' . esc_html__( 'Select the night hours.', 'iva_business_hours' ) . '</p>';
	echo '</div></div>';

	// Custom CSS
	echo '<div class="ivabh_bh_options-row">';
	echo '<div class="ivabh_bh_title">' . esc_html__( 'Custom CSS', 'iva_business_hours' ) . '</div>';
	echo '<div class="ivabh-input-details">';
	echo '<textarea class="iva_bh_customcss" name="iva_bh_customcss" id="iva_bh_customcss" rows="10" cols="60">' . esc_attr( $iva_bh_customcss ) . '</textarea>';
	echo '<p class="ivabh-desc">' . esc_html__( 'If you wish to add any custom css for the business hours shortcode, you can add it here in this block.', 'iva_business_hours' ) . '</p>';
	echo '</div></div>';

	echo '</div>'; //businessHrs-section
	echo '</div>'; //bHrs-mainwrap
	echo '<div id="settings_success_msg"></div>';
	echo '</form>'; // end Form

	// Save Settings Button
	echo '<a data_ivbh_url = "' . esc_url( admin_url( 'admin.php?page=bhrs-settings' ) ) . '" class="update_bh_settings button button-hero green-bhp">' . esc_html__( 'Save All Changes', 'iva_business_hours' ) . '</a>';

} // End iva_bh_settings().

/**
 * function iva_get_timeformat()
 * deleting busiess hours data from database.
 */
add_action( 'wp_ajax_iva_bh_update_settings', 'iva_bh_update_settings' );
add_action( 'wp_ajax_nopriv_iva_bh_update_settings', 'iva_bh_update_settings' );
function iva_bh_update_settings() {
	global $wpdb;

	check_ajax_referer( 'iva-bhp-setting-string', 'setting_nonce' );
	$postform = isset( $_POST['data'] ) ? $_POST['data'] : '';

	/**
	* function parse_str
	* @param 'str' inpput string
	* @param 'arr' If the second parameter arr is present, variables are stored in this variable as array elements instead.
	* @return No value is returned.
	*/
	parse_str( $postform, $formdata );

	$error = '';

	if ( isset( $formdata['iva_bh_time_format'] ) && '' !== $formdata['iva_bh_time_format'] ) {
		$iva_bh_time_format = $formdata['iva_bh_time_format'];
	} else {
		$iva_bh_time_format = 'H:i';
	}

	if ( isset( $formdata['iva_bh_date_format'] ) && '' !== $formdata['iva_bh_date_format'] ) {
		$iva_bh_date_format = $formdata['iva_bh_date_format'];
	} else {
		$iva_bh_date_format = 'Y/m/d';
	}

	if ( isset( $formdata['iva_bh_date_lng'] ) && '' !== $formdata['iva_bh_date_lng'] ) {
		$iva_bh_date_lng = $formdata['iva_bh_date_lng'];
	} else {
		$iva_bh_date_lng = '';
	}

	if ( '' !== $formdata['iva_bh_start_of_week'] ) {
		$iva_bh_start_of_week = $formdata['iva_bh_start_of_week'];
	}

	if ( isset( $formdata['iva_bh_latenight_hrs'] ) && '' !== $formdata['iva_bh_latenight_hrs'] ) {
		$iva_bh_latenight_hrs = $formdata['iva_bh_latenight_hrs'];
	}

	if ( isset( $formdata['iva_bh_latenight_hrs_enable'] ) && '' !== $formdata['iva_bh_latenight_hrs_enable'] ) {
		$iva_bh_latenight_hrs_enable = $formdata['iva_bh_latenight_hrs_enable'];
	}

	if ( isset( $formdata['timezone_string'] ) && '' !== $formdata['timezone_string'] ) {
		$iva_timezone_string = $formdata['timezone_string'];
	}

	if ( isset( $formdata['iva_bh_customcss'] ) && '' !== $formdata['iva_bh_customcss'] ) {
		$iva_bh_customcss = $formdata['iva_bh_customcss'];
	} else {
		$iva_bh_customcss = '';
	}

	// Map UTC+- timezones to gmt_offsets and set timezone_string to empty.
	if ( ! empty( $formdata['timezone_string'] ) && preg_match( '/^UTC[+-]/', $formdata['timezone_string'] ) ) {
		$iva_gmt_offset = $formdata['timezone_string'];
		$iva_gmt_offset = preg_replace( '/UTC\+?/', '', $iva_gmt_offset );

		$iva_timezone_string = '';
	} else {
		$iva_timezone_string = $formdata['timezone_string'];

		$iva_gmt_offset = '';
	}

	$iva_bh_settings = array(
		'iva_bh_time_format'          => $iva_bh_time_format,
		'iva_bh_date_format'          => $iva_bh_date_format,
		'iva_bh_date_lng'             => $iva_bh_date_lng,
		'iva_bh_start_of_week'        => $iva_bh_start_of_week,
		'timezone_string'             => $iva_timezone_string,
		'gmt_offset'                  => $iva_gmt_offset,
		'iva_bh_latenight_hrs_enable' => $iva_bh_latenight_hrs_enable,
		'iva_bh_latenight_hrs'        => $iva_bh_latenight_hrs,
		'iva_bh_customcss'            => $iva_bh_customcss,
	);

	foreach ( $iva_bh_settings as $key => $value ) {
		if ( isset( $value ) ) {
			update_option( $key, $value );
		}
	}

	$response = '<div id="iva_bh_msg" class="updated notice success is-dismissible clearfix">
	<p>' . esc_html__( 'Settings updated successfully', 'iva_business_hours' ) . '</p>
	<button class="notice-dismiss" type="button">
	<span class="screen-reader-text">Dismiss this notice.</span></button></div>';

	echo wp_kses_post( $response );
	wp_die();
}
// Custom css
function iva_bh_custom_css() {
	$iva_bh_customcss = get_option( 'iva_bh_customcss' ) ? stripslashes( get_option( 'iva_bh_customcss' ) ) : '';
	if ( '' !== $iva_bh_customcss ) {
		echo '<style type="text/css">';
		echo wp_kses_post( $iva_bh_customcss );
		echo '</style>';
	}
}
add_action( 'wp_head', 'iva_bh_custom_css', 100 );

/**
* function iva_bh_plugin_data()
* Parse the plugin contents to retrieve plugin's metadata.
*/
function iva_bh_plugin_data() {
	global $wpdb;
	$iva_bh_plugin_data = get_plugin_data( __FILE__ );
	return $iva_bh_plugin_data;
}

/**
* function iva_bh_page()
* plugin dashboard shows business hours pro list and instructions
*/
function iva_bh_page() {
	global $wpdb;
	$output = '';

	$iva_bh_plugin_data   = iva_bh_plugin_data();
	$iva_bh_section_title = esc_html__( 'Business Hours List','iva_business_hours' );
	$iva_bh_section_icon  = 'aicon_hourg';

	// Logo Bar
	echo '<div class="bHrs-mainwrap">';
	echo wp_kses_post( iva_bh_plugin_header() );
	echo '<div class="btnwrap">';
	echo '<a data_ivbh_url = "' . esc_url( 'admin.php?page=bhrs-operations' ) . '" class="add_bhrs button button-hero blue-bhp">' . esc_html__( 'Create Hours', 'iva_business_hours' ) . '</a>';
	echo '<a id="import_single_bhrs" data-modal="iva_bh_import_dialog" class="import_single_bhrs button md-trigger button button-hero alert-bhp">' . esc_html__( 'Import Hours', 'iva_business_hours' ) . '</a>';
	echo '</div>';
	$results = $wpdb->get_results( "SELECT * FROM $wpdb->iva_businesshours ORDER BY id" );
	if ( $results ) {
		$iva_bhp_delete_nonce = wp_create_nonce( 'iva-bhp-delete-hours' );
		echo '<input type="hidden" name="iva_bhp_delete_nonce" id="iva_bhp_delete_nonce" value="' . esc_attr( $iva_bhp_delete_nonce ) . '">';
		echo '<div class="businessHrs-section">';
		echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
		echo '<div class="bHrs_list">';
		echo '<div id="iva_bh_message"></div>';
		echo '<form method="post" name="iva_bhrslist" id="iva_bhrslist" action="">';
		echo '<table class="widefat fancytable" width="500">';
		echo '<thead><tr><th>' . esc_html__( 'ID', 'iva_business_hours' ) . '</th>';
		echo '<th>' . esc_html__( 'Name', 'iva_business_hours' ) . '</th>';
		echo '<th>' . esc_html__( 'Shortcode', 'iva_business_hours' ) . '</th>';
		echo '<th colspan="4">' . esc_html__( 'Actions', 'iva_business_hours' ) . '</th>';
		echo '</tr></thead>';
		echo '<tbody>';
		$iva_bhp_ids = array();
		foreach ( $results as $value ) {
			$iva_bh_shortcode = strtolower( trim( str_replace( '-', ' ', $value->shortcode ) ) ); // Replaces all spaces with hyphens.

			$iva_bhp_ids[] = $value->id;
			echo '<tr valign="top">';
			echo '<td>' . esc_html( $value->id ) . '</td>';
			echo '<td>' . esc_html( $value->title ) . '</td>';
			echo '<td>' . wp_kses_stripslashes( $value->shortcode ) . '</td>';
			echo '<td><input type="hidden" value="edit_ivbh_data" name="edit_ivbh_data"/><a href="' . esc_url( admin_url( 'admin.php?page=bhrs-operations&id=' . $value->id ) ) . '" class="button green-bhp"><i class="aicon_edit"></i>' . esc_html__( 'Edit', 'iva_business_hours' ) . '</a></td>';
			echo '<td><a id="delete_bhrs" class="delete_bhrs button red-bhp"  data_ivbh_url = "' . esc_url( admin_url( 'admin.php?page=iva-business-hours-pro' ) ) . '"  data_iva_bhid="' . esc_attr( $value->id ) . '"><i class="aicon_delete"></i>' . esc_html__( 'Delete', 'iva_business_hours' ) . '</a></td>';
			echo '<td><a id="import_bhrs" class="import_bhrs button blue-bhp md-trigger" data-id="' . $value->id . '" data-modal="iva_bh_import_dialog" data-iva-bhid="' . esc_attr( $value->id ) . '"><i class="aicon_delete"></i>' . esc_html__( 'Import', 'iva_business_hours' ) . '</a></td>';
			echo '<td><a id="export_bhrs" class="export_bhrs button green-bhp"  data_ivbh_url = "' . esc_url( admin_url( 'admin.php?page=iva-business-hours-pro' ) ) . '"  data_iva_bhid="' . esc_attr( $value->id ) . '"><i class="aicon_export"></i>' . esc_html__( 'Export', 'iva_business_hours' ) . '</a></td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		echo '</form>';
	}
	// Import hours Dialog Form
	echo '<div id="iva_bh_import_dialog" class="iva_bh_import_dialog md-modal md-effect-1">';
	echo '<div class="md-content">';
	echo '<div>';
	echo '<h3>' . esc_html__( 'Import Business Hours', 'iva_business_hours' ) . '</h3>';
	echo '<p>' . esc_html__( 'Select a file to import', 'iva_business_hours' ) . '</p>';
	echo '<form action="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" enctype="multipart/form-data" method="post">';
	echo '<input type="hidden" name="import_id" id="import_id" value="">';
	echo '<input type="hidden" name="action" value="iva_bh_import_ajax_action">';
	echo '<p><input type="file" name="iva_bh_import_file" class="iva_bh_import_file"></p>';
	echo '<p><input type="submit" class="button green-bhp button-hero subbtn" value="' . esc_html__( 'import hours ', 'iva_business_hours' ) . '"></p>';
	echo '</form>';
	echo '<p><a class="button red-bhp md-close">' . esc_html__( 'Close me!', 'iva_business_hours' ) . '</a></p>';
	echo '</div>';
	echo '</div>';//md-content
	echo '</div>';//iva_bh_import_dialog
	echo '<div class="md-overlay"></div>';
	if ( $results ) {
		// Import hours Dialog Form Ends
		echo '</div>';
		echo '</div>';
	}
	echo '<div  class=""><a id="iva_bh_update_plugin" class="button green-bhp button-hero iva_bh_update_plugin md-trigger" data-modal="iva_bh_update_plugin_dialog">' . esc_html__( 'Manual Update Plugin', 'iva_business_hours' ) . '</a></div>';
	echo '<div class="bHrs_copyright"><p>&copy;' . esc_html__( 'All rights reserved', 'iva_business_hours' ) . ' - www.aivahthemes.com - ' . esc_html( $iva_bh_plugin_data['Name'] ) . '&nbsp;<span>' . esc_html( $iva_bh_plugin_data['Version'] ) . '</span></p></div>';

	// Update Plugin Dialog Form
	echo '<div id="iva_bh_update_plugin_dialog" class="iva_bh_update_plugin_dialog md-modal md-effect-1">';
	echo '<div class="md-content">';
	echo '<div>';
	echo '<h3>' . esc_html__( 'Update Business Hours Pro', 'iva_business_hours' ) . '</h3>';
	echo '<p>' . esc_html__( 'Select a file provided within the package "iva-business-hours-pro.zip" If you update the plugin The files will be overwriten.', 'iva_business_hours' ) . '</p>';
	echo '<p>' . esc_html__( 'Choose the update file:', 'iva_business_hours' ) . '</p>';
	echo '<form action="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" enctype="multipart/form-data" method="post">';
	echo '<input type="hidden" name="action" value="iva_bh_ajax_action">';
	echo '<p><input type="file" name="iva_bh_update_file" class="input_update_slider"></p>';
	echo '<p><input type="submit" class="button green-bhp button-hero subbtn" value="' . esc_html__( 'Update Plugin', 'iva_business_hours' ) . '"></p>';
	echo '</form>';
	echo '<p><a class="button red-bhp md-close">' . esc_html__( 'Close me!', 'iva_business_hours' ) . '</a></p>';
	echo '</div>';
	echo '</div>';//iva_bh_update_plugin_dialog
	echo '</div>';//md-content
	echo '<div class="md-overlay"></div>';
	echo '</div>';//bHrs-mainwrap
}

/**
 * function iva_bh_operations()
 * here adding and updating business hours pro operations goes here
*/
function iva_bh_operations() {
	global $wpdb;

	$iva_desc_prefix_checked          = '';
	$iva_desc_enable_checked          = '';
	$iva_todaydate_checked            = '';
	$iva_oc_text_checked              = '';
	$iva_singleday_checked            = '';
	$iva_algncenter_hrs_checked       = '';
	$iva_singleday_disable_checked    = '';
	$iva_week_day_min_checked         = '';
	$iva_rem_zeros_from_time_checked  = '';
	$iva_hide_time_on_holiday_checked = '';

	$iva_bh_id = isset( $_GET['id'] ) ? ( $_GET['id'] ) : '';

	$iva_bh_plugin_data   = iva_bh_plugin_data();
	$iva_bh_section_title = esc_html__( 'Edit Business Hours', 'iva_business_hours' );
	$iva_bh_section_icon  = 'aicon_edit';

	echo '<div class="bHrs-mainwrap">';
	echo wp_kses_post( iva_bh_plugin_header() );
	if ( '' !== $iva_bh_id ) {
		//Fetching Business hours pro data
		$iva_bhp_edit_nonce = wp_create_nonce( 'iva-bhp-edit-hours' );

		$iva_bh_sql     = "SELECT * FROM $wpdb->iva_businesshours where id='" . $iva_bh_id . "'" ;
		$iva_bh_results = $wpdb->get_results( $iva_bh_sql, ARRAY_A );

		echo '<div id="update_success_mg"></div>';
		echo '<form method="post" id="iva_bh_update_form" class="iva_bh_update_form" name="iva_bh_update_form" action="#">';
		echo '<input type="hidden" name="iva_bhp_edit_nonce" id="iva_bhp_edit_nonce" value="' . esc_attr( $iva_bhp_edit_nonce ) . '">';
		echo '<div class="bHrs_wrap">';
		echo '<div class="bHrs-left">';
		echo '<div class="businessHrs-section">';
		echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
		echo '<p>&bull; ' . esc_html__( 'Additional text field will be displayed beside the time if the field contains any text.', 'iva_business_hours' ) . '</p>';
		echo '<p>&bull; ' . esc_html__( 'To create a closed day leave both the start time and end time hours blank include text fields.', 'iva_business_hours' ) . '</p>';
		echo '<p>&bull; ' . esc_html__( 'To split the timings for a single day click on Plus Sign on right and add your timings.', 'iva_business_hours' ) . '</p>';
		echo '<table id="iva_bh_update_table" class="widefat fancytable edithours">';

		if ( ! empty( $iva_bh_results ) ) {
			foreach ( $iva_bh_results as $iva_bh_data ) {

				$iva_bh_shortcode    = stripslashes( $iva_bh_data['shortcode'] );

				$iva_week_day_min      = isset( $iva_bh_data['week_day_min'] ) ? $iva_bh_data['week_day_min'] : '';
				$iva_rem_zeros_from_time  = isset( $iva_bh_data['rem_zeros_from_time'] ) ? $iva_bh_data['rem_zeros_from_time'] : '';
				$iva_today_text           = isset( $iva_bh_data['today_text'] ) ? $iva_bh_data['today_text'] : '';
				$iva_seemore_text         = isset( $iva_bh_data['seemore_text'] ) ? $iva_bh_data['seemore_text'] : '';
				$iva_singleday_off_text   = isset( $iva_bh_data['singleday_off_text'] ) ? $iva_bh_data['singleday_off_text'] : '';
				$iva_multidays_off_text   = isset( $iva_bh_data['multidays_off_text'] ) ? $iva_bh_data['multidays_off_text'] : '';
				$iva_hide_time_on_holiday = isset( $iva_bh_data['hide_time_on_holiday'] ) ? $iva_bh_data['hide_time_on_holiday'] : '';

				if ( 'on' === $iva_bh_data['grouping_enable'] ) {
					$iva_bh_data['grouping_enable'] = 'checked=checked';
				}
				if ( 'on' === $iva_bh_data['toggle_enable'] ) {
					$iva_bh_data['toggle_enable'] = 'checked=checked';
				}
				if ( 'on' === $iva_bh_data['closedays_hide'] ) {
					$iva_bh_data['closedays_hide'] = 'checked=checked';
				}
				if ( 'on' === $iva_bh_data['oc_text_hide'] ) {
					$iva_bh_data['oc_text_hide'] = 'checked=checked';
				}
				if ( 'on' === $iva_bh_data['singleday_show'] ) {
					$iva_bh_data['singleday_show'] = 'checked=checked';
				}
				if ( 'on' === $iva_bh_data['algncenter_hrs'] ) {
					$iva_bh_data['algncenter_hrs'] = 'checked=checked';
				}
				if ( 'on' == $iva_bh_data['singleday_disable'] ) {
					$iva_bh_data['singleday_disable'] = 'checked=checked';
				}

				if ( 'on' == $iva_bh_data['descriptionenable'] ) { $iva_desc_enable_checked = 'checked=checked'; }
				if ( 'on' == $iva_bh_data['descriptionprefix'] ) { $iva_desc_prefix_checked = 'checked=checked'; }
				if ( 'on' == $iva_bh_data['todaydate'] ) { $iva_todaydate_checked = 'checked=checked'; }
				if ( 'on' == $iva_rem_zeros_from_time ) { $iva_rem_zeros_from_time_checked = 'checked=checked'; }
				if ( 'on' == $iva_week_day_min ) { $iva_week_day_min_checked = 'checked=checked'; }
				if ( 'on' == $iva_hide_time_on_holiday ) { $iva_hide_time_on_holiday_checked = 'checked=checked'; }


				echo '<thead><tr>';
				echo '<th><strong>' . esc_html__( 'Weekday', 'iva_business_hours' ) . '</strong></th>';
				echo '<th><strong>' . esc_html__( 'Start Time', 'iva_business_hours' ) . '</strong></th>';
				echo '<th><strong>' . esc_html__( 'Start Text', 'iva_business_hours' ) . '</strong></th>';
				echo '<th><strong>' . esc_html__( 'End Time', 'iva_business_hours' ) . '</strong></th>';
				echo '<th><strong>' . esc_html__( 'End Text', 'iva_business_hours' ) . '</strong></th>';
				echo '<th><strong>' . esc_html__( 'Split Hours', 'iva_business_hours' ) . '</strong></th>';
				echo '</tr></thead>';

				echo '<tbody id="the-list">';

				echo '<tr id="iva_business_row" style="display: none;">';
				echo '<td>&nbsp;</td>';
				echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" class="iva_bh_input" name="iva_bh[day][period][open]" value="" style="width:90px;" id="iva_bh[day][period][open]"></td>';
				echo '<td><input type="text" name="iva_bh[day][period][starttime]" value="" class="iva_bh_latetime" id="iva_bh[day][period][starttime]"></td>';
				echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" class="iva_bh_input" name="iva_bh[day][period][close]" value="" style="width:90px;" id="iva_bh[day][period][close]"></td>';
				echo '<td><input type="text" name="iva_bh[day][period][latetime]" value="" class="iva_bh_latetime" id="iva_bh[day][period][latetime]"></td>';
				echo '<td><span class="button green-bhp iva_bh-add-period"><span><i class=" aicon_add"></i></span></span>';
				echo '<span class="button red-bhp iva_bh-remove-period"><span><i class="aicon_delete"></i></span></span></td>';
				echo '</tr>';

				$j = 0;
				$week_day_key = '';
				$iva_bh_time_format = get_option( 'iva_bh_time_format' ) ? get_option( 'iva_bh_time_format' ) : 'H:i';
				foreach ( iva_bh_get_weekdays() as $key => $day ) {
					$week_day_key = 'weekday' . $key;
					$iva_bh_day = json_decode( $iva_bh_data[ $week_day_key ] );
					foreach ( $iva_bh_day as $key => $value ) {
						$iva_row_count = count( $value );
						foreach ( $value as $time ) {

							$late_time 			= isset( $time->latetime ) ? $time->latetime : '';
							$start_time 		= isset( $time->starttime ) ? $time->starttime : '';
							$open_attr 			= 'iva_bh[' . $key . '][' . $j . '][open]';
							$starttime_attr = 'iva_bh[' . $key . '][' . $j . '][starttime]';
							$close_attr 		= 'iva_bh[' . $key . '][' . $j . '][close]';
							$latetime_attr  = 'iva_bh[' . $key . '][' . $j . '][latetime]';
							$day_attr  			= 'iva_bh-day-' . $key;

							if ( 0 == $j ) {
								echo '<tr id="' . esc_attr( $day_attr ) . '" class="' . esc_attr( $day_attr ) . '" data-count="' . esc_attr( $iva_row_count ) . '">';
								echo '<td>&nbsp;' . esc_html( $day ) . '</td>';
								echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" name="' . $open_attr . '" value="' . esc_attr( iva_bh_format_time( $time->open,$iva_bh_time_format ) ) . '" style="width:90px;" class="iva_bh_timepicker iva_bh_input" id="' . esc_attr( $open_attr ) . '"></td>';
								echo '<td><input type="text" name="' . $starttime_attr . '" value="' . esc_attr( $start_time ) . '" class="iva_bh_starttime" id="' . esc_attr( $starttime_attr ) . '"></td>';
								echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" name="' . $close_attr . '" value="' . esc_attr( iva_bh_format_time( $time->close,$iva_bh_time_format ) ) . '" style="width:90px;" class="iva_bh_timepicker iva_bh_input" id="' . esc_attr( $close_attr ) . '"></td>';
								echo '<td><input type="text" name="' . $latetime_attr . '" value="' . esc_attr( $late_time ) . '" class="iva_bh_latetime" id="' . esc_attr( $latetime_attr ) . '"></td>';
								echo '<td>';
								echo '<span class="button green-bhp iva_bh-add-period" data-day="' . esc_attr( $key ) . '"><span><i class=" aicon_add"></i></span></span></td>';
								echo '</tr>';
							}
							if ( 0 != $j ) {
								echo '<tr id="' . esc_attr( $day_attr ) . '" class="' . esc_attr( $day_attr ) . '" data-count="' . esc_attr( $iva_row_count ) . '">';
								echo '<td>&nbsp;</td>';
								echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" name="' . $open_attr . '" value="' . esc_attr( iva_bh_format_time( $time->open,$iva_bh_time_format ) ) . '" style="width:90px;" class="iva_bh_timepicker iva_bh_input" id="' . esc_attr( $open_attr ) . '"></td>';
								echo '<td><input type="text" name="' . $starttime_attr . '" value="' . esc_attr( $start_time ) . '" class="iva_bh_starttime" id="' . esc_attr( $starttime_attr ) . '"></td>';
								echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" name="' . $close_attr . '" value="' . esc_attr( iva_bh_format_time( $time->close,$iva_bh_time_format ) ) . '" style="width:90px;" class="iva_bh_timepicker iva_bh_input" id="' . esc_attr( $close_attr ) . '"></td>';
								echo '<td><input type="text" name="' . $latetime_attr . '" value="' . esc_attr( $late_time ) . '" class="iva_bh_latetime" id="' . esc_attr( $latetime_attr ) . '"></td>';
								echo '<td>';
								echo '<span class="button green-bhp iva_bh-add-period" data-day="' . esc_attr( $key ) . '"><span><i class=" aicon_add"></i></span></span>';
								echo '<span class="button red-bhp iva_bh-remove-period"><span><i class="aicon_delete"></i></span></span></td>';
								echo '</tr>';
							}
							$j++;
							if ( $iva_row_count == $j ) {
								$j = 0;
							}
						}
					}
				}
				echo '</tbody></table>';
				echo '</div>';

				// Open Image
				echo '<div class="one_half">';
				$iva_bhrs_open_image 	= isset( $iva_bh_data['open_image'] )? stripslashes( $iva_bh_data['open_image'] ) : '';
				$iva_bh_section_title = esc_html__('Opening Image','iva_business_hours');
				$iva_bh_section_icon 	= 'aicon_close';
				echo '<div class="businessHrs-section">';
				echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
				echo '<div class="ivabh_img_wrap">';
				echo '<div id="iva_oc_preview_image-iva_open_image" class="iva-oc-screenshot">';
				if ( '' != $iva_bhrs_open_image ) {
					$image_attributes = wp_get_attachment_image_src( iva_bhrs_get_attachment_id_from_src( $iva_bhrs_open_image ) );
					if ( ! empty( $image_attributes[0] ) ) {
						echo '<img src="' . esc_url( $image_attributes[0] ) . '"  class="iva_oc_preview_image" alt="" />';
					} else {
						echo '<img src="' . esc_url( $iva_bhrs_open_image ) . '"  class="iva_oc_preview_image" alt="" />';
					}
				}
					echo '</div>'; //iva-oc-screenshot
				echo '<div class="iva-oc-addrem">';
				echo '<p class="ivabh-desc">' . esc_html__( 'Upload the image you wish to display as we\'re open on the hours display.','iva_business_hours' ) . '</p>';
				echo '<input name="iva_open_image" id="iva_open_hidden_image"  type="hidden" class="iva_oc_upload_image" value="' . esc_attr( $iva_bhrs_open_image ) . '" />';
				echo '<input name="iva_open_image" id="iva_open_image" class="iva_oc_upload_btn button blue-bhp" type="button" value="' . esc_html__( 'Upload Image','iva_business_hours' ) . '" />';
				echo '<a href="#" class="iva_oc_image_remove button red-bhp">remove</a>';
				echo '</div>'; //iva-oc-addrem
				echo '</div>'; //ivabh_img_wrap

				// Open Title
				$iva_bhrs_open_title = isset( $iva_bh_data['open_title'] )? stripslashes( $iva_bh_data['open_title'] ) : '';
				echo '<div class="businessHrs-open-title clearfix">';
				echo '<h3>' . esc_html__( 'We are Open Title','iva_business_hours' ) . '</h3>';
				echo '<span class="ivabh-desc">' . esc_html__( 'Use Custom text if you don\'t want to use the image.','iva_business_hours' ) . '</span>';
				echo '<p><input type="text" name="iva_open_title" id="iva_open_title" value="' . $iva_bhrs_open_title . '"></p>';
				echo '</div>'; //iva_bhrs_open_title

				echo '</div>'; //businessHrs-section
				echo '</div>'; //one_half

				// Close Image
				echo '<div class="one_half last">';
				$iva_bhrs_close_image	= isset( $iva_bh_data['close_image'] )? stripslashes( $iva_bh_data['close_image'] ):'';
				$iva_bh_section_title = esc_html__('Closing Image','iva_business_hours');
				$iva_bh_section_icon = 'aicon_open';
				echo '<div class="businessHrs-section">';
				echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
				echo '<div class="ivabh_img_wrap">';
				echo '<div id="iva_oc_preview_image-iva_close_image" class="iva-oc-screenshot">';
				if ( '' != $iva_bhrs_close_image ) {
					$image_attributes = wp_get_attachment_image_src( iva_bhrs_get_attachment_id_from_src( $iva_bhrs_close_image ) );
					if ( ! empty( $image_attributes[0] ) ) {
						echo '<img src="' . esc_url( $image_attributes[0] ) . '"  class="iva_oc_preview_image" alt="" />';
					} else {
						echo '<img src="' . esc_url( $iva_bhrs_close_image ) . '"  class="iva_oc_preview_image" alt="" />';
					}
				}
				echo '</div>'; //iva-oc-screenshot
				echo '<div class="iva-oc-addrem">';
				echo '<p class="ivabh-desc">' . esc_html__( 'Upload the image you wish to display as we\'are closed once the shop timings are about closed','iva_business_hours' ) . '</p>';
				echo '<input name="iva_close_image" id="iva_close_hidden_image"  type="hidden" class="iva_oc_upload_image" value="' . esc_attr( $iva_bhrs_close_image ) . '" />';
				echo '<input name="iva_close_image" id="iva_close_image"  class="iva_oc_upload_btn button blue-bhp" type="button" value="' . esc_html__( 'Upload Image','iva_business_hours' ) . '" />';
				echo '<a href="#" class="iva_oc_image_remove button red-bhp">remove</a>';
				echo '</div>'; //iva-oc-addrem
				echo '</div>'; //ivabh_img_wrap

				// Close Title
				$iva_bhrs_close_title = isset( $iva_bh_data['close_title'] )? stripslashes( $iva_bh_data['close_title'] ) : '';
				echo '<div class="businessHrs-close-title clearfix">';
				echo '<h3>' . esc_html__( 'We are Close Title','iva_business_hours' ) . '</h3>';
				echo '<span class="ivabh-desc">' . esc_html__( 'Use Custom text if you don\'t want to use the image.','iva_business_hours' ) . '</span>';
				echo '<p><input type="text" name="iva_close_title" id="iva_close_title" value="' . $iva_bhrs_close_title . '"></p>';
				echo '</div>'; //iva_bhrs_close_title

				echo '</div>'; //businessHrs-section
				echo '</div><div class="clear"></div>';	// clear column floats

				/* Shortcode Settings */
				echo '<div class="general-wrapper bhrs-settings">';
				$iva_bh_section_title = esc_html__( 'Edit Shortcode Settings','iva_business_hours' );
				$iva_bh_section_icon = 'aicon_setings';
				echo '<div class="businessHrs-section">';
				echo iva_bh_section_header( $iva_bh_section_icon , $iva_bh_section_title );
				echo '<div class="general-input clearfix">';
				echo '<div class="one_half">';
				echo '<div class="bhs-title">' . esc_html__( 'Title', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="bhrs-title-input" name="iva_bh_title" value="' . esc_attr( $iva_bh_data['title'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Enter the title for shortcode.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Shortcode Alias', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="bhrs-edit-alias" name="iva_bh_alias" value="' . esc_attr( trim( str_replace( '-', ' ', $iva_bh_data['alias'] ) ) ) . '"><span class="ivabh-desc">' . esc_html__( 'Slug for the shortcode, Do not use special characters.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Shortcode:', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input type="text"  name="iva_bh_shortcode" class="bhrs-edit-shortcode"  readonly="readonly"  value=\'' . esc_attr( $iva_bh_shortcode ) . '\'><span class="ivabh-desc">' . esc_html__( 'Shortcode to use in your pages or posts.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Description', 'iva_business_hours' ) . '</div><div class="bhs-desc"><textarea rows="5" cols="10" class="" name="iva_description">' . esc_textarea( $iva_bh_data['description'] ) . '</textarea><span class="ivabh-desc" class="tarea-align">' . esc_html__( 'Additional info which displays before/before the hours in shortcode.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Description Position', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="desc_prefix" type="checkbox" class="" name="iva_desc_prefix" value="on" ' . esc_attr( $iva_desc_prefix_checked ) . '><label class="ivabh-desc" for="desc_prefix">' . esc_html__( 'Check this if you wish to display description above the hours.','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Description Hide', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="desc_check" type="checkbox" class="" name="iva_desc_enable" value="on" ' . esc_attr( $iva_desc_enable_checked ) . '><label class="ivabh-desc" for="desc_check">' . esc_html__( 'Check this if you wish to hide the description ( Additional Info).','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Time Separator', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_time_separator" value="' . esc_attr( $iva_bh_data['timeseparator'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Time Separator ( e.g: 09:00 <strong class="red"> - </strong> 06:00 ) add one space before/after your separator symbol.','iva_business_hours' ) . '</span></div><br />';

				// Custom Width
				echo '<div class="bhs-title">' . esc_html__( 'Custom Width', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_custom_width" value="' . esc_attr( $iva_bh_data['customwidth'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Enter the width in only numbers, no percentage or pixels.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Grouping Hours', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="grouping_enable" type="checkbox" class="" name="iva_grouping_enable" value="on" ' . esc_attr( $iva_bh_data['grouping_enable'] ) . '><label class="ivabh-desc" for="grouping_enable">' . esc_html__( 'Check this if you wish to group hours display if the timings are same.','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html__( 'Toggle Display', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="toggle_enable" type="checkbox" class="" name="iva_toggle_enable" value="on" ' . esc_attr( $iva_bh_data['toggle_enable'] ) . '><label class="ivabh-desc" for="toggle_enable">' . esc_html__( 'Check this if you wish to hide all hours and display only current day and add toggle option to see remaining days.','iva_business_hours' ) . '</label></div><br />';
				echo '</div>';
				echo '<div class="one_half last">';
				echo '<div class="bhs-title">' . esc_html( 'Current Day', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="todaydate_check" type="checkbox" class="" name="iva_today_date" value="on" ' . esc_attr( $iva_todaydate_checked ) . '><label class="ivabh-desc" for="todaydate_check">' . esc_html__( 'Check this if you wish to highlight current day.','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Current Day Color', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="current_day_color" type="text" class="wpcolorpicker" name="iva_current_day_color" value="' . esc_attr( $iva_bh_data['current_day_color'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Choose the HEX Color to highlight the current day (e.g: #ff8800 ).','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Closed Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_closed_text" value="' . esc_attr( $iva_bh_data['closedtext'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Text if day is closed.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Closed Text Background', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="closed_bg_color" type="text" class="wpcolorpicker" name="iva_closed_bg_color" value="' . esc_attr( $iva_bh_data['closed_bg_color'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Choose the HEX Color for the closed text background. Make sure you select dark colors as the text color is white by default.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Open Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_open_text" value="' . esc_attr( $iva_bh_data['opentext'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Text if day is open.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Open Text Background:', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="open_bg_color" type="text" class="wpcolorpicker" name="iva_open_bg_color" value="' . esc_attr( $iva_bh_data['open_bg_color'] ) . '"><span class="ivabh-desc">' . esc_html__( 'Choose the HEX color for the open text background. Make sure you select dark colors as the text color is white by default.','iva_business_hours' ) . '</span></div><br />';

				echo '<div class="bhs-title">' . esc_html( 'Closed Days', 'iva_business_hours' ) . '</div>
				<div class="bhs-desc bhs-check">
				<input id="closedays_hide" type="checkbox" class="" name="iva_closedays_hide" value="on" ' . esc_attr( $iva_bh_data['closedays_hide'] ) . '>
				<label class="ivabh-desc" class="ivabh-desc" for="closedays_hide">' . esc_html__( 'Hide closed days.', 'iva_business_hours' ) . '</label>
				</div><br />';

				echo '<div class="bhs-title">' . esc_html( 'Open/Close Text', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="oc_text_hide" type="checkbox" class="" name="iva_oc_text_hide" value="on" ' . esc_attr( $iva_bh_data['oc_text_hide'] ) . '><label class="ivabh-desc" for="oc_text_hide">' . esc_html__( 'Check this if you wish to hide open/close text which appears beside Today Hours.', 'iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Single Day', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="singleday_show" type="checkbox" class="" name="iva_singleday_show" value="on" ' . esc_attr( $iva_bh_data['singleday_show'] ) . '><label class="ivabh-desc" for="singleday_show">' . esc_html__( 'Check this if you wish to display single day instead of showing all days.','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Hours Alignment', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="algncenter_hrs" type="checkbox" class="" name="iva_algncenter_hrs" value="on" ' . esc_attr( $iva_bh_data['algncenter_hrs'] ) . '><label class="ivabh-desc" for="algncenter_hrs">' . esc_html__( 'Check this if you wish to display hours aligned center','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Today Hours', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="singleday_disable" type="checkbox" class="" name="iva_singleday_disable" value="on" ' . esc_attr( $iva_bh_data['singleday_disable'] ) . '><label class="ivabh-desc" for="singleday_disable">' . esc_html__( 'Check this if you wish to disable single day hours ( Today Hours )','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Weekdays Shortname', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="week_day_min" type="checkbox" class="" name="iva_week_day_min" value="on" ' . esc_attr( $iva_week_day_min_checked ) . '><label class="ivabh-desc" for="week_day_min">' . esc_html__( 'Check this if you wish to display weekdays shortname with 3 characters','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Remove trailing zeros from time', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="rem_zeros_from_time" type="checkbox" class="" name="iva_rem_zeros_from_time" value="on" ' . esc_attr( $iva_rem_zeros_from_time_checked ) . '><label class="ivabh-desc" for="rem_zeros_from_time">' . esc_html__( 'Check this if you wish to remove trailing zeros from timeformat ( 9:00AM ) becomes 9AM','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Hide time on holiday', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="hide_time_on_holiday" type="checkbox" class="" name="iva_hide_time_on_holiday" value="on" ' . esc_attr( $iva_hide_time_on_holiday_checked ) . '><label class="ivabh-desc" for="hide_time_on_holiday">' . esc_html__( 'Check this if you wish to hide time when the day is Closed/Holiday ','iva_business_hours' ) . '</label></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Today text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_today_text" type="text" name="iva_today_text" value="' . esc_attr( stripslashes( $iva_today_text ) ) . '"><span class="ivabh-desc">' .  esc_html__( ' \'Todays\'text string translation which appears on frontend.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'See more', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_seemore_text" type="text"  name="iva_seemore_text" value="' . esc_attr( stripslashes( $iva_seemore_text ) ) . '"><span class="ivabh-desc">' . esc_html__( ' \'See more\' text string translation which appears on frontend when \'Toggle Display\' is checked in.','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Single Day Off Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_seemore_text" type="text"  name="iva_singleday_off_text" value="' . esc_attr( stripslashes( $iva_singleday_off_text ) ) . '"><span class="ivabh-desc">' . esc_html__( 'Text to display if you set single holiday - (e.g.We are off for the day on).','iva_business_hours' ) . '</span></div><br />';
				echo '<div class="bhs-title">' . esc_html( 'Multiple Days Off Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_seemore_text" type="text"  name="iva_multidays_off_text" value="' . esc_attr( stripslashes( $iva_multidays_off_text ) ) . '"><span class="ivabh-desc">' . esc_html__( 'Text to display if you set multiple holidays - (e.g.We are on holidays from)','iva_business_hours' ) . '</span></div><br />';
				echo '</div>';
				echo '</div>';//general-input
				echo '</div>';//general-wrapper
				echo '</div>';//bHrs-right

				echo '<div class="clear"></div>';

				echo '<div class="iva_bhrs_notes">';
				echo '<a data_ivbh_url="' . esc_url( admin_url( 'admin.php?page=bhrs-operations&id=' . esc_attr( $iva_bh_id ) ) ) . '" data_iva_bhid="' . esc_attr( $iva_bh_id ) . '" id="update_bhrs" class="update_bhrs button button-hero green-bhp"><i class="aicon_edit"></i>' . esc_html__( 'Update','iva_business_hours' ) . '</a>';
				echo '</div>';//.iva_bhrs_notes
				echo '</br>';

				echo '</div>';// bHrs_wrap
				echo '</form>';
			} // End foreach().
		} // End if().
	} else {
		// Creating Business hours pro
		$iva_bh_section_title = esc_html__( 'Create Business Hours','iva_business_hours' );
		$iva_bh_section_icon = 'aicon_edit';

		$iva_bhp_create_nonce = wp_create_nonce( 'iva-bhp-create-hours' );
		echo '<div id="create_success_mg"></div>';
		echo '<form method="post" id="iva_bh_create_form" class="iva_bh_create_form" name="iva_bh_create_form" action="#">';
		echo '<input type="hidden" name="iva_bhp_create_nonce" id="iva_bhp_create_nonce" value="' . esc_attr( $iva_bhp_create_nonce ) . '">';

		echo '<div class="bHrs_wrap">';
		echo '<div class="bHrs-left">';
		echo '<div class="businessHrs-section">';
		echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
		echo '<p>&bull; ' . esc_html__( 'Additional text field will be displayed beside the time if the field contains any text.','iva_business_hours' ) . '</p>';
		echo '<p>&bull; ' . esc_html__( 'To create a closed day leave both the start time and end time hours blank include text fields.','iva_business_hours' ) . '</p>';
		echo '<p>&bull; ' . esc_html__( 'To split the timings for a single day click on Plus Sign on right and add your timings.','iva_business_hours' ) . '</p>';
		echo '<table id="iva_bh_create_table" class="widefat fancytable createhours">';

		echo '<thead><tr>';
		echo '<th><strong>' . esc_html__( 'Weekday', 'iva_business_hours' ) . '</strong></th>';
		echo '<th><strong>' . esc_html__( 'Start Time', 'iva_business_hours' ) . '</strong></th>';
		echo '<th><strong>' . esc_html__( 'Start Text', 'iva_business_hours' ) . '</strong></th>';
		echo '<th><strong>' . esc_html__( 'End Time', 'iva_business_hours' ) . '</strong></th>';
		echo '<th><strong>' . esc_html__( 'End Text', 'iva_business_hours' ) . '</strong></th>';
		echo '<th><strong>' . esc_html__( 'Add / Remove Period', 'iva_business_hours' ) . '</strong></th>';
		echo '</tr></thead>';

		echo '<tbody id="the-list">';
		echo '<tr id="iva_business_row" style="display: none;" >';
		echo '<td>&nbsp;</td>';
		echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" class="iva_bh_input" name="iva_bh[day][period][open]" value=""  style="width:90px;" id="iva_bh[day][period][open]"></td>';
		echo '<td><input type="text" name="iva_bh[day][period][starttime]" value="" id="iva_bh[day][period][starttime]" class="iva_bh_starttime"></td>';
		echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" class="iva_bh_input" name="iva_bh[day][period][close]" value="" style="width:90px;" id="iva_bh[day][period][close]"></td>';
		echo '<td><input type="text" name="iva_bh[day][period][latetime]" value="" id="iva_bh[day][period][latetime]" class="iva_bh_latetime"></td>';
		echo '<td><span class="button green-bhp iva_bh-add-period"><span><i class="aicon_add"></i></span></span>';
		echo '<span class="button red-bhp iva_bh-remove-period"><span><i class="aicon_delete"></i></span></span></td>';
		echo '</tr>';

		foreach ( iva_bh_get_weekdays() as $key => $day ) {
			$open_attr 			= 'iva_bh[' . $key . '][0][open]';
			$starttime_attr = 'iva_bh[' . $key . '][0][starttime]';
			$close_attr 		= 'iva_bh[' . $key . '][0][close]';
			$latetime_attr  = 'iva_bh[' . $key . '][0][latetime]';
			$day_attr  			= 'iva_bh-day-' . $key;
			echo '<tr id="' . esc_attr( $day_attr ) . '" class="' . esc_attr( $day_attr ) . '" >';
			echo '<td>&nbsp;' . esc_html( $day ) . '</td>';
			echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" name="' . $open_attr . '" value="" style="width:90px;" class="iva_bh_timepicker iva_bh_input" id="' . esc_attr( $open_attr ) . '"></td>';
			echo '<td><input type="text" name="' . $starttime_attr . '" value="" class="iva_bh_starttime" id="' . esc_attr( $starttime_attr ) . '"></td>';
			echo '<td><span class="clockicon"><i class="aicon_clock"></i></span><input type="text" name="' . $close_attr . '" value="" style="width:90px;" class="iva_bh_timepicker iva_bh_input" id="' . esc_attr( $close_attr ) . '"></td>';
			echo '<td><input type="text" name="' . $latetime_attr . '" value="" class="iva_bh_latetime" id="' . esc_attr( $latetime_attr ) . '"></td>';
			echo '<td><span class="button green-bhp iva_bh-add-period" data-day="' . esc_attr( $key ) . '"><span><i class=" aicon_add"></i></span></span></td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		echo '</div>';

		// Open Image
		echo '<div class="one_half">';
		$iva_bh_section_title = esc_html__('Opening Image','iva_business_hours');
		$iva_bh_section_icon = 'aicon_close';
		echo '<div class="businessHrs-section">';
		echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
		echo '<p>' . esc_html__( 'Upload the image you wish to display as we\'re open on the hours display.','iva_business_hours' ) . '</p>';
		echo '<input name="iva_open_image" id="iva_open_hidden_image"  type="hidden" class="iva_oc_upload_image" />';
		echo '<input name="iva_open_image" id="iva_open_image"  class="iva_oc_upload_btn button blue-bhp" type="button" value="' . esc_html__( 'Upload Image','iva_business_hours' ) . '" />';
		echo '<a href="#" class="iva_oc_image_remove button red-bhp">remove</a>';
		echo '<div id="iva_oc_preview_image-iva_open_image" class="iva-oc-screenshot">';
		echo '</div>'; //iva-oc-screenshot

		// Open Title
		echo '<div class="businessHrs-open-title clearfix">';
		echo '<h3>' . esc_html__( 'We are Open Title','iva_business_hours' ) . '</h3>';
		echo '<span class="ivabh-desc">' . esc_html__( 'Use Custom text if you don\'t want to use the image.','iva_business_hours' ) . '</span>';
		echo '<p><input type="text" name="iva_open_title" id="iva_open_title" value=""></p>';
		echo '</div>'; //iva_bhrs_open_title

		echo '</div>'; //businessHrs-section
		echo '</div>'; //one_half

		// Close Image
		echo '<div class="one_half last">';
		$iva_bh_section_title = esc_html__('Closing Image','iva_business_hours');
		$iva_bh_section_icon = 'aicon_open';
		echo '<div class="businessHrs-section">';
		echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
		echo '<p>' . esc_html__( 'Upload the image you wish to display as we\'re closed once the shop timings are about closed','iva_business_hours' ) . '</p>';
		echo '<input name="iva_close_image" id="iva_close_hidden_image"  type="hidden" class="iva_oc_upload_image" />';
		echo '<input name="iva_close_image" id="iva_close_image"  class="iva_oc_upload_btn button blue-bhp" type="button" value="' . esc_html__( 'Upload Image','iva_business_hours' ) . '" />';
		echo '<a href="#" class="iva_oc_image_remove button red-bhp">remove</a>';
		echo '<div id="iva_oc_preview_image-iva_close_image" class="iva-oc-screenshot">';
		echo '</div>'; //iva-oc-screenshot

		// Close Title
		echo '<div class="businessHrs-close-title clearfix">';
		echo '<h3>' . esc_html__( 'We are Close Title','iva_business_hours' ) . '</h3>';
		echo '<span class="ivabh-desc">' . esc_html__( 'Use Custom text if you don\'t want to use the image.','iva_business_hours' ) . '</span>';
		echo '<p><input type="text" name="iva_close_title" id="iva_close_title" value=""></p>';
		echo '</div>'; //iva_bhrs_close_title

		echo '</div>'; //businessHrs-section
		echo '</div>'; //one_half last;
		echo '<div class="clear"></div>';	// clear column floats

		/* Shortcode Settings */
		echo '<div class="general-wrapper bhrs-settings">';
		$iva_bh_section_title = esc_html__( 'Shortcode Settings','iva_business_hours' );
		$iva_bh_section_icon = 'aicon_setings';
		echo '<div class="businessHrs-section">';
		echo iva_bh_section_header( $iva_bh_section_icon, $iva_bh_section_title );
		echo '<div class="general-input clearfix">';
		echo '<div class="one_half">';
		echo '<div class="bhs-title">' . esc_html__( 'Title', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="bhrs-title-input" name="iva_bh_title" value=""><span class="ivabh-desc">' . esc_html__( 'Enter the title for shortcode.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Shortcode Alias', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="bhrs-alias" name="iva_bh_alias" value=""><span class="ivabh-desc">' . esc_html__( 'Slug for the shortcode, Do not use special characters.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Shortcode', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text"  name="iva_bh_shortcode" class="bhrs-shortcode"  readonly="readonly"  value=""><span class="ivabh-desc">' . esc_html__( 'Shortcode to use in your pages or posts.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Description', 'iva_business_hours' ) . '</div><div class="bhs-desc"><textarea rows="5" cols="10" class="" name="iva_description"></textarea><span class="ivabh-desc tarea-align">' . esc_html__( 'Additional info which displays before/before the hours in shortcode.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Description Position', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="desc_prefix" type="checkbox" class="" name="iva_desc_prefix" value="on"><label class="ivabh-desc" for="desc_prefix">' . esc_html__( 'Check this if you wish to display description above the hours.','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Description Hide', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="desc_check" type="checkbox" class="" name="iva_desc_enable" value="on" ><label class="ivabh-desc" for="desc_check">' . esc_html__( 'Check this if you wish to hide the description ( Additional Info).','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Time Separator', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_time_separator" value=""><span class="ivabh-desc">' . esc_html__( 'Time Separator ( e.g: 09:00 - 06:00 ) add one space before/after your separator symbol.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Grouping Hours', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="grouping_enable" type="checkbox" class="" name="iva_grouping_enable" value="on" ><label class="ivabh-desc" for="grouping_enable">' . esc_html__( 'Check this if you wish to group hours display if the timings are same.','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Toggle Hours', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="toggle_enable" type="checkbox" class="" name="iva_toggle_enable" value="on" ><label class="ivabh-desc" for="toggle_enable">' . esc_html__( 'Check this if you wish to hide all hours and display only current day and add toggle option to see remaining days.','iva_business_hours' ) . '</label></div><br />';
		// Custom Width
		echo '<div class="bhs-title">' . esc_html__( 'Custom Width', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_custom_width" value=""><span class="ivabh-desc">' . esc_html__( 'Enter the width in only numbers, no percentage or pixels.','iva_business_hours' ) . '</span></div><br />';

		echo '</div>';
		echo '<div class="one_half last">';

		echo '<div class="bhs-title">' . esc_html( 'Current Day', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="todaydate_check" type="checkbox" class="" name="iva_today_date" value="on" ><label class="ivabh-desc" for="todaydate_check">' . esc_html__( 'Check this if you wish to highlight current day.','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Current Day Color', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="current_day_color" type="text" class="wpcolorpicker" name="iva_current_day_color" value=""><span class="ivabh-desc">' . esc_html__( 'Choose the HEX Color to highlight the current day (e.g: #ff8800 ).','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Closed Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_closed_text" value="Closed"><span class="ivabh-desc">' . esc_html__( 'Closed text if specific day is closed.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Closed Text Background', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="closed_bg_color" type="text" class="wpcolorpicker" name="iva_closed_bg_color" value=""><span class="ivabh-desc">' . esc_html__( 'Choose the HEX Color for the closed text background. Make sure you select dark colors as the text color is white by default.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Open Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="" type="text" class="" name="iva_open_text" value="Open"><span class="ivabh-desc">' . esc_html__( 'Text if day is open.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Open Text Background', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="open_bg_color" type="text" class="wpcolorpicker" name="iva_open_bg_color" value=""><span class="ivabh-desc">' . esc_html__( 'Choose the HEX color for the open text background. Make sure you select dark colors as the text color is white by default.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Closed Days', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="closedays_hide" type="checkbox" class="" name="iva_closedays_hide" value="on" ><label class="ivabh-desc" for="closedays_hide">' . esc_html__( 'Check this if you wish to hide close days.','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Open/Close Text', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="oc_text_hide" type="checkbox" class="" name="iva_oc_text_hide" value="on" ><label class="ivabh-desc" for="oc_text_hide">' . esc_html__( 'Check this if you wish to hide open/close text.','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Single Day', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="singleday_show" type="checkbox" class="" name="iva_singleday_show" value="on" ><label class="ivabh-desc" for="singleday_show">' . esc_html__( 'Check this if you wish to display single day instead of showing all days.','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Hours Alignment', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="algncenter_hrs" type="checkbox" class="" name="iva_algncenter_hrs" value="on"><label class="ivabh-desc" for="algncenter_hrs">' . esc_html__( 'Check this if you wish to display hours aligned center','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html__( 'Today Hours', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="singleday_disable" type="checkbox" class="" name="iva_singleday_disable" value="on"><label class="ivabh-desc" for="singleday_disable">' . esc_html__( 'Check this if you wish to disable single day hours ( Today Hours )','iva_business_hours' ) . '</label></div><br />';
		//
		echo '<div class="bhs-title">' . esc_html( 'Weekdays Shortname', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="week_day_min" type="checkbox" class="" name="iva_week_day_min" value="on"><label class="ivabh-desc" for="week_day_min">' . esc_html__( 'Check this if you wish to display weekdays shortname with 3 characters','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html( 'Remove trailing zeros from time', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="rem_zeros_from_time" type="checkbox" class="" name="iva_rem_zeros_from_time" value="on"><label class="ivabh-desc" for="rem_zeros_from_time">' . esc_html__( 'Check this if you wish to remove trailing zeros from timeformat ( 9:00AM ) becomes 9AM','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html( 'Hide time on holiday', 'iva_business_hours' ) . '</div><div class="bhs-desc bhs-check"><input id="hide_time_on_holiday" type="checkbox" class="" name="iva_hide_time_on_holiday" value="on"><label class="ivabh-desc" for="hide_time_on_holiday">' . esc_html__( 'Check this if you wish to hide time when the day is Closed/Holiday ','iva_business_hours' ) . '</label></div><br />';
		echo '<div class="bhs-title">' . esc_html( 'Today text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_today_text" type="text" name="iva_today_text" value="' . esc_html__( 'Today', 'iva_business_hours' ) . '"><span class="ivabh-desc">' .  esc_html__( ' \'Todays\'text string translation which appears on frontend.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html( 'See more', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_seemore_text" type="text"  name="iva_seemore_text" value=""><span class="ivabh-desc">' . esc_html__( ' \'See more\' text string translation which appears on frontend when \'Toggle Display\' is checked in.','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html( 'Single Day Off Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_seemore_text" type="text"  name="iva_singleday_off_text" value=""><span class="ivabh-desc">' . esc_html__( 'Text to display if you set single holiday - (e.g.We are off for the day on).','iva_business_hours' ) . '</span></div><br />';
		echo '<div class="bhs-title">' . esc_html( 'Multiple Days Off Text', 'iva_business_hours' ) . '</div><div class="bhs-desc"><input id="iva_seemore_text" type="text"  name="iva_multidays_off_text" value=""><span class="ivabh-desc">' . esc_html__( 'Text to display if you set multiple holidays - (e.g.We are on holidays from)','iva_business_hours' ) . '</span></div><br />';
		echo '</div>';
		echo '</div>';//general-input
		echo '</div>';//general-wrapper
		echo '</div>';//bHrs-right

		echo '<div class="clear"></div>';

		echo '<div class="iva_bhrs_notes">';
		echo '<h4>' . esc_html__( 'Note: To create a closed day leave both the start time and end time hours blank.','iva_business_hours' ) . '</h4>';
		echo '<a data_ivbh_url = "' . esc_url( admin_url( 'admin.php?page=iva-business-hours-pro' ) ) . '" class="create_bhrs button button-hero green-bhp">' . esc_html__( 'Create','iva_business_hours' ) . '</a>';
		echo '<a data_ivbh_url = "' . esc_url( admin_url( 'admin.php?page=iva-business-hours-pro' ) ) . '" class="iva_bh_close button button-hero red-bhp">' . esc_html__( 'Close','iva_business_hours' ) . '</a>';
		echo '</div>';//iva_bhrs_notes
		echo '</br>';
		echo '</div>';//bHrs_wrap
		echo '</form>';
	} // End If().
	echo '<div class="clear"></div><hr />';
	echo '</div>';//bHrs-mainwrap';
}

/**
 * function iva_bh_timepicker_options()
 * convert the PHP date/time format value to be jQuery UI DateTimePicker compliant.
 */
function iva_bh_timepicker_options() {
	$iva_bh_time_format = get_option( 'iva_bh_time_format' ) ? get_option( 'iva_bh_time_format' ) : 'H:i';
	$iva_bh_search  = array( 'G', 'H',  'h',  'g', 'i',  's',  'u', 'a',  'A' );
	$iva_bh_replace = array( 'H', 'HH', 'hh', 'h', 'mm', 'ss', 'c', 'tt', 'TT' );
	$iva_bh_options = array(
		'currentText'   => esc_html__( 'Now', 'iva_business_hours' ),
		'closeText'	 		=> esc_html__( 'Done', 'iva_business_hours' ),
		'amNames'	   		=> array( esc_html__( 'AM', 'iva_business_hours' ), esc_html__( 'A', 'iva_business_hours' ) ),
		'pmNames'	   		=> array( esc_html__( 'PM', 'iva_business_hours' ), esc_html__( 'P', 'iva_business_hours' ) ),
		'timeFormat'		=> str_replace( $iva_bh_search, $iva_bh_replace, $iva_bh_time_format ),
		'timeSuffix'		=> '',
		'timeOnlyTitle' => esc_html__( 'Choose Time', 'iva_business_hours' ),
		'timeText'	  	=> esc_html__( 'Time', 'iva_business_hours' ),
		'hourText'	  	=> esc_html__( 'Hour', 'iva_business_hours' ),
		'minuteText'		=> esc_html__( 'Minute', 'iva_business_hours' ),
		'secondText'		=> esc_html__( 'Second', 'iva_business_hours' ),
		'millisecText'  => esc_html__( 'Millisecond', 'iva_business_hours' ),
		'microsecText'  => esc_html__( 'Microsecond', 'iva_business_hours' ),
		'timezoneText'  => esc_html__( 'Time Zone', 'iva_business_hours' ),
		'isRTL'		 			=> is_rtl(),
		'parse'		 			=> 'loose',
	);
	return  $iva_bh_options;
}

/**
 * function iva_bh_format_time()
 * get Time Format set in the WP General Settings.
 */
function iva_bh_format_time( $value, $format = null ) {
	$format = is_null( $format ) ? get_option( 'iva_bh_time_format' ) : $format;
	if ( strlen( $value ) > 0 ) {
		return date_i18n( $format, strtotime( $value ) );
	} else {
		return $value;
	}
}

/**
 * function iva_bh_get_weekdays()
 * Output the weekdays sorted by the start of the week
 * set in the WP General Settings.
 */
function iva_bh_get_weekdays() {
	global $wp_locale;
	$weekstart = get_option( 'iva_bh_start_of_week' ) ? get_option( 'iva_bh_start_of_week' ) : '0';
	$weekday   = $wp_locale->weekday;
	for ( $i = 0; $i < $weekstart; $i++ ) {
		$day = array_slice( $weekday, 0, 1, true );
		unset( $weekday[ $i ] );
		$weekday = $weekday + $day;
	}
	return $weekday;
}

/**
* function iva_bh_insert()
* inserting busiess hours pro data into database.
*/
add_action( 'wp_ajax_iva_bh_insert', 'iva_bh_insert' );
add_action( 'wp_ajax_nopriv_iva_bh_insert', 'iva_bh_insert' );
function iva_bh_insert() {
	global $wpdb;

	// check_ajax_referer( 'iva-bhp-create-hours', 'create_nonce' );
	$postform = isset( $_POST['data'] ) ? $_POST['data'] : '';
	/**
	 * function parse_str
	 * @param 'str' inpput string
	 * @param 'arr' If the second parameter arr is present, variables are stored in this variable as array elements instead.
	 * @return No value is returned.
	 */
	parse_str( $postform, $formdata );

	$error = $iva_bh_shortcode = $iva_time_separator = $iva_custom_width = $iva_bh_alias = $iva_desc_enable = $iva_desc_prefix = '';
	$iva_today_date = $iva_description = $iva_closed_text = $iva_open_text = $iva_closed_bg_color = $iva_open_bg_color = $iva_current_day_color = $iva_grouping_enable = $iva_closedays_hide = $iva_oc_text_hide = $iva_singleday_show = $iva_algncenter_hrs = $iva_singleday_disable = '';
	$iva_toggle_enable = $iva_oc_image = $iva_open_image = $iva_close_image = $iva_open_title = $iva_close_title = '';
	$iva_week_day_min = $iva_rem_zeros_from_time = $iva_hide_time_on_holiday = $iva_seemore_text = $iva_today_text = $iva_singleday_off_text = $iva_multidays_off_text = '';

	// Name validation
	( '' != $formdata['iva_bh_title'] ) ? $iva_bh_title = $formdata['iva_bh_title'] : $error .= esc_html__( 'Enter Title','iva_business_hours' ) . '<br>';

	if ( '' != $formdata['iva_bh_alias'] ) {
		$alias_string = strtolower( trim( str_replace( ' ', '-', $formdata['iva_bh_alias'] ) ) ); // Replaces all spaces with hyphens.
		$iva_bh_alias = preg_replace( '/[^A-Za-z0-9\-\(\) ]/', '', $alias_string ); // Removes special chars.
		global $wpdb;

		$iva_bh_result_row = $wpdb->get_col( $wpdb->prepare( "SELECT alias FROM {$wpdb->iva_businesshours} WHERE id = %d", 1 ) );
		if ( ! empty( $iva_bh_result_row ) ) {
			if ( in_array( $iva_bh_alias, $iva_bh_result_row, true ) ) {
				$error .= esc_html__( 'Alias Exist','iva_business_hours' ) . '<br>';
			}
		}
	} else {
		$error .= esc_html__( 'Enter Alias','iva_business_hours' ) . '<br>';
	}

	if ( isset( $formdata['iva_description'] ) && '' != $formdata['iva_description'] ) { $iva_description = $formdata['iva_description']; }
	if ( isset( $formdata['iva_closed_text'] ) && '' != $formdata['iva_closed_text'] ) { $iva_closed_text = $formdata['iva_closed_text']; }
	if ( isset( $formdata['iva_open_text'] ) && '' != $formdata['iva_open_text'] ) { $iva_open_text = $formdata['iva_open_text']; }
	if ( isset( $formdata['iva_bh_shortcode'] ) && '' != $formdata['iva_bh_shortcode'] ) { $iva_bh_shortcode = $formdata['iva_bh_shortcode']; }
	if ( isset( $formdata['iva_time_separator'] ) && '' != $formdata['iva_time_separator'] ) { $iva_time_separator = $formdata['iva_time_separator']; }
	if ( isset( $formdata['iva_custom_width'] ) && '' != $formdata['iva_custom_width'] ) { $iva_custom_width = $formdata['iva_custom_width']; }
	if ( isset( $formdata['iva_desc_enable'] ) && '' != $formdata['iva_desc_enable'] ) { $iva_desc_enable 	= $formdata['iva_desc_enable']; }
	if ( isset( $formdata['iva_desc_prefix'] ) && '' != $formdata['iva_desc_prefix'] ) { $iva_desc_prefix 	= $formdata['iva_desc_prefix']; }
	if ( isset( $formdata['iva_today_date'] ) && '' != $formdata['iva_today_date'] ) { $iva_today_date 	= $formdata['iva_today_date']; }
	if ( isset( $formdata['iva_closed_bg_color'] ) && '' != $formdata['iva_closed_bg_color'] ) { $iva_closed_bg_color 	= $formdata['iva_closed_bg_color']; }
	if ( isset( $formdata['iva_open_bg_color'] ) && '' != $formdata['iva_open_bg_color'] ) { $iva_open_bg_color 	= $formdata['iva_open_bg_color']; }
	if ( isset( $formdata['iva_grouping_enable'] ) && '' != $formdata['iva_grouping_enable'] ) { $iva_grouping_enable 	= $formdata['iva_grouping_enable']; }
	if ( isset( $formdata['iva_toggle_enable'] ) && '' != $formdata['iva_toggle_enable'] ) { $iva_toggle_enable 	= $formdata['iva_toggle_enable']; }
	if ( isset( $formdata['iva_open_image'] ) && '' != $formdata['iva_open_image'] ) { $iva_open_image 	= $formdata['iva_open_image']; }
	if ( isset( $formdata['iva_close_image'] ) && '' != $formdata['iva_close_image'] ) { $iva_close_image 	= $formdata['iva_close_image']; }
	if ( isset( $formdata['iva_current_day_color'] ) && '' != $formdata['iva_current_day_color'] ) { $iva_current_day_color = $formdata['iva_current_day_color']; }
	if ( isset( $formdata['iva_closedays_hide'] ) && '' != $formdata['iva_closedays_hide'] ) { $iva_closedays_hide 	= $formdata['iva_closedays_hide']; }
	if ( isset( $formdata['iva_oc_text_hide'] ) && '' != $formdata['iva_oc_text_hide'] ) { $iva_oc_text_hide 	= $formdata['iva_oc_text_hide']; }
	if ( isset( $formdata['iva_singleday_show'] ) && '' != $formdata['iva_singleday_show'] ) { $iva_singleday_show 	= $formdata['iva_singleday_show']; }
	if ( isset( $formdata['iva_algncenter_hrs'] ) && '' != $formdata['iva_algncenter_hrs'] ) { $iva_algncenter_hrs 	= $formdata['iva_algncenter_hrs']; }
	if ( isset( $formdata['iva_singleday_disable'] ) && '' != $formdata['iva_singleday_disable'] ) { $iva_singleday_disable 	= $formdata['iva_singleday_disable']; }
	if ( isset( $formdata['iva_open_title'] ) && '' != $formdata['iva_open_title'] ) { $iva_open_title = $formdata['iva_open_title']; }
	if ( isset( $formdata['iva_close_title'] ) && '' != $formdata['iva_close_title'] ) { $iva_close_title = $formdata['iva_close_title']; }
	if ( isset( $formdata['iva_week_day_min'] ) && '' != $formdata['iva_week_day_min'] ) { $iva_week_day_min = $formdata['iva_week_day_min']; }
	if ( isset( $formdata['iva_rem_zeros_from_time'] ) && '' != $formdata['iva_rem_zeros_from_time'] ) { $iva_rem_zeros_from_time = $formdata['iva_rem_zeros_from_time']; }
	if ( isset( $formdata['iva_hide_time_on_holiday'] ) && '' != $formdata['iva_hide_time_on_holiday'] ) { $iva_hide_time_on_holiday = $formdata['iva_hide_time_on_holiday']; }
	if ( isset( $formdata['iva_today_text'] ) && '' != $formdata['iva_today_text'] ) { $iva_today_text = $formdata['iva_today_text']; }
	if ( isset( $formdata['iva_seemore_text'] ) && '' != $formdata['iva_seemore_text'] ) { $iva_seemore_text = $formdata['iva_seemore_text']; }
	if ( isset( $formdata['iva_singleday_off_text'] ) && '' != $formdata['iva_singleday_off_text'] ) { $iva_singleday_off_text = $formdata['iva_singleday_off_text']; }
	if ( isset( $formdata['iva_multidays_off_text'] ) && '' != $formdata['iva_multidays_off_text'] ) { $iva_multidays_off_text = $formdata['iva_multidays_off_text']; }

	if ( ! $error ) {
		foreach ( iva_bh_get_weekdays() as $key => $day ) {
			$week_day_key = 'weekday' . $key;
			$label_key  = 'iva_' . $week_day_key . '_hrs';
			$iva_bh_arr = '';
			$iva_bh_time = array();
			$iva_bh_arr = isset( $formdata['iva_bh'][ $key ] )? $formdata['iva_bh'][ $key ]:'';
			foreach ( $iva_bh_arr as $iva_bh_arr_key => $test2 ) {
				$iva_late_time = isset( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['latetime'] ) ? $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['latetime']:'';
				$iva_start_time = isset( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['starttime'] ) ? $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['starttime']:'';
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['open']  = iva_bh_format_time( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['open'] , 'H:i' );
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['close'] = iva_bh_format_time( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['close'], 'H:i' );
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['latetime'] = $iva_late_time;
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['starttime'] = $iva_start_time;
			}
			$$label_key = wp_json_encode( $iva_bh_time );
		}
		$iva_bh_shortcode = stripslashes( $iva_bh_shortcode );
		$result = $wpdb->insert(
			$wpdb->iva_businesshours,
			array(
				'title'				=> $iva_bh_title,
				'alias'				=> $iva_bh_alias,
				'shortcode' 		=> $iva_bh_shortcode,
				'weekday0' 			=> $iva_weekday0_hrs,
				'weekday1' 			=> $iva_weekday1_hrs,
				'weekday2'			=> $iva_weekday2_hrs,
				'weekday3'			=> $iva_weekday3_hrs,
				'weekday4' 			=> $iva_weekday4_hrs,
				'weekday5' 			=> $iva_weekday5_hrs,
				'weekday6' 			=> $iva_weekday6_hrs,
				'closedtext'  		=> $iva_closed_text,
				'opentext'  		=> $iva_open_text,
				'timeseparator'  	=> $iva_time_separator,
				'customwidth'		=> $iva_custom_width,
				'description' 		=> $iva_description,
				'todaydate'  		=> $iva_today_date,
				'descriptionprefix'	=> $iva_desc_prefix,
				'descriptionenable'	=> $iva_desc_enable,
				'closed_bg_color'	=> $iva_closed_bg_color,
				'open_bg_color'		=> $iva_open_bg_color,
				'grouping_enable'	=> $iva_grouping_enable,
				'toggle_enable'		=> $iva_toggle_enable,
				'open_image'		=> $iva_open_image,
				'close_image'		=> $iva_close_image,
				'current_day_color'	=> $iva_current_day_color,
				'closedays_hide'	=> $iva_closedays_hide,
				'oc_text_hide'		=> $iva_oc_text_hide,
				'singleday_show'	=> $iva_singleday_show,
				'algncenter_hrs'	=> $iva_algncenter_hrs,
				'singleday_disable'	=> $iva_singleday_disable,
				'open_title'		=> $iva_open_title,
				'close_title'		=> $iva_close_title,
				'week_day_min' 				=> $iva_week_day_min,
				'rem_zeros_from_time' => $iva_rem_zeros_from_time,
				'today_text'					=> $iva_today_text,
				'seemore_text' 			  => $iva_seemore_text,
				'singleday_off_text'  => $iva_singleday_off_text,
				'multidays_off_text'  => $iva_multidays_off_text,
				'hide_time_on_holiday'  => $iva_hide_time_on_holiday,
			),
			array( '%s' ,'%s' ,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s' )
		);
		$wpdb->insert_id;

		$response = '<div id="iva_bh_msg" class="updated success is-dismissible clearfix"><p>' . esc_html__( 'Created Successfully','iva_business_hours' ) . '</p></div>';
	} else {
		$response = '<div id="iva_bh_msg" class="updated error is-dismissible clearfix"><p>' . $error . '</p></div>';
	}
	echo wp_kses_post( $response );
	wp_die();
}

/**
* function iva_bh_update()
* updating busiess hours pro data into database.
*/
add_action( 'wp_ajax_iva_bh_update', 'iva_bh_update' );
add_action( 'wp_ajax_nopriv_iva_bh_update', 'iva_bh_update' );
function iva_bh_update() {

	check_ajax_referer( 'iva-bhp-edit-hours', 'edit_nonce' );
	$iva_bh_id  = isset( $_POST['iva_bh_id'] ) ?  $_POST['iva_bh_id'] : '';

	$postdata = $_POST['data'];
	$postform = isset( $postdata ) ?  $postdata : '';

	$error = $iva_bh_title = '';
	$error = $iva_bh_shortcode = $iva_desc_enable = $iva_desc_prefix = $iva_today_date = $iva_time_separator = '';
	$iva_bh_alias = $iva_description = $iva_closed_text = $iva_open_text = $iva_closed_bg_color = $iva_open_bg_color = $iva_current_day_color = $iva_grouping_enable = $iva_closedays_hide = $iva_oc_text_hide = $iva_singleday_show = $iva_algncenter_hrs = $iva_singleday_disable = $iva_custom_width = '';
	$iva_toggle_enable = $iva_oc_image = $iva_open_image = $iva_close_image = $iva_open_title = $iva_close_title = '';
	$iva_week_day_min = $iva_rem_zeros_from_time = $iva_hide_time_on_holiday = $iva_seemore_text = $iva_today_text = $iva_singleday_off_text = $iva_multidays_off_text = '';
	/**
	 * function parse_str
	 * @param 'str' inpput string
	 * @param 'arr' If the second parameter arr is present, variables are stored in this variable as array elements instead.
	 * @return No value is returned.
	 */
	parse_str( $postform, $formdata );

	// Name validation
	if ( '' != $formdata['iva_bh_title'] ) {
		$iva_bh_title = $formdata['iva_bh_title'];
	} else {
		$error .= esc_html__( 'Enter Title','iva_business_hours' );
	}

	if ( '' != $formdata['iva_bh_alias'] ) {
		$alias_string = strtolower( trim( str_replace( ' ', '-', $formdata['iva_bh_alias'] ) ) ); // Replaces all spaces with hyphens.
		$iva_bh_alias = preg_replace( '/[^A-Za-z0-9\-\(\) ]/', '', $alias_string ); // Removes special chars.

		global $wpdb;

		$iva_bh_alias_sql  = "SELECT alias FROM $wpdb->iva_businesshours where id!= $iva_bh_id";
		$iva_bh_result_row = $wpdb->get_col( $iva_bh_alias_sql );
		if ( ! empty( $iva_bh_result_row ) ) {
			if ( in_array( $iva_bh_alias, $iva_bh_result_row, true ) ) {
				$error .= esc_html__( 'Alias Exist','iva_business_hours' ) . '<br>';
			}
		}
	} else {
		$error .= esc_html__( 'Enter Alias','iva_business_hours' ) . '<br>';
	}
	if ( isset( $formdata['iva_description'] ) && '' != $formdata['iva_description'] ) { $iva_description = $formdata['iva_description']; }
	if ( isset( $formdata['iva_closed_text'] ) && '' != $formdata['iva_closed_text'] ) { $iva_closed_text = $formdata['iva_closed_text']; }
	if ( isset( $formdata['iva_open_text'] ) && '' != $formdata['iva_open_text'] ) { $iva_open_text = $formdata['iva_open_text']; }
	if ( isset( $formdata['iva_bh_shortcode'] ) && '' != $formdata['iva_bh_shortcode'] ) { $iva_bh_shortcode = $formdata['iva_bh_shortcode']; }
	if ( isset( $formdata['iva_time_separator'] ) && '' != $formdata['iva_time_separator'] ) { $iva_time_separator = $formdata['iva_time_separator']; }
	if ( isset( $formdata['iva_custom_width'] ) && '' != $formdata['iva_custom_width'] ) { $iva_custom_width = $formdata['iva_custom_width']; }
	if ( isset( $formdata['iva_desc_enable'] ) && '' != $formdata['iva_desc_enable'] ) { $iva_desc_enable = $formdata['iva_desc_enable']; }
	if ( isset( $formdata['iva_desc_prefix'] ) && '' != $formdata['iva_desc_prefix'] ) { $iva_desc_prefix = $formdata['iva_desc_prefix']; }
	if ( isset( $formdata['iva_today_date'] ) && '' != $formdata['iva_today_date'] ) { $iva_today_date = $formdata['iva_today_date']; }
	if ( isset( $formdata['iva_closed_bg_color'] ) && '' != $formdata['iva_closed_bg_color'] ) { $iva_closed_bg_color = $formdata['iva_closed_bg_color']; }
	if ( isset( $formdata['iva_open_bg_color'] ) && '' != $formdata['iva_open_bg_color'] ) { $iva_open_bg_color = $formdata['iva_open_bg_color']; }
	if ( isset( $formdata['iva_grouping_enable'] ) && '' != $formdata['iva_grouping_enable'] ) { $iva_grouping_enable = $formdata['iva_grouping_enable']; }
	if ( isset( $formdata['iva_toggle_enable'] ) && '' != $formdata['iva_toggle_enable'] ) { $iva_toggle_enable = $formdata['iva_toggle_enable']; }
	if ( isset( $formdata['iva_current_day_color'] ) && '' != $formdata['iva_current_day_color'] ) { $iva_current_day_color = $formdata['iva_current_day_color']; }
	if ( isset( $formdata['iva_open_image'] ) && '' != $formdata['iva_open_image'] ) { $iva_open_image = $formdata['iva_open_image']; }
	if ( isset( $formdata['iva_close_image'] ) && '' != $formdata['iva_close_image'] ) { $iva_close_image = $formdata['iva_close_image']; }
	if ( isset( $formdata['iva_closedays_hide'] ) && '' != $formdata['iva_closedays_hide'] ) { $iva_closedays_hide = $formdata['iva_closedays_hide']; }
	if ( isset( $formdata['iva_oc_text_hide'] ) && '' != $formdata['iva_oc_text_hide'] ) { $iva_oc_text_hide = $formdata['iva_oc_text_hide']; }
	if ( isset( $formdata['iva_singleday_show'] ) && '' != $formdata['iva_singleday_show'] ) { $iva_singleday_show = $formdata['iva_singleday_show']; }
	if ( isset( $formdata['iva_algncenter_hrs'] ) && '' != $formdata['iva_algncenter_hrs'] ) { $iva_algncenter_hrs = $formdata['iva_algncenter_hrs']; }
	if ( isset( $formdata['iva_singleday_disable'] ) && '' != $formdata['iva_singleday_disable'] ) { $iva_singleday_disable = $formdata['iva_singleday_disable']; }
	if ( isset( $formdata['iva_open_title'] ) && '' != $formdata['iva_open_title'] ) { $iva_open_title = $formdata['iva_open_title']; }
	if ( isset( $formdata['iva_close_title'] ) && '' != $formdata['iva_close_title'] ) { $iva_close_title = $formdata['iva_close_title']; }
	if ( isset( $formdata['iva_week_day_min'] ) && '' != $formdata['iva_week_day_min'] ) { $iva_week_day_min = $formdata['iva_week_day_min']; }
	if ( isset( $formdata['iva_rem_zeros_from_time'] ) && '' != $formdata['iva_rem_zeros_from_time'] ) { $iva_rem_zeros_from_time = $formdata['iva_rem_zeros_from_time']; }
	if ( isset( $formdata['iva_today_text'] ) && '' != $formdata['iva_today_text'] ) { $iva_today_text = $formdata['iva_today_text']; }
	if ( isset( $formdata['iva_seemore_text'] ) && '' != $formdata['iva_seemore_text'] ) { $iva_seemore_text = $formdata['iva_seemore_text']; }
	if ( isset( $formdata['iva_singleday_off_text'] ) && '' != $formdata['iva_singleday_off_text'] ) { $iva_singleday_off_text = $formdata['iva_singleday_off_text']; }
	if ( isset( $formdata['iva_multidays_off_text'] ) && '' != $formdata['iva_multidays_off_text'] ) { $iva_multidays_off_text = $formdata['iva_multidays_off_text']; }
	if ( isset( $formdata['iva_hide_time_on_holiday'] ) && '' != $formdata['iva_hide_time_on_holiday'] ) { $iva_hide_time_on_holiday = $formdata['iva_hide_time_on_holiday']; }

	global $wpdb;
	if ( ! $error ) {
		foreach ( iva_bh_get_weekdays() as $key => $day ) {
			$week_day_key = 'weekday' . $key;
			$label_key  = 'iva_' . $week_day_key . '_hrs';
			$iva_bh_arr = '';
			$iva_bh_time = array();
			$iva_bh_arr = isset( $formdata['iva_bh'][ $key ] )? $formdata['iva_bh'][ $key ]:'';
			foreach ( $iva_bh_arr as $iva_bh_arr_key => $test2 ) {
				$iva_late_time = isset( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['latetime'] ) ? $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['latetime']:'';
				$iva_start_time = isset( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['starttime'] ) ? $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['starttime']:'';
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['open']  = iva_bh_format_time( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['open'] , 'H:i' );
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['close'] = iva_bh_format_time( $formdata['iva_bh'][ $key ][ $iva_bh_arr_key ]['close'], 'H:i' );
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['latetime'] = $iva_late_time;
				$iva_bh_time[ $key ][ $iva_bh_arr_key ]['starttime'] = $iva_start_time;
			}
			$$label_key = wp_json_encode( $iva_bh_time );
		}
		$iva_bh_shortcode = stripslashes( $iva_bh_shortcode );
		$wpdb->update(
			$wpdb->iva_businesshours,
			array(
				'title' 					=> $iva_bh_title,
				'alias'						=> $iva_bh_alias,
				'shortcode' 			=> $iva_bh_shortcode,
				'weekday0' 				=> $iva_weekday0_hrs,
				'weekday1' 				=> $iva_weekday1_hrs,
				'weekday2'				=> $iva_weekday2_hrs,
				'weekday3'				=> $iva_weekday3_hrs,
				'weekday4' 				=> $iva_weekday4_hrs,
				'weekday5' 				=> $iva_weekday5_hrs,
				'weekday6' 				=> $iva_weekday6_hrs,
				'closedtext'  		=> $iva_closed_text,
				'opentext'  			=> $iva_open_text,
				'timeseparator'  	=> $iva_time_separator,
				'customwidth'			=> $iva_custom_width,
				'description' 		=> $iva_description,
				'todaydate'  				=> $iva_today_date,
				'descriptionprefix'	=> $iva_desc_prefix,
				'descriptionenable'	=> $iva_desc_enable,
				'closed_bg_color'		=> $iva_closed_bg_color,
				'open_bg_color'			=> $iva_open_bg_color,
				'current_day_color'	=> $iva_current_day_color,
				'grouping_enable'		=> $iva_grouping_enable,
				'toggle_enable'			=> $iva_toggle_enable,
				'open_image'				=> $iva_open_image,
				'close_image'				=> $iva_close_image,
				'closedays_hide'		=> $iva_closedays_hide,
				'oc_text_hide'			=> $iva_oc_text_hide,
				'singleday_show'		=> $iva_singleday_show,
				'algncenter_hrs'		=> $iva_algncenter_hrs,
				'singleday_disable'	=> $iva_singleday_disable,
				'open_title'					=> $iva_open_title,
				'close_title'				 	=> $iva_close_title,
				'week_day_min' 				=> $iva_week_day_min,
				'rem_zeros_from_time' => $iva_rem_zeros_from_time,
				'today_text'					=> $iva_today_text,
				'seemore_text' 			  => $iva_seemore_text,
				'singleday_off_text'  => $iva_singleday_off_text,
				'multidays_off_text'  => $iva_multidays_off_text,
				'hide_time_on_holiday'  => $iva_hide_time_on_holiday,
			),
			array( 'id' => $iva_bh_id ),
			array( '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s' ),
			array( '%d' )
		);
		$response = '<div id="iva_bh_msg" class="updated success is-dismissible clearfix"><p>' . esc_html__( 'Updated Successfully','iva_business_hours' ) . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	} else {
		$response = '<div id="iva_bh_msg" class="updated error is-dismissible clearfix"><p>' . $error . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	}
	echo wp_kses_post( $response );
	wp_die();
}

/**
* function iva_bh_delete()
* deleting busiess hours data from database.
*/
add_action( 'wp_ajax_iva_bh_delete', 'iva_bh_delete' );
add_action( 'wp_ajax_nopriv_iva_bh_delete', 'iva_bh_delete' );
function iva_bh_delete() {

	global $wpdb;

	check_ajax_referer( 'iva-bhp-delete-hours', 'delete_nonce' );

	$post_iva_bh_id = sanitize_text_field( $_POST['iva_bh_id'] );
	$iva_bh_id  = isset( $post_iva_bh_id ) ?  $post_iva_bh_id : '';

	$wpdb->delete( $wpdb->iva_businesshours,
		array( 'id' => $iva_bh_id ),
		array( '%d' )
	);

	$response = '<div id="iva_bh_msg" class="updated success is-dismissible clearfix"><p>' . esc_html__( 'Deleted Successfully','iva_business_hours' ) . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	echo wp_kses_post( $response );
	wp_die();
}

/**
* Grouping hours
*/
if ( ! function_exists( 'iva_bhp_grouping_hours' ) ) {
	function iva_bhp_grouping_hours( $openhours, $iva_todaydate_enable, $today_color, $iva_oc_class, $iva_closedays_hide, $iva_closed_text, $closed_css, $iva_days_shortname, $holiday_result ) {
		$output = $out = $time = $iva_bhp_hrs = '';
		$open_array = array();
		foreach ( $openhours as $day => $hours ) {
			$iva_bhp_hrs = serialize( $hours );
			if ( ! isset( $open_array[ $iva_bhp_hrs ] ) ) {
				$open_array[ $iva_bhp_hrs ] = array();
			}
			$open_array[ $iva_bhp_hrs ][] = $day;
		}
		$iva_bh_today = date_i18n( 'l', strtotime( date( 'N' ) ) );

		if ( $iva_days_shortname == 'on' ) {
			$day_format = 'D';
			$iva_bh_today = substr( $iva_bh_today, 0, 3 );
		} else {
			$iva_bh_today = $iva_bh_today;
			$day_format = 'l';
		}
		foreach ( $open_array as $times => $days ) {

			$iva_closedays = false;
			$times = unserialize( $times );
			$iva_time = $iva_b_days = '';
			$iva_bhp_count = count( $times );

			if ( count( $days ) > 2 ) {
				$limit = count( $days ) - 1;
				$first = $days[0];
				$last  = $days[ $limit ];

				if ( date( $day_format, strtotime( '+' . $limit . ' days', strtotime( $first ) ) ) == $last ) {
					$iva_b_days  = $first . ' - ' . $last;
				} else {
					$sep = '';
					foreach ( $days as $sepdays ) {
						$iva_b_days .= $sep . $sepdays;
						$sep = ', ';
					}
				}
			} else {
				$iva_b_days = implode( ', ', $days );
			}

			for ( $i = 0 ; $i < $iva_bhp_count; $i++ ) {

				if ( $i == 0 ) {

					if ( in_array( $iva_bh_today ,$days ) && $iva_todaydate_enable == 'on' ) {
						$select_today = 'ivabh-current-day';
						$today_css 	  = ( $today_color != '' ) ? ' style="' . $today_color . '"':'';
					} else {
						$select_today = $today_css = '';
					}
					$iva_time[] = $times[ $i ];
					if ( strpos( $times[ $i ], 'closed' ) && ( $iva_closedays_hide == 'on' ) ) {
						$iva_closedays = true;
						$iva_time[] = $iva_closed_text;
					}
				} else {
					$iva_time[] = $times[ $i ];
					if ( strpos( $times[ $i ], 'closed' ) && ( $iva_closedays_hide == 'on' ) ) {
						$iva_closedays = true;
						$iva_time[] = $iva_closed_text;
					}
				}
			}
		 	if ( ! $iva_closedays ) {
				$output .= '<div class="iva_bhp_hours_row">';
				$output .= '<span class="days ' . $select_today . '" ' . $today_css . '>' . $iva_b_days . ' &nbsp;</span>';
				$output .= '<span class="hours ' . $select_today . '" ' . $today_css . '>';
				foreach ( $iva_time as $iva_time ) {
					$output .= '<span class="hours-row">';
					$output .= $iva_time;
					$output .= '</span>';
				}
				$output .= '</span>';
				$output .= '</div>';//.iva_bhp_hours_row
			}
		}
		return $output;
	}
}
//
if ( ! function_exists( 'iva_bhrs_get_attachment_id_from_src' ) ) {
	function iva_bhrs_get_attachment_id_from_src( $image_src ) {
		global $wpdb;
		$id = $wpdb->get_var( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid = %s", $image_src ) );
		return $id;
	}
}

function iva_bhp_holidays_close( $hours_alias ) {
	$iva_bhrs_holidays   = get_option( 'iva_bh_holidays' ) ? get_option( 'iva_bh_holidays' ) : '';
	$iva_bh_date_format  = get_option( 'iva_bh_date_format' ) ? get_option( 'iva_bh_date_format' ) : 'Y/m/d';
	$holidays = array();
	if ( ! empty( $iva_bhrs_holidays ) ) {
		$iva_bh_hd_data = json_decode( $iva_bhrs_holidays );

		foreach ( $iva_bh_hd_data as $key => $value ) {
			$holiday = array();
			$iva_bhrs_id = isset( $value->iva_bhrs_id ) ? strip_tags( $value->iva_bhrs_id ) : '';
			$desc_disable = isset( $value->desc_disable ) ? $value->desc_disable : '';
			if ( ( $iva_bhrs_id == $hours_alias )&& ( $desc_disable != 'on' ) ) {
					$name 										= isset( $value->name ) ? strip_tags( $value->name ) : '';
					$start 										= isset( $value->start )? date_i18n( $iva_bh_date_format, $value->start ) : '';
					$end 											= isset( $value->end ) ? date_i18n( $iva_bh_date_format, $value->end ) : '';
					$desc 										= isset( $value->desc ) ? stripslashes( $value->desc ) : '';
					$desc_disable 						= isset( $value->desc_disable ) ? $value->desc_disable : '';
					$time_disable 						= isset( $value->time_disable ) ? $value->time_disable : 'off';
					$bgcolor 									= isset( $value->bgcolor ) ? $value->bgcolor : '';
					$color 										= isset( $value->color ) ? $value->color : '';
					$holiday['closed'] 				= iva_bhp_today_closed( $start, $end );
					$holiday['name'] 				 	= $name;
					$holiday['bgcolor'] 		 	= $bgcolor;
					$holiday['time_disable'] 	= $time_disable;
					$holiday['color'] 				= $color;
					$holiday['startdate'] 		= $start;
					$holiday['enddate'] 			= $end;
					$holidays[] 							= $holiday;
					unset( $holiday );
			}
		}
	}
	return $holidays;
}

function iva_bhp_today_closed( $start, $end ) {
	$start_date = strtotime( $start );
	$end_date 	= strtotime( $end );
	$offset 	= $end_date - $start_date;
	$today_date = time() - (time() % 86400);
	$result = '';
	$floor = floor( $offset / 24 / 60 / 60 );
	for ( $i = 0; $i <= $floor; $i++ ) {
		if ( $today_date == strtotime( $start . ' + ' . $i . '  days' ) ) {
			$result = esc_html__( 'Closed', 'iva_business_hours' );
		}
	}
	return $result;
}
function iva_bhp_is_holiday( $day, $list ) {
	foreach ( $list as $key => $value ) {
		foreach ( $value as $hkey => $hvalue ) {
			$result = ( $day == $hkey ) ? true : false;
			if ( $result ) {
				return true;
			}
		}
	}
	return false;
}
function iva_bhp_holiday_name( $day, $list ) {
	$result = array();
	foreach ( $list as $key => $value ) {
		foreach ( $value as $hkey => $hvalue ) {
			if ( $day == $hkey ) { $result[ $hkey ] = $hvalue; }
		}
	}
	return $result;
}
add_filter( 'safe_style_css', function( $styles ) {
    $styles[] = 'display';
    return $styles;
} );

function iva_bhrs_oc_display( $open_time, $close_time ) {
	$timezone_format 					= _x( 'H:i', 'timezone date format' );
	$iva_curent_time 					= date_i18n( $timezone_format );
	$iva_latenight_hrs 				= get_option( 'iva_bh_latenight_hrs' );
	$today_time_close_period 	= substr( date( 'H:i A', strtotime( $close_time ) ), -2 );
	$today_time_open_period 	= substr( date( 'H:i A', strtotime( $open_time ) ), -2 );
	if ( '' == $close_time &&  ''== $open_time  ) {
		return 'close';
	}
	if ( ''!= $open_time && '' != $close_time ) {
		if ( ( strtotime( $iva_curent_time ) <= strtotime( $close_time ) )
			 || ( 'PM'== $today_time_open_period && 'AM'== $today_time_close_period && strtotime( $close_time ) <= strtotime( $iva_latenight_hrs ) )
			 || ( 'AM'== $today_time_open_period && 'AM'== $today_time_close_period && strtotime( $close_time ) <= strtotime( $iva_latenight_hrs ) )
		) {
			return 'open';
		} else{
			 return 'close';
		}
	}
}
function iva_bhrs_day_short_names( $day, $enable ) {
		if ( $enable == 'on' ) {
				$day_short_name = substr( $day, 0,3 );
				return $day_short_name;
		} else {
				return $day;
		}
}
/**
* Requiring shoortcode
* Requiring Widget
*/
require_once( 'iva-business-hours-pro-widget.php' );
require_once( 'iva-business-hours-pro-shortcode.php' );
require_once( 'iva-bh-plugin-update-file.php' );
require_once( 'iva-bhrs-widget-holidays.php' );
require_once( 'iva_bhrs_holidays_vc_addon.php' );
require_once( 'iva_bhrs_vc_addon.php' );
require_once( 'iva-bhrs-import-export.php' );
require_once( 'iva-bhrs-shortcode-holidays.php' );
