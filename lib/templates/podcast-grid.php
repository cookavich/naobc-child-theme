<?php
/** @var Array $podcasts */
global $post;
global $wp_query;
?>
<div class="podcasts-container">
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
    <section class="story-nav">
        <div class="filter-options">
            <form action="">
                <div class="select-container">
                    <?php wp_dropdown_categories([
                        'show_option_none' => 'Select Series',
                        'taxonomy' => 'series',
                    ]); ?>
                    <script type="text/javascript">
                        const dropdown = document.getElementById("cat");
                        function onCatChange() {
                            const currentSelection = dropdown.options[dropdown.selectedIndex].value;
                            if (currentSelection > 0) {
                                location.href = "<?php echo esc_url(home_url('/')); ?>?cat=" + currentSelection;
                            }
                        }
                        dropdown.onchange = onCatChange;
                    </script>
                </div>
            </form>
        </div>
        <div class="filter-reset">
            <a href="<?php echo esc_url(home_url('/')); ?>podcast">See all Sermons</a>
        </div>
    </section>

</div>
