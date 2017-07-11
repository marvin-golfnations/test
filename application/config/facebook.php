<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


$config['facebook_app_id']              = '1561457630815890';
$config['facebook_app_secret']          = '11a4a6d1d9512a2fb5477f49151d6c5b';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'index.php/register';
$config['facebook_logout_redirect_url'] = 'index.php/login';
$config['facebook_permissions']         = array('public_profile', 'publish_actions', 'email');
$config['facebook_graph_version']       = 'v2.6';
$config['facebook_auth_on_load']        = TRUE;
?>
