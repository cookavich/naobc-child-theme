<?php $queried_object = get_queried_object(); ?>

<div class="podcast-sidebar">
    <section class="story-nav">
        <div class="filter-options">
            <form action="">
                <div class="select-container">
                    <?php wp_dropdown_categories([
                        'show_option_none' => 'Sermons by Preacher',
                        'taxonomy' => 'speaker',
                        'id' => 'speaker-dropdown',
                        'value_field' => 'slug'
                    ]); ?>
                    <script type="text/javascript">
                        var speakerDropdown = document.getElementById('speaker-dropdown');
                        function onSpeakerCatChange() {
                            var currentSelection = speakerDropdown.options[speakerDropdown.selectedIndex].value;
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
                        'show_option_none' => 'Sermons by Series',
                        'taxonomy' => 'series',
                        'id' => 'series-dropdown',
                        'value_field' => 'slug'
                    ]); ?>
                    <script type="text/javascript">
                        var seriesDropdown = document.getElementById('series-dropdown');
                        function onSeriesCatChange() {
                            var currentSelection = seriesDropdown.options[seriesDropdown.selectedIndex].value;
                            if (currentSelection.length > 0) {
                                location.href = "<?php echo esc_url(home_url('/')); ?>series/" + currentSelection;
                            }
                        }
                        seriesDropdown.onchange = onSeriesCatChange;
                    </script>
                </div>
            </form>
        </div>
    </section>
    <?php if ($queried_object->taxonomy === 'speaker' || $queried_object->taxonomy === 'series'): ?>
        <div class="filter-reset">
            <a href="<?php echo esc_url(home_url('/')); ?>podcast">See all Sermons</a>
        </div>
    <?php endif; ?>
</div>
