<?php
/** @var Array $podcasts */
global $post;
global $wp_query;
if (is_archive()) {
    $wpTerm = get_queried_object();
    $podcasts = get_posts([
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
?>
<div class="podcasts-container">
    <div class="podcast-sidebar">
        <section class="story-nav">
            <div class="filter-options">
                <form action="">
                    <div class="select-container">
                        <?php wp_dropdown_categories([
                            'show_option_none' => 'Select Speaker',
                            'taxonomy' => 'speaker',
                            'id' => 'speaker-dropdown',
                            'value_field' => 'slug'
                        ]); ?>
                        <script type="text/javascript">
                            var speakerDropdown = document.getElementById("speaker-dropdown");
                            function onSpeakerCatChange() {
                                var currentSelection = dropdown.options[dropdown.selectedIndex].value;
                                if (currentSelection.length > 0) {
                                    location.href = "<?php echo esc_url(home_url('/')); ?>speaker/" + currentSelection;
                                }
                            }
                            speakerDropdown.onchange = onSpeakerCatChange;
                        </script>
                    </div>
                </form>
            </div>
        </section>
        <section class="story-nav">
            <div class="filter-options">
                <form action="">
                    <div class="select-container">
                        <?php wp_dropdown_categories([
                            'show_option_none' => 'Select Series',
                            'taxonomy' => 'series',
                            'id' => 'series-dropdown',
                            'value_field' => 'slug'
                        ]); ?>
                        <script type="text/javascript">
                            var seriesDropdown = document.getElementById("series-dropdown");
                            function onSeriesCatChange() {
                                var currentSelection = dropdown.options[dropdown.selectedIndex].value;
                                if (currentSelection > 0) {
                                    location.href = "<?php echo esc_url(home_url('/')); ?>//series/" + currentSelection;
                                }
                            }
                            seriesDropdown.onchange = onSeriesCatChange;
                        </script>
                    </div>
                </form>
            </div>
            <div class="filter-reset">
                <a href="<?php echo esc_url(home_url('/')); ?><!--podcast">See all Sermons</a>
            </div>
        </section>
    </div>
    <div class="grid">
        <?php foreach ($podcasts as $post): ?>
            <?php $taxonomies = get_the_taxonomies(); ?>
            <article class="card-podcast">
                <header class="card-info">
                    <div class="card-meta">
                        <span><?php echo $taxonomies['series'] ?></span>
                        <span class="card-date"><?php echo get_the_date() ?></span>
                    </div>
                </header>
                <div class="card-body">
                    <h3 class="card-title"><?php the_title() ?></h3>
                    <p class="card-preacher"><?php echo $taxonomies['speaker'] ?></p>
                </div>
                <footer class="listen-to-container">
                    <a class="listen-to" href="<?php the_permalink() ?>">Listen/Watch</a>
                </footer>
            </article>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
    <div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>

</div>
