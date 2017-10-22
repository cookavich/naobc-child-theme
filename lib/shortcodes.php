<?php

/**
 * Outputs the current year
 * @param $atts
 * @return bool|string
 */
function current_year( $atts ){
    return date("Y");
}
add_shortcode( 'year', 'current_year' );

/**
 * Returns the Enfold breadcrumb in a shortcode
 * @return mixed
 */
function enfold_customization_breadcrumb(){
    global $avia_config;

    if(!$id) $id = avia_get_the_id();

    $header_settings = avia_header_setting();

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
//    $args['breadcrumb'] = true;

    //disable title if requested
//    $args['title'] = true;

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
add_shortcode( 'bread_crumb', 'enfold_customization_breadcrumb' );