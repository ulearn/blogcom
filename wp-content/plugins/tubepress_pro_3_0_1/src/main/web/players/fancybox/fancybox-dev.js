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
    var name                 = 'fancybox',
        subscribe            = tubePress.Beacon.subscribe,
        domInjector          = tubePress.DomInjector,
        path                 = tubePress.Environment.getBaseUrl() + '/src/main/web/vendor/fancybox/',
        event_prefix_players = 'tubepress.players.',

        isFancyBoxAvailable = function () {
            
            return tubePress.Lang.Utils.isDefined(jquery.fancybox);
        },
        
        loadFancyboxIfNeeded = function () {
          
            if (!isFancyBoxAvailable()) {

                domInjector.loadJs(path + 'jquery.fancybox-1.3.4.js');
                domInjector.loadCss(path + 'jquery.fancybox-1.3.4.css');
            }
        },
        
        invoke = function (e, playerName, height, width, videoId, galleryId) {

            if (playerName !== name) {

                return;
            }
            
            jquery.fancybox.showActivity();
        },

        populate = function (e, playerName, title, html, height, width, videoId, galleryId) {

            if (playerName !== name) {

                return;
            }
            
            jquery.fancybox({

                'content'        : html,
                'height'         : parseInt(height, 10) + 5,
                'width'          : width,
                'autoDimensions' : false,
                'title'          : title
            });
        };

    subscribe(event_prefix_players + 'invoke', invoke);
    subscribe(event_prefix_players + 'populate', populate);
    
    loadFancyboxIfNeeded();
    
}(jQuery, TubePress));