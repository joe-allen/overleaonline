=== Contact Form 7 - Recurring Payments Pro ===
Plugin Name: Contact Form 7 - Recurring Payments Pro
Author: Scott Paterson
Contributors: scottpaterson,wp-plugin
Donate link: https://wpplugin.org/donate/
Tags: paypal, contact form 7, cf7
Author URI: https://wpplugin.org
Requires at least: 3.5
Tested up to: 5.6
Stable tag: 1.2.2

Adds subscriptions to Contact Form 7 - PayPal & Stripe Add-on Pro.

== Description ==
= Overview =

*   Adds subscriptions to Contact Form 7 - PayPal & Stripe Add-on Pro.


WPPlugin is an offical and Stripe PayPal Partner. Various trademarks held by their respective owners.


== Installation ==

== Frequently Asked Questions ==

== Screenshots ==


== Changelog ==

= 1.2.2 =
* 10/3/21
* Fix - Fixed issue with recurring Stripe payments.

= 1.2.1 =
* 2/19/21
* Fix - Email not sending after payment for Stripe and PayPal.

= 1.2 =
* 12/7/20
* New - Stripe now redirects to hosted Stripe checkout page.
* New - Stripe is now fully SCA complient.
* New - The plugin now supports auto updating, if enabled.
* Changed - Removed manually adding taxes. The plugin now uses Stripe / PayPal tax profiles, which offers way for flexability.
* Update - Updated license manager.
* Removed - Removed Stripe jump to form option, since Stripe is now hosted on Stripe.com
* Important note - subscription option / id / text data nows shows on Stripe.com under Payments link -> (Choose payment) -> Subscription link -> Metabox section of the page.

= 1.1.7 =
* 10/26/20
* Fix - Fixed dynamic recurring PayPal payment defaulting to monthly.

= 1.1.6 =
* 10/20/20
* Fix - Fixed bug related to Stripe ID when using cookies.

= 1.1.5 =
* 10/20/20
* Fix - Fixed bug related to Stripe payment button terms not showing.
* Fix - Fixed admin recurring menu now showing due to JavaScript problem.
* Fix - Fixed static recurring PayPal payment defaulting to monthly.

= 1.1.4 =
* Fix - Fixed issue with admin recurring menu not showing on some sites.

= 1.1.3 =
* Fix - Stripe sesssion issue.

= 1.1.2 =
* Fix - Existing plan lookup name error.

= 1.1.1 =
* Fix - Changed code to reflect changed in Stripe API used for creating plans names.

= 1.1 =
* Fix - Stripe billing interval was not working correctly when using a static recurring payment.
* New - Added json error logging for Stripe.

= 1.0.4 =
* New - Added ability to link recurring and non recurring amounts in same form item. Only for PayPal - use 1 for number of cycles parameter.

= 1.0.3 =
* Fix - Updater issue

= 1.0.2 =
* New - Added ability to link form values to the dynamic price and description. Documentation here: https://wpplugin.org/documentation/enable-dynamic-recurring-payments/

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
* Initial release