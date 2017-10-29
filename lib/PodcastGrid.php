<?php

class PodcastGrid
{

    private function __construct()
    {

    }

    public static function getGrid()
    {
        return (new self())->getTemplate();
    }

    private function getTemplate()
    {
        ob_start();
        set_query_var('podcasts', $this->podcasts());
        get_template_part('lib/templates/podcast-grid');
        return ob_get_clean();
    }

    private function podcasts()
    {
        if (is_archive())
            return $this->byTaxonomy($this->getTerm());

        return $this->getPodcasts();
    }


    function byTaxonomy(WP_Term $wpTerm)
    {
        return get_posts([
            'orderby' => 'date',
            'order' => 'DESC',
            'category_name' => '',
            'post_type' => 'podcast',
            'post_status' => 'publish',
            'numberposts' => 15,
            'tax_query' => [
                [
                    'taxonomy' => $wpTerm->taxonomy,
                    'field' => 'slug',
                    'terms' => $wpTerm->slug
                ]
            ]
        ]);
    }

    private function getPodcasts()
    {
        return get_posts([
            'orderby' => 'date',
            'order' => 'DESC',
            'category_name' => '',
            'post_type' => 'podcast',
            'post_status' => 'publish',
            'numberposts' => 15,

        ]);
    }

    private function getTerm()
    {
        return get_queried_object();
    }
}

add_shortcode('podcast_grid', ['PodcastGrid', 'getGrid']);
