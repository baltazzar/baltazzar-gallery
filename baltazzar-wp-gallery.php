<?php
/*
Plugin Name: BaltazZar Gallery
Description: WordPress gallery with back-end and front-end interfaces developed by BaltazZar Team. Based on PhotoSwipe and CollagePlus.
Author: BaltazZar™
Version: 1.0.2
Author URI: http://github.com/baltazzar
*/
define('BTZ_GALLERY_PATH',  plugin_dir_path( __FILE__ ));
define("BTZ_GALLERY_PLUGINPATH", "/" . dirname(plugin_basename( __FILE__ )));
define('BTZ_GALLERY_TEXTDOMAIN', 'codestyling-localization');
define('BTZ_GALLERY_BASE_URL', plugins_url(BTZ_GALLERY_PLUGINPATH));

if(!defined('BTZ_CORE_PATH')) {
    add_action( 'admin_notices', 'my_admin_error_notice' );
    function my_admin_error_notice() {
        $class = "update-nag";
        $message = "O BaltazZar Gallery precisa do plugin <a href=\"https://github.com/baltazzar/baltazzar-wp-core/\">BaltazZar Core</a> para funcionar adequadamente!";
        echo "<div class=\"$class\"> <p>$message</p></div>"; 
    }
    return;
}

require BTZ_CORE_PATH . '/includes/plugin-update-checker/plugin-update-checker.php';
$repoInfo = PucFactory::getLatestClassVersion('PucGitHubChecker');
$myUpdateChecker = new $repoInfo(
    'https://github.com/baltazzar/baltazzar-wp-gallery/',
    __FILE__,
    'master'
);

require 'includes/functions.php';
?>
