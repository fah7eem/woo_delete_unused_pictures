<?php
/**
 * Plugin Name: Delete Unused Images
 * Description: A plugin to delete unused WooCommerce images from the database and wp-content/uploads directory.
 * Version: 1.0
 * Author: Faheem Seedat
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Register the custom endpoint to trigger the image deletion job
add_action('init', function() {
    add_rewrite_rule('^delete-unused-images/?$', 'index.php?delete_unused_images=1', 'top');
});

// Register the custom query variable
add_filter('query_vars', function($vars) {
    $vars[] = 'delete_unused_images';
    return $vars;
});

// Execute the image deletion job when the custom URL is accessed
add_action('template_redirect', function() {
    if (get_query_var('delete_unused_images')) {
        fs_delete_unused_images();
        wp_die('Unused images deleted successfully.');
    }
});

// The function to find and delete unused images
function fs_delete_unused_images() {
    global $wpdb;

    $limit = $_GET['limit'] ?? 1000;
    $limit = intval($limit);
    // Query to find unused images
    $unused_images = $wpdb->get_results("
        SELECT p.ID, pm.meta_value AS image_path
        FROM {$wpdb->prefix}posts p
        LEFT JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_wp_attached_file'
        LEFT JOIN (
            SELECT pm.meta_value AS image_id
            FROM {$wpdb->prefix}postmeta pm
            WHERE pm.meta_key IN ('_thumbnail_id', '_product_image_gallery')
        ) used_images ON p.ID = used_images.image_id
        WHERE p.post_type = 'attachment'
        AND p.post_mime_type LIKE 'image%'
        AND used_images.image_id IS NULL
        limit 
    ". $limit);

    $count = 0;
    foreach ($unused_images as $image) {
        // Full path to the image file
        $file_path = ABSPATH . 'wp-content/uploads/' . $image->image_path;

        // Check if file exists and delete it
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the image post from the database
        wp_delete_post($image->ID, true);
        $count++;
    }
    echo "Deleted $count unused images.";
}
?>
