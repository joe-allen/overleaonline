=== Contact Form 7 - PayPal Add-on Pro ===
Plugin Name: Contact Form 7 - PayPal Add-on Pro
Author: Scott Paterson
Contributors: scottpaterson,wp-plugin
Donate link: https://wpplugin.org/donate/
Tags: paypal, contact form 7, cf7
Author URI: https://wpplugin.org
Requires at least: 3.5
Tested up to: 5.7
Stable tag: 2.9.6

Integrates PayPal with Contact Form 7

== Description ==
= Overview =

*   Integrates PayPal with Contact Form 7

*   Developed by an Official PayPal Partner.


WPPlugin is an offical PayPal Partner. Various trademarks held by their respective owners.


== Installation ==

= Automatic Installation =
> 1. Sign in to your WordPress site as an administrator.
> 2. In the main menu go to Plugins -> Add New.
> 3. Search for Contact Form 7 - PayPal Add-on and click install.

== Frequently Asked Questions ==

== Screenshots ==





== Changelog ==

= 2.9.6 =
* 9/20/21
* Fix - Fixed PHP error showing on Edit Page screen.

= 2.9.5 =
* 5/17/21
* Update - Updated Stripe PHP Library to version 7.77.0

= 2.9.4 =
* 5/17/21
* New - Emails sent after payment now support the [order_id] mail tag.

= 2.9.3 =
* 4/25/21
* Fix - Fixed PHP error caused by a few webhosting companies disabling PHP allow_url_fopen. This caused Stripe Connect to have multiple errors.

= 2.9.1 =
* 4/7/21
* Fix - Fixed PHP error caused by 2.9 release. This was related to using a version of PHP less than 7.4.

= 2.9 =
* 4/6/21
* New - Added Stripe Connect

= 2.8.6 =
* 2/20/21
* Updated - Changed the way the PayPal IPN works to make it more reliable.

= 2.8.5 =
* 2/19/21
* Fix - Fixed recurring payment add-on email not sending issue.
* Fix - Redirect URL was not working for Stripe.

= 2.8.4 =
* 2/12/21
* Fix - Fixed issue with attachments not sending when form is set to send email after payment.
* Fix - Return after payment URLs not working for Stripe

= 2.8.3 =
* 2/3/21
* Fix - Fixed issue caused by Yoast making form to redirect to homepage.
* Fix - Fixed issue with JS files not including version number causing them to be cached.
* Fix - Fixed issue with Stripe return text not showing.

= 2.8.2 =
* 2/3/21
* Fix - Fixed issue with PayPal and Stripe when price is equal to zero.

= 2.8.1 =
* 1/28/21
* New - PayPal & Stripe admin payment history
* New - Stripe will automatically register and check webhook for live and sandbox payments
* New - Local environment helper admin notice
* New - Added admin review notice
* Update - Updated PayPal IPN code

= 2.7 =
* 12/7/20
* New - Stripe now redirects to hosted Stripe checkout page.
* New - Stripe is now fully SCA complient.
* New - The plugin now supports auto updating, if enabled.
* New - Added many more helpful error notices so that site owners can more quickly solve problems.
* Changed - Removed manually adding taxes. The plugin now uses Stripe / PayPal tax profiles, which offers way for flexability.
* Update - Updated license manager.
* Removed - Removed Stripe jump to form option, since Stripe is now hosted on Stripe.com

= 2.6.18 =
* 10/28/20
* Fix - Fixed bug related to recurring payments add-on plugin.
* Update - Changed frontend note to display direction for what to do is PHP Sessions are not working.

= 2.6.17 =
* 10/20/20
* Fix - Fixed bug related to recurring payments add-on plugin.

= 2.6.16 =
* 10/14/20
* Fix - Fixed bug related to PHP setcookie.

= 2.6.15 =
* 8/27/20
* Fix - Fixed bug related to Japanese JPY currency format.

= 2.6.13 =
* 8/10/20
* Fix - Changed the name for the temporary storage method setting on the settings page.
* Fix - Link from tthe plugins page to our website was incorrect.

= 2.6.12 =
* 8/10/20
* New - Added ability to change between cookie use and session use. Some servers support one or the other.
* Fix - Changed the way cookies work.

= 2.6.11 =
* 8/8/20
* New - Added new redirect method. Can be used for some sites that have trouble redirecting to PayPal or Stripe.

= 2.6.10 =
* 7/18/20
* Fixed redirect issue on some servers (such as WP Engine) that use aggressive server side caching (Only getting cookies inside Ajax requests now).
* Fixed Stripe redirect to URL issue.

= 2.6.9 =
* 7/9/20
* Fixed Stripe Credit Card form payment button amount formatting issue.

= 2.6.8 =
* 7/9/20
* New - Removed PHP Session support, now the pluign uses PHP Cookies.
* Fix - The plugin no longer causes an issue with WordPress Site Health Performance.
* Update - Updated Stripe version to 7.4

= 2.6.6 =
* 7/4/20
* Fix - Contact Form 7 5.2 broke redirecting to PayPal or Stripe.

= 2.6.5 =
* 5/21/19
* Fix - IPN foreach PHP error.

= 2.6.4 =
* 5/7/19
* Change - Changed the return method for PayPal. Now when a payment is completed, and the customer is redirected back to the site, all payment variables are available as POST. Docs here - 'rm' feature: https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#paypal-checkout-page-variables


= 2.6.3 =
* 4/25/19
* Fix - Changed redirect URL from using WordPress's site URL to home URL. This fixes a problem on sites with a different WordPress Address and Site Address.

= 2.6.2 =
* 3/21/19
* Update - Updated Stripe Library to latest - v6.31.0

= 2.6.1 =
* 2/13/19
* New - Added feature to allow passing a message to the Stripe after payment page. Documentation here: https://wpplugin.org/documentation/stripe-after-payment-message/
* Update - Added more feature suport for for Contact Form 7 - Recurring Payments Pro

= 2.6 =
* 1/25/19
* New - Support for Contact Form 7 - Recurring Payments Pro

= 2.5.14 =
* 10/16/18
* Fix - Problem saving text field codes.

= 2.5.13 =
* 9/23/18
* Fix - Problem saving Description 5 code.

= 2.5.12 =
* 9/5/18
* New - Added feature to allow Stripe form to be focused on after form is submittd. This is useful for long forms / pages / headers. Setting on settings page, other tab.

= 2.5.11 =
* 8/20/18
* Fix - Form save item had incorrect name.

= 2.5.10 =
* 8/20/18
* Change - Changed the hidden HTML form names on the tabs settings page to fix a conflict with the plugin Frontend Registration - Contact Form 7.

= 2.5.9 =
* 8/18/18
* Fix - The code for sending a quantity value of 0 had a logic problem.

= 2.5.8 =
* 8/18/18
* Fix - The code for sending a quantity value of 0 had a logic problem.

= 2.5.7 =
* 7/23/18
* New - Added new after payment filter for developers for both PayPal and Stripe.

= 2.5.6 =
* 7/6/18
* New - Can change Stripe currency code value per form.

= 2.5.5 =
* 7/2/18
* Fix - Old email temp posts were not correclty being deleted. Set to delete 20 per batch.

= 2.5.4 =
* 6/29/18
* New - Added ability to link form email field to Stripe.
* New - Added ability to redirect to success page after Stripe payment.
* Fix - Radio buttons that included a price with cents - cents was not correctly being passed to PayPal or Stripe.

= 2.5.3 =
* 6/28/18
* Fix - Undefined index error related to settings redirect variable.
* New - Added pre send email hook.
* New - Added hook for adding attachments programmatically.

= 2.5.2 =
* 5/28/18
* Fix - Redirect to PayPal encoding error.

= 2.5.1 =
* 5/21/18
* New - Skip email settings on settings page other tab. This controls how email sending should work using the skip redirect feature.
* Fix - Sending the email after payment was not including attachments if the Mail -> File Attachments section contained spaces between the brackets.

= 2.5 =
* 5/7/18
* New - The PayPal IPN code has mostly been rewritten to increase the reliability of payment notifications which trigger after payment emails.

= 2.4.13 =
* 4/23/18
* Fix - Using other plugins (such as Easy Digital Downloads) that also include PayPal IPN code was throwing an error on certain pages.

= 2.4.12 =
* 4/20/18
* New - Hook cf7pp_payment_successful now includes PayPal / Stripe Transaction ID as second parameter. Usage example here: https://wpplugin.org/documentation/run-custom-php-after-payment/

= 2.4.11 =
* 4/15/18
* Fix - Stripe price was not displaying correctly since version 2.4.10

= 2.4.10 =
* 4/7/18
* New - If a dynamic quantity of 0 is passed, it will skip adding the item at checkout.
* Fix - Stripe price multiplied by quantity calculation was not correct.

= 2.4.9 =
* 3/13/18
* Fix - Only load files from Stripe if needed
* Fix - Price integer issue on PHP 7.1

= 2.4.8 =
* 2/22/18
* Fix - Fixed plugin update issue.

= 2.4.7 =
* 2/19/18
* Fix - Stripe checkout was giving an error message if the Stripe test keys were not entered.

= 2.4.6 =
* 2/15/18
* Fix - Version bump due to updater issue.

= 2.4.5 =
* 2/15/18
* New - Added the feature of authorizing a PayPal transaction without capturing the funds from the customer's account immediately. Documentation here: https://wpplugin.org/documentation/authorize-payment/

= 2.4.3 =
* 2/9/18
* Fix - Was not redirecting to Stripe, if only Stripe was enabled.
* New - Added Test Mode indicator on Stripe mode form, if Stripe is being used in Sandbox mode.

= 2.4.2 =
* 2/7/18
* Fix - Plugin had a conflict with the Divi theme's full page width.

= 2.4.1 =
* 2/6/18
* Fix - Not all forms where redirecting on some sites.

= 2.4 =
* 2/6/18
* Major Release - Added Stripe to the plugin
* Change - The majority of the plugin has been completely rewritten
* Fix - The plugin now works with Contact Form 7 version 5

= 2.3.3 =
* 1/21/18
* Fix - PHP 7.1 warning message was displayed for redirect code value.

= 2.3.2 =
* 11/20/17
* Fix - Linking customer values did not work with pipes used in dropdown menus or radio buttons.

= 2.3.1 =
* 10/23/17
* Fix - Plugin should not work with many more Contact Form 7 extensions, such as Mailchimp, Google Sheets, Datepicker, etc.
* Fix - Currency will now pass through a filter, this is useful as PayPal does not accept $ anymore in front of amounts.
* Fix - Free version is deactivated upon pro version activate.

= 2.3 =
* 10/19/17
* New - Link customer input fields to auto populate on PayPal. Documentation: https://wpplugin.org/documentation/link-customer-input-values/
* New - Landing Page on PayPal can now be set. Documentation: https://wpplugin.org/documentation/credit-card-landing-page/

= 2.2.1 =
* 10/12/17
* New - Skip Code can now contains mutiple form elements seperated by a comma. The total price determines if the form should redirect or not.

= 2.2 =
* 10/9/17
* New - Comlpetely rewrote the PayPal IPN listener. This should be more stable on diffent server environments.

= 2.1.2 =
* 9/29/17
* Bug fix - Fixed code error regarding Skip Redirect Code feature.

= 2.1.1 =
* 9/3/17
* Bug fix - Function name being used in other plugin. This caused an error in certain circumstances.

= 2.1 =
* 9/2/17
* New - Added feature to allow the use of the code [txn_id] on the email body section. If the form is set to send "email after payment", then this code will be replaced with the PayPal Transaction ID.
* New - Added skip redirect form code feature. This allows a form element such as a dropdown menu to control if the form will redirect to PayPal or skip the redirect.

= 2.0.4 =
* 8/25/17
* New - Added new PayPal IPN success hook. The new hook: cf7pp_payment_successful_pre_post_delete is called before the cf7pp post is deleted.
* New - Added test template redirect hook that can be used for IPN URL testing. Format: http://example.com?cf7pp_test=1
* Bug fix - Default quantity 5 form redirect element had wrong variable name.

= 2.0.3 =
* 8/21/17
* Bug fix - Contact Form 7 version 4.9 changed the way the skip mail function works.

= 2.0.2 =
* 6/19/17
* Bug fix - Facebook Browser was redirecting to PayPal home page.

= 2.0.1 =
* 5/17/17
* Fix - Fixed illegal string offset bug that occured in debug mode on a small amount of servers running PHP 5.6.
* Update - Updated plugin update class.

= 2.0 =
* 5/2/17
* Tweak - Version bump due to issue with updater - for some users the most recent verion was not showing.
* Update - Tested with Contact Form 7 and WordPress version 4.7.4

= 1.9.11 =
* 3/4/17
* Important - Please Update Immediately to this version.
* Fix - Contact Form 7 version 4.7 changed some internal code which caused this plugin to not correctly redirect to PayPal and give error messages. Version 1.9.11 fixes this issue.

= 1.9.10 =
* 2/7/17
* Fix - Alignment on settings page input boxes.

= 1.9.9 =
* 1/26/17
* Feature - Specify a manual PayPal IPN (Instant Payment Notification) URL on the settings page.

= 1.9.8 =
* 1/24/17
* Feature - Language is now used to set default dropdown menu billing country in PayPal.

= 1.9.7 =
* 1/6/17
* Fix - Item description / name was not being correct passed to PayPal when set as a static value.

= 1.9.6 =
* 12/12/16
* Fix - Shipping value was not being sent to PayPal. This was caused a change on PayPal's system.

= 1.9.5 =
* 9/13/16
* Fix - If using a radio button as a form item, the quantity was not being correctly passed to PayPal.

= 1.9.4 =
* 9/13/16
* Feature - Added 2 Option text fields for up to 5 items.
* Fix - Checkbox description fields were not being correctly passed to PayPal.
* Fix - Option text was not being correctly passed to PayPal due.

= 1.9.3 =
* 9/7/16
* Bug fix - Mutiple dropdown menu and checkbox values where not being correctly sent to PayPal.

= 1.9.2 =
* 8/23/16
* Bug fix - Fixed error that occured on some server running on older version of PHP.

= 1.9 =
* 8/22/16
* Feature - Now up to 5 price, quantity and item name fields can be linked to PayPal at a time.
* Feature - Reordered layout of input fields on PayPal tab.
* Feature - Fixed PayPal tab background color; now it looks like the rest of Contact Form 7.
* Feature - If item name is not set, then the item name "No item name" will be passed to PayPal.
* Feature - Fixed plugins license settings. Now a license key is not required to access the plugins page, but it is required to get updates.

= 1.8.4 =
* 4/27/16
* Bug fix - Shipping code feature in 1.8.3 was not working when using pipes.

= 1.8.3 =
* 4/27/16
* Added feature - Added Shipping Code field - Now shipping amount can be passed to PayPal via a form item.

= 1.8.2 =
* 4/14/16
* Bug fix - If skip redirect for 0.00 amount was checked and send email after payment was choosen, email was not sending
* Updated - Compatible WordPress version

= 1.8.1 =
* 3/14/16
* Bug fix - Bug fixed that caused licensces to sometimes not activate.

= 1.8 =
* 3/4/16
* Added feature - New internal upgrade manager.

= 1.7.9 =
* 2/23/16
* Added feature - Can override currency per form.

= 1.7.8 =
* 1/21/16
* Bug fix - Settings page not saving on some server configurations.

= 1.7.7 =
* 1/20/16
* Added feature - Shipping address settings added on setttings page
* Added feature - Can now skip redirecting to PayPal for 0.00 amounts, settings on PayPal tab of contact form
* Bug fix - Fixed spelling mistake on PayPal tab of contact form

= 1.7.6 =
* 1/4/16
* Bug fixed - Settings page redirect variables not getting set properly sometimes.

= 1.7.5 =
* 11/13/15
* Added feature - Added English - UK option to language list - this effects which PayPal page the customer is redirected to.

= 1.7.4 =
* 11/10/15
* Bug fixed - Non PayPal forms would redirect from bug from 1.7 update.
* Bug fixed - If send email before payment option was choosen a PHP error was shown in the log.

= 1.7.3 =
* 11/3/15
* Bug fixed - Plugin would not redirect to PayPal due to error caused by some servers running on older version of PHP.

= 1.7.2 =
* 11/2/15
* Bug fixed - License activation problems

= 1.7.1 =
* 10/27/15
* Bug fixed - Error shown when using PHP 5.4 or below.

= 1.7 =
* 10/27/15
* Major release
* Feature - Alternative method of redirecting to PayPal - can change method on settings page.
* Bug fixed - Attachements now work properly, for both redirect methods.
* Feature - Added hook for developers - after payment has been completed - name of hook is: cf7pp_payment_successful
* Feature - Flamingo integeration - now contacts are added to flamingo database using redriect method 1.

= 1.6.3 =
* 9/13/15
* Bug fixed - Modified IPN failed notice.

= 1.6.2 =
* 9/22/15
* Added feature - Plugin now supports all Contact Form 7 speical mail tags.

= 1.6.1 =
* 9/9/15
* Bug fixed - Can pass date through from Contact Form 7 now using [_date]

= 1.6 =
* 9/8/15
* Bug fixed - PayPal IPN not being received on some forms.

= 1.5.9 =
* 9/4/15
* Bug fixed - PayPal IPN eror related to sandbox on individual forms.

= 1.5.8 =
* 9/2/15
* Added feature - Can enable PayPal sandbox on individual forms

= 1.5.6 =
* 8/25/15
* Bug fixed - PayPal return URL sometimes shows up as blank page.

= 1.5.5 =
* 8/24/15
* Bug fixed - PayPal IPN not working if using URL rewrite on website.

= 1.5.4 =
* 8/18/15
* Added feature - Can pass radio button text field to PayPal now by using Contact Form 7's free_text option.

= 1.5.3 =
* 8/17/15
* Added feature - PayPal item description can now be linked to a Contact Form 7 item.

= 1.5.2 =
* 8/15/15
* Bug fixed - If send email after payment was selected, secondary email was not sending.

= 1.5 =
* 8/13/15
* Added feature - Ability to only send Contact Form 7 email is payment is successful or not at all
* Bug fixed - Some server permissions didn't allow plugin to be deactivated

= 1.4.4 =
* Added feature - Ability for each form to have its own PayPal account

= 1.4.3 =
* Added feature - If using pipes for price, description can be passed in both option fields

= 1.4.2 =
* Added feature - checkboxes amounts are now added together for price

= 1.4.1 =
* Fix bug related to price and radio buttons

= 1.4 =
* Compatibility fix for new layout of Contact Form 7 4.2

= 1.3 =
* Added feature to allow pipes on price field

= 1.2 =
* Added feature to link to form items

= 1.1 =
* Fixed failed to open stream problem

= 1.0 =
* Initial release





== Upgrade Notice ==

= 2.3.1 =
* 10/23/17
* Fix - Plugin should not work with many more Contact Form 7 extensions, such as Mailchimp, Google Sheets, Datepicker, etc.
* Fix - Currency will now pass through a filter, this is useful as PayPal does not accept $ anymore in front of amounts.
* Fix - Free version is deactivated upon pro version activate.

= 2.3 =
* 10/19/17
* New - Link customer input fields to auto populate on PayPal. Documentation: https://wpplugin.org/documentation/link-customer-input-values/
* New - Landing Page on PayPal can now be set. Documentation: https://wpplugin.org/documentation/credit-card-landing-page/

= 2.2.1 =
* 10/12/17
* New - Skip Code can now contains mutiple form elements seperated by a comma. The total price determines if the form should redirect or not.

= 2.2 =
* 10/9/17
* New - Comlpetely rewrote the PayPal IPN listener. This should be more stable on diffent server environments.

= 2.1.2 =
* 9/29/17
* Bug fix - Fixed code error regarding Skip Redirect Code feature.

= 2.1.1 =
* 9/3/17
* Bug fix - Function name being used in other plugin. This caused an error in certain circumstances.

= 2.1 =
* 9/2/17
* New - Added feature to allow the use of the code [txn_id] on the email body section. If the form is set to send "email after payment", then this code will be replaced with the PayPal Transaction ID.
* New - Added skip redirect form code feature. This allows a form element such as a dropdown menu to control if the form will redirect to PayPal or skip the redirect.

= 2.0.4 =
* 8/25/17
* New - Added new PayPal IPN success hook. The new hook: cf7pp_payment_successful_pre_post_delete is called before the cf7pp post is deleted.
* New - Added test template redirect hook that can be used for IPN URL testing. Format: http://example.com?cf7pp_test=1
* Bug fix - Default quantity 5 form redirect element had wrong variable name.

= 2.0.3 =
* 8/21/17
* Bug fix - Contact Form 7 version 4.9 changed the way the skip mail function works.

= 2.0.2 =
* 6/19/17
* Bug fix - Facebook Browser was redirecting to PayPal home page.

= 2.0.1 =
* 5/17/17
* Fix - Fixed illegal string offset bug that occured in debug mode on a small amount of servers running PHP 5.6.
* Update - Updated plugin update class.

= 2.0 =
* 5/2/17
* Tweak - Version bump due to issue with updater - for some users the most recent verion was not showing.
* Update - Tested with Contact Form 7 and WordPress version 4.7.4

= 1.9.11 =
* 3/4/17
* Important - Please Update Immediately to this version.
* Fix - Contact Form 7 version 4.7 changed some internal code which caused this plugin to not correctly redirect to PayPal and give error messages. Version 1.9.11 fixes this issue.

= 1.9.10 =
* 2/7/17
* Fix - Alignment on settings page input boxes.

= 1.9.9 =
* 1/26/17
* Feature - Specify a manual PayPal IPN (Instant Payment Notification) URL on the settings page.

= 1.9.8 =
* 1/24/17
* Feature - Language is now used to set default dropdown menu billing country in PayPal.

= 1.9.7 =
* 1/6/17
* Fix - Item description / name was not being correct passed to PayPal when set as a static value.

= 1.9.6 =
* 12/12/16
* Fix - Shipping value was not being sent to PayPal. This was caused a change on PayPal's system.

= 1.9.5 =
* 9/13/16
* Fix - If using a radio button as a form item, the quantity was not being correctly passed to PayPal.

= 1.9.4 =
* 9/13/16
* Feature - Added 2 Option text fields for up to 5 items.
* Fix - Checkbox description fields were not being correctly passed to PayPal.
* Fix - Option text was not being correctly passed to PayPal due.

= 1.9.3 =
* 9/7/16
* Bug fix - Mutiple dropdown menu and checkbox values where not being correctly sent to PayPal.

= 1.9.2 =
* 8/23/16
* Bug fix - Fixed error that occured on some server running on older version of PHP.

= 1.9 =
* 8/22/16
* Feature - Now up to 5 price, quantity and item name fields can be linked to PayPal at a time.
* Feature - Reordered layout of input fields on PayPal tab.
* Feature - Fixed PayPal tab background color; now it looks like the rest of Contact Form 7.
* Feature - If item name is not set, then the item name "No item name" will be passed to PayPal.
* Feature - Fixed plugins license settings. Now a license key is not required to access the plugins page, but it is required to get updates.

= 1.8.4 =
* 4/27/16
* Bug fix - Shipping code feature in 1.8.3 was not working when using pipes.

= 1.8.3 =
* 4/27/16
* Added feature - Added Shipping Code field - Now shipping amount can be passed to PayPal via a form item.

= 1.8.2 =
* 4/14/16
* Bug fix - If skip redirect for 0.00 amount was checked and send email after payment was choosen, email was not sending
* Updated - Compatible WordPress version

= 1.8.1 =
* 3/14/16
* Bug fix - Bug fixed that caused licensces to sometimes not activate.

= 1.8 =
* 3/4/16
* Added feature - New internal upgrade manager.

= 1.7.9 =
* 2/23/16
* Added feature - Can override currency per form.

= 1.7.8 =
* 1/21/16
* Bug fix - Settings page not saving on some server configurations.

= 1.7.7 =
* 1/20/16
* Added feature - Shipping address settings added on setttings page
* Added feature - Can now skip redirecting to PayPal for 0.00 amounts, settings on PayPal tab of contact form
* Bug fix - Fixed spelling mistake on PayPal tab of contact form

= 1.7.6 =
* 1/4/16
* Bug fixed - Settings page redirect variables not getting set properly sometimes.

= 1.7.5 =
* 11/13/15
* Added feature - Added English - UK option to language list - this effects which PayPal page the customer is redirected to.

= 1.7.4 =
* 11/10/15
* Bug fixed - Non PayPal forms would redirect from bug from 1.7 update.
* Bug fixed - If send email before payment option was choosen a PHP error was shown in the log.

= 1.7.3 =
* 11/3/15
* Bug fixed - Plugin would not redirect to PayPal due to error caused by some servers running on older version of PHP.

= 1.7.2 =
* 11/2/15
* Bug fixed - License activation problems

= 1.7.1 =
* 10/27/15
* Bug fixed - Error shown when using PHP 5.4 or below.

= 1.7 =
* 10/15/15
* Major release
* Feature - Alternative method of redirecting to PayPal - can change method on settings page.
* Bug fixed - Attachements now work properly, for both redirect methods.
* Feature - Added hook for developers - after payment has been completed - name of hook is: cf7pp_payment_successful
* Feature - Flamingo integeration - now contacts are added to flamingo database using redriect method 1.

= 1.6.3 =
* 9/13/15
* Bug fixed - Modified IPN failed notice.

= 1.6.2 =
* 9/13/15
* Added feature - Plugin now supports all Contact Form 7 speical mail tags.

= 1.6.1 =
* 9/9/15
* Bug fixed - Can pass date through from Contact Form 7 now using [_date]

= 1.6 =
* 9/8/15
* Bug fixed - PayPal IPN not being received on some forms.

= 1.5.9 =
* 9/4/15
* Bug fixed - PayPal IPN eror related to sandbox on individual forms.

= 1.5.8 =
* 9/2/15
* Added feature - Can enable PayPal sandbox on individual forms

= 1.5.6 =
* 8/25/15
* Bug fixed - PayPal return URL sometimes shows up as blank page.

= 1.5.5 =
* 8/24/15
* Bug fixed - PayPal IPN not working if using URL rewrite on website.

= 1.5.4 =
* 8/18/15
* Added feature - Can pass radio button text field to PayPal now by using Contact Form 7's free_text option.

= 1.5.3 =
* 8/17/15
* Added feature - PayPal item description can now be linked to a Contact Form 7 item.

= 1.5.2 =
* 8/15/15
* Bug fixed - If send email after payment was selected, secondary email was not sending.

= 1.5 =
* 8/13/15
* Added feature - Ability to only send Contact Form 7 email is payment is successful or not at all
* Bug fixed - Some server permissions didn't allow plugin to be deactivated

= 1.4.4 =
* Added feature - Ability for each form to have its own PayPal account

= 1.4.3 =
* Added feature - If using pipes for price, description can be passed in both option fields

= 1.4.2 =
* Added feature - checkboxes amounts are now added together for price

= 1.4.1 =
* Fix bug related to price and radio buttons

= 1.4 =
* Compatibility fix for new layout of Contact Form 7 4.2

= 1.3 =
* Added feature to allow pipes on price field

= 1.2 =
* Added feature to link to form items

= 1.1 =
* Fixed failed to open stream problem

= 1.0 =
* Initial release