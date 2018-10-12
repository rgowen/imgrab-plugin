<?php
/**
 * @package imgrabPlugin
 */

?>

<h1>imgrab</h1>
<form action="" method="post">
URL: <input type="URL" name="url"><input type="submit" value="Grab!">
</form>
<br>

<?php

$downloadPath = WP_CONTENT_DIR;

function downloadFile($url, $filepath)
{
    $file = file_put_contents($filepath, file_get_contents($url));
    if ($file == false) {
        return false;
    } else {
        return true;
    }
}

if (!function_exists('media_handle_sideload')) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
}

if (isset($_POST['url'])) {
    $url = $_POST['url'];
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        echo $url. "<br>";
        $filename = basename($url);
        $filepath = $downloadPath . '/' . $filename;
        $success = downloadFile($url, $filepath);
        if ($success) {
            $file_array = array(
                'name' => $filename,
                'tmp_name' => $filepath,
            );
            $post_id = 0;
            $attachment_id = media_handle_sideload($file_array, $post_id);

            if (is_wp_error($attachment_id)) {
                echo "Could not upload image - <br>". $attachment_id->get_error_message();
            } else {
                echo "Image uploaded successfully <br>";
                echo $filepath;
            }
        } else {
            echo "Could not upload image - download to server failed ";
        }

    } else {
        echo "Please enter a valid url.";
    }
}?>