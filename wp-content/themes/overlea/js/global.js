/**
 * @file Anything that can run on every page
 */

import * as quicklink from 'quicklink';

import vCard from '../components/card/card';

/**
 * Global functions
 *
 * Runs component js and any global tasks
 */
const vGlobal = () => {
	const selects = document.querySelectorAll( 'select' );
	[ ...selects ].forEach( ( select ) => {
		const selectParent = select.parentNode;
		if ( selectParent.classList.contains( 'v-form__select' ) ) {
			return;
		}

		const wrapper = document.createElement( 'span' );
		wrapper.classList.add( 'v-form__select' );
		selectParent.insertBefore( wrapper, select );
		wrapper.appendChild( select );
	} );

	vCard();

	/**
	 * Global Window Load
	 *
	 * Runs polyfills on page load
	 */
	function onWindowLoad() {
		const body = document.querySelector( 'body' );
		if ( ! body.classList.contains( 'admin-bar' ) ) {
			quicklink.listen( {
				ignores: [
					( url ) => {
						const cleanUrl = url.replace( /#.*/, '' );
						return cleanUrl === window.location.href;
					},
					/.*\/wp-admin\/.*/,
				],
			} );
		}
	}

	if ( document.readyState === 'complete' ) {
		onWindowLoad();
	} else {
		window.addEventListener( 'load', onWindowLoad );
	}
};

if ( document.readyState !== 'loading' ) {
	vGlobal();
} else {
	document.addEventListener( 'DOMContentLoaded', vGlobal );
}
