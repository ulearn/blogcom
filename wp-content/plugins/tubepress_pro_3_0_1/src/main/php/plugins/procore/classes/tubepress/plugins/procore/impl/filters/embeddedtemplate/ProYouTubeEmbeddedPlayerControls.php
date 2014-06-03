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
 * Optionally forces the embedded player to load over HTTPS.
 */
class tubepress_plugins_procore_impl_filters_embeddedtemplate_ProYouTubeEmbeddedPlayerControls
{
    public function onEmbeddedTemplate(tubepress_api_event_TubePressEvent $event)
    {
        $providerName = $event->getArgument('providerName');

        if ($providerName !== 'youtube') {

            return;
        }

        $embeddedImplName = $event->getArgument('embeddedImplementationName');

        if ($embeddedImplName !== 'youtube') {

            return;
        }

        /*
         * At this point we know we are building a fresh YouTube embed
         */
        $dataUrl         = $event->getArgument('dataUrl');
        $template        = $event->getSubject();
        $context         = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $theme           = $context->get(tubepress_plugins_youtube_api_const_options_names_Embedded::THEME);
        $annotations     = $context->get(tubepress_plugins_youtube_api_const_options_names_Embedded::SHOW_ANNOTATIONS);
        $cc              = $context->get(tubepress_plugins_youtube_api_const_options_names_Embedded::CLOSED_CAPTIONS);
        $controls        = $context->get(tubepress_plugins_youtube_api_const_options_names_Embedded::SHOW_CONTROLS);
        $disableKeys     = $context->get(tubepress_plugins_youtube_api_const_options_names_Embedded::DISABLE_KEYBOARD);

        if ($cc) {

            $dataUrl->setQueryVariable('cc_load_policy', '1');
        }

        $dataUrl->setQueryVariable('controls', self::_getControlsValue($controls));
        $dataUrl->setQueryVariable('disablekb', tubepress_impl_embedded_EmbeddedPlayerUtils::booleanToOneOrZero($disableKeys));
        $dataUrl->setQueryVariable('theme', self::_getThemeValue($theme));
        $dataUrl->setQueryVariable('iv_load_policy', self::_getAnnotationsValue($annotations));

        $template->setVariable(tubepress_api_const_template_Variable::EMBEDDED_DATA_URL, $dataUrl->toString());
     }

    private static function _getAnnotationsValue($raw)
    {
        return $raw ? 1 : 3;
    }

    private static function _getThemeValue($raw)
    {
        if ($raw === tubepress_plugins_youtube_api_const_options_values_YouTube::PLAYER_THEME_LIGHT) {

            return 'light';
        }

        return 'dark';
    }

    private static function _getControlsValue($raw)
    {
        switch ($raw) {

            case tubepress_plugins_youtube_api_const_options_values_YouTube::CONTROLS_HIDE:

                return 0;

            case tubepress_plugins_youtube_api_const_options_values_YouTube::CONTROLS_SHOW_DELAYED_FLASH:

                return 2;

            default:

                return 1;
        }
    }
}