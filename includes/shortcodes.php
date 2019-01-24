<?php

class SdsTournamentsShortcodes
{
    public function listEvents(){
        ob_start();
        ?>
        <div class="event_list">
            <div class="row">
                <?php
                $events = new WP_Query( array( 'post_type' => 'events', 'posts_per_page' => 10 ) );
                while ( $events->have_posts() ) : $events->the_post();
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <?= the_post_thumbnail(array('class' => 'card-img-top')) ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= the_title() ?></h5>
                                <p class="card-text"><?= the_excerpt() ?></p>
                                <a href="<?= the_permalink() ?>" class="btn btn-primary">View Event</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function eventDetails($single){
        global $post;

        /* Checks for single template by post type */
        if ( $post->post_type == 'events' ) {
            if ( file_exists( dirname(__FILE__) . '/templates/single-event.php' ) ) {
                return dirname(__FILE__) . '/templates/single-event.php';
            }
        }

        return $single;
    }
}

