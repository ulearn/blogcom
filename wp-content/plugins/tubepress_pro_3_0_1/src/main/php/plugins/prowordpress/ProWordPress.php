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
class tubepress_plugins_procore_ProWordPress
{
    public static function init()
    {
        $environmentDetector = tubepress_impl_patterns_sl_ServiceLocator::getEnvironmentDetector();

        if (!$environmentDetector->isWordPress()) {

            //short circuit
            return;
        }

        self::_warnUserOnUpgrade();
        self::_removeTubePressFromPluginUpdates();
    }

    private static function _warnUserOnUpgrade()
    {
        $dirName                  = basename(TUBEPRESS_ROOT);
        $wordPressFunctionWrapper = tubepress_impl_patterns_sl_ServiceLocator::getService(tubepress_plugins_wordpress_spi_WordPressFunctionWrapper::_);

        $wordPressFunctionWrapper->add_action("in_plugin_update_message-$dirName/tubepress.php", array('tubepress_plugins_procore_ProWordPress', '_callbackWarnOnUpgrade'), 10, 1);
    }

    private static function _removeTubePressFromPluginUpdates()
    {
        $wordPressFunctionWrapper = tubepress_impl_patterns_sl_ServiceLocator::getService(tubepress_plugins_wordpress_spi_WordPressFunctionWrapper::_);

        $wordPressFunctionWrapper->add_filter('upgrader_pre_install', array('tubepress_plugins_procore_ProWordPress', '_callbackUpgraderPreInstall'), 10, 2);
    }

    public static function _callbackUpgraderPreInstall($bool, $hook_extra)
    {
        if (!isset($hook_extra['plugin'])) {

            return null;
        }

        $plugin = $hook_extra['plugin'];

        if ($plugin !== basename(TUBEPRESS_ROOT) . '/tubepress.php') {

            return null;
        }

        return new WP_Error(999, "Please update TubePress Pro by downloading it directly from tubepress.org. TubePress Pro does not use WordPress's standard update mechanism because it is not public source code. We apologize for the inconvenience!");
    }

    /**
     * Warns the user with a big yellow banner.
     */
    public static function _callbackWarnOnUpgrade()
    {
        $templateGenerator = tubepress_impl_patterns_sl_ServiceLocator::getTemplateBuilder();
        $template          = $templateGenerator->getNewTemplateInstance(

            dirname(__FILE__) . "/resources/templates/pro-upgrade-notice.tpl.php");

        echo $template->toString();
    }
}

tubepress_plugins_procore_ProWordPress::init();