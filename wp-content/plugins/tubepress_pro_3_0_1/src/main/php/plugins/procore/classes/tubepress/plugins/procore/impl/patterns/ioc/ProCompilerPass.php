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
class tubepress_plugins_procore_impl_patterns_ioc_ProCompilerPass implements ehough_iconic_api_compiler_ICompilerPass
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ehough_iconic_impl_ContainerBuilder $container
     *
     * @return void
     */
    public final function process(ehough_iconic_impl_ContainerBuilder $container)
    {
        $this->_registerVideoCollector($container);
        $this->_registerOptionsValidator($container);

        $this->_registerStorageManagerIfNeeded($container);
    }

    private function _registerOptionsValidator(ehough_iconic_impl_ContainerBuilder $container)
    {
        $originalDefinition = $container->findDefinition(tubepress_spi_options_OptionValidator::_);

        $newDefinition = new ehough_iconic_impl_Definition('tubepress_plugins_procore_impl_options_ProOptionsValidator');
        $newDefinition->addArgument($originalDefinition);

        $container->setDefinition(tubepress_spi_options_OptionValidator::_, $newDefinition);
    }

    private function _registerVideoCollector(ehough_iconic_impl_ContainerBuilder $container)
    {
        $originalDefinition = $container->findDefinition(tubepress_spi_collector_VideoCollector::_);

        $newDefinition = new ehough_iconic_impl_Definition('tubepress_plugins_procore_impl_collector_MultipleSourcesVideoCollector');
        $newDefinition->addArgument($originalDefinition);

        $container->setDefinition(tubepress_spi_collector_VideoCollector::_, $newDefinition);
    }

    private function _registerStorageManagerIfNeeded(ehough_iconic_impl_ContainerBuilder $container)
    {
        if ($container->has(tubepress_spi_options_StorageManager::_)) {

            //someone else registered a storage manager
            return;
        }

        $container->register(

            tubepress_spi_options_StorageManager::_,
            'tubepress_plugins_procore_impl_options_MemoryStorageManager'
        );
    }
}