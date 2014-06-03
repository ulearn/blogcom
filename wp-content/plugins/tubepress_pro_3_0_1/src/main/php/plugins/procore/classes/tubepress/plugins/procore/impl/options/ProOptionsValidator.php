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

class tubepress_plugins_procore_impl_options_ProOptionsValidator implements tubepress_spi_options_OptionValidator
{
    private $_delegate;

    private $_hasInitialized = false;

    private $_allKnownGallerySourceNames = array();

    private $_allOptionNamesThatWeHandle = array();

    private $_allKnownGallerySourceNamesAsPipeSeparatedString;

    private $_logger;

    public function __construct(tubepress_spi_options_OptionValidator $delegate)
    {
        $this->_delegate = $delegate;
        $this->_logger   = ehough_epilog_api_LoggerFactory::getLogger('Pro Option Validator');
    }

    /**
     * Gets the failure message of a name/value pair that has failed validation.
     *
     * @param string $optionName The option name
     * @param mixed  $candidate  The candidate option value
     *
     * @return mixed Null if the option passes validation, otherwise a string failure message.
     */
    public final function getProblemMessage($optionName, $candidate)
    {
        $this->_initialize();

        $originalProblemMessage = $this->_delegate->getProblemMessage($optionName, $candidate);

        if ($originalProblemMessage === null || !$this->_isOptionThatWeHandle($optionName)) {

            return $originalProblemMessage;
        }

        return $this->_getProProblemMessage($optionName, $candidate);
    }

    /**
     * Validates an option value.
     *
     * @param string $optionName The option name
     * @param mixed  $candidate  The candidate option value
     *
     * @return boolean True if the option name exists and the value supplied is valid. False otherwise.
     */
    public final function isValid($optionName, $candidate)
    {
        return $this->getProblemMessage($optionName, $candidate) === null;
    }

    private function _isOptionThatWeHandle($optionName)
    {
        return in_array($optionName, $this->_allOptionNamesThatWeHandle);
    }

    private function _getProProblemMessage($optionName, $candidate)
    {
        if ($optionName === tubepress_api_const_options_names_Output::GALLERY_SOURCE) {

            return $this->_getProblemMessageForMode($candidate);
        }

        return $this->_getProblemMessageForSourceValue($optionName, $candidate);
    }

    private function _getProblemMessageForSourceValue($optionName, $candidate)
    {
        $exploded    = preg_split('/\s*\+\s*/', $candidate);
        $isDebugging = $this->_logger->isDebugEnabled();

        foreach ($exploded as $sourceValue) {

            if ($isDebugging) {

                $this->_logger->debug(sprintf('Checking validity of %s = "%s"', $optionName, $sourceValue));
            }

            $message = $this->_delegate->getProblemMessage($optionName, $sourceValue);

            if ($message !== null) {

                return sprintf('"%s" is not a valid value for "%s"', $sourceValue, $optionName);
            }
        }

        //all the checks passed
        return null;
    }

    private function _getProblemMessageForMode($candidate)
    {
        $acceptableValuesString = $this->_allKnownGallerySourceNamesAsPipeSeparatedString;

        return $this->_matchesRegex(

            tubepress_api_const_options_names_Output::GALLERY_SOURCE,
            "/^(?:$acceptableValuesString)(?:\s*\+\s*(?:$acceptableValuesString))*$/",
            $candidate
        );
    }

    private function _initialize()
    {
        if ($this->_hasInitialized) {

            return;
        }

        $videoProviders = tubepress_impl_patterns_sl_ServiceLocator::getVideoProviders();
        $odr            = tubepress_impl_patterns_sl_ServiceLocator::getOptionDescriptorReference();

        foreach ($videoProviders as $videoProvider) {

            /** @noinspection PhpUndefinedMethodInspection */
            $this->_allKnownGallerySourceNames = array_merge($this->_allKnownGallerySourceNames, $videoProvider->getGallerySourceNames());
        }

        $this->_allKnownGallerySourceNamesAsPipeSeparatedString = implode('|', $this->_allKnownGallerySourceNames);

        $gallerySourcesWithValues = array();

        foreach ($this->_allKnownGallerySourceNames as $gallerySourceName) {

            if ($odr->findOneByName($gallerySourceName . 'Value') !== null) {

                array_push($gallerySourcesWithValues, $gallerySourceName . 'Value');
            }
        }

        $this->_allOptionNamesThatWeHandle = array_merge(array(tubepress_api_const_options_names_Output::GALLERY_SOURCE), $gallerySourcesWithValues);

        $this->_hasInitialized = true;
    }

    private function _matchesRegex($optionName, $regex, $candidate)
    {
        if ($this->_logger->isDebugEnabled()) {

            $this->_logger->debug(sprintf('Checking "%s" for option %s against regex: %s', $candidate, $optionName, $regex));
        }

        if (preg_match_all($regex, $candidate, $matches) === 1) {

            return null;
        }

        return sprintf('%s must match %s. You supplied %s', $optionName, $regex, $candidate);
    }
}