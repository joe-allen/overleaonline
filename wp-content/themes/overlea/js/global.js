/**
 * @file Anything that can run on every page
 */

import * as quicklink from 'quicklink';
import vHeader from '../components/header/header';
import vSlider from '../components/slider/slider';
import vHero from '../components/hero/hero';

/**
 * Global functions
 *
 * Runs component js and any global tasks
 */
const vGlobal = () => {
	const links = document.querySelectorAll( 'a' );

	[ ...links ].forEach( ( link ) => {
		link.addEventListener( 'click', ( e ) => {
			const location = window.location.href;

			if ( location.indexOf( 'localhost' ) <= 0 ) {
				e.preventDefault();
				console.log( 'Blocking all links clicked in global.js' );
			}
		} );
	} );
	const shareBtn = document.querySelector( '.v-content__social--share' );

	vHeader();
	vSlider();
	vHero();

	const selects = document.querySelectorAll( 'select' );
	[ ...selects ].forEach( ( select ) => {
		const selectParent = select.parentNode;
		if ( selectParent.classList.contains( 'v-form__select' ) ) {
			return;
		}

		const wrapper = document.createElement( 'span' );
		const arrow   = document.createElement( 'span' );
		wrapper.classList.add( 'v-form__select' );
		arrow.classList.add( 'v-form__select-arrow' );
		selectParent.insertBefore( wrapper, select );
		wrapper.appendChild( select );
		wrapper.appendChild( arrow );
		select.classList.add( 'v-form__select-field' );
	} );

	if ( shareBtn ) {
		if ( ! navigator.share ) {
			console.log( 'hyh' );
			shareBtn.style.display = 'none';
		} else {
			shareBtn.addEventListener( 'click', shareOpen );
		}
	}

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

const shareOpen = ( e ) => {
	const shareBtn     = document.querySelector( '.v-content__social--share' );

	e.preventDefault();

	if ( ! navigator.share ) {
		// shareShowMessage( shareBtn, 'sorry, browser doesnt support!' );
		return false;
	}

	const ogBtnContent = shareBtn.textContent;
	const title        = document.querySelector( 'h1' ).textContent;
	const url          = document.querySelector( 'link[rel=canonical]' ) &&
							document.querySelector( 'link[rel=canonical]' ).href ||
							window.location.href;

	navigator.share( {
		title,
		url,
	} ).then( () => {
		shareShowMessage( shareBtn, 'Nice!' );
	} ).error( () => {
		console.log( 'here' );
		shareShowMessage( shareBtn, 'Nope!' );
	} );
};

const shareShowMessage = ( el, msg ) => {
	el.textContent = msg;

	setTimeout( () => {
		el.textContent = msg;
	}, 2000 );
};

if ( document.readyState !== 'loading' ) {
	vGlobal();
} else {
	document.addEventListener( 'DOMContentLoaded', vGlobal );
}
