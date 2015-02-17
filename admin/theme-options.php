<?php

function my_acf_admin_head()
{
  ?>
  <div id="options-header">
    <h1>Hi</h1>
  </div>

  <style type="text/css">

    #options-header { display: none; }
    h1 { margin: 0;}

  </style>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      jQuery('#options-header').prependTo('.acf-settings-wrap');
      jQuery('.acf-settings-wrap #options-header').slideDown(0);
    });
    </script>

  <?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');



if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'icon_url'    => 'dashicons-images-alt2',
    'redirect'    => false
  ));
  acf_add_options_sub_page(array(
    'page_title'  => 'Theme Header Settings',
    'menu_title'  => 'Header',
    'parent_slug' => 'theme-general-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'  => 'Theme Footer Settings',
    'menu_title'  => 'Footer',
    'parent_slug' => 'theme-general-settings',
  ));
  
}


?>