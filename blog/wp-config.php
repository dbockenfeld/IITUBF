<?php
/** WordPress's config file **/
/** http://wordpress.org/   **/

// ** MySQL settings ** //
define('DB_NAME', 'iitubfdb');     // The name of the database
define('DB_USER', 'iitubf');     // Your MySQL username
define('DB_PASSWORD', 'Ps4lm6620'); // ...and password
define('DB_HOST', 'iitubfdb.iitubf.org');     // ...and the server MySQL is running on

// Change the prefix if you want to have multiple blogs in a single database.

$table_prefix  = 'wp_pxms8r_';   // example: 'wp_' or 'b2' or 'mylogin_'

// Change this to localize WordPress.  A corresponding MO file for the
// chosen language must be installed to wp-includes/languages.
// For example, install de.mo to wp-includes/languages and set WPLANG to 'de'
// to enable German language support.
define ('WPLANG', '');

/* Stop editing */

$server = DB_HOST;
$loginsql = DB_USER;
$passsql = DB_PASSWORD;
$base = DB_NAME;

define('ABSPATH', dirname(__FILE__).'/');
define('WP_ALLOW_MULTISITE', true);
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
$base = '/blog/';
define( 'DOMAIN_CURRENT_SITE', 'iitubf.org' );
define( 'PATH_CURRENT_SITE', '/blog/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

define( 'AUTH_KEY', '#}rIYT)4QHb<iE&x8{VN#V*{rM8g^B.2#Iq$YjTgUHuIOvtl-9qLj`1s5 4+doIS' );
define( 'SECURE_AUTH_KEY', '8#>7*E&sM|p?YYk<M,*iNo#=5{6FmR.]ld4!}d{?%OqE;s8 g2uz4qtNrXE_/zpS' );
define( 'LOGGED_IN_KEY', 'E|}H$L0]e4;1 V=|:skGmh.Xf>xn9/ao/7z-t^D+6CmA<uSRsmfp{l91lzkn$6Xy' );
define( 'NONCE_KEY', 'AX.-@xew+[.>B0++MF8u7/+vn]ZJX6^poBD~-syjgTMQLIS} =y+)K%e[A5[HJX?' );
define( 'AUTH_SALT', '6R2tD-o0V>>Di*goB$5PwGI?f0U@;|tHKIC,@s#![UEMaaKe<}.FhF(}8kF*PZ)P' );
define( 'SECURE_AUTH_SALT', '?u(|0Q8Byh9xz>Bl7+j*<j4Ho *OJoH&6ho|nWGuf[oqkNx|KQ=rh.+U.,SQWJe@' );
define( 'LOGGED_IN_SALT', '@bD1v|Oz0bWXGmMf~(uRstF_1#CWEIM7(7]eY:!v?+>J11|G6D+0zTE7fL|2L.Up' );
define( 'NONCE_SALT', 'o3A7dF1kwaj{_)aq-U5hZj^-oTc}`|G-v*~lSH+rL{pvv*|7|.3)y^`7d?+p $/q' );

// Get everything else
require_once(ABSPATH.'wp-settings.php');
?>