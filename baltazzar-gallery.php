<?php
/*
Plugin Name: BaltazZar Gallery
Description: Adiciona galeria de imagens ao site.
Author: Thiago Ribeiro, Renato Mestre, Leonardo Góes
Version: 1.0.2
Author URI: http://github.com/baltazzar
*/
define('PMS_GALERIA_PATH',  plugin_dir_path( __FILE__ ));
define("PMS_GALERIA_PLUGINPATH", "/" . dirname(plugin_basename( __FILE__ )));

define('PMS_GALERIA_TEXTDOMAIN', 'codestyling-localization');
define('PMS_GALERIA_BASE_URL', plugins_url(PMS_GALERIA_PLUGINPATH));

require 'includes/plugin-update-checker/plugin-update-checker.php';
$repoInfo = PucFactory::getLatestClassVersion('PucGitHubChecker');
$myUpdateChecker = new $repoInfo(
    'https://github.com/baltazzar/baltazzar-gallery/',
    __FILE__,
    'master'
);


function my_plugin_init() {
    if (!is_plugin_active('timber-library/timber.php')) {
        function my_admin_error_notice() {
            $class = "update-nag";
            $message = "A galeria precisa do plugin <a href=\"https://wordpress.org/plugins/timber-library/\">Timber</a> para funcionar adequadamente!";
            echo "<div class=\"$class\"> <p>$message</p></div>"; 
        }
        add_action( 'admin_notices', 'my_admin_error_notice' );

        return;
    } 
}
add_action( 'admin_init', 'my_plugin_init' );

require 'includes/functions.php';

?>
