/**
 * @file <%= nameSpaced %>
 */

/**
 * <%= nameSpaced %> functions
 *
 * Runs js specific to the <%= nameSpaced %> template
 */
const v<%= nameUpper %> = () => {

};

if ( document.readyState !== 'loading' ) {
	v<%= nameUpper %>();
} else {
	document.addEventListener( 'DOMContentLoaded', v<%= nameUpper %> );
}
