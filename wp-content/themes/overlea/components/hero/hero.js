import { gsap } from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

gsap.registerPlugin( ScrollTrigger );

/**
 * @file Hero
 */

/**
 * Hero component
 */
const vHero = () => {
	const hero   = document.querySelector( '.v-hero' );
	const slider = document.querySelectorAll( '.v-slider__wrap' );

	if ( ! hero ) {
		return false;
	}

	const tlOverlay = gsap.timeline( {
		scrollTrigger: {
			trigger: '.v-hero__overlay',
			start:   'top top',
			end:     `${ ( hero.getBoundingClientRect().bottom - 100 ) }px`,
			scrub:   1,
			markers: false,
		},
	} );

	tlOverlay.fromTo( '.v-hero__overlay', {
		opacity: 0,
	}, {
		opacity: 1,
	} );

	const tlSlider = gsap.timeline( {
		scrollTrigger: {
			trigger: hero,
			start:   'top top',
			scrub:   .2,
			markers: false,
		},
	} );

	tlSlider.fromTo( slider, {
		scale: 1,
	}, {
		scale: 1.2,
	} );
};

export default vHero;
