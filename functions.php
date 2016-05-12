<?php
/*
 *  Author: Framework | @Framework
 *  URL: wordfly.com | @wordfly
 *  Custom functions, support, custom post types and more.
 */

// Theme setting
require_once('init/theme-init.php');
require_once('init/options/option.php');

// Custom for theme

function wf_conditional_scripts() {
  wp_register_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0');
  wp_enqueue_script('script');
}
add_action('wp_print_scripts', 'wf_conditional_scripts');

function wf_styles() {
  wp_register_style('custom-style', get_template_directory_uri() . '/stylesheet/css/customs.css', array(), '1.0', 'all');
  wp_enqueue_style('custom-style');
}
add_action('wp_enqueue_scripts', 'wf_styles');

/* Enable Function */
function wf_menu() {
  register_nav_menus();
}
add_action('init', 'wf_menu');

function wf_setup() {
  add_theme_support( 'custom-logo', array(
    'flex-width' => true,
  ) );
}
add_action( 'after_setup_theme', 'wf_setup' );

add_theme_support( 'post-thumbnails' );

/* Add Dynamic Siderbar */
if (function_exists('register_sidebar')) {
  // Define Sidebar Widget Area 1
  register_sidebar(array(
    'name' => __('Sidebar one'),
    'description' => __('Description for this widget-area...'),
    'id' => 'sidebar-1',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

/* Add custom new widget arena */
add_action( 'widgets_init', 'create_wf_Widget' );
function create_wf_Widget() {
  register_widget('wf_Widget');
}

class wf_Widget extends WP_Widget {
  /**
   * Setting widget: name, base ID
   */
  function __construct() {
    parent::__construct (
      'wf_widget', // widget ID
      'WF Widget', // widget name
      array(
        'description' => '' // décription
      )
    );
  }
  /**
   * Create form option for widget
   */
  function form( $instance ) {
    parent::form( $instance );
    // Default value on form
    $default = array(
      'title' => ''
    );
    $instance = wp_parse_args( (array) $instance, $default);
    // Create each value for each default value on $default array
    $title = esc_attr( $instance['title'] );
    // Display form option of widget
    echo 'Title <input class="widefat" type="text" name="'.$this->get_field_name('title').'" value="'.$title.'" />';
  }
  /**
   * save widget form
   */
  function update( $new_instance, $old_instance ) {
    parent::update( $new_instance, $old_instance );
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }
  /**
   * Show widget
   */
  function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters( 'widget_title', $instance['title'] );
    echo $before_widget;
    echo $before_title.$title.$after_title;
    echo $after_widget;
  }
}

/* Add custom post type */
function create_my_post_types() {
  register_post_type( 'movies', 
    array(
      'labels' => array(
        'name' => __( 'Movie' ),
        'singular_name' => __( 'Movie' )
      ),
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'comments',
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_my_post_types' );
?>
