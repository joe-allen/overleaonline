/**
 * @file Header
 */
import { gsap } from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

gsap.registerPlugin( ScrollTrigger );

/**
 * Header component
 */
const vHeader = () => {
	const mqLg              = window.matchMedia( '(max-width: 1024px)' );
	const header            = document.querySelector( '.v-header' );
	const logo              = header.querySelector( '.v-header__logo' );
	const logoLettersTop    = logo.querySelectorAll( '.v-header__logo .v-header__logo--top path' );
	const logoLettersBottom = logo.querySelectorAll( '.v-header__logo .v-header__logo--bottom' );
	const headerNavItems    = header.querySelectorAll( '.v-header__nav-item:not(:first-of-type)' );
	const hamburger         = header.querySelector( '.v-header__hamburger' );
	const search            = header.querySelector( '.v-header__nav-search-input' );
	const hero              = document.querySelector( '.v-hero' ) || document.querySelector( '.v-hero' );
	const heroBottom        = hero.getBoundingClientRect().height;

	if ( ! header ) {
		return;
	}

	const { body }         = document;
	let isOpen             = false;
	let prevOpenNav        = null;
	const itemWithChildren = header.querySelectorAll( '.v-header__nav-has-children' );

	/**
	 *
	 * @param {*} e
	 * @return
	 */
	const toggle = ( e ) => {
		const { currentTarget } = e;

		// return out if user clicks same open menu item
		if ( currentTarget.classList.contains( 'open' ) ) {
			return;
		}

		const dropdown = currentTarget.querySelector( '.v-header__nav-child-list' );

		// toggle ui
		if ( dropdown.classList.contains( 'open' ) ) {
			close( dropdown, currentTarget );
		} else if ( prevOpenNav ) {
			const prevNavDropDown = prevOpenNav.querySelector( '.v-header__nav-child-list' );

			gsap.to( prevNavDropDown, {
				height:     0,
				duration:   .1,
				ease:       'sine.in',
				onComplete: () => {
					prevNavDropDown.classList.remove( 'open' );
					prevNavDropDown.removeAttribute( 'style' );
					prevOpenNav.classList.remove( 'open' );
					isOpen = false;

					open( dropdown, currentTarget );
				},
			} );
		} else {
			open( dropdown, currentTarget );
		}
	};

	// opens dropdown
	const open = ( dropdown, currentTarget ) => {
		if ( header.classList.contains( 'open' ) ) {
			return false;
		}

		currentTarget.classList.add( 'open' );
		body.classList.add( 'open' );
		prevOpenNav = currentTarget;

		dropdown.classList.add( 'open' );
		const height          = window.getComputedStyle( dropdown ).getPropertyValue( 'height' );
		[ ...dropdown.querySelectorAll( 'li' ) ].forEach( ( el ) => {
			el.style.opacity = 0;
		} );
		dropdown.style.height = 0;

		gsap.to( dropdown, {
			height,
			duration:   .15,
			ease:       'sine.out',
			onComplete: () => {
				dropdown.classList.add( 'open' );
				isOpen = true;
			},
		} );

		gsap.to( dropdown.querySelectorAll( 'li' ), {
			duration: .2,
			opacity:  1,
			stagger:  {
				each: .1,
			},
		} );

		// add eventlistener to body
		body.addEventListener( 'click', autoCloseMenu );
	};

	// closes dropdown
	const close = ( dropdown, currentTarget ) => {
		currentTarget.classList.remoce( 'open' );
		dropdown.classList.remove( 'open' );
		body.classList.remove( 'open' );
		prevOpenNav = currentTarget;
		isOpen      = false;

		// clear search input
		if ( search.value.length ) {
			search.value = '';
		}

		// remove eventlistener from body
		body.removeEventListener( 'click', autoCloseMenu );
	};

	const autoCloseMenu = ( e ) => {
		const ct = e.currentTarget;

		if ( ! e.target.classList.contains( 'v-header__nav-link' ) && ! e.target.classList.contains( 'v-header__nav-has-children' ) ) {
			if ( ct.classList.contains( 'open' ) && isOpen ) {
				const navChildList        = document.querySelector( '.v-header__nav-child-list.open' );
				const navChildListWrapper = document.querySelector( '.v-header__nav-has-children.open' );

				gsap.to( navChildList, {
					height:     0,
					duration:   .1,
					ease:       'sine.in',
					onComplete: () => {
						navChildListWrapper.classList.remove( 'open' );
						navChildList.classList.remove( 'open' );
						navChildList.removeAttribute( 'style' );
						isOpen      = false;
						prevOpenNav = null;
					},
				} );
			}
		}
	};

	// toggle mobile menu
	const toggleMenu = () => {
		if ( header.classList.contains( 'open' ) ) {
			gsap.to( headerNavItems, {
				duration: .4,
				y:        -16,
				delay:    .2,
				opacity:  0,
				stagger:  {
					amount: .2,
					from:   'end',
				},
				ease:       'sine.in',
				onComplete: () => {
					[ ...headerNavItems ].forEach( ( el ) => {
						el.classList.remove( 'show' );
						el.removeAttribute( 'style' );
					} );

					if ( ! logoLettersTop[ 0 ].hasAttribute( 'style' ) ) {
						if ( window.scrollY <= hero.getBoundingClientRect().height ) {
							// console.log( `logo`, window.scrollY );
							// [ ...logoLettersTop ].forEach( ( el ) => {
							// 	el.removeAttribute( 'style' );
							// 	el.setAttribute( 'transform', 'matrix(1,0,0,1,0,0)' );
							// } );
						} else {
							[ ...logoLettersTop ].forEach( ( el ) => {
								el.style.opacity = '0';
							} );
						}
					}

					// clear search input
					if ( search.value.length ) {
						search.value = '';
					}

					header.classList.remove( 'open' );
					body.style.overflowY = 'visible';
				},
			} );
		} else {
			if ( hamburger.hasAttribute( 'style' ) ) {
				hamburger.removeAttribute( 'style' );
			}

			[ ...headerNavItems ].forEach( ( el ) => {
				el.style.opacity   = 0;
				el.style.transform = 'translateY(-16px)';
				el.classList.add( 'show' );
			} );

			if ( logoLettersTop[ 0 ].hasAttribute( 'style' ) ) {
				logo.removeAttribute( 'style' );
				[ ...logoLettersTop ].forEach( ( el ) => {
					el.removeAttribute( 'style' );
					el.removeAttribute( 'transform' );
				} );
			}

			header.classList.add( 'open' );
			body.style.overflowY = 'hidden';

			gsap.to( headerNavItems, {
				duration:   .6,
				y:          0,
				ease:       'sine.out',
				opacity:    1,
				stagger:    .1,
				onComplete: () => {
				},
			} );
		}
	};

	/**
	 *
	 * @return
	 */
	const showHamburgerOnScroll = () => {
		if ( mqLg.matches ) {
			hamburger.removeAttribute( 'style' );
			hamburger.style.position = 'fixed';
			hamburger.classList.remove( 'v-header__hamburger--entering' );
			// should remove TL, but neither that or set is working
			gsap.set( hamburger, { y: 0, opactiy: 1 } );
			return false;
		}

		const tl = gsap.timeline( {
			scrollTrigger: {
				trigger:  '.v-hero',
				markers:  false,
				scrub:    .1,
				ease:     'sine.out',
				duration: 1,
				start:    `${ ( heroBottom > 400 ) ? 700 : heroBottom }px center`,
				onEnter:  () => {
					hamburger.classList.add( 'v-header__hamburger--entering' );
				},
				onLeaveBack: () => {
					hamburger.classList.remove( 'v-header__hamburger--entering' );
				},
			},
		} );

		tl.from( hamburger, {
			y:       -100,
			opacity: 0,
		} ).to( hamburger, {
			y:       0,
			opacity: 1,
		} );
	};
	showHamburgerOnScroll();

	/**
	 *
	 * @return
	 */
	const hideLogoOnScroll = () => {
		if ( mqLg.matches ) {
			const tlLogo = gsap.timeline( {
				scrollTrigger: {
					trigger:  '.v-hero',
					markers:  false,
					ease:     'sine.out',
					scrub:    .1,
					duration: 1,
					repeat:   -1,
					start:    `${ heroBottom - 400 }px top`,
					end:      `${ heroBottom - 200 }px top`,
					onLeave:  () => {
						logo.style.display = 'none';
					},
					onEnterBack: () => {
						logo.style.display = 'block';
					},
				},
			} );

			tlLogo.from( logoLettersBottom, {
				opacity: 1,
			} ).to( logoLettersBottom, {
				opacity:  0,
				duration: 2,
			} );

			tlLogo.from( logoLettersTop, {
				// y:       0,
				opacity: 1,
			} ).to( logoLettersTop, {
				stagger: {
					each: .5,
					// y:       -100,
				},
				opacity: 0,
			}, '+=.1' );
		}
	};
	hideLogoOnScroll();

	mqLg.addEventListener( 'change', showHamburgerOnScroll );
	mqLg.addEventListener( 'change', hideLogoOnScroll );

	hamburger.addEventListener( 'click', toggleMenu );
	[ ...itemWithChildren ].forEach( ( el ) => el.addEventListener( 'click', toggle ) );
	[ ...itemWithChildren ].forEach( ( el ) => el.addEventListener( 'focus', toggle ) );
};

export default vHeader;
