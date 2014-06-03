/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

(function (jquery, tubePress) {
	
	/* this stuff helps compression */
	var name	             = 'detached',
        subscribe            = tubePress.Beacon.subscribe,
        event_prefix_players = 'tubepress.players.',
        selectorPrefix       = '#tubepress_detached_player_',
        loadStyler           = tubePress.Ajax.LoadStyler,

        invoke = function (e, playerName, height, width, videoId, galleryId) {

            if (playerName !== name) {

                return;
            }

			var selector = selectorPrefix + galleryId;

            loadStyler.applyLoadingStyle(selector);
			jquery(selector)[0].scrollIntoView(true);
		},

        populate = function (e, playerName, title, html, height, width, videoId, galleryId) {

            if (playerName !== name) {

                return;
            }

            var selector = selectorPrefix + galleryId;
			
			jquery(selector).html(html);
            loadStyler.removeLoadingStyle(selector);
		};

    subscribe(event_prefix_players + 'invoke', invoke);
    subscribe(event_prefix_players + 'populate', populate);

}(jQuery, TubePress));