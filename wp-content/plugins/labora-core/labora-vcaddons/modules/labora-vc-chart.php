<?php
/*
* Add-on Name: Charts for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Charts' ) ) {
	class Labora_VC_Charts {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_charts_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_charts_script' ), 1 );
			add_shortcode( 'labora_vc_charts', array( $this, 'labora_vc_charts_shortcode' ) );
		}
		// intialize the  wp enqueue  scripts
		function labora_vc_charts_script() {
			wp_register_script( 'labora-charts', LABORA_VC_ADDON_URL . 'assets/js/Chart.min.js', false,false,'all' );
		}
		// initialize the mapping function
		function labora_vc_charts_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
					   'name' 		 => esc_html__( 'Charts','labora-vc-textdomain' ),
					   'base' 		 => 'labora_vc_charts',
					   'class' 		 => '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	 => 'Labora VC Addons',
					   'description' => esc_html__( 'Displays Charts','labora-vc-textdomain' ),
					   'params' 	 => array(
					   		array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Chart Types', 'labora-vc-textdomain' ),
								'param_name' => 'chart_data',
								'description' => esc_html__( 'Select the type of the Chart you wish to use.', 'labora-vc-textdomain' ),
								'holder' 	 => 'div',
								'value'      => array(
									esc_html__( 'Choose one..', 'labora-vc-textdomain' )   => '',
									esc_html__( 'Line', 'labora-vc-textdomain' )   => 'line',
									esc_html__( 'Bar', 'labora-vc-textdomain' )    => 'bar',
									esc_html__( 'Circle', 'labora-vc-textdomain' ) => 'circle',
									esc_html__( 'Pie', 'labora-vc-textdomain' )    => 'pie',
								),
							),
							array(
								'type'        => 'checkbox',
								'heading'     => esc_html__( 'Legend Enable/Disable', 'labora-vc-textdomain' ),
								'param_name'  => 'legend',
								'description' => esc_html__( 'Check this if you wish to have legend on the chart.', 'labora-vc-textdomain' ),
								'value'       => array( esc_html__( 'Yes', 'labora-vc-textdomain' ) => 'yes' ),
								'std'         => '',
							),
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Legend Position', 'labora-vc-textdomain' ),
								'param_name' => 'legend_position',
								'description' => esc_html__( 'Select the position of the legend.', 'labora-vc-textdomain' ),
								'value'      => array(
									esc_html__( 'Choose one..', 'labora-vc-textdomain' ) => '',
									esc_html__( 'Right', 'labora-vc-textdomain' )  => 'right',
									esc_html__( 'Bottom', 'labora-vc-textdomain' ) => 'bottom',
								),
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Height', 'labora-vc-textdomain' ),
								'param_name' => 'height',
								'description' => esc_html__( 'Enter the height, if you wish to use the chart in a specific width.', 'labora-vc-textdomain' ),
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Width', 'labora-vc-textdomain' ),
								'param_name' => 'width',
								'description' => esc_html__( 'Enter the width, if you wish to use the chart in a specific width.', 'labora-vc-textdomain' ),
							),
							array(
								'type'       => 'textarea',
								'heading'    => esc_html__( 'X-axis values', 'labora-vc-textdomain' ),
								'param_name' => 'x_values',
								'value'      => 'January; February; March; April; May; June; July; August; September',
								'description' => esc_html__( 'Enter the x-axis values. For eg: "January; February; March; April; May; June; July; August; September; October; November; December', 'labora-vc-textdomain' ),
								'dependency' => array(
									'element' => 'chart_data',
									'value'   => array( 'line', 'bar' ),
								),
							),
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Values', 'labora-vc-textdomain' ),
								'param_name' => 'labels',
								'dependency' => array(
									'element' => 'chart_data',
									'value'   => array( 'line', 'bar' ),
								),
								'value'      => urlencode( json_encode( array(
									array(
										'title' => esc_html__( 'First', 'labora-vc-textdomain' ),
										'y_values' => '10; 15; 20; 25; 30; 35; 40; 45',
										'description' => esc_html__( 'Enter the y-axis values. For eg: 0; 5; 10; 15; 20; 25; 30; 35', 'labora-vc-textdomain' ),
										'colors' => '#fe6c61',
									),
									array(
										'title' => esc_html__( 'Second', 'labora-vc-textdomain' ),
										'y_values' => '20; 30; 40; 50; 60; 70; 80; 90',
										'description' => esc_html__( 'Enter the y-axis values. For eg: 20; 30; 40; 50; 60; 70; 80; 90', 'labora-vc-textdomain' ),
										'colors' => '#5472d2',
									),
								) ) ),
								'params'     => array(
									array(
										'type'        => 'textfield',
										'heading'     => esc_html__( 'Title', 'labora-vc-textdomain' ),
										'param_name'  => 'title',
										'description' => esc_html__( 'Enter title for chart dataset.', 'labora-vc-textdomain' ),
										'admin_label' => true,
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Y-axis values', 'labora-vc-textdomain' ),
										'param_name' => 'y_values',
									),
									array(
										'type'       => 'colorpicker',
										'heading'    => esc_html__( 'Color', 'labora-vc-textdomain' ),
										'param_name' => 'colors',
										'description' => esc_html__( 'Choose the color of your choice.', 'labora-vc-textdomain' ),
									),
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								'type'       => 'param_group',
								'heading'    => esc_html__( 'Values', 'labora-vc-textdomain' ),
								'param_name' => 'xy_circle',
								'dependency' => array(
									'element' => 'chart_data',
									'value'   => array( 'circle', 'pie' ),
								),
								'value'      => urlencode( json_encode( array(
									array(
										'title' => esc_html__( 'Hours', 'labora-vc-textdomain' ),
										'value' => '15',
										'colors' => '#FFBB33',
									),
									array(
										'title' => esc_html__( 'Minutes', 'labora-vc-textdomain' ),
										'value' => '20',
										'colors' => '#8EE3B3',
									),
									array(
										'title' => esc_html__( 'Seconds', 'labora-vc-textdomain' ),
										'value' => '25',
										'colors' => '#DAAAF1',
									),
								) ) ),
								'params'     => array(
									array(
										'type'        => 'textfield',
										'heading'     => esc_html__( 'Title', 'labora-vc-textdomain' ),
										'param_name'  => 'title',
										'description' => esc_html__( 'Enter the title for chart dataset.', 'labora-vc-textdomain' ),
										'admin_label' => true,
									),
									array(
										'type'       => 'textfield',
										'heading'    => esc_html__( 'Value', 'labora-vc-textdomain' ),
										'param_name' => 'value',
									),
									array(
										'type'       => 'colorpicker',
										'heading'    => esc_html__( 'Color', 'labora-vc-textdomain' ),
										'param_name' => 'colors',
										'description' => esc_html__( 'Choose the color of your choice.', 'labora-vc-textdomain' ),
									),
								),
								'callbacks'  => array(
									'after_add' => 'vcChartParamAfterAddCallback',
								),
							),
							array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Extra cssname', 'labora-vc-textdomain' ),
								'param_name' => 'extra_class',
								'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'labora-vc-textdomain' ),
							),
							array(
								'type'       => 'css_editor',
								'heading'    => esc_html__( 'CSS Box', 'labora-vc-textdomain' ),
								'param_name' => 'css',
								'group'      => esc_html__( 'Design options', 'labora-vc-textdomain' ),
							),
						),
					)
				);
			}
		}

		function labora_vc_charts_shortcode( $atts ) {
			extract( shortcode_atts( array(
				'chart_data'		=> '',
				'legend'			=> '',
				'legend_position'	=> '',
				'x_values'			=> '',
				'labels'			=> '',
				'title'				=> '',
				'y_values'			=> '',
				'colors'			=> '',
				'xy_circle' 		=> '',
				'width'				=> '',
				'height'			=> '',
				'css'				=> '',
				'extra_class'		=> '',
			), $atts));

			wp_enqueue_script( 'Chart' );

			$labora_unique_chartid = uniqid( 'chart_' );

			$labora_extra_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			if ( ! empty( $legend_position ) ) {
				$labora_extra_css .= ' labora-legend-position-' . $legend_position;
			}
			if ( ! empty( $extra_class ) ) {
				$labora_extra_css .= ' ' . $extra_class;
			}

			$labels		= (array) vc_param_group_parse_atts( $labels );
			$xy_circle  = (array) vc_param_group_parse_atts( $xy_circle );

			$x_values = explode( ';', trim( $x_values, ';' ) );

			$inline_style = array(
				'height' => '300',
				'width'  => '500',
			);

			if ( $height ) {
				$inline_style['height'] = $height;
			}

			if ( $width ) {
				$inline_style['width'] = $width;
			}

			$labora_data = array(
				'labels'   => $x_values,
				'datasets' => array(),
			);

			if ( 'line' == $chart_data || 'bar' == $chart_data ) {
				foreach ( $labels as $key => $val ) {

					$colors = $val['colors'];
					$rgb   = vc_hex2rgb( $colors );

					if ( 'line' == $chart_data ) {
						$labora_data['datasets'][] = array(
							'label'                => isset( $val['title'] ) ? $val['title'] : '',
							'fillColor'            => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.3)',
							'strokeColor'          => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)',
							'pointColor'           => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)',
							'pointStrokeColor'     => '#fff',
							'pointHighlightFill'   => '#fff',
							'pointHighlightStroke' => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)',
							'pointColor'           => $colors,
							'data'                 => explode( ';', isset( $val['y_values'] ) ? trim( $val['y_values'], ';' ) : '' ),
						);
					} elseif ( 'circle' == $chart_data ) {
						$labora_data['datasets'][] = array(
							'label'      => isset( $val['title'] ) ? $val['title'] : '',
							'highlight'  => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.7)',
							'color'      => $colors,
							'pointColor' => $colors,
							'data'       => explode( ';', isset( $val['y_values'] ) ? trim( $val['y_values'], ';' ) : '' ),
						);
					} elseif ( 'bar' == $chart_data || 'pie' == $chart_data ) {
						$labora_data['datasets'][] = array(
							'label'           => isset( $val['title'] ) ? $val['title'] : '',
							'fillColor'       => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.6)',
							'strokeColor'     => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0)',
							'highlightFill'   => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)',
							'highlightStroke' => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)',
							'pointColor'      => $colors,
							'data'            => explode( ';', isset( $val['y_values'] ) ? trim( $val['y_values'], ';' ) : '' ),
						);
					}
				}
			} else {
				foreach ( $xy_circle as $key => $val ) {
					$colors = $val['colors'];
					$rgb   = vc_hex2rgb( $colors );
					$labora_data['datasets'][] = array(
						'label'      => isset( $val['title'] ) ? $val['title'] : '',
						'highlight'  => 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.75)',
						'color'      => $colors,
						'pointColor' => $colors,
						'value'      => $val['value'],
					);
				}
				$labels = $xy_circle;
			}
			?>
			<?php
			if ( $labels && $x_values ) {
				$out = '';
				$out .= '<div class="labora-chart' . esc_attr( $labora_extra_css ) . '">';
				$out .= '<canvas id="' . esc_attr( $labora_unique_chartid ) . '"></canvas>';
				if ( 'yes' != $legend ) {
					$out .= '<ul class="labora-chart-legend">';
					foreach ( $labora_data['datasets'] as $val ) {
						$colors = is_array( $val['pointColor'] ) ? current( $val['pointColor'] ) : $val['pointColor'];
						$out .= '<li><span style="background-color:' . esc_attr( $colors ) . '"></span>' . esc_html( $val['label'] ) . '</li>';
					}
					$out .= '</ul>';
				}
				$out .= '</div>'; ?>
				<script type="text/javascript">
					jQuery(window).on('load', function ($) {
						var <?php echo esc_js( $labora_unique_chartid ); ?> = jQuery("#<?php echo esc_js( $labora_unique_chartid ); ?>").get(0).getContext("2d");
						<?php echo esc_js( $labora_unique_chartid ); ?>.canvas.width = <?php echo esc_js( $inline_style['width'] ); ?>;
						<?php echo esc_js( $labora_unique_chartid ); ?>.canvas.height = <?php echo esc_js( $inline_style['height'] ); ?>;
						<?php
						switch ( $chart_data ) {
							case 'line':
							?>
							var ChartData_<?php echo esc_js( $labora_unique_chartid ); ?> = <?php echo wp_json_encode( $labora_data ); ?>;
							new Chart(<?php echo esc_js( $labora_unique_chartid ); ?>).Line(ChartData_<?php echo esc_js( $labora_unique_chartid ); ?>, {
								responsive: false
							});
							<?php
							break;
							case 'bar':
							?>
							var ChartData_<?php echo esc_js( $labora_unique_chartid ); ?> = <?php echo wp_json_encode( $labora_data ); ?>;
							new Chart(<?php echo esc_js( $labora_unique_chartid ); ?>).Bar(ChartData_<?php echo esc_js( $labora_unique_chartid ); ?>, {
								responsive: false
							});
							<?php
							break;
							case 'pie':
							?>
							var ChartData_<?php echo esc_js( $labora_unique_chartid ); ?> = <?php echo wp_json_encode( $labora_data['datasets'] ); ?>;
							new Chart(<?php echo esc_js( $labora_unique_chartid ); ?>).Pie(ChartData_<?php echo esc_js( $labora_unique_chartid ); ?>, {
								responsive: false,
								segmentShowStroke: false
							});
							<?php
							break;
							case 'circle':
							?>
							var ChartData_<?php echo esc_js( $labora_unique_chartid ); ?> = <?php echo wp_json_encode( $labora_data['datasets'] ); ?>;
							new Chart(<?php echo esc_js( $labora_unique_chartid ); ?>).Doughnut(ChartData_<?php echo esc_js( $labora_unique_chartid ); ?>, {
								responsive: false,
								barShowStroke : true
							});
							<?php
							break;
							default:
						}
						?>
					});
				</script>
			<?php return $out;
			}
		}
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Charts' ) ) {
		$labora_vc_charts = new Labora_VC_Charts;
	}
	class WPBakeryShortCode_labora_vc_charts extends WPBakeryShortCode {
	}
}
