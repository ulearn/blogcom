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
 * Generates TubePress's output via Ajax.
 */
class tubepress_plugins_procore_impl_http_ShortcodePluggableAjaxCommandService extends tubepress_impl_http_AbstractPluggableAjaxCommandService
{
    protected function getStatusCodeToHtmlMap()
    {
        $qss              = tubepress_impl_patterns_sl_ServiceLocator::getHttpRequestParameterService();
        $executionContext = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $htmlGenerator    = tubepress_impl_patterns_sl_ServiceLocator::getShortcodeHtmlGenerator();
        $nvpMap           = $qss->getAllParams();

        $executionContext->setCustomOptions($nvpMap);

        try {

            return array(200 => $htmlGenerator->getHtmlForShortcode(''));

        } catch (Exception $e) {

            return array(500 => $e->getMessage());
        }
    }

    /**
     * @return string The command name that this handler responds to.
     */
    public final function getName()
    {
        return 'shortcode';
    }
}