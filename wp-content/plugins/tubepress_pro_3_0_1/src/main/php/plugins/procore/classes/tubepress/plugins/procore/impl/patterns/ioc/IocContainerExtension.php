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
 * Registers all the Pro Core services.
 */
class tubepress_plugins_procore_impl_patterns_ioc_IocContainerExtension implements ehough_iconic_api_extension_IExtension
{

    /**
     * Loads a specific configuration.
     *
     * @param ehough_iconic_impl_ContainerBuilder $container A ContainerBuilder instance
     *
     * @return void
     */
    public final function load(ehough_iconic_impl_ContainerBuilder $container)
    {
        /**
         * Singleton services.
         */
        $this->_registerMessageService($container);

        /**
         * Pluggable services.
         */
        $this->_registerPluggableServices($container);

        /**
         * Filters
         */
        $this->_registerFilters($container);
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public final function getAlias()
    {
        return 'procore';
    }

    private function _registerMessageService(ehough_iconic_impl_ContainerBuilder $container)
    {
        $envDetector = tubepress_impl_patterns_sl_ServiceLocator::getEnvironmentDetector();

        if ($envDetector->isWordPress()) {

            //The WordPress message service should already be registered
            return;
        }

        $container->register(

            tubepress_spi_message_MessageService::_,
            'tubepress_plugins_procore_impl_message_GettextMessageService'
        );
    }

    private function _registerPluggableServices(ehough_iconic_impl_ContainerBuilder $container)
    {
        $container->register(

            'tubepress_plugins_procore_impl_http_ShortcodePluggableAjaxCommandService',
            'tubepress_plugins_procore_impl_http_ShortcodePluggableAjaxCommandService'

        )->addTag(tubepress_spi_http_PluggableAjaxCommandService::_);

        $playerLocationClasses = array(

            'tubepress_plugins_procore_impl_player_DetachedPluggablePlayerLocationService',
            'tubepress_plugins_procore_impl_player_FancyboxPluggablePlayerLocationService',
            'tubepress_plugins_procore_impl_player_TinyBoxPluggablePlayerLocationService',
        );

        foreach ($playerLocationClasses as $playerLocationClass) {

            $container->register(

                $playerLocationClass, $playerLocationClass

            )->addTag(tubepress_spi_player_PluggablePlayerLocationService::_);
        }

        $container->register(

            'tubepress_plugins_procore_impl_shortcode_AjaxSearchInputPluggableShortcodeHandlerService',
            'tubepress_plugins_procore_impl_shortcode_AjaxSearchInputPluggableShortcodeHandlerService'

        )->addTag(tubepress_spi_shortcode_PluggableShortcodeHandlerService::_);

        $container->register(

            'tubepress_plugins_procore_impl_shortcode_DetachedPlayerPluggableShortcodeHandlerService',
            'tubepress_plugins_procore_impl_shortcode_DetachedPlayerPluggableShortcodeHandlerService'

        )->addTag(tubepress_spi_shortcode_PluggableShortcodeHandlerService::_);
    }

    private function _registerFilters(ehough_iconic_impl_ContainerBuilder $container)
    {
        $filterClasses = array(

            'tubepress_plugins_procore_impl_filters_embeddedtemplate_EmbeddedPlayerHttpsFilter',
            'tubepress_plugins_procore_impl_filters_galleryinitjs_GalleryInitJsSequencer',
            'tubepress_plugins_procore_impl_filters_video_ProVideoConstructionFilter',
            'tubepress_plugins_procore_impl_filters_videogallerypage_SequenceLogger',
            'tubepress_plugins_procore_impl_filters_embeddedtemplate_ProYouTubeEmbeddedPlayerControls',
        );

        foreach ($filterClasses as $filterClass) {

            $container->register($filterClass, $filterClass);
        }
    }
}