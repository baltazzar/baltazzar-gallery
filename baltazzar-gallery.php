<?php
/*
Plugin Name: BaltazZar Gallery
Description: Adiciona galeria de imagens ao site.
Author: Thiago Ribeiro, Renato Mestre, Leonardo Góes
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


require 'includes/functions.php';

?>
