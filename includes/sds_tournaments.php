<?php

class sdsTournaments
{
    public function __construct()
    {

//      Fubnctions
        add_action('init', array($this, 'create_event_categories_taxonomy'));
        add_action('init', array($this, 'create_events_post_type'));
        add_action('add_meta_boxes_events', array($this, 'adding_event_meta_boxes'), 10);
        add_action('save_post', array($this, 'wpevent_save_meta'), 10);
        add_action('wp_enqueue_scripts', array($this, 'register_plugin_styles'));

//      Shortcodes
        $shortcode = new SdsTournamentsShortcodes();
        add_shortcode('list_events', array($shortcode, 'listEvents'));
        add_filter('single_template', array($shortcode, 'eventDetails'));

    }

    function create_events_post_type()
    {
        $labels = array(
            'name' => _x('Events', 'post type general name', SDS_TEXTDOMAIN),
            'singular_name' => _x('Event', 'post type singular name', SDS_TEXTDOMAIN),
            'menu_name' => _x('Events', 'admin menu', SDS_TEXTDOMAIN),
            'name_admin_bar' => _x('Event', 'add new on admin bar', SDS_TEXTDOMAIN),
            'add_new' => _x('Add New', 'Event', SDS_TEXTDOMAIN),
            'add_new_item' => __('Add New Event', SDS_TEXTDOMAIN),
            'new_item' => __('New Event', SDS_TEXTDOMAIN),
            'edit_item' => __('Edit Event', SDS_TEXTDOMAIN),
            'view_item' => __('View Event', SDS_TEXTDOMAIN),
            'all_items' => __('All Events', SDS_TEXTDOMAIN),
            'search_items' => __('Search Events', SDS_TEXTDOMAIN),
            'parent_item_colon' => __('Parent Events:', SDS_TEXTDOMAIN),
            'not_found' => __('No Events found.', SDS_TEXTDOMAIN),
            'not_found_in_trash' => __('No Events found in Trash.', SDS_TEXTDOMAIN)
        );
        register_post_type('events', array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail')
        ));
        flush_rewrite_rules();
    }

    function create_event_categories_taxonomy()
    {
        $labels = array(
            'name' => _x('Event Categories', 'taxonomy general name', 'textdomain'),
            'singular_name' => _x('Event Category', 'taxonomy singular name', 'textdomain'),
            'search_items' => __('Search Event Categories', 'textdomain'),
            'popular_items' => __('Popular Event Categories', 'textdomain'),
            'all_items' => __('All Event Categories', 'textdomain'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Event Category', 'textdomain'),
            'update_item' => __('Update Event Category', 'textdomain'),
            'add_new_item' => __('Add New Event Category', 'textdomain'),
            'new_item_name' => __('New Event Category Name', 'textdomain'),
            'separate_items_with_commas' => __('Separate Event Categories with commas', 'textdomain'),
            'add_or_remove_items' => __('Add or remove Event Categories', 'textdomain'),
            'choose_from_most_used' => __('Choose from the most used Event Categories', 'textdomain'),
            'not_found' => __('No Event Categories found.', 'textdomain'),
            'menu_name' => __('Event Categories', 'textdomain'),
        );

        $args = array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'Event Category'),
        );

        register_taxonomy('event_category', 'events', $args);
    }

    function adding_event_meta_boxes($post)
    {
        add_meta_box(
            'event-details',
            __('Event Details'),
            array($this, 'render_event_meta_box'),
            'events',
            'normal',
            'default'
        );
    }

    function render_event_meta_box($post)
    {
        $start_date = get_post_meta($post->ID, 'start_date', true);
        $end_date = get_post_meta($post->ID, 'end_date', true);
        $address = get_post_meta($post->ID, 'address', true);
        ?>
        <style>
            .field label, .field input, .field textarea{
                width: 100%;
            }
            .field input{
                margin: 0;
            }
            .field label{
                padding: 10px 0;
                display: block;
                font-weight: bold;
            }
        </style>
        <div class="field">
            <label>Start Date</label>
            <input type="date" name="start_date" value="<?= $start_date ?>">
        </div>
        <div class="field">
            <label>End Date</label>
            <input type="date" name="end_date" value="<?= $end_date ?>">
        </div>
        <div class="field">
            <label>Address</label>
            <textarea name="address"><?= $address ?></textarea>
        </div>
        <?php
    }

    function wpevent_save_meta($post_id)
    {
        if(array_key_exists('start_date', $_POST)){
            update_post_meta(
                $post_id,
                'start_date',
                $_POST['start_date']
            );
        }
        if(array_key_exists('end_date', $_POST)){
            update_post_meta(
                $post_id,
                'end_date',
                $_POST['end_date']
            );
        }
        if(array_key_exists('address', $_POST)){
            update_post_meta(
                $post_id,
                'address',
                $_POST['address']
            );
        }
    }

    public function register_plugin_styles()
    {
        wp_register_style('SDS_Tournaments', plugins_url('SDS_Tournaments/includes/assets/css/shortcode.css'));
        wp_enqueue_style('SDS_Tournaments');
        wp_register_style('Font Awesome', plugins_url('SDS_Tournaments/includes/assets/fontawesome-free-5.6.3-web/css/fontawesome.css'));
        wp_register_style('Font Awesome All', plugins_url('SDS_Tournaments/includes/assets/fontawesome-free-5.6.3-web/css/all.css'));
        wp_enqueue_style('Font Awesome');
        wp_enqueue_style('Font Awesome All');
    }

}

?>