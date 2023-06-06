<?php
// adding theme support
function luavo_theme_support(){
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}


add_action('after_setup_theme', 'luavo_theme_support');

function luavo_menus(){
    $locations = array(
        'primary' => "Desktop Primary Left Sidebar",
        'footer' => "Footer Menu Items",
    );

    register_nav_menus($locations);
}

add_action('init', 'luavo_menus');

// Enqueuing styles and scripts
function luavo_register_styles(){
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('luavo-style', get_template_directory_uri(). "/style.css", array('luavo-bootstrap'), '1.6.1.', 'all');
    wp_enqueue_style('luavo-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), "4.4.4", 'all');
    wp_enqueue_style('luavo-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), "5.13.0", 'all');
}

add_action('wp_enqueue_scripts', 'luavo_register_styles');




function luavo_register_scripts(){
   wp_enqueue_script('luavo-jquery', 'https://code.jquery.com/jquery-3.4.1.slim.min.js', array(), '3.4.1', true);
   wp_enqueue_script('luavo-bootstrap-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array(), '1.16.0', true);
   wp_enqueue_script('luavo-bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array(), '4.4.1', true);
   wp_enqueue_script('luavo-custom-js', get_template_directory_uri()."/assets/js/main.js", array(), '1.0', true);
}

add_action('wp_enqueue_scripts', 'luavo_register_scripts');



// walker class



// ====================
require get_template_directory() . '/template-parts/walker.php';



function luavo_widget_areas(){
    register_sidebar(
        array(
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Sidebar Area',
            'id' => 'sidebar-1',
            'description' => 'Sidebar Widget Area'
        
        ));


    register_sidebar(
        array(
            'before_title' => '',
            'after_title' => '',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Footer Area',
            'id' => 'footer-1',
            'description' => 'Footer Widget Area'
        )
    );

}

add_action('widgets_init', 'luavo_widget_areas');



// projects custom post 
function projects_init() {

    //setting up up labels required for our portfolio cpt 
    $labels = array(
    
        'name' => 'Projects',
        'singular_name' => 'Project',
        'add_new' => 'Add New Project',
        'add_new_item' => 'Add New Project',
        'edit_item' => 'Edit Project',
        'new_item,' => 'New Project',
        'all_items' => 'All Project',
        'view_item' => 'View this Project',
        'search_items' => 'Search Project',
        'not_found' => 'No Project Found',
        'not_found_in_trash' => 'No Project found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Projects',
    );
    
    // registering our projects post type
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'project'),
        'query_var' => true,
        'menu_icon' => 'dashicons-groups',
        'show_in_rest' => true,
        'supports' => array(
            'title',
     		'editor',
            'excerpt',
            'custom-fields',
            'revesions',
            'thumbnail',
            'page-attributes'
        )
    );
    
    
    // now to to initiate by calling the function
    register_post_type('project' , $args);
    
    //registering the category taxonomy 
    $args_cat = array(
        
        'hierarchical' => true,
        'label' => 'Project Category',
        'query_var' => true,
        'rewrite' => array('slug' => 'project-category')
     );
    register_taxonomy('project_category' , array('project'), $args_cat);
    
    
    }
    
    //now adding action hook of init with our fuction written 
    
    add_action('init' , 'projects_init');

// theme customizer options


function custom_theme_customizer($wp_customize) {
    // Add a new section for global color palette
    $wp_customize->add_section('global_colors', array(
      'title' => 'Global Color Palette',
      'priority' => 30
    ));
  
    // Define an array of color settings
    $color_settings = array(
      'primary_color' => 'Primary Color',
      'secondary_color' => 'Secondary Color',
      'accent_color' => 'Accent Color',
      'background-color' => 'Background Color',
      'fonts-color' => 'Fonts Color'
    );
  
    // Loop through the color settings and add controls
    foreach ($color_settings as $setting => $label) {
      $wp_customize->add_setting($setting, array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh'
      ));
  
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $setting, array(
        'label' => $label,
        'section' => 'global_colors',
        'settings' => $setting
      )));
    }
  }
  add_action('customize_register', 'custom_theme_customizer');


?>