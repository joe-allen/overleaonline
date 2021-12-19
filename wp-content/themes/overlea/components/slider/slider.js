/**
 * @file Slider
 */
import KeenSlider from 'keen-slider';

/**
 * Slider component
 */
const vSlider = () => {
	const sliderWrapEl = document.querySelector( '.v-slider' );
	const sliderEl     = sliderWrapEl.querySelector( '.v-slider #my-keen-slider' );
	let interval       = 0;

	if ( ! sliderEl || sliderEl.children.length <= 1 ) {
		return;
	}

	const arrowR = sliderWrapEl.querySelector( '#arrow-right' );
	const arrowL = sliderWrapEl.querySelector( '#arrow-left' );
	const slider = new KeenSlider( '#my-keen-slider', {
		loop:      true,
		duration:  1000,
		dragStart: () => {
			autoplay( false );
		},
		dragEnd: () => {
			autoplay( true );
		},
		created( instance ) {
			if ( arrowL ) {
				arrowL
					.addEventListener( 'click', function() {
						instance.prev();
					} );

				arrowR
					.addEventListener( 'click', function() {
						instance.next();
					} );
			}

			const dots_wrapper = document.getElementById( 'dots' );
			const slides       = document.querySelectorAll( '.keen-slider__slide' );

			if ( dots_wrapper ) {
				slides.forEach( function( t, idx ) {
					const dot = document.createElement( 'button' );
					dot.classList.add( 'dot' );
					dots_wrapper.appendChild( dot );
					dot.addEventListener( 'click', function() {
						instance.moveToSlide( idx );
					} );
				} );
				updateClasses( instance );
			}
		},
		slideChanged( instance ) {
			if ( arrowL ) {
				updateClasses( instance );
			}
		},
	} );

	/**
	 * @param run
	 */
	function autoplay( run ) {
		clearInterval( interval );
		interval = setInterval( () => {
			if ( run && slider ) {
				slider.next();
			}
		}, 8000 );
	}

	if ( arrowL ) {
		autoplay();

		sliderWrapEl.addEventListener( 'mouseover', () => {
			autoplay( false );
		} );
		sliderWrapEl.addEventListener( 'mouseout', () => {
			autoplay( true );
		} );
		autoplay( true );
	}

	/**
	 * @param instance
	 */
	function updateClasses( instance ) {
		const slide      = instance.details().relativeSlide;
		const arrowLeft  = document.getElementById( 'arrow-left' );
		const arrowRight = document.getElementById( 'arrow-right' );
		slide === 0
			? arrowLeft.classList.add( 'arrow--disabled' )
			: arrowLeft.classList.remove( 'arrow--disabled' );
		slide === instance.details().size - 1
			? arrowRight.classList.add( 'arrow--disabled' )
			: arrowRight.classList.remove( 'arrow--disabled' );

		const dots = document.querySelectorAll( '.dot' );
		dots.forEach( function( dot, idx ) {
			idx === slide
				? dot.classList.add( 'dot--active' )
				: dot.classList.remove( 'dot--active' );
		} );
	}
};

export default vSlider;
