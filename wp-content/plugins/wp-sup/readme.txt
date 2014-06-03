=== WP SUP ===
Contributors: derekvanvliet
Tags: friendfeed, sup, feeds, syndication, rss, atom, rdf, simpleupdateprotocol
Requires at least: 2.0.2
Tested up to: 2.7
Stable tag: 1.1

WP SUP implements FriendFeed's [Simple Update Protocol](http://code.google.com/p/simpleupdateprotocol/ "Simple Update Protocol"). Your blog posts will appear on FriendFeed near-instantly after they are published.

== Description ==

WP SUP is a plugin for WordPress that implements FriendFeed's Simple Update Protocol. Your blog posts will appear on FriendFeed near-instantly after they are published.

The plugin adds the SUP-ID HTTP header to your blog's feeds and adds the SUP-ID link tag to your blog's feeds.

It also pings FriendFeed's [public SUP feed](http://friendfeed.com/api/public-sup "Public SUP Feed") when you publish a post.

== Installation ==

1. Upload `wp-sup.php` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. You're done!

== Frequently Asked Questions ==

= Is this plugin compatible with FeedBurner feeds? =

No. The changes that are applied to your feeds are not propagated to FeedBurner feeds.