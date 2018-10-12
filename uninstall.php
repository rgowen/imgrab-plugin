<?php

/**
 * Uninstall file
 * @package imgrabPlugin
 */

if(!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// clear database data

$books = get_posts(array('post_type' => 'book', 'numberposts' => -1 ));

foreach($books as $book)
{
    wp_delete_post($book->ID, true);
}
