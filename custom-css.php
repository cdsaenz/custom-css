<?php
// Prevent direct access if not in WonderCMS
if (!defined('VERSION')) {
    exit;
}

global $Wcms;

// Register listeners for custom CSS and settings
$Wcms->addListener('css', 'load_custom_css');
$Wcms->addListener('editable', 'custom_css_settings');


// Load custom CSS
function load_custom_css($args) {
    global $Wcms;
    $custom_css_url = $Wcms->url('plugins/custom-css/custom.css');
    
    // Add the custom CSS to the existing CSS in the head
    $args[0] .= '<link rel="stylesheet" href="' . $custom_css_url . '" type="text/css">';
    return $args;
}

// Display the custom CSS settings in the admin area
function custom_css_settings($args) {
    // Load the current custom CSS content
    $custom_css = file_get_contents('plugins/custom-css/custom.css');

    if (isset($_POST['custom_css'])) {
        // Save the custom CSS content to the file
        file_put_contents('plugins/custom-css/custom.css', $_POST['custom_css']);
        $custom_css = $_POST['custom_css']; // Update the variable with the new content
    }

    // Create the settings form
    echo '<form method="post">';
    echo '<textarea name="custom_css" style="width:100%; height:200px;">' . htmlspecialchars($custom_css) . '</textarea>';
    echo '<button type="submit">Save Custom CSS</button>';
    echo '</form>';
}
