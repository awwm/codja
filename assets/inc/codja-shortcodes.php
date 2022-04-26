<?php
/*
*
*	***** CODJA *****
*
*	Shortcodes
*	
*/
// If this file is called directly, abort. //
if (!defined('WPINC')) {
    die;
} // end if

//  Display Anywhere Using Shortcode: [codja_users]

function codja_users_list($atts, $content = NULL)
{
    extract(shortcode_atts(array(
        'el_class' => '',
        'el_id' => '',
    ), $atts));
    ob_start(); 
    if(current_user_can('administrator')) : ?>
        <input type="hidden" id="sort_column">
        <input type="hidden" id="sort_order">
        <div class="col-md-12 table-content">

        </div>
    <?php else : ?>
        <div class="col-md-12">
            <p>Only administrators can view the content.</p>
        </div>
    <?php endif;
    return ob_get_clean();
}

/*
Register All Shorcodes At Once
*/
add_action('init', 'codja_register_shortcodes');
function codja_register_shortcodes()
{
    // Registered Shortcodes
    add_shortcode('codja_users', 'codja_users_list');
};
