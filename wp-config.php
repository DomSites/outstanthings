<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'outstanthings' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '8_TgC;;5H36]H^IB?Ab:w*Uyb$=#yQPPd_Kg)l!]?jlmnjyGUxe7 -_n}+<G!M,@' );
define( 'SECURE_AUTH_KEY',  '*{6Ged273b.NZ`yVJ_f@IaXF57vGgsFHc-FlvZ!; }W>Hin1JE#&,zB-QoVPJ?RX' );
define( 'LOGGED_IN_KEY',    'KD2!l%o%K|,9^6s,m^Tr>$&{FLZZTPC5jL$VGj`>:=G=[umMuCtkj[%=+ZhIF,C^' );
define( 'NONCE_KEY',        ' f-0PnCc6Q>_[`y/;DMn8/=b.kFur?{J`#0BX;cMj95+ +BzD&)u5-q3e:A?)gP=' );
define( 'AUTH_SALT',        'e|UR@lx!n1YMPw7]surTtuk}w]9$f]s3PAup0=e3$<H&Q{4T:?C71D7%4~7*q7p[' );
define( 'SECURE_AUTH_SALT', '_mBCYg[g:`_r/c$u?Hwbi9&/Xz@]sS8oazX3>;YHs!4s1}/|oFX|4YKmcF:cp$W?' );
define( 'LOGGED_IN_SALT',   'GyP~]UpoDw{/.UplAbJ!)=Ux *d;~elpMf)];WOU;=1WE*+gr6OX_hmX2U65JJWX' );
define( 'NONCE_SALT',       '`mD@nx];Q I}]U_)hEdt)j?haT2):+#U<!8C`7`,onk],$wK:)lu#E11Z$cT#]dU' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
