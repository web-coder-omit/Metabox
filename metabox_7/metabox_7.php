<?php
/**
 * Plugin Name: Metabox_7
 * Plugin URI:  Plugin URL Link
 * Author:      Plugin Author Name
 * Author URI:  Plugin Author Link
 * Description: This plugin make for pratice wich is "Metabox_7".
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: mb_7
 */
// Languages file loaded
function plugin_file_function(){
    load_plugin_textdomain('mb_7', false, dirname(__FILE__)."/languages");
}
add_action('plugins_loaded','plugin_file_function');
 
// add CSS file
function my_plugin_design(){
    wp_enqueue_style('my_css_style_file', plugin_dir_url(__FILE__).'asset/admin/css/style.css',null,time());
}
add_action('admin_enqueue_scripts','my_plugin_design');



// Reginstation maetabox 
function reginster_metabox_function(){
    add_meta_box('metabox_7', __('Your InFo:','mb_7'), 'regester_metabox_function','post');
}
add_action('admin_init','reginster_metabox_function');

// Show meta info
function regester_metabox_function($post){
    $colors = array('red','green','blue','yellow','megenta','pink','black');
    $label_1 = __('Your Name:','mb_7');
    $label_2 = __('Your color:','mb_7');
    $value_01 = get_post_meta($post->ID, 'save_name_fild', true);
    $colors_value = get_post_meta($post->ID, 'save_filds', true);
    $colors_value_radio = get_post_meta($post->ID, 'save_filds_radio', true);

    $meta_HTML = <<<EOD
    <div>
        <label for='names'>{$label_1}</label>
        <div class="class">
            <input id='names' type='text' name='names' value='{$value_01}'/>
        </div>
    </div>
    <div class="checkbox_1">
        <label for='checkbox'>{$label_2}</label>
   
    EOD;

    foreach($colors as $color){
        $_color = ucwords($color);
        $clicked = in_array($color,(array)$colors_value) ? 'checked':'';
    // $checked = in_array($color, $colors_value) ? 'checked' : '';
        $meta_HTML .=<<<EOD
        <label for='clr{$_color}'>{$_color}</label>
        <input id='clr{$_color}' type='checkbox' name='checkbox[]' value='{$color}' {$clicked}/>
        EOD;
    }
    $meta_HTML .= "</div>";

   $meta_HTML .=<<<EOD
    <div>
        <label for='radio'>{$label_2}</label>
   EOD;

//Content for radio button 
   foreach($colors as $color){
    $_color = ucwords($color);
   $checked = ($color == $colors_value_radio) ? "checked = 'checked'": '';
    $meta_HTML .=<<<EOD
    <label for='clr{$_color}'>{$_color}</label>
    <input id='clr{$_color}' type='radio' name='radio_' value='{$color}' {$checked}/>

  EOD;
}

// foreach($colors as $color){
//     $_color = ucwords($color);
//     $checked = ($color == $colors_value_radio) ? "checked='checked'" : '';
//     $meta_HTML .=<<<EOD
//     <label for='clr{$_color}'>{$_color}</label>
//     <input id='clr{$_color}' type='radio' name='radio_' value='{$color}' {$checked}/>
//     EOD;
// }







$meta_HTML .= "</div>";

    echo $meta_HTML;
}
// Save Data
function save_data_in_database($post_id){

    array_key_exists('names',$_POST)?update_post_meta($post_id, 'save_name_fild', $_POST['names']):'';

    if (array_key_exists('checkbox', $_POST)) {
        update_post_meta($post_id, 'save_filds', $_POST['checkbox']);
    } else {
        delete_post_meta($post_id, 'save_filds');
    }


// save for radio button 
    if (array_key_exists('radio_', $_POST)) {
        update_post_meta($post_id, 'save_filds_radio', $_POST['radio_']);
    } else {
        delete_post_meta($post_id, 'save_filds_radio');
    }

    // if (array_key_exists('names', $_POST)) {
    //     update_post_meta($post_id, 'save_name_fild', $_POST['names']);
    // }

    // if (array_key_exists('checkbox', $_POST)) {
    //     update_post_meta($post_id, 'save_filds', $_POST['checkbox']);
    // } else {
    //     delete_post_meta($post_id, 'save_filds');
    // }
 
}
add_action('save_post','save_data_in_database');



?>