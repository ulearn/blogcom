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
 * HTML generation strategy that generates HTML for a single video + meta info.
 */
class tubepress_plugins_procore_impl_shortcode_DetachedPlayerPluggableShortcodeHandlerService implements tubepress_spi_shortcode_PluggableShortcodeHandlerService
{
    /**
     * @return string The name of this shortcode handler. Never empty or null. All lowercase alphanumerics and dashes.
     */
    public function getName()
    {
        return 'detached-player';
    }

    /**
     * @return boolean True if this handler is interested in generating HTML, false otherwise.
     */
    public function shouldExecute()
    {
        $execContext = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

        return $execContext->get(tubepress_api_const_options_names_Output::OUTPUT) === tubepress_api_const_options_values_OutputValue::PLAYER;
    }

    /**
     * @return string The HTML for this shortcode handler.
     */
    public function getHtml()
    {
        $player   = tubepress_impl_patterns_sl_ServiceLocator::getPlayerHtmlGenerator();
        $provider = tubepress_impl_patterns_sl_ServiceLocator::getVideoCollector();
        $ms       = tubepress_impl_patterns_sl_ServiceLocator::getMessageService();

        $feedResult = $provider->collectVideoGalleryPage();
        $videoArray = $feedResult->getVideos();

        if (count($videoArray) === 0) {

            return $ms->_('No matching videos');     //>(translatable)<
        }

        return $player->getHtml($videoArray[0]);
    }
}