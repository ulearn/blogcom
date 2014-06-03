/**
 * Copyright 2006 - 2013 TubePress LLC (http://tubepress.org)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @author Eric D. Hough (eric@tubepress.org)
 */
(function (jquery, win, tubepress) {

    /** http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/ */
    'use strict';

    var beacon               = tubepress.Beacon,
        publish              = beacon.publish,
        subscribe            = beacon.subscribe,
        langUtils            = tubepress.Lang.Utils,
        logger               = tubepress.Logger,
        eventPrefixPlayerApi = 'tubepress.video.',
        playerApiLoadEvent   = eventPrefixPlayerApi + 'load',
        loggerOn             = logger.on(),

        /**
         * Utilities for the player APIs.
         */
        playerApiUtils = (function () {

            var
                /**
                 * Helper method to trigger events on jQuery(document).
                 */
                triggerEvent = function (eventName, videoId, domId, providerName, playerImplementationName) {

                    publish(eventName, [ videoId, domId, providerName, playerImplementationName ]);
                },

                /**
                 * A video has started.
                 */
                fireVideoStarted = function (videoId, domId, providerName, playerImplementationName) {

                    triggerEvent(eventPrefixPlayerApi + 'start', videoId, domId, providerName, playerImplementationName);
                },

                /**
                 * A video has stopped.
                 */
                fireVideoStopped = function (videoId, domId, providerName, playerImplementationName) {

                    triggerEvent(eventPrefixPlayerApi + 'stop', videoId, domId, providerName, playerImplementationName);
                },

                /**
                 * A video is buffering.
                 */
                fireVideoBuffering = function (videoId, domId, providerName, playerImplementationName) {

                    triggerEvent(eventPrefixPlayerApi + 'buffer', videoId, domId, providerName, playerImplementationName);
                },

                /**
                 * A video has paused.
                 */
                fireVideoPaused = function (videoId, domId, providerName, playerImplementationName) {

                    triggerEvent(eventPrefixPlayerApi + 'pause', videoId, domId, providerName, playerImplementationName);
                },

                /**
                 * A video has encountered an error.
                 */
                fireVideoError = function (videoId, domId, providerName, playerImplementationName) {

                    triggerEvent(eventPrefixPlayerApi + 'error', videoId, domId, providerName, playerImplementationName);
                },

                getDataFromDomId = function (domId, dataName) {

                    return jquery('#' + domId).data(dataName);
                },

                getVideoIdFromDomId = function (domId) {

                    return getDataFromDomId(domId, 'videoid');
                },

                getPlayerImplNameFromDomId = function (domId) {

                    return getDataFromDomId(domId, 'playerimplementation');
                },

                getVideoProviderFromDomId = function (domId) {

                    return getDataFromDomId(domId, 'videoprovidername');
                },

                loadScriptWithCache = function (path) {

                    jquery.ajax({

                        url      : path,
                        dataType : 'script',
                        cache    : true
                    });
                };

            return {

                fireVideoError             : fireVideoError,
                fireVideoPaused            : fireVideoPaused,
                fireVideoBuffering         : fireVideoBuffering,
                fireVideoStopped           : fireVideoStopped,
                fireVideoStarted           : fireVideoStarted,
                getVideoIdFromDomId        : getVideoIdFromDomId,
                getVideoProviderFromDomId  : getVideoProviderFromDomId,
                getPlayerImplNameFromDomId : getPlayerImplNameFromDomId,
                loadScriptWithCache        : loadScriptWithCache
            };

        }()),

        youTubeIframeApi = (function () {

            var

                /** These variable declarations aide in compression. */
                isDef        = langUtils.isDefined,
                text_youtube = 'youtube',

                isLoadingApi   = false,
                youTubePlayers = {},

                getDomIdFromYouTubeEvent = function (event) {

                    return event.target.a.id;
                },

                /**
                 * Pulls out the video ID from a YouTube event.
                 */
                getVideoIdFromYouTubeEvent = function (event) {

                    return playerApiUtils.getVideoIdFromDomId(getDomIdFromYouTubeEvent(event));
                },

                /**
                 * Is the YouTube API available yet?
                 */
                isYouTubeApiAvailable = function () {

                    //noinspection JSUnresolvedVariable
                    return isDef(win.YT) && isDef(win.YT.Player);
                },

                /**
                 * Load the YouTube API, if necessary.
                 */
                loadYouTubeApi = function () {

                    if (isLoadingApi || isYouTubeApiAvailable()) {

                        return;
                    }

                    isLoadingApi = true;

                    var path = win.location.protocol + '//www.youtube.com/player_api';

                    playerApiUtils.loadScriptWithCache(path);
                },

                /**
                 * The YouTube player will call this method when a player event
                 * fires.
                 */
                onYouTubeStateChange = function (event) {

                    //noinspection JSUnresolvedVariable
                    var videoId     = getVideoIdFromYouTubeEvent(event),
                        domId       = getDomIdFromYouTubeEvent(event),
                        playerImpl  = playerApiUtils.getPlayerImplNameFromDomId(domId),
                        eventData   = event.data,
                        playerState = YT.PlayerState;

                    /**
                     * If we can't parse the event, just bail.
                     */
                    if (videoId === null) {

                        return;
                    }

                    //noinspection JSUnresolvedVariable
                    switch (eventData) {

                    case playerState.PLAYING:

                        playerApiUtils.fireVideoStarted(videoId, domId, text_youtube, playerImpl);
                        break;

                    case playerState.PAUSED:

                        playerApiUtils.fireVideoPaused(videoId, domId, text_youtube, playerImpl);
                        break;

                    case playerState.ENDED:

                        playerApiUtils.fireVideoStopped(videoId, domId, text_youtube, playerImpl);
                        break;

                    case playerState.BUFFERING:

                        playerApiUtils.fireVideoBuffering(videoId, domId, text_youtube, playerImpl);
                        break;

                    case -1:

                        //YouTube "unstarted" event
                        //https://developers.google.com/youtube/iframe_api_reference#Events
                        break;

                    default:

                        if (loggerOn) {

                            logger.log('Unknown YT event');
                            logger.dir(event);
                        }

                        break;
                    }
                },

                /**
                 * YouTube will call this when a player hits an error.
                 */
                onYouTubeError = function (event) {

                    var videoId    = getVideoIdFromYouTubeEvent(event),
                        domId      = getDomIdFromYouTubeEvent(event),
                        playerImpl = playerApiUtils.getPlayerImplNameFromDomId(domId);

                    if (videoId === null) {

                        return;
                    }

                    if (loggerOn) {

                        logger.log('YT error');
                        logger.dir(event);
                    }

                    playerApiUtils.fireVideoError(videoId, domId, text_youtube, playerImpl);
                },

                /**
                 * Registers a YouTube player for use with the TubePress API.
                 */
                registerYouTubeVideo = function (domId) {

                    /** Load 'er up. */
                    loadYouTubeApi();

                    /** This stuff will execute once the TubePress API is loaded. */
                    var callback = function () {

                        if (loggerOn) {

                            logger.log(text_youtube + ' API is available');
                        }

                        //noinspection JSUnresolvedFunction,JSUnresolvedVariable
                        youTubePlayers[domId] = new YT.Player(domId, {

                            events: {

                                'onError'       : onYouTubeError,
                                'onStateChange' : onYouTubeStateChange
                            }
                        });
                    };

                    langUtils.callWhenTrue(callback, isYouTubeApiAvailable, 250);
                },

                onNewVideoRegistered = function (event, videoId, domId, providerName, playerImplementationName) {

                    if (playerImplementationName === text_youtube) {

                        registerYouTubeVideo(domId);
                    }
                };

            subscribe(playerApiLoadEvent, onNewVideoRegistered);

            /**
             * It's necessary to make these functions public, as the YouTube API will need to call them
             */
            return {

                onYouTubeStateChange : onYouTubeStateChange,
                onYouTubeError       : onYouTubeError
            };
        }()),

        vimeoPlayerApi = (function () {

            var
                /** Vimeo variables. */
                loadingVimeoApi = false,
                vimeoPlayers    = {},
                text_vimeo      = 'vimeo',

                /**
                 * Is the Vimeo API available yet?
                 */
                isVimeoApiAvailable = function () {

                    //noinspection JSUnresolvedVariable
                    return langUtils.isDefined(win.Froogaloop);
                },

                /**
                 * Load the Vimeo API, if necessary.
                 */
                loadVimeoApi = function () {

                    if (!loadingVimeoApi && !isVimeoApiAvailable()) {

                        loadingVimeoApi = true;

                        playerApiUtils.loadScriptWithCache(win.location.protocol + '//a.vimeocdn.com/js/froogaloop2.min.js');
                    }
                },

                /**
                 * Vimeo will call then when a video starts.
                 */
                onVimeoPlay = function (domId) {

                    var videoId    = playerApiUtils.getVideoIdFromDomId(domId),
                        provider   = playerApiUtils.getVideoProviderFromDomId(domId),
                        playerImpl = playerApiUtils.getPlayerImplNameFromDomId(domId);

                    playerApiUtils.fireVideoStarted(videoId, domId, provider, playerImpl);
                },

                /**
                 * Vimeo will call then when a video pauses.
                 */
                onVimeoPause = function (domId) {

                    var videoId    = playerApiUtils.getVideoIdFromDomId(domId),
                        provider   = playerApiUtils.getVideoProviderFromDomId(domId),
                        playerImpl = playerApiUtils.getPlayerImplNameFromDomId(domId);

                    playerApiUtils.fireVideoPaused(videoId, domId, provider, playerImpl);
                },

                /**
                 * Vimeo will call then when a video ends.
                 */
                onVimeoFinish = function (domId) {

                    var videoId    = playerApiUtils.getVideoIdFromDomId(domId),
                        provider   = playerApiUtils.getVideoProviderFromDomId(domId),
                        playerImpl = playerApiUtils.getPlayerImplNameFromDomId(domId);

                    playerApiUtils.fireVideoStopped(videoId, domId, provider, playerImpl);
                },

                /**
                 * A Vimeo player is ready for action.
                 */
                onVimeoReady = function (domId) {

                    if (loggerOn) {

                        logger.log(text_vimeo + ' API is available');
                    }

                    var froog = vimeoPlayers[domId];

                    froog.addEvent('play', onVimeoPlay);
                    froog.addEvent('pause', onVimeoPause);
                    froog.addEvent('finish', onVimeoFinish);
                },

                /**
                 * Registers a Vimeo player for use with the TubePress API.
                 */
                registerVimeoVideo = function (domId) {

                    /** Load up the API. */
                    loadVimeoApi();

                    var iframe = win.document.getElementById(domId),

                        callback = function () {

                            //noinspection JSUnresolvedFunction
                            /** Create and save the player. */
                            var froog = new Froogaloop(iframe);

                            vimeoPlayers[domId] = froog;

                            froog.addEvent('ready', onVimeoReady);
                        };

                    /** Execute it when Vimeo is ready. */
                    langUtils.callWhenTrue(callback, isVimeoApiAvailable, 400);
                },

                onNewVideoRegistered = function (event, videoId, domId, providerName, playerImplementationName) {

                    if (providerName === text_vimeo) {

                        registerVimeoVideo(domId);
                    }
                };

            subscribe(playerApiLoadEvent, onNewVideoRegistered);

            return {

                onVimeoReady  : onVimeoReady,
                onVimeoPlay   : onVimeoPlay,
                onVimeoPause  : onVimeoPause,
                onVimeoFinish : onVimeoFinish
            };
        }()),

        asyncPlayerRegistrar = (function () {

            var register = function (domId) {

                    var videoId              = playerApiUtils.getVideoIdFromDomId(domId),
                        playerImplementation = playerApiUtils.getPlayerImplNameFromDomId(domId),
                        providerName         = playerApiUtils.getVideoProviderFromDomId(domId);

                    publish(playerApiLoadEvent, [ videoId, domId, providerName, playerImplementation ]);
                };

            return {

                register : register
            };
        }());

    tubepress.AsyncUtil.processQueueCalls('tubePressPlayerApi', asyncPlayerRegistrar);

}(jQuery, window, TubePress));