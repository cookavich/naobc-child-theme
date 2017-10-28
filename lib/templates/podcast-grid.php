<?php
/** @var Array $podcasts */
global $post;
global $wp_query;
?>
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
