<?php

/**
* Plugin Name: Stop Propaghate Custom Functions Plugin
* Description: Custom functions for the Stop Propaghate Theme.
* Author: Tiago Devezas
* Version: 0.1
*/

add_action( 'widgets_init', 'sph_init' );

function sph_init() {
  register_widget( 'sph_team_member_widget' );
}

class sph_team_member_widget extends WP_Widget
{

    public function __construct()
    {
        $widget_details = array(
            'classname' => 'sph_team_member_widget',
            'description' => 'Creates a team member item consisting of a title, image and description.'
        );

        parent::__construct( 'sph_team_member_widget', 'Team Member Widget', $widget_details );

        add_action('admin_enqueue_scripts', array($this, 'sph_assets'));
    }


public function sph_assets()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('sph-media-upload', plugin_dir_url(__FILE__) . 'sph-media-upload.js', array('jquery'));
    wp_enqueue_style('thickbox');
}


    public function widget( $args, $instance )
    {
    echo $args['before_widget'];
    ?>

    <img src='<?php echo $instance['image'] ?>' class='team-member-image dib ba b--black-05 pa1' style="max-width: 190px;">

    <?php
    if ( ! empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
    }
    ?>
    
    <div class='sph-description f5 fw4 gray mt0 mw5 center'>
      <?php echo wpautop( esc_html( $instance['description'] ) ) ?>
    </div>


    <?php

    echo $args['after_widget'];
    }

  public function update( $new_instance, $old_instance ) {  
      return $new_instance;
  }

    public function form( $instance )
    {

    $title = '';
      if( !empty( $instance['title'] ) ) {
          $title = $instance['title'];
      }

      $description = '';
      if( !empty( $instance['description'] ) ) {
          $description = $instance['description'];
      }

    $image = '';
    if(isset($instance['image']))
    {
        $image = $instance['image'];
    }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Name:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" ><?php echo esc_attr( $description ); ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="upload_image_button" type="button" value="Upload Image" />
        </p>
    <?php
    }
}

// Register custom widget areas
function stop_propaghate_theme_register_custom_widgets_area() {
  register_sidebar( array(
    'name'          => esc_html__( 'Team (Active Members)', 'stop-propaghate-theme' ),
    'id'            => 'team-1',
    'description'   => esc_html__( 'Add Team Member Widgets here.', 'stop-propaghate-theme' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s w-100 w-33-ns pa2">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title f3 mb2 mt0">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Team (Inactive Members)', 'stop-propaghate-theme' ),
    'id'            => 'team-2',
    'description'   => esc_html__( 'Add Team Member Widgets here.', 'stop-propaghate-theme' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s w-100 w-33-ns pa2">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title f3 mb2 mt0">',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'stop_propaghate_theme_register_custom_widgets_area' );

// Add custom CSS classes to the menu list items
function add_class_to_menu_li($classes, $item, $args) {
  if($args->theme_location == 'menu-sph') {
    $classes[] = 'dib link';
  }
  return $classes;
}
add_filter( 'nav_menu_css_class', 'add_class_to_menu_li', 1, 3 );


// Add custom CSS classes to the menu list links
function add_class_to_menu_li_a($attrs, $item, $args) {
  $class = 'f4 fw7 dib pa2 no-underline bg-animate bg-white hover-bg-dark-red black hover-white ml2';
  $attrs['class'] = $class;
  return $attrs;
}
add_filter( 'nav_menu_link_attributes', 'add_class_to_menu_li_a', 1, 3 );


// Create and register custom post types
// function create_custom_posts_types() {
//   register_post_type( 'team-member',
//     array(
//       'labels' => array(
//         'name' => __( 'Team Member' ),
//         'add_new_item' => 'Add New Team Member'
//       ),
//       'public' => true,
//       'has_archive' => false,
//       'supports' => array(
//         'title',
//         'editor',
//         'thumbnail',
//         'custom-fields'
//       )
//     )
//   );
// }

// add_action( 'init', 'create_custom_posts_types' );

// Show select custom post types on home page
// function add_my_post_types_to_query( $query ) {
//   if ( is_home() && $query->is_main_query() )
//     $query->set( 'post_type', array( 'team-member' ) );
//   return $query;
// }
// add_action( 'pre_get_posts', 'add_my_post_types_to_query' );


?>