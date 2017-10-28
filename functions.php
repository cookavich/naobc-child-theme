<?php

require_once 'lib/shortcodes.php';
require_once 'lib/PodcastGrid.php';

/**
 * Adds custom class field to enfold page builder
 * Link Ref: http://www.kriesi.at/documentation/enfold/turn-on-custom-css-field-for-all-alb-elements/
 */
add_theme_support('avia_template_builder_custom_css');

function enqueue_custom_scripts() {
    wp_enqueue_script( 'header-border', get_stylesheet_directory_uri() . '/js/header-border.js', ['jquery'], true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );

/**
 * Changes the mobile menu icon to three solid lines
 */
add_filter('avf_default_icons', function($icons) {
    $icons['mobile_menu'] = array( 'font' =>'entypo-fontello', 'icon' => 'ue811');
    return $icons;
}, 10, 1);

/**
 * Overwrites the avia_title method in functions-enfold.php so we can change the breadcrumb separator
 * @param bool $args
 * @param bool $id
 * @return mixed|string
 */
function avia_title($args = false, $id = false)
{
    global $avia_config;

    if(!$id) $id = avia_get_the_id();

    $header_settings = avia_header_setting();
    if($header_settings['header_title_bar'] == 'hidden_title_bar') return "";

    $defaults 	 = array(

        'title' 		=> get_the_title($id),
        'subtitle' 		=> "", //avia_post_meta($id, 'subtitle'),
        'link'			=> get_permalink($id),
        'html'			=> "<div class='{class} title_container'><div class='container'><{heading} class='main-title entry-title'>{title}</{heading}>{additions}</div></div>",
        'class'			=> 'stretch_full container_wrap alternate_color '.avia_is_dark_bg('alternate_color', true),
        'breadcrumb'	=> true,
        'additions'		=> "",
        'heading'		=> 'h1' //headings are set based on this article: http://yoast.com/blog-headings-structure/
    );

    if ( is_tax() || is_category() || is_tag() )
    {
        global $wp_query;

        $term = $wp_query->get_queried_object();
        $defaults['link'] = get_term_link( $term );
    }
    else if(is_archive())
    {
        $defaults['link'] = "";
    }


    // Parse incomming $args into an array and merge it with $defaults
    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters('avf_title_args', $args, $id);

    //disable breadcrumb if requested
    if($header_settings['header_title_bar'] == 'title_bar') $args['breadcrumb'] = false;

    //disable title if requested
    if($header_settings['header_title_bar'] == 'breadcrumbs_only') $args['title'] = '';


    // OPTIONAL: Declare each item in $args as its own variable i.e. $type, $before.
    extract( $args, EXTR_SKIP );

    if(empty($title)) $class .= " empty_title ";
    $markup = avia_markup_helper(array('context' => 'avia_title','echo'=>false));
    if(!empty($link) && !empty($title)) $title = "<a href='".$link."' rel='bookmark' title='".__('Permanent Link:','avia_framework')." ".esc_attr( $title )."' $markup>".$title."</a>";
    if(!empty($subtitle)) $additions .= "<div class='title_meta meta-color'>".wpautop($subtitle)."</div>";
    if($breadcrumb) $additions .= avia_breadcrumbs(array('separator' => '>', 'richsnippet' => true));


    $html = str_replace('{class}', $class, $html);
    $html = str_replace('{title}', $title, $html);
    $html = str_replace('{additions}', $additions, $html);
    $html = str_replace('{heading}', $heading, $html);



    if(!empty($avia_config['slide_output']) && !avia_is_dynamic_template($id) && !avia_is_overview())
    {
        $avia_config['small_title'] = $title;
    }
    else
    {
        return $html;
    }
}