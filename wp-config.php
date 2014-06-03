<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ulearn_blog');

/** MySQL database username */
define('DB_USER', 'ulearn_admin');

/** MySQL database password */
define('DB_PASSWORD', 'Pa22w0rd');

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
define('AUTH_KEY',         'U#Z#0:I%W,Qjx1/JQ=`Zv.uS$r>[7T1z>9:M[VyVK!>FltdHJ92sI&ohs9dL<CTW');
define('SECURE_AUTH_KEY',  'wU*u,S%C.gjCOw(nn(JZWHc1Quq9pVm-bP0F{5egqy&C>VXcJX;yw^me}/w5!yUD');
define('LOGGED_IN_KEY',    '+Wd5lf5&$/%!:yey7e@!q4r]]a$PoDHv+?7Ckn#|JLj4p+Y Sc@1PmD4w0ABI~DK');
define('NONCE_KEY',        '9{|pyybZ0<l_/GH2e=IM@l3gr)3:Ax|oV ;/%t7LX]!@)ybKb+sI.G=jLb}bH4+D');
define('AUTH_SALT',        '2zTq4 F)D)9%c~_A|^&77GE0Uvq[8d&-Gi~%_|bK-gp`n|7z NPoi`U;Iu1@S8c@');
define('SECURE_AUTH_SALT', 'pe=d#ihXJBZZ1-4-2DrE;[[6&~}Ja1K]bsYS/[oq<C,j&@Hv~sX[7:/e!w:CQA-M');
define('LOGGED_IN_SALT',   '+!iXDFo++?uZV{@ k&8Y/!wSE)~J@X8ak2T5VQZ6qD,xXjUhuL,~SBUJ|#_J$2|L');
define('NONCE_SALT',       'h?L.Q:Ri|6u-z Ew13DPy9,}1d?B8TKfva[)2+*>2kX7XEK{i)}>Sty7RX8(O$ %');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
?>