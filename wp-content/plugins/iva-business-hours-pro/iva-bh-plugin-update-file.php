<?php
/**
* Class IvaBizZip
*/
if ( ! class_exists( 'IvaBizZip' ) ) {
	class IvaBizZip {
		private $zip;
		public static function is_zip_exists() {
			$exists = class_exists( 'ZipArchive' );
			return $exists;
		}
		public function extract( $src, $dest ) {
			$zip = new ZipArchive;
			if ( $zip->open( $src ) == true ) {
				$zip->extractTo( $dest );
				$zip->close();
				return true;
			}
			return false;
		}
	}
}

/**
 * function iva_bh_throw_error
 * throws error message
 */
if ( ! function_exists( 'iva_bh_throw_error' ) ) {
	function iva_bh_throw_error( $message ) {
		throw new Exception( $message );
	}
}

/**
 * function iva_bh_check_create_dir
 * checks directory exist or not
 * if not it creates directory
 */
if ( ! function_exists( 'iva_bh_check_create_dir' ) ) {
	function iva_bh_check_create_dir( $dir ) {
		if ( ! is_dir( $dir ) ) { mkdir( $dir ); }
		if ( ! is_dir( $dir ) ) { return "Could not create directory: $dir"; }
	}
}

/**
 * function iva_bh_copy_dir
 * copys directory
 */
if ( ! function_exists( 'iva_bh_copy_dir' ) ) {
	function iva_bh_copy_dir( $path, $dest ) {
		if ( is_dir( $path ) ) {
			@mkdir( $dest );
			$objects = scandir( $path );
			if ( count( $objects ) > 0 ) {
				foreach ( $objects as $file ) {
					if ( '.' == $file || '..' == $file ) { continue; }

					// go on
					if ( is_dir( $path . '/' . $file ) ) {
						iva_bh_copy_dir( $path . '/' . $file, $dest . '/' . $file );
					} else {
						@copy( $path . '/' . $file, $dest . '/' . $file );
					}
				}
			}
			return true;
		} elseif ( is_file( $path ) ) {
			return copy( $path, $dest );
		} else {
			return false;
		}
	}
}

/**
 * function iva_bh_delete_dir
 * deletes directory
 */
if ( ! function_exists( 'iva_bh_delete_dir' ) ) {
	function iva_bh_delete_dir( $str ) {
		if ( is_file( $str ) ) { return @unlink( $str );
		} elseif ( is_dir( $str ) ) {
			$scan = glob( rtrim( $str,'/' ) . '/*' );
			if ( ! empty( $scan ) ) {
				foreach ( $scan as $index => $path ) {
					iva_bh_delete_dir( $path );
				}
			}
			return @rmdir( $str );
		}
	}
}

/**
* function iva_bh_update_plugin
* Updates the plugin
*/
add_action( 'wp_ajax_iva_bh_ajax_action', 'iva_bh_update_plugin' );
add_action( 'wp_ajax_nopriv_iva_bh_ajax_action', 'iva_bh_update_plugin' );
function iva_bh_update_plugin() {
	// Creates Zip Class Object
	$iva_bh_zip = new IvaBizZip();

	try {
		if ( function_exists( 'unzip_file' ) == false ) {
			if ( IvaBizZip::is_zip_exists() == false ) {
				iva_bh_throw_error( esc_html__( 'The ZipArchive php extension not exists, can\'t extract the update file. Please turn it on in php ini.','iva_business_hours' ) );
			}
		}
		echo esc_html__( 'Update in progress...','iva_business_hours' );

		// If update files empty returns error
		if ( empty( $_FILES ) ) {
			iva_bh_throw_error( esc_html__( 'Update file not found.','iva_business_hours' ) );
		}

		// Current Plugin main file path
		$iva_bh_main_file 			= IVA_BH_PATH . '/iva-business-hours-pro/';

		// Update file path info
		$iva_bh_file_name 			= $_FILES['iva_bh_update_file']['name'];
		$iva_bh_file_temp_path 		= $_FILES['iva_bh_update_file']['tmp_name'];
		$iva_bh_file_type 			= $_FILES['iva_bh_update_file']['type'];

		// Current Plugin path
		$iva_bh_plugin_path 		= dirname( $iva_bh_main_file ) . '/';

		// Current Plugin temporary path
		$iva_bh_plugin_temp_path 	= $iva_bh_plugin_path . 'temp/';

		// Current Plugin path info
		$iva_bh_plugin_file_info		= pathinfo( $iva_bh_main_file );
		$iva_bh_plugin_file_basename 	= $iva_bh_plugin_file_info['basename'];
		$iva_bh_plugin_file_name 		= str_replace( '.php','',$iva_bh_plugin_file_basename );

		// checks uploaded file is not empty
		if ( empty( $iva_bh_file_name ) ) {
			iva_bh_throw_error( esc_html__( 'You have not selected a file to upload, please select a file.','iva_business_hours' ) );
		}

		// Checks uploaded file is zip file or not
		$iva_bh_upload_file_ext = pathinfo( $iva_bh_file_name, PATHINFO_EXTENSION );
		if ( 'zip' != $iva_bh_upload_file_ext ) {
			iva_bh_throw_error( esc_html__( 'Uploaded file is not a zip file, Select zip file and upload.','iva_business_hours' ) );
		}

		// Checks temporary folder is exist or not
		if ( file_exists( $iva_bh_file_temp_path ) == false ) {
			iva_bh_throw_error( esc_html__( 'Cannot find the update files','iva_business_hours' ) );
		}

		// Crates temporary folder
		iva_bh_check_create_dir( $iva_bh_plugin_temp_path );

		// Copys the zip file.
		$iva_bh_zip_filepath = $iva_bh_plugin_temp_path . $iva_bh_file_name;

		// Moves the zip file.
		$iva_bh_success = move_uploaded_file( $iva_bh_file_temp_path, $iva_bh_zip_filepath );

		// If success
		if ( false == $iva_bh_success ) {
			iva_bh_throw_error( "Can't move the update files here: {$iva_bh_zip_filepath}." );
		}

		if ( function_exists( 'unzip_file' ) == true ) {
			WP_Filesystem();
			$response = unzip_file( $iva_bh_zip_filepath, $iva_bh_plugin_temp_path );
		} else {
			$iva_bh_zip->extract( $iva_bh_zip_filepath, $iva_bh_plugin_temp_path );
		}

		// Scans update file and returns all files
		$iva_bh_tmp_dir_files = scandir( $iva_bh_plugin_temp_path );
		$iva_bh_extracted_files = array();
		foreach ( $iva_bh_tmp_dir_files as $file ) {
			if ( '.' == $file || '..' == $file ) { continue; }
			// Uploaded file path
			$filepath = $iva_bh_plugin_temp_path . $file;
			// If update file is directory then returns extracted folder
			if ( is_dir( $filepath ) ) {
				$iva_bh_extracted_files[] = $file;
			}
		}

		// Gets extracted folder
		$iva_bh_extracted_folder = $iva_bh_extracted_files;

		if ( empty( $iva_bh_extracted_folder ) ) {
			iva_bh_throw_error( esc_html__( 'The update folder is not extracted','iva_business_hours' ) );
		}
		if ( count( $iva_bh_extracted_folder ) > 1 ) {
			iva_bh_throw_error( esc_html__( 'Extracted folders are more then 1. Please check the update file.','iva_business_hours' ) );
		}

		// Gets update folder
		$iva_bh_uploaded_folder = $iva_bh_extracted_folder[0];
		if ( empty( $iva_bh_uploaded_folder ) ) {
			iva_bh_throw_error( esc_html__( 'Wrong update folder.','iva_business_hours' ) );
		}

		// Checks if update folder is match the main plugin filename
		if ( $iva_bh_uploaded_folder != $iva_bh_plugin_file_name ) {
			iva_bh_throw_error( esc_html__( 'The update folder do not match the current plugin folder, please check the updated file.','iva_business_hours' ) );
		}

		// Update file path
		$iva_bh_update_file_path  = $iva_bh_plugin_temp_path . $iva_bh_uploaded_folder . '/';

		//check some file in folder to validate it's the real one:
		$iva_bh_check_filepath = $iva_bh_update_file_path . $iva_bh_uploaded_folder . '.php';

		if ( file_exists( $iva_bh_check_filepath ) == false ) {
			// delete the update file from temporary path
			iva_bh_delete_dir( $iva_bh_plugin_temp_path );

			//iva_bh_throw_error("The file: $iva_bh_uploaded_folder.php not found in update folder.");
			iva_bh_throw_error( esc_html__( 'Wrong update folder.','iva_business_hours' ) );
		}

		// Copy update files to destination folder
		iva_bh_copy_dir( $iva_bh_update_file_path, $iva_bh_plugin_path );

		// delete the update file from temporary path
		iva_bh_delete_dir( $iva_bh_plugin_temp_path );

		echo 'Plugin Updated Successfully and redirecting...';
		echo "<script>location.href='admin.php?page=iva-business-hours-pro'</script>";

	} catch ( Exception $e ) {
		$iva_bh_message  = $e->getMessage();
		$iva_bh_message .= '<br>' . esc_html__( 'Please update the plugin manually via the ftp','iva_business_hours' );
		echo '<div style="color:#ff0000;font-size:20px;"><b>' . esc_html__( 'Update Error:','iva_business_hours' ) . '</b>' . esc_html( $iva_bh_message ) . '</div><br>';
		echo '<a href="admin.php?page=iva-business-hours-pro">' . esc_html__( 'Go Back','iva_business_hours' ) . '</a>';
		exit();
	}
}
