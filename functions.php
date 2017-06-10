<?php /*
  * FUNCTIONS.PHP for Bootstrap 4 for Wordpress Theme
  */
/*  REGISTER AND ENQUEUE */
add_action( 'wp_enqueue_scripts', 'enqueue_bootstrap_theme_scripts_and_styles' );
function enqueue_bootstrap_theme_scripts_and_styles(){
    wp_enqueue_style('bootstrap-css', "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css", false, NULL, 'all');
    wp_enqueue_style('font-awesome-css',"https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css", false, NULL, 'all');
    wp_enqueue_style( 'theme-style', get_template_directory_uri(). '/style.css', array('bootstrap-css'), NULL, 'all');
    // BOOTSTRAP THEME is an optional additional stylesheet
    //wp_enqueue_style('bootstrap-theme-css', get_template_directory_uri(). "/css/bootstrap-theme.min.css", false, NULL, 'all');





    /*  REGISTER AND ENQUEUE BOOTSTRAP JS FOR DEPENDENCIES */
    wp_deregister_script('jquery');
    wp_enqueue_script('modernizr_custom',get_template_directory_uri() . "/js/modernizr.js", array(),null, false);
    wp_register_script('jquery', "https://code.jquery.com/jquery-3.1.1.slim.min.js", Array(), NULL, true);
    wp_register_script('tether-js', "https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js", Array('jquery'), NULL, true);
    wp_enqueue_script('custom_jquery_mobile',get_template_directory_uri() . "/js/jquery.mobile.custom.min.js",array('jquery'), null, true);
    wp_register_script('bootstrap-js', "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js", Array('jquery', 'tether-js'), NULL, true);
    wp_enqueue_script('bootstrap-js',get_stylesheet_uri() . "/js/theme.js",Array('jquery','bootstrap-js','tether-js'),NULL, true);

    // not sure what should go in the theme js file (if anything).  bootstrap provides most required js
    //wp_register_script('theme-js', "");
}

/*  ADD FUNCTION WP_BOOTSTRAP_NAVBAR_MENU  */
/*  MENU ITEM CLASSES WALKER  */
// adds 'nav-item' to list item, adds 'nav-link' to link
class Bootstrap_Navbar_Menu_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
						$t = '';
						$n = '';
		} else {
						$t = "\t";
						$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
    if(in_array("current-menu-item",$classes)) $classes[] = 'active';

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = 'nav-item '. join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li' . $id . $class_names .'>';
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['class'] = 'nav-link';
		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
						if ( ! empty( $value ) ) {
										$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
										$attributes .= ' ' . $attr . '="' . $value . '"';
						}
		}
		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}



function wp_bootstrap_navbar_menu($args){
  $args['menu_class'] = 'menu navbar-nav';
  $args['container'] = 'ul';
	$args['walker'] =  new Bootstrap_Navbar_Menu_Walker();
  wp_nav_menu($args);
}


?>
