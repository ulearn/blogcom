/**
 * Handles Ajax interactive searching.
 */
(function (jquery, tubepress) {

    var beacon = tubepress.Beacon,

        onAjaxSearchRequested = function (event, galleryInitJs, rawSearchTerms, galleryId) {

            //noinspection JSUnresolvedVariable
            /** These variable declarations aide in compression. */
            var targetDomSelector = galleryInitJs.nvpMap.searchResultsDomId,
                tubepressGallery  = window.TubePressGallery,
                galleryRegistry   = tubepressGallery ? tubepressGallery.Registry : undefined,
                logger            = tubepress.Logger,

                /** Some vars we'll need later. */
                callback,
                ajaxResultSelector,
                finalAjaxContentDestination,

                urlParams = {

                    action           : 'shortcode',
                    tubepress_search : rawSearchTerms
                },

                /** Does a gallery with this ID already exist? */
                galleryExists = galleryRegistry && galleryRegistry.isRegistered(galleryId),

                /** Does the target DOM exist? */
                targetDomExists = tubepress.Lang.Utils.isDefined(targetDomSelector) && jquery(targetDomSelector).length > 0;

            /** We have three cases to handle... */
            if (galleryExists) {

                //CASE 1: gallery already exists

                /** Stick the thumbs into the existing thumb area. */
                finalAjaxContentDestination = galleryRegistry.getThumbAreaSelector(galleryId);

                /** We want just the new thumbnails. */
                ajaxResultSelector = finalAjaxContentDestination + ' > *';

                /** Announce the new thumbs */
                callback = function () {

                    beacon.publish('tubepress.gallery.newthumbs', [ galleryId ]);
                };

            } else {

                if (targetDomExists) {

                    //CASE 2: TARGET SELECTOR EXISTS AND GALLERY DOES NOT EXIST

                    /** Stick the gallery into the target DOM. */
                    finalAjaxContentDestination = targetDomSelector;

                } else {

                    //CASE 3: TARGET SELECTOR DOES NOT EXIST AND GALLERY DOES NOT EXIST

                    if (logger.on()) {

                        logger.log('Bad target selector and missing gallery');
                    }

                    return;
                }
            }

            if (logger.on()) {

                logger.log('Final dest: ' + finalAjaxContentDestination);
                logger.log('Ajax selector: ' + ajaxResultSelector);
            }

            jquery.extend(urlParams, galleryInitJs.nvpMap);

            //noinspection JSUnresolvedVariable
            tubepress.Ajax.Executor.loadAndStyle(

                galleryInitJs.jsMap.httpMethod,

                tubepress.Environment.getBaseUrl() + '/src/main/php/scripts/ajaxEndpoint.php?' + jquery.param(urlParams),

                finalAjaxContentDestination,

                ajaxResultSelector,

                null,

                callback
            );
        };

    beacon.subscribe('tubepress.search.ajax', onAjaxSearchRequested);

}(jQuery, TubePress));