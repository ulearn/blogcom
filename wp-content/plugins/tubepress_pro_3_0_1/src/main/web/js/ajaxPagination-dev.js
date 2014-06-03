/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

/**
 * Handles Ajax pagination.
 */
(function (jquery, tubepress, tubePressGallery) {

    /** http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/ */
    'use strict';

    var beacon             = tubepress.Beacon,
        galleryRegistry    = tubePressGallery.Registry,
        eventPrefixGallery = 'tubepress.gallery.',

        /**
         * After we've loaded a new set of thumbs.
         */
        postLoad = function (galleryId) {

            beacon.publish(eventPrefixGallery + 'newthumbs', [ galleryId ]);
        },

        /** Handles an ajax pagination click. */
        changePage = function (galleryId, page) {

            var baseUrl       = tubepress.Environment.getBaseUrl(),
                nvpMap        = galleryRegistry.getNvpMap(galleryId),
                thumbnailArea = galleryRegistry.getThumbAreaSelector(galleryId),

                postLoadCallback = function () {

                    postLoad(galleryId);
                },

                toSend = {

                    action : 'shortcode'
                },

                pageToLoad         = baseUrl + '/src/main/php/scripts/ajaxEndpoint.php?tubepress_page=' + page + '&' + jquery.param(jquery.extend(toSend, nvpMap)),
                remotePageSelector = thumbnailArea + ' > *',
                httpMethod         = galleryRegistry.getHttpMethod(galleryId);

            tubepress.Ajax.Executor.loadAndStyle(httpMethod, pageToLoad, thumbnailArea, remotePageSelector, '', postLoadCallback);
        },

        /**
         * Adds click handlers to galleries with Ajax pagination.
         */
        onPageChangeRequested = function (e, galleryId, page) {

            if (galleryRegistry.isAjaxPagination(galleryId)) {

                changePage(galleryId, page);
            }
        };

    /** Sets up new thumbnails for ajax pagination */
    beacon.subscribe(eventPrefixGallery + 'pagechange', onPageChangeRequested);

}(jQuery, TubePress, TubePressGallery));