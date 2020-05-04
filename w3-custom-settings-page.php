<?php
/*
Plugin Name: W3 Custome Settings Page
Description: Add Custome Admin Settings Page
Plugin URI: https://github.com/w3programmers/w3-custom-settings-page
Version: 1.0.0
Author: Masud Alam
Author URI: http://w3programmers.com
Text Domain: w3-custom-settings-page
*/


/* Hook to admin_menu the w3_add_custom_admin_page function above */
add_action( 'admin_menu', 'w3_add_custom_admin_page' );

function w3_add_custom_admin_page() {

    //Add Settings Page
    add_menu_page(
        'Yet Another Custom Admin Page', //Page Title
        __( 'Custom Settings', 'w3-custom-settings-page' ), //Menu Title
        'manage_options', //capability
        'w3-custom-settings-page', //menu slug
        'w3_custom_settings_page_content', //The function to be called to output the content for this page.
        'dashicons-schedule',
        2
    );

}

add_action( 'admin_init', 'w3_form_init' );

function w3_form_init() {
    register_setting(
        'w3_form', // A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
        'w3_form', //The name of an option to sanitize and save.
        'w3_name_sanitize'//for sanitizing callback function
    );

    add_settings_section( 'w3_section_id', 'W3 Custom Section', 'w3_section_callback', 'w3-custom-settings-page' );
    add_settings_field( 'name', 'Your Name', 'w3_form_name_callback', 'w3-custom-settings-page', 'w3_section_id' );
}

function w3_section_callback() {
    echo "Section Description here";
}

function w3_form_name_callback() {
    $options = get_option('name' );
   // print_r($options);
    echo "<input id='name' name='name'  type='text' value='$name' />"; 
   
}
// Validate user input (we want text only) 
function w3_name_sanitize($input){
    $valid = array();    
    $valid['name'] = preg_replace('/[^a-zA-Z]/','',$input['name'] );
    if( $valid['name'] != $input['name'] ){
        add_settings_error('name','w3_name_texterror','Incorrect value entered!','error');
    }
    return $valid; 
}
/* Settings Page Content */
function w3_custom_settings_page_content() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'yasr' ) );
    }
    ?>
    <div class="wrap">
        <h2>Settings API Demo</h2>
        <?php settings_errors(); ?>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'w3_form' );
            do_settings_sections( 'w3-custom-settings-page' );
            submit_button();
            ?>
        </form>
    </div>

<?php
} //End yasr_settings_page_content