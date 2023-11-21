<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', '8096acc79ae64224c07f33f0e95bea7977934aca34c73984');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'KfX]A#w$yt>@|0y/}u}qfV45#XSMXRl;l%s`!*+X|s;W,GD5%=@M9`j8W/Fw0fBN');
define('SECURE_AUTH_KEY',  ',jH2gzH$MQmp s[>Z|.Aw?sUkkQePt]<]Abn*g4BWyD.7rhPP~KXF]x59^rHb5`&');
define('LOGGED_IN_KEY',    'cb~3J9y6N~Om(D4kfi62@c:cQ>H!hcX_*p@jhdxATCtl.Ks*T/2=@.8rQVEV.PBx');
define('NONCE_KEY',        'WG%zvHH;@S}+z^f#@l.X{-34q_G@RtXkfA/%uOzyB:awU`-4zistqEQ2Cq<hH]U+');
define('AUTH_SALT',        ':HhQ*E))[;fmPUO/O7S =UocftM2]N!d@*l=vcdMHYp~RifDBZuPtU,AX%7T?qH_');
define('SECURE_AUTH_SALT', ')? ?3bt$Nu)IA[y+Ug>(_6L9]?0My2?~5FJmBKzSYzkn;r,wfS0k?YE5&3({xZJM');
define('LOGGED_IN_SALT',   'aPA+aXeb;!FZkX6%s8W_wRGSVmK_h<aiKs`qu^Y$Mwt[ca[;&6R<[n[.9&r~i@;e');
define('NONCE_SALT',       '~[{B2;[c;u55pAA2|4=_J>/21>&mJvNAvWps *,rPLT>T(r. }KlzYbPIIN2? *4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define( 'FS_METHOD', 'direct' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
