<?php

class PodcastGrid
{

    private function __construct() {

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
            return $this->bySeries($this->getCategory());

        return $this->getPodcasts();
    }


    private function bySeries($series)
    {
        return $this->bySeries($series);
    }

    private function bySpeaker()
    {

    }

    private function getPodcasts($series = '') {
        return get_posts([
            'orderby' => 'date',
            'order' => 'DESC',
            'category_name' => $series,
            'post_type' => 'podcast',
            'post_status' => 'publish',
            'numberposts' => 15,
        ]);
    }

    private function getCategory()
    {
        return get_queried_object()->category_nicename;
    }
}

add_shortcode( 'podcast_grid', ['PodcastGrid', 'getGrid']);
