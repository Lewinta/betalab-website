<?php
// Register Widget
function iva_bhp_holidays() {
	register_widget( 'Iva_BHP_Holidays' );
}

// Define the Widget as an extension of WP_Widget
class Iva_BHP_Holidays extends WP_Widget {

	/* constructor */
	public function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname'		=> 'ivabh-hd-hours-widget',
			'description'	=> esc_html( 'Display Holidays.', 'iva_business_hours' ),
		);

		/* Widget control settings. */
		$control_ops = array(
			'width'		=> 300,
			'height'	=> 350,
			'id_base'	=> 'iva_bhrs_holidays',
		);
		/* Create the widget. */
		parent::__construct( 'iva_bhrs_holidays','Business Hours Holidays', $widget_ops, $control_ops );

		}

	function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$iva_bh_hd_title 	= $instance['iva_bh_hd_title'];
		$extra_class = 'ivabh-hd-s1';
		// Fetch Data
		global $wpdb;
		echo wp_kses_post( $before_widget );
		$iva_bhrs_holidays = get_option( 'iva_bh_holidays' )?get_option( 'iva_bh_holidays' ) : '';
		$iva_bh_hd_style = $instance['iva_bh_hd_style'] ? $instance['iva_bh_hd_style'] :'style1';
		$holidays_name = isset($instance['iva_holidays_name']) ? $instance['iva_holidays_name'] :'';
		if( 'style1' === $iva_bh_hd_style ){ $extra_class="ivabh-hd-s1"; }
		if( 'style2' === $iva_bh_hd_style ){ $extra_class="ivabh-hd-s2"; }
		if ( '' != $iva_bh_hd_title ) {
			echo wp_kses_post( $before_title . $iva_bh_hd_title . $after_title );
		}
		$holiday_names_list = array();
		if ( ! empty( $holidays_name ) ) {
			foreach( $holidays_name as $key => $value ){
				$holiday_names_list[ $value ] = $value;
			}
		}
		$iva_bh_date_format = get_option( 'iva_bh_date_format' ) ? get_option( 'iva_bh_date_format' ) : 'Y/m/d';
		if ( ! empty( $iva_bhrs_holidays ) ) {
			$iva_bh_hd_data = json_decode( $iva_bhrs_holidays );
			foreach ( $iva_bh_hd_data as $key => $value ) {
				$name 			= isset( $value->name ) ? strip_tags( $value->name ) : '';
				if ( in_array( $name, $holiday_names_list ) || empty( $holiday_names_list ) ) {
					$start 			= isset( $value->start ) ? date( $iva_bh_date_format, $value->start ) : '';
					$end 			= isset( $value->end ) ? date( $iva_bh_date_format, $value->end ) : '';
					$desc 			= isset( $value->desc ) ? stripslashes( $value->desc ) : '';
					$desc_disable 	= isset( $value->desc_disable ) ? $value->desc_disable : '';
					$bgcolor 	= isset( $value->bgcolor ) ? $value->bgcolor : '';
					$text_color 	= isset( $value->color ) ? $value->color : '';
					$textcolor 		= $text_color 		? ' color:'.$text_color.';':'';
					$bg_color 		= $bgcolor 			? 'background-color:'.$bgcolor.';':'';
					if (!empty($bg_color) || !empty($textcolor)) {
						$extras = ' style="' . $bg_color . $textcolor . '"';
					} else {
						$extras = '';
					}
					if ( 'on' != $desc_disable ) {
						if ( strtotime( $end ) >= time() - (time() % 86400) ) {
							echo '<div class="ivabh-hd-hours '.$extra_class.'" '.$extras.'><p>';

								echo '<span class="days ">' . esc_html( $name ) . '</span>';
								if ( $start == $end ) {
									echo '<span class="hours ">' . esc_html( $start ) . '</span>';
								} else {
									echo '<span class="hours ">' . esc_html( $start ) . ' - ' . esc_html( $end ) . '</span>';
								}
								echo '<small>' . esc_html( $desc ) . '</small>';
							echo '</p></div>';
						}
					}
				}
			}
		}

		echo wp_kses_post( $after_widget );
	}

	//processes widget options to be saved
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['iva_bh_hd_title'] = strip_tags( $new_instance['iva_bh_hd_title'] );
		$instance['iva_bh_hd_style'] = strip_tags( $new_instance['iva_bh_hd_style'] );
		$instance['iva_holidays_name'] =  esc_sql( $new_instance['iva_holidays_name']);
		return $instance;
	}

	// Outputs the options form on admin
	function form( $instance ) {
		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance,
			array( 'iva_bh_hd_title' => '' )
		);
		$iva_bhrs_title  = strip_tags( $instance['iva_bh_hd_title'] );
		$iva_bh_hd_style = isset( $instance['iva_bh_hd_style'] ) ? $instance['iva_bh_hd_style'] : 'style1';
		$iva_holiday_names =  isset( $instance['iva_holidays_name'] ) ? $instance['iva_holidays_name'] : '';
		$iva_bhrs_holidays = get_option( 'iva_bh_holidays' ) ? get_option( 'iva_bh_holidays' ) : '';
		$holiday_options = array();
		if ( ! empty( $iva_bhrs_holidays ) ) {
			$iva_bh_hd_data = json_decode( $iva_bhrs_holidays );
			foreach ( $iva_bh_hd_data as $key => $value ) {
				$name = isset( $value->name ) ? strip_tags( $value->name ) : '';
				$holiday_options[ $name ] = $name;
			}
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'iva_bh_hd_title' ) ); ?>"><?php esc_html_e( 'Title', 'iva_business_hours' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'iva_bh_hd_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iva_bh_hd_title' ) ); ?>" value="<?php echo esc_attr( $iva_bhrs_title ); ?>" type="text" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'style_select' ); ?>"><?php _e('Holidays Style:', 'iva_business_hours'); ?></label>
			<select id="<?php echo $this->get_field_id( 'iva_bh_hd_style' ); ?>" name="<?php echo $this->get_field_name( 'iva_bh_hd_style' ); ?>">
				<option value="style1" <?php selected($iva_bh_hd_style,'style1');?>>Style1</option>
				<option value="style2" <?php selected($iva_bh_hd_style,'style2');?>>Style2</option>
			</select>
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'holidays' ) ); ?>"><?php esc_html_e( 'Select The Holidays Names:', 'iva_business_hours' ); ?></label>
		<select  id="<?php echo esc_attr( $this->get_field_id( 'iva_holidays_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'iva_holidays_name' ) );?>[]" multiple>
		<?php
		foreach( $holiday_options as $key => $value ){
			$selected = ( in_array( $value, $iva_holiday_names ) ) ? selected( 1, 1, false ) : '';
			?>
			<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
		<?php	} ?>
		</select>
		</p>


	<?php
	}
}
/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'iva_bhp_holidays' );
