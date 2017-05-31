<?php
/*FUNCTIONS.PHP for BootstrapXpress Wordpress Theme  */
/*  REGISTER AND ENQUEUE */
function enqueue_bootstrap_express_scripts_and_styles(){
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . "/css/bootstrap.min.css", false, NULL, 'all');
    wp_enqueue_style('bootstrap-theme-css', get_template_directory_uri(). "/css/bootstrap-theme.min.css", false, NULL, 'all'); //  BOOTSTRAP THEME is optional addition to main bootstrap css
    wp_enqueue_style( 'style', get_stylesheet_uri(), false, NULL, 'all');

    wp_register_script('bootstrap-js', get_template_directory_uri() . "/js/bootstrap.min.js", Array('jquery'), false, true);
    wp_enqueue_script('bootstrap-js');
}
add_action( 'wp_enqueue_scripts', 'enqueue_bootstrap_express_scripts_and_styles' );

/*  THEME SUPPORT FOR TITLE TAG  */
add_theme_support( 'title-tag' );



?>
