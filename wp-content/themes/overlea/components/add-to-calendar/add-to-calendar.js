import { atcb_init } from 'add-to-calendar-button';

/**
 * @file Add To Calendar
 */

/**
 * Add To Calendar component
 */
const vAddToCalendar = () => {
	const addToCalendar = document.querySelector( '.v-add-to-calendar--js' );

	if ( ! addToCalendar ) {
		return;
	}

	addToCalendar.classList.add( 'atcb' );
	setTimeout( () => {
		// addToCalendar.removeAttribute( 'style' );
		atcb_init();
	}, 0 );
};

export default vAddToCalendar;
