<?php
/**
 * Search Form
 *
 * Default search form used by get_search_form()
 *
 * @package BoogieDown\Overlea\Core_Components
 * @author  Vitamin
 * @version 1.0.0
 */

?>

<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input class="search-field" type="search" placeholder="Search..." name="s" id="s" value="<?php echo get_search_query(); ?>" />
	<input class="search-button" type="submit" value="Search" />
</form>
