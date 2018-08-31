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
define('DB_NAME', 'db751798268');

/** MySQL database username */
define('DB_USER', 'dbo751798268');

/** MySQL database password */
define('DB_PASSWORD', '@Chica2018');

/** MySQL hostname */
define('DB_HOST', 'db751798268.db.1and1.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '9cB[?%d 4dqFn(>MD?)#^@4Idm_vN2IxOi_90XIFwg3{=cS &/uw!:x^hD_cKX=L');
define('SECURE_AUTH_KEY',  'uX8;:Bzv~Hjq+VsNwZwR;n9vJ@WE~t5zj#Ss^9`N*CHzLk.ZoXuo$S0R{OC)?f!c');
define('LOGGED_IN_KEY',    'I<CVBLD[d`&K#nM|.*)XScPZWcs$Y/X>xcoh7g`)LcOY>w[Rx2MQ-nuk/&`.MWM8');
define('NONCE_KEY',        'DEv^bhxZl]L`IdlX*?F09Vm>WX;<Nq7_Qrg5J3//i(V4d|qr=J.xy<YM 9HH#,},');
define('AUTH_SALT',        'j6U=JeuQgTj45ghH.]CsEuJ?unPZ$2=MKAfG+b+E$i;5V!YDw*ulq:@7*%uJO>]p');
define('SECURE_AUTH_SALT', '{J@9>aZ%# W-NI<SQ|-z*aB-bcIp@{X/Gg5OQaZa/@F-&^qJ9Q[r meJ>RR-(ZtP');
define('LOGGED_IN_SALT',   '4#e-huf]0  ;nxM_uaNPf>d`?e~D`M!BMDM__/l#Yu)_SBhD;-ZfK+gb5$34c]-/');
define('NONCE_SALT',       'GL>;Edy9ZH H92sjzfY/Zd{J_#,vbT|+{wZxR.R?9>8Ip9:I`#ddO~[CC_(NWi7n');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
