<?php
function be_sample_metaboxes( $meta_boxes ) {
  $prefix = '_cmb_'; // Prefix for all fields
  $meta_boxes['landing_page_option'] = array(
    'id' => 'landing_page_option',
    'title' => 'Landing Page Options',
    'pages' => array('page'), // post type
    'context' => 'normal',
    'priority' => 'high',
    'show_names' => true, // Show field names on the left
    'fields' => array(
      array(
        'name' => 'Set landing page',
        'desc' => 'Check to set landing this page',
        'id' => $prefix . 'landing_page',
        'type' => 'checkbox'
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'be_sample_metaboxes' );

function framework_page($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb_' . $name, true );
  echo $value;
}
?>