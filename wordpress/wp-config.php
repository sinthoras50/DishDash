<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         '4{<Vr+!WktEk:j}<A+% 4V2z`6Iv&vmX1V.^&lUH-bhr>Q}vEqLg.y9LQfM@nPxj' );
define( 'SECURE_AUTH_KEY',  ';HMR<0V#-v(Bn{?f9LnA?2NF=F<XD<Qv(b%rlyx4Oke,5AZ3v u#1*JnYX?iGy#b' );
define( 'LOGGED_IN_KEY',    'Ri<68ytiQKr|2{Z2T[c;$N)Vd8)*?_xt0?/&v.N}]J<PkTju^/LGu+bvc9zZcfLC' );
define( 'NONCE_KEY',        'Bkogt3evdnn44AS03kxuK<KTT!d]^A -<}Cbf}Ku+favhlOtCn=&oi}#88hs:*H{' );
define( 'AUTH_SALT',        '>j_,xu0r&[]7TV(pItG58]>Wf.9(!=zHad ro+lpfV[5pG!5/jx=i1?m}Ltgm;~*' );
define( 'SECURE_AUTH_SALT', '(:!j6085xHhjPAoY.o?A>7sW/WzKBZ15V7Xh{c-v1hgj$s4&)9mg&l_8fchzFcTC' );
define( 'LOGGED_IN_SALT',   '{FjpKvg=Pb@t Z<3HA-7DDL4|Xb=5+O=ca%b)7#?ptQ$i#^XIwna-PFI!o!]4dD>' );
define( 'NONCE_SALT',       'iy2b08Z]-G3/M[jI,yLmBu<+tk~ylm]C*sffDZ4WR|[o?^SGHtD-;#9j?;KFB$vw' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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


