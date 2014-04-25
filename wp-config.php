<?php
# Database Configuration
define('DB_NAME','smithsonian_current');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_HOST','127.0.0.1:3306');
// define('DB_HOST_SLAVE','localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
$table_prefix = 'wp2_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'B]UpNh xs@h~tj[+f :;a0@A)-H+&g(TgZ-{M$dT}xL*x>|t`Rpy,vZdXsYb^v `');
define('SECURE_AUTH_KEY',  'LR?h_y+Gr:B<kh_BzS9}O?:nc+VSGmMa`r7R:=6-Ur>l2HO|{F|c4=-P-Kj#bEYO');
define('LOGGED_IN_KEY',    'uez;aX-_8+C;/]P}/3+v]dmP-)+-&Cu&|?R,Mte;ug+eGQydj)k&^?)$~@g+5A%7');
define('NONCE_KEY',        '+hAmmEBm@/GI;h- uYe2tuy-i|9C+4.}61[kAYF93Vg%?1^gEW!)#M=DC&Z(j-lH');
define('AUTH_SALT',        '6+=uX#Mv hlqgT?@D-K-jS(|jsy`7J.D]LHp}A?(/7?DM@sp|P(kn+9 )#XG-}gt');
define('SECURE_AUTH_SALT', '9TSQFKN0T6/pgSAfr7i&1%EuzomO(+R}d]F^aK|tT;Fm]A_gZsaj$Y$_+--oSgKd');
define('LOGGED_IN_SALT',   ',#*+]kKk #ty{JAa](S-?(Ln1O0|T6C8Uej:4CEP:3pelNxhAwm<}:;0}+ T,}~]');
define('NONCE_SALT',       'e61VE;aVK%Pb,a:4::0-bhwxV*OR7 qc`&J`6/pt-y7WOE52gajbT|K|/Q~DNl#2');


# Localized Language Stuff

define('WP_CACHE',TRUE);

define('WP_AUTO_UPDATE_CORE',false);

define('PWP_NAME','smithson');

define('FS_METHOD','direct');

define('FS_CHMOD_DIR',0775);

define('FS_CHMOD_FILE',0664);

define('PWP_ROOT_DIR','/nas/wp');

define('WPE_APIKEY','4e02e68fbb862a7dc2f837de47a4d0535664aaca');

define('WPE_FOOTER_HTML',"");

define('WPE_CLUSTER_ID','19');

define('WPE_CLUSTER_TYPE','apache');

define('WPE_ISP',false);

define('WPE_BPOD',false);

define('WPE_RO_FILESYSTEM',false);

define('WPE_LARGEFS_BUCKET','largefs.wpengine');

define('WPE_CDN_DISABLE_ALLOWED',true);

define('DISALLOW_FILE_EDIT',FALSE);

define('DISALLOW_FILE_MODS',FALSE);

define('DISABLE_WP_CRON',false);

define('WPE_FORCE_SSL_LOGIN',false);

define('FORCE_SSL_LOGIN',false);

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define('WPE_EXTERNAL_URL',false);

define('WP_POST_REVISIONS',FALSE);

define('WPE_WHITELABEL','wpengine');

define('WP_TURN_OFF_ADMIN_BAR',false);

define('WPE_BETA_TESTER',false);

umask(0002);

$wpe_cdn_uris=array ();

$wpe_no_cdn_uris=array ();

$wpe_content_regexs=array ();

$wpe_all_domains=array (  0 => 'smithsonianchannel.dev',);

$wpe_varnish_servers=array (  0 => 'web-19-1',  1 => 'web-19-2',  2 => 'web-19-3',);

$wpe_special_ips=array (  0 => '66.155.36.246',  1 => '66.155.36.247',  2 => '66.155.36.248',);

$wpe_ec_servers=array ();

$wpe_largefs=array ();

$wpe_netdna_domains=array ();

$wpe_netdna_domains_secure=array ();

$wpe_netdna_push_domains=array ();

$wpe_domain_mappings=array ();

$memcached_servers=array (  'default' =>   array (    0 => '172.16.30.149:11211',  ),);

define('WPE_HYPER_DB','safe');
define ('WP_SITEURL', 'http://www.smithsonianchannel.dev');
define ('WP_HOME', 'http://www.smithsonianchannel.dev');
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
