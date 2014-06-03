<?php
/*
Plugin Name: WP SUP
Plugin URI: http://neothoughts.com/wp-sup/
Description: A SUP (Simple Update Protocol) plugin for WordPress. It adds the SUP-ID HTTP header to your site's feed and pings FriendFeed's public SUP feed.
Author: Derek van Vliet
Version: 1.1
Author URI: http://neothoughts.com/

Copyright 2008 Derek van Vliet (email : derek@neothoughts.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function ping($url) {
	$curl_handle = curl_init();
	curl_setopt($curl_handle,CURLOPT_URL, $url);
	curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER, 1);
	curl_exec($curl_handle);
	curl_close($curl_handle);
}


function wpsup_get_supid() {
	return substr(md5(get_bloginfo('url')), 0, 10);
}

function wpsup_header() {
	if(is_feed()) {
		$supid = wpsup_get_supid();
		$supheader = 'X-SUP-ID: http://friendfeed.com/api/public-sup.json#' . $supid;
		header($supheader);
	}
}

add_action('pre_get_posts', 'wpsup_header');

function wpsup_publish() {
	$supid = wpsup_get_supid();
	$feedurl = urlencode(get_bloginfo('rss2_url'));
	$url = 'http://friendfeed.com/api/public-sup-ping?supid=' . $supid . '&url=' . $feedurl;
	ping($url);
}

add_action('publish_post', 'wpsup_publish');

function wpsup_atom_head() {
	$supid = wpsup_get_supid();
	$link = '<link rel="http://api.friendfeed.com/2008/03#sup" type="application/json" href="http://friendfeed.com/api/public-sup.json#' . $supid . '"/>';
	echo $link;
}

add_action('atom_head', 'wpsup_atom_head');

function wpsup_rdf_head() {
	$supid = wpsup_get_supid();
	$link = '<link rel="http://api.friendfeed.com/2008/03#sup" xmlns="http://www.w3.org/2005/Atom" type="application/json" href="http://friendfeed.com/api/public-sup.json#' . $supid . '"/>';
	echo $link;
}

add_action('rdf_header', 'wpsup_rdf_head');

function wpsup_rss_head() {
	$supid = wpsup_get_supid();
	$link = '<link rel="http://api.friendfeed.com/2008/03#sup" xmlns="http://www.w3.org/2005/Atom" type="application/json" href="http://friendfeed.com/api/public-sup.json#' . $supid . '"/>';
	echo $link;
}

add_action('rss_head', 'wpsup_rss_head');

function wpsup_rss2_head() {
	$supid = wpsup_get_supid();
	$link = '<link rel="http://api.friendfeed.com/2008/03#sup" xmlns="http://www.w3.org/2005/Atom" type="application/json" href="http://friendfeed.com/api/public-sup.json#' . $supid . '"/>';
	echo $link;
}

add_action('rss2_head', 'wpsup_rss2_head');
?>
