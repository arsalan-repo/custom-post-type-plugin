<?php
/*
 * Template Name: Event Details
 * Template Post Type: events
 */

get_header();

while (have_posts()): the_post();
    $event_categories = wp_get_object_terms($post->ID, 'event_category', array('fields' => 'names'));
    $s_date = get_post_meta(get_the_ID(), 'start_date', true);
    $start_date = date('jS F, Y', strtotime($s_date));
    $e_date = get_post_meta(get_the_ID(), 'end_date', true);
    $end_date = date('jS F, Y', strtotime($e_date));
    ?>

    <div class="event_detail">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?= the_post_thumbnail() ?>
                    <div class="misc_details">
                        <div class="detail">
                            <div><i class="fas fa-calendar-check"></i></div>
                            <span><span class="detail_heading">Start Date</span> <br/><?= $start_date ?></span></div>
                        <br/>
                        <div class="detail">
                            <div><i class="fas fa-calendar-times"></i></div>
                            <span><span class="detail_heading">End Date</span><br/><?= $end_date ?></span></div>
                        <br/>
                        <div class="detail">
                            <div><i class="fas fa-map-marker-alt"></i></div>
                            <span><span class="detail_heading">Address</span><br/><?= get_post_meta(get_the_ID(), 'address', true); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <h2><?= the_title() ?></h2>
                    <span> Posted on <?= the_date() ?>
                        <?php if(!empty($event_categories)) {?>
                        in
                        <?php foreach ($event_categories as $val) { ?>
                            <?= $val ?>
                        <?php }} ?>
                    </span>
                    <p>
                        <?php the_content() ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php endwhile; ?>
<?php get_footer(); ?>