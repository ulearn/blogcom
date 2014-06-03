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
 * Writes the video sequence to JavaScript.
 */
class tubepress_plugins_procore_impl_filters_galleryinitjs_GalleryInitJsSequencer
{
    private static $_PROPERTY_NVPMAP = 'nvpMap';
    private static $_PROPERTY_JSMAP  = 'jsMap';

    public function onGalleryInitJsConstruction(tubepress_api_event_TubePressEvent $event)
    {
        $context  = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $args     = $event->getSubject();

        /**
         * Grab the existing maps, if they exist, or create fresh ones.
         */
        $nvp = isset($args[self::$_PROPERTY_NVPMAP]) ? $args[self::$_PROPERTY_NVPMAP] : array();
        $js  = isset($args[self::$_PROPERTY_JSMAP]) ? $args[self::$_PROPERTY_JSMAP] : array();

        /**
         * Delete the existing sequence from the NVP so we don't resend it via Ajax.
         */
        unset($nvp[tubepress_api_const_options_names_Embedded::SEQUENCE]);

        /**
         * Write the sequence to JavaScript.
         */
        $sequence = $context->get(tubepress_api_const_options_names_Embedded::SEQUENCE);
        $js[tubepress_api_const_options_names_Embedded::SEQUENCE] = $sequence;

        $autoNext = $context->get(tubepress_api_const_options_names_Embedded::AUTONEXT) ? 'true' : 'false';
        $js[tubepress_api_const_options_names_Embedded::AUTONEXT] = $autoNext ? true : false;

        /**
         * Reset the maps and restore them into the event.
         */
        $args[self::$_PROPERTY_NVPMAP] = $nvp;
        $args[self::$_PROPERTY_JSMAP]  = $js;


        $event->setSubject($args);
    }
}