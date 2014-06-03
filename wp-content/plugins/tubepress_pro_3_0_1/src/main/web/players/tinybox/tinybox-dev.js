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
	var name	             = 'tinybox',
        event_prefix_players = 'tubepress.players.',
        subscribe            = tubePress.Beacon.subscribe,
		path	             = tubePress.Environment.getBaseUrl() + '/src/main/web/vendor/tinybox/',
        domInjector          = tubePress.DomInjector,
        selector             = '#tinycontent',

        invoke = function (e, playerName, height, width, videoId, galleryId) {

            if (playerName !== name) {

                return;
            }

			TINY.box.show('', 0, width, height, 1);
		},

        populate = function (e, playerName, title, html, height, width, videoId, galleryId) {

            if (playerName !== name) {

                return;
            }

			var element = jquery(selector);
			
			if (element.width() !== parseInt(width, 10)) {

				setTimeout(function () {

					populate(e, name, title, html, height, width, videoId, galleryId);

				}, 10);
				
			} else {

				jquery(selector).html(html);
			}
		};

    if (!tubePress.Lang.Utils.isDefined(window.TINY)) {

        domInjector.loadJs(path + 'tinybox.js');
        domInjector.loadCss(path + 'style.css');
    }

    subscribe(event_prefix_players + 'invoke', invoke);
    subscribe(event_prefix_players + 'populate', populate);

}(jQuery, TubePress));