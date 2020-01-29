<?php
$path 		= __FILE__;
$pathwp 	= explode( 'wp-content', $path );
$wp_url		= $pathwp[0];
require_once( $wp_url . '/wp-load.php' );
require_once( ABSPATH . '/wp-admin/includes/file.php' );
$iva_bhp_action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$iva_bhp_id = isset( $_GET['iva_bh_id'] )? $_GET['iva_bh_id'] : '';
if ( 'export_bhrs' == $iva_bhp_action ) {
	$iva_bh_sql 	= "SELECT * FROM $wpdb->iva_businesshours where id='" . $iva_bhp_id . "'" ;
	$iva_bh_results = $wpdb->get_row( $iva_bh_sql,ARRAY_A );
	$iva_bhp_data = wp_json_encode( $iva_bh_results );

	if ( class_exists( 'ZipArchive' ) ) {
		$zip = new ZipArchive;
		$zip_filename = sprintf( 'iva-bhp-export-%1$s.zip', date( 'Y-m-d-H-i-s' ) );
		$success = $zip->open( $zip_filename, ZipArchive::CREATE );
		if ( true !== $success ) {
			throwError( "Can't create zip file: " . $zip_filename );
		}
		$zip->addFromString( 'iva-bhp-export.txt', $iva_bhp_data );
		$open_img	= $iva_bh_results['open_image'];
		$close_img 	= $iva_bh_results['close_image'];
		$upload_dir = iva_bhp_upload_path();
		$upload_dir_multisiteless = wp_upload_dir();
		$uploads_url = $upload_dir_multisiteless['baseurl'];
		$uploads_url_no_www = str_replace( 'www.', '', $upload_dir_multisiteless['baseurl'] );

		if ( $open_img || $close_img ) {
			$open_img_checkpath = str_replace( array( $uploads_url, $uploads_url_no_www ), '', $open_img );
			$close_img_checkpath = str_replace( array( $uploads_url, $uploads_url_no_www ), '', $close_img );
			if ( is_file( $upload_dir . $open_img_checkpath ) || is_file( $upload_dir . $close_img_checkpath ) ) {
				$zip->addFile( $upload_dir . $open_img_checkpath,'images' . $open_img_checkpath );
				$zip->addFile( $upload_dir . $close_img_checkpath,'images' . $close_img_checkpath );
			}
		}
		$zip->close();
		header( 'Content-type: application/zip' );
		header( 'Content-Disposition: attachment; filename=' . $zip_filename );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
		readfile( $zip_filename );
		@unlink( $zip_filename );
		exit;
	}
}

/**
* function iva_bhp_import_hours
* imports hours
*/
add_action( 'wp_ajax_iva_bh_import_ajax_action', 'iva_bhp_import_hours' );
add_action( 'wp_ajax_nopriv_iva_bh_import_ajax_action', 'iva_bhp_import_hours' );
function iva_bhp_import_hours() {
	global $wpdb;
	// Creates Zip Class Object
	$iva_bh_zip = new IvaBizZip();
	$iva_bh_import_id = isset( $_POST['import_id'] ) ? $_POST['import_id'] : '';
	try {
		if ( function_exists( 'unzip_file' ) == false ) {
			if ( IvaBizZip::is_zip_exists() == false ) {
				iva_bh_throw_error( esc_html__( 'The ZipArchive php extension not exists, cannot extract the file. Please turn it on in php ini.','iva_business_hours' ) ) . '<br>';
			}
		}
		// If update files empty returns error
		if ( empty( $_FILES['iva_bh_import_file']['name'] ) ) {
			iva_bh_throw_error( esc_html__( 'Import file not found.','iva_business_hours' ) ) . '<br>';
		}

		$upload_dir_path = iva_bhp_upload_path();
		$iva_bh_file_name = $_FILES['iva_bh_import_file']['name'];
		$iva_bh_file_tmp_path = $_FILES['iva_bh_import_file']['tmp_name'];
		// Checks uploaded file is zip file or not
		$iva_bh_upload_file_ext = pathinfo( $iva_bh_file_name, PATHINFO_EXTENSION );
		if ( 'zip' != $iva_bh_upload_file_ext ) {
			iva_bh_throw_error( esc_html__( 'Uploaded file is not a zip file, Select zip file and upload.','iva_business_hours' ) ) . '<br>';
		}
		if ( function_exists( 'unzip_file' ) == true ) {
			WP_Filesystem();
			global $wp_filesystem;
			// Current Plugin temporary path
			$iva_bh_dir_destination_path = $upload_dir_path . '/iva-bhp-tmp/';
			$tmp_filename = basename( $iva_bh_file_tmp_path );
			$unzipfile = unzip_file( $iva_bh_file_tmp_path, $iva_bh_dir_destination_path );
			echo esc_html__( 'Import in progress...','iva_business_hours' ) . '<br>';
			if ( ! is_wp_error( $unzipfile ) ) {
				$impoort_content = ( $wp_filesystem->exists( $iva_bh_dir_destination_path . 'iva-bhp-export.txt' ) ) ? $wp_filesystem->get_contents( $iva_bh_dir_destination_path . 'iva-bhp-export.txt' ) : '';
				if ( '' == $impoort_content ) {
					iva_bh_throw_error( esc_html__( 'iva-bhp-export.txt does not exist!', 'iva_business_hours' ) ) . '<br>';
				} else {
					$iva_bhp_data  = json_decode( $impoort_content, true );
					$iva_bh_id = $iva_bhp_data['id'];
					$iva_bh_open_dir_path  = ! empty( $iva_bhp_data['open_image'] ) ? $iva_bhp_data['open_image'] : '';
					$iva_bh_close_dir_path = ! empty( $iva_bhp_data['close_image'] ) ? $iva_bhp_data['close_image'] : '';
					unset( $iva_bhp_data['id'] );
					if ( $iva_bh_import_id === $iva_bh_id ) {
						$iva_bh_update_query = $wpdb->update(
							$wpdb->iva_businesshours,
							$iva_bhp_data,
							array( 'id' => $iva_bh_id ),
							array( '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s' ),
							array( '%d' )
						);
						echo esc_html__( 'Updated Hours Successfully','iva_business_hours' ) . '<br>';
					} else {
						$iva_bh_alias = $iva_bhp_data['alias'];
						$iva_bh_alias_sql  = "SELECT alias FROM $wpdb->iva_businesshours";
						$iva_bh_result_row = $wpdb->get_col( $iva_bh_alias_sql );
						if ( ! empty( $iva_bh_result_row ) ) {
							if ( in_array( $iva_bh_alias, $iva_bh_result_row, true ) ) {
								iva_bh_throw_error( esc_html__( 'Record Exists.','iva_business_hours' ) ) . '<br>';
							}
						}
						$iva_bh_create_query = $wpdb->insert(
							$wpdb->iva_businesshours,
							$iva_bhp_data,
							array( '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s' )
						);
						$wpdb->insert_id;
						echo esc_html__( 'Created Hours Successfully.','iva_business_hours' ) . '<br>';
					}
					if ( ! empty( $iva_bh_open_dir_path ) ) {
							iva_bhp_import_media_files( $iva_bh_dir_destination_path, $iva_bh_open_dir_path );
					}
					if ( ! empty( $iva_bh_close_dir_path ) ) {
							iva_bhp_import_media_files( $iva_bh_dir_destination_path, $iva_bh_close_dir_path );
					}
				}
				$wp_filesystem->delete( $iva_bh_dir_destination_path, true );
				echo 'Import Hours Successfully and redirecting...';
				echo "<script>location.href='admin.php?page=iva-business-hours-pro'</script>";
			}
		}
	} catch ( Exception $error ) {
		$iva_bh_message  = $error->getMessage();
		echo '<div style="color:#ff0000;font-size:20px;"><b>' . esc_html__( 'Import Error:','iva_business_hours' ) . '</b>' . esc_html( $iva_bh_message ) . '</div><br>';
		echo '<a href="admin.php?page=iva-business-hours-pro">' . esc_html__( 'Go Back','iva_business_hours' ) . '</a>';
		exit();
	}
}

/**
* function iva_bhp_import_media_files
* imports media files
*/
function iva_bhp_import_media_files( $iva_bh_dir_destination_path, $file_url ) {
	global $wp_filesystem;
	$image = $wp_filesystem->exists( $iva_bh_dir_destination_path . 'images' );
	$iva_bhp_tmp_imgs_dir = $iva_bh_dir_destination_path . 'images';
	if ( ! $image ) {
		iva_bh_throw_error( esc_html__( 'Images directory not found!<br>', 'iva_business_hours' ) );
	} else {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$iva_bhp_upload_dir 		 = wp_upload_dir();
		$uploads_url 				 = $iva_bhp_upload_dir['baseurl'];
		$uploads_url_no_www 		 = str_replace( 'www.', '', $iva_bhp_upload_dir['baseurl'] );
		$iva_bhp_check_tmp_imgs_path = str_replace( array( $uploads_url, $uploads_url_no_www ), '', $file_url );
		$iva_bhp_check_imgs_path 	 = str_replace( array( $uploads_url, $uploads_url_no_www, 'iva-bhp-tmp' ), '', $file_url );
		if ( ! file_exists( $iva_bhp_upload_dir['basedir'] . $iva_bhp_check_imgs_path ) ) {
			if ( @fclose( @fopen( $iva_bhp_tmp_imgs_dir . $iva_bhp_check_tmp_imgs_path, 'r' ) ) ) {
				$iva_bhp_temp_imgs_dir = $iva_bhp_tmp_imgs_dir . $iva_bhp_check_tmp_imgs_path;
				$iva_bhp_save_imgs_dir = $iva_bhp_upload_dir['basedir'] . $iva_bhp_check_imgs_path;
				copy( $iva_bhp_temp_imgs_dir, $iva_bhp_save_imgs_dir );
				$iva_bhp_file_pathinfo = pathinfo( $file_url );
				$file_name 		= $iva_bhp_file_pathinfo['filename'];
				$file_info 		= getimagesize( $iva_bhp_save_imgs_dir );
				$post_date 		= current_time( 'mysql' );
				$post_date_gmt 	= get_gmt_from_date( $post_date );
				$iva_bhp_attach_data = array(
					'post_author' => 1,
					'post_date' => current_time( 'mysql' ),
					'post_date_gmt' => current_time( 'mysql' ),
					'post_title' => $file_name,
					'post_status' => 'inherit',
					'comment_status' => 'open',
					'ping_status' => 'closed',
					'post_name' => sanitize_title_with_dashes( str_replace( '_', '-', $file_name ) ),
					'post_modified' => $post_date,
					'post_modified_gmt' => $post_date_gmt,
					'post_type' => 'attachment',
					'guid' => $iva_bhp_upload_dir['baseurl'] . $iva_bhp_check_imgs_path,
					'post_mime_type' => $file_info['mime'],
				);
				$iva_bhp_attach_id = wp_insert_attachment( $iva_bhp_attach_data, $iva_bhp_upload_dir['baseurl'] . $iva_bhp_check_imgs_path );
				$save_path = $iva_bhp_upload_dir['basedir'] . $iva_bhp_check_imgs_path;
				if ( $attach_data = wp_generate_attachment_metadata( $iva_bhp_attach_id, $save_path ) ) {
					wp_update_attachment_metadata( $iva_bhp_attach_id, $attach_data );
			  	}
			}
		}
	}
}

/**
* function iva_bhp_upload_path
*/
function iva_bhp_upload_path() {
	global $wpdb;
	if ( is_multisite() ) {
		if ( ! defined( 'BLOGUPLOADDIR' ) ) {
			$upload_dir = ABSPATH . "wp-content/uploads/sites/{$wpdb->blogid}";
		} else {
			$upload_dir = BLOGUPLOADDIR;
		}
	} else {
		$upload_dir = WP_CONTENT_DIR;
		$upload_dir = ABSPATH . 'wp-content/uploads';
	}
	return $upload_dir;
}
