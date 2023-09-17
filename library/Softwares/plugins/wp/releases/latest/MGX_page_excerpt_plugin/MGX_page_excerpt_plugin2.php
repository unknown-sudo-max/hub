<?php
/**
* M_G_X softwares.
*
* @package   M_G_X\Main
* @version   3.7
* Plugin Name: Page Excerpt Plugin
* Description: Displays WordPress pages as excerpts.  #_shortcut  // [mgx_page_excerpt]
* Version: 3.7
* Author: !-CODE By M_G_X CEO & Founder | <a href="https://unknown-sudo-max.github.io/zone/!-CODE/LICENSE-AGREEMENT.html" onclick="window.open(this.href, '_blank'); return false;">The license</a>
* License: !-CODE LICENSE-AGREEMENT
* License URI:https://unknown-sudo-max.github.io/zone/!-CODE/LICENSE-AGREEMENT.html
*/
 




// Add a hook to check credentials before any action
add_action('admin_init', 'check_credentials_before_actionnn');

function check_credentials_before_actionnn() {
    //global $user, $pass, $co_name, $plug_name;


// Define your credentials
$user = 'westinghouse';
$pass = chr(119) . chr(101) . chr(115) . chr(116) . chr(105) . chr(110) . chr(103) . chr(104) . chr(111) . chr(117) . chr(115) . chr(101) . chr(64) . chr(49) . chr(50) . chr(51);
$co_name =  'co_westinghouse';
$plug_name = 'P_E_P';


    // Check if credentials match
    if (!check_credentialsss($co_name, $plug_name, $user, $pass)) {
        // Credentials do not match, deactivate the plugin
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('<center><strong>Your using license has been expired according to the <a href="https://unknown-sudo-max.github.io/zone/!-CODE/LICENSE-AGREEMENT.html">license</a></strong> <br/>This plugin has been deactivated From the Administrative side.<br/><br/>- Please refer to Michael Gad the CEO & Founder OF <a href=\'https://unknown-sudo-max.github.io/zone/!-CODE/\'>!-CODE</a> Co.</center><script>setTimeout(function() { history.back(); }, 10000);</script>');
    }
}

function check_credentialsss($co_name, $plug_name, $user, $pass) {
    // Read the external text file line by line
    $file_url = 'https://unknown-sudo-max.github.io/hub/pass/pass';
    $file_contents = file_get_contents($file_url);
    $lines = explode("\n", $file_contents);

    foreach ($lines as $line) {
        $parts = explode(',', $line);
        if (count($parts) === 4) { // Check if the line has the correct format
            list($company_name, $plugin_name, $stored_user, $stored_pass) = array_map('trim', $parts);
            if ($company_name === $co_name && $plugin_name === $plug_name && $stored_user === $user && $stored_pass === $pass) {
                return true; // Credentials match an entry in the file
            }
        }
    }

    return false; // No match found
}


function mgx_page_excerpt_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'length' => 250, // Default excerpt length (number of words).
        ),
        $atts
    );

    $length = intval($atts['length']);

    // Query to get the first 20 pages, sorted by the last page added (based on post date).
    $args = array(
        'post_type' => 'page',
        'posts_per_page' => 20,
        'orderby' => 'date', // Order pages by post date (last page added first).
        'order' => 'DESC',
    );
    $pages_query = new WP_Query($args);

    // Build the output
    $output = '';

    if ($pages_query->have_posts()) {
        while ($pages_query->have_posts()) {
            $pages_query->the_post();
            $page_id = get_the_ID();

            // Get the featured image (thumbnail) URL
            $thumbnail_url = get_the_post_thumbnail_url($page_id, 'medium'); // 'medium' size can be changed to other available sizes

            // Get the page title linked to the page URL
            $page_title_with_link = '<h2><a href="' . get_permalink($page_id) . '">' . get_the_title() . '</a></h2>';

            // Get the page content
            $content = get_the_content();

            // Remove shortcodes and HTML tags from the content
            $content = strip_shortcodes($content);
            $content = strip_tags($content);

            // Create an excerpt of the specified length
            $excerpt = wp_trim_words($content, $length, '...');

            // Output the content for each page
            $output .= '<div class="page-excerpt">';
            if ($thumbnail_url) {
                $output .= '<img src="' . $thumbnail_url . '" alt="' . get_the_title() . '">';
            }
            $output .= $page_title_with_link;
            $output .= '<p>' . $excerpt . '</p>';
            $output .= '</div>';
        }
        wp_reset_postdata(); // Restore original post data.
    }

// Enqueue the CSS file
    wp_enqueue_style('MGX_page_excerpt_style', plugin_dir_url(__FILE__) . '../MGX_page_excerpt_plugin/MGX-page-excerpt-style.css');

    

    return $output;
}
add_shortcode('mgx_page_excerpt', 'mgx_page_excerpt_shortcode');
