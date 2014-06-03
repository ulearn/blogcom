<?php
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
 * Performs TubePress-wide initialization.
 */
class tubepress_plugins_procore_ProCore
{
    public static function init()
    {
        self::_registerProCoreOptions();

        self::_registerEventListeners();
    }

    private static function _registerProCoreOptions()
    {
        $odr = tubepress_impl_patterns_sl_ServiceLocator::getOptionDescriptorReference();

        $option = new tubepress_spi_options_OptionDescriptor(tubepress_plugins_procore_api_const_options_names_Advanced::LANG);
        $option->setProOnly();
        $option->setValidValueRegex('/\w+/');
        $odr->registerOptionDescriptor($option);

        $option = new tubepress_spi_options_OptionDescriptor(tubepress_plugins_procore_api_const_options_names_InteractiveSearch::SEARCH_RESULTS_DOM_ID);
        $option->setProOnly();
        $odr->registerOptionDescriptor($option);
    }

    private static function _registerEventListeners()
    {
        $eventDispatcher = tubepress_impl_patterns_sl_ServiceLocator::getEventDispatcher();
        $callback        = array('tubepress_plugins_procore_ProCore', '_callbackHandleEvent');
        $eventNames      = array(

            tubepress_api_const_event_CoreEventNames::EMBEDDED_TEMPLATE_CONSTRUCTION,
            tubepress_api_const_event_CoreEventNames::VIDEO_GALLERY_PAGE_CONSTRUCTION,
            tubepress_api_const_event_CoreEventNames::VIDEO_CONSTRUCTION,
            tubepress_api_const_event_CoreEventNames::GALLERY_INIT_JS_CONSTRUCTION,
        );

        foreach ($eventNames as $eventName) {

            $eventDispatcher->addListener($eventName, $callback);
        }
    }

    public static function _callbackHandleEvent(tubepress_api_event_TubePressEvent $event)
    {
        switch ($event->getName()) {

            case tubepress_api_const_event_CoreEventNames::EMBEDDED_TEMPLATE_CONSTRUCTION:

                self::_call(

                    $event,
                    'tubepress_plugins_procore_impl_filters_embeddedtemplate_EmbeddedPlayerHttpsFilter', 'onEmbeddedTemplate'
                );

                self::_call(

                    $event,
                    'tubepress_plugins_procore_impl_filters_embeddedtemplate_ProYouTubeEmbeddedPlayerControls', 'onEmbeddedTemplate'
                );

                break;

            case tubepress_api_const_event_CoreEventNames::VIDEO_GALLERY_PAGE_CONSTRUCTION:

                self::_call(

                    $event,
                    'tubepress_plugins_procore_impl_filters_videogallerypage_SequenceLogger', 'onVideoGalleryPage'
                );

                break;

            case tubepress_api_const_event_CoreEventNames::VIDEO_CONSTRUCTION:

                self::_call(

                    $event,
                    'tubepress_plugins_procore_impl_filters_video_ProVideoConstructionFilter', 'onVideoConstruction'
                );

                break;

            case tubepress_api_const_event_CoreEventNames::GALLERY_INIT_JS_CONSTRUCTION:

                self::_call(

                    $event,
                    'tubepress_plugins_procore_impl_filters_galleryinitjs_GalleryInitJsSequencer', 'onGalleryInitJsConstruction'
                );
        }
    }

    private static function _call(tubepress_api_event_TubePressEvent $event, $serviceId, $functionName)
    {
        $serviceInstance = tubepress_impl_patterns_sl_ServiceLocator::getService($serviceId);

        $serviceInstance->$functionName($event);
    }
}

tubepress_plugins_procore_ProCore::init();