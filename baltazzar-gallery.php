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

// Register Custom Post Type
function agencia_posttypes() {
// echo plugin_dir_path();
	$labels = array(
		'name'                => _x( 'Galerias', 'Post Type General Name', 'agencia_posttypes' ),
		'singular_name'       => _x( 'Galeria', 'Post Type Singular Name', 'agencia_posttypes' ),
		'menu_name'           => __( 'Galeria', 'agencia_posttypes' ),
		'parent_item_colon'   => __( 'Galeria Pai:', 'agencia_posttypes' ),
		'all_items'           => __( 'Todas as Galerias', 'agencia_posttypes' ),
		'view_item'           => __( 'Visualizar Galeria', 'agencia_posttypes' ),
		'add_new_item'        => __( 'Adicionar nova galeria', 'agencia_posttypes' ),
		'add_new'             => __( 'Nova', 'agencia_posttypes' ),
		'edit_item'           => __( 'Editar', 'agencia_posttypes' ),
		'update_item'         => __( 'Atualizar', 'agencia_posttypes' ),
		'search_items'        => __( 'Procurar', 'agencia_posttypes' ),
		'not_found'           => __( 'Não encontrada', 'agencia_posttypes' ),
		'not_found_in_trash'  => __( 'Não encontrada na lixeira', 'agencia_posttypes' ),
	);
	$args = array(
		'label'               => __( 'galeria', 'agencia_posttypes' ),
		'description'         => __( 'Galeria de fotos', 'agencia_posttypes' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-gallery',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'galeria', $args );
}

// Hook into the 'init' action
add_action( 'init', 'agencia_posttypes', 0 );


// function be_gallery_metabox_page_and_rotator( $post_types ) {
// 	return array( 'galeria' );
// }
// add_action( 'be_gallery_metabox_post_types', 'be_gallery_metabox_page_and_rotator' );


// add_filter('images_cpt','my_image_cpt');
// function my_image_cpt(){
//     $cpts = array('galeria');
//     return $cpts;
// }

remove_shortcode('gallery');
add_shortcode('gallery', 'parse_gallery_shortcode');
function parse_gallery_shortcode($atts) {
 
    global $post;
 
    if ( ! empty( $atts['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $atts['orderby'] ) )
            $atts['orderby'] = 'post__in';
        $atts['include'] = $atts['ids'];
    }
 
    extract(shortcode_atts(array(
        'orderby' => 'menu_order ASC, ID ASC',
        'include' => '',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'medium',
        'link' => 'file'
    ), $atts));
 
 
    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'post_mime_type' => 'image',
        'orderby' => $orderby
    );
 
    if ( !empty($include) )
        $args['include'] = $include;
    else {
        $args['post_parent'] = $id;
        $args['numberposts'] = -1;
    }
 
    $images = get_posts($args);
    
    echo '<div class="pms-galeria" itemscope itemtype="http://schema.org/ImageGallery">';
    foreach ( $images as $image ) {     
        $caption = $image->post_excerpt;
 
        $description = $image->post_content;
        if($description == '') $description = $image->post_title;
 
        $image_alt = get_post_meta($image->ID,'_wp_attachment_image_alt', true);
 		$image_attributes_full = wp_get_attachment_image_src($image->ID, 'full');
 		$image_attributes_medium = wp_get_attachment_image_src($image->ID, $size);
 		// render your gallery here 

        echo '<a href="'. $image->guid . '" itemprop="contentUrl" data-size="' . $image_attributes_full[1] . 'x' . $image_attributes_full[2] .'" class="Image_Wrapper" data-caption="' . $caption . '">';
        //echo  wp_get_attachment_image($image->ID, $size);
		echo  '<img src="' . $image_attributes_medium[0] . '" width="' . $image_attributes_medium[1]  . '" height="' . $image_attributes_medium[2]  . '">';
		echo '<span itemprop="caption description" style="display: none;">' . $caption . '</span>';
        
        echo '</a>';
    }
	echo '</div>';

    include(PMS_GALERIA_PATH . 'init.php');
}

function pms_galeria_enqueues()
{
    wp_register_style('photoswipe-css', PMS_GALERIA_BASE_URL . '/css/photoswipe.css', false, null);
    wp_enqueue_style('photoswipe-css');

    wp_register_style('photoswipe-ui-css', PMS_GALERIA_BASE_URL . '/css/default-skin/default-skin.css', false, null);
    wp_enqueue_style('photoswipe-ui-css');

    wp_register_style('galeria-css', PMS_GALERIA_BASE_URL . '/css/main.css', false, null);
    wp_enqueue_style('galeria-css');

    wp_register_style('collage-plus-css', PMS_GALERIA_BASE_URL . '/css/collagePlus.css', false, null);
    wp_enqueue_style('collage-plus-css');
}
add_action('wp_enqueue_scripts', 'pms_galeria_enqueues', 100);

?>
