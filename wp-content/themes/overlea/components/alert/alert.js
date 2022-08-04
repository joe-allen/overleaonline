/**
 * @file Alert
 */

/**
 * Alert component
 */
const vAlert = () => {
	const alert = document.querySelector( '.v-alert' );

	if ( ! alert ) {
		return;
	}

	const close          = document.querySelector( '.v-alert__close' );
	const { body }       = document;
	const currentAlertID = close.getAttribute( 'data-id' );

	/**
	 * @param  {} e
	 */
	const showAlert = ( e ) => {
		const storageAlertID = window.localStorage.getItem( 'alert_id' );

		if ( body.classList.contains( 'v-alert--true' ) ) {
			if ( currentAlertID !== storageAlertID ) {
				body.classList.add( 'v-alert--show' );
			}
		}
	};
	showAlert();

	/**
	 * @param  {} e
	 */
	const closeAlert = () => {
		window.localStorage.setItem( 'alert_id', currentAlertID );
		body.classList.remove( 'v-alert--show' );
	};

	close.addEventListener( 'click', closeAlert );
};

export default vAlert;
