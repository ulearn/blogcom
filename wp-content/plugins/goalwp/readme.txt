=== MailChimp Goal for WordPress ===
Contributors: mc_nate, MC_Will
Tags: MailChimp, MailChimp Goal, Goal,
Requires at least: 3.8
Tested up to: 3.9
Stable tag: 1.1.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin for adding MailChimp's Goal tracking code to your WordPress site.

== Description ==

= What is Goal? =

Goal is an optional campaign tracking feature available for [paid accounts](http://kb.mailchimp.com/article/how-do-mailchimp-pricing-plans-work) that lets you trigger [autoresponders](http://kb.mailchimp.com/article/how-do-i-create-an-autoresponder) based on subscriber activity from your email campaigns to your website. The Goal integration can also be used to create segments of subscribers allowing you to send targeted campaigns to your subscribers based on their Goal activity.

[More information about MailChimp Goal...](http://kb.mailchimp.com/article/how-do-i-use-goals-tracking/#how)

= Enable Goal for your MailChimp account =

Before installing MailChimp Goal for WordPress, make sure to enable Goal tracking in your MailChimp account.  From your MailChimp dashboard:

* Click your profile name to expand the Account Panel, then choose Account Settings.
* Click the Extras menu, and choose Integrations.
* Under the *Goal* heading, click "Enable."


== Installation ==

1. Upload `goalWP` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Connect your MailChimp account in *Settings > MailChimp Goal*.

== Frequently Asked Questions ==

= Where can I find my MailChimp API Key? =

From your MailChimp dashboard:

* Click your profile name to expand the Account Panel and choose Account Settings.
* Click the Extras menu and choose API keys.
* Copy an existing API key or click the Create A Key button.
* Label your key to keep your keys organized.

[Where can I find my API Key?](http://kb.mailchimp.com/article/where-can-i-find-my-api-key)

= I don't see any Goal activity for my subscribers, is it broken? =

In order for Goal to track subscribers, you'll want to check two things:

First, make sure Goal has been enabled in your MailChimp account.  After logging in to Mailchimp, click on your profile name to expand the Account Panel and choose Account Settings.  Click the Extras menu and choose Integrations.  From the list of integrations, click on the Goal option and click Enable.

Second, in order to track subscribers, you'll need to send a campaign with [Goal tracking](http://kb.mailchimp.com/article/how-can-i-add-additional-tracking-options-to-my-campaigns#goooal) enabled.

= Does MailChimp Goal work with Forever Free accounts? =

Right now, Goal is only available for paid accounts.

== Screenshots ==

1. Connect with your MailChimp API Key
2. A summary of the account

== Changelog ==

= 1.1 =
* Fix issue where datacenters wouldn't save.

= 1.0 =
* Initial release of MailChimp Goal for WordPress.
* Include Goal tracking javascript code within head tags for generic WordPress themes.
* Limit API calls to 1 inital call and save the significant values.
* Make things generally not explode-y.
