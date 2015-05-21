==== Authorize.Net Payment Gateway WooCommerce Addon ====
Contributors: nazrulhassanmca
Plugin Name: Authorize.Net WooCommerce Lightweight Addon
Plugin URI: https://wordpress.org/plugins/authorizenet-woocommerce-lightweight-addon/
Tags: woocommerce, authorize.net, woocommerce addon ,authorize.net for woocommerce,authorize.net for wordpress,credit card payment with Authorize.Net,authorize.net for woocommerce,authorize.net payment gateway for woocommerce
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=nazrulhassan@ymail.com&item_name=Donation+Authorize.Net+Woocommerce+Addon
Requires at least: 4.0
Author: nazrulhassanmca
Tested up to: 4.2.2 & Woocommerce 2.3.9
Stable tag: 1.0
License: GPLv2

== Description ==

This plugin is an addon for WooCommerce to implement a payment gateway method for accepting **Credit Cards Payments** By merchants via **Authorize.Net** Gateway

This plugin uses AIM and is light weight version of https://wordpress.org/plugins/authorizenet-woocommerce-addon/  Lightweight in sense it  does not use any Authorize.Net Libraries bundled with it it simply Uses CURL to pass data to payment gateway


= Features =
1. Very Simple Clean Code plugin to add a Authorize.Net payment method to woocommerce
2. No technical skills needed.
3. Prerequisite visualized on screenshots.
4. Adds Transaction ID, Authorization Code, Response Reason to Order Note.
5. Can be customized easily.
6. Can work with sandbox/live Authorize.Net accounts for testing purpose.
7. This plugin currently **Supports accepting in USD**.
8. This plugin **does not store Credit Card Details**.
9. MD5 Hash not neccesary as this plugin uses AIM http://developer.authorize.net/faqs/#md5


== Screenshots ==

1. Screenshot-1 - Api Key Location 
2. Screenshot-2 - Admin Settings of Addon
3. Screenshot-3 - Checkout Page Form
4. Screenshot-4 - Admin order details
5. Screenshot-5 - Authorize.Net Order Details

== Installation ==

1. Upload 'authorize.net-woocommerce-lightweight-addon' folder to the '/wp-content/plugins/' directory
2. Activate 'Authorize.Net WooCommerce Lightweight Addon' from wp plugin lists in admin area
3. Plugin will appear in settings of woocommerce
4. You can set the addon settings from wocommmerce->settings->Checkout->Authorize.Net Cards Settings


== Frequently Asked Questions ==

1. You need to have woocoommerce plugin installed to make this plugin work.
2. You need to follow Authorize.Net -> Accounts ->  	API Login ID and Transaction Key  in account to Obtain Api key & transaction key
3. This plugin works on test & live mode of Authorize.Net.
4. This plugin readily works on developmentment server.
5. This plugin does not requires SSL.
6. This plugin does not store Card Details anywhere.
7. You can check for Testing Card No Here http://developer.authorize.net/faqs/#testccnumbers
8. This plugin requires CURL installed. 
9. This plugin does not support Pre Order or Subscriptions 
10. This plugin does not support Refunds in woocommmerce interface
== Changelog ==
This is first version no known errors found this is a replacement for https://wordpress.org/plugins/authorizenet-woocommerce-addon/  That shows Error Connecting Authorize.Net

== Upgrade Notice == 
This is first version no known notices yet
