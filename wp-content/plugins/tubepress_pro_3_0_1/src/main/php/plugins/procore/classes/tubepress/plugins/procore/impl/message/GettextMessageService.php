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
 * Gettext functionality for TubePress
 */
class tubepress_plugins_procore_impl_message_GettextMessageService implements tubepress_spi_message_MessageService
{
    private $_isInitialized = false;

    private $_logger;

    public function __construct()
    {
        $this->_logger = ehough_epilog_api_LoggerFactory::getLogger('Gettext Message Service');
    }

    /**
     * Retrieves a message for TubePress
     *
     * @param string $msgId The message ID
     *
     * @return string The corresponding message, or "" if not found
     */
    public function _($msgId)
    {
        if (!$this->_isInitialized) {

            $this->_initialize();
        }

        return $msgId == '' ? '' : _gettext($msgId);
    }

    private function _initialize()
    {
        $isDebugEnabled = $this->_logger->isDebugEnabled();

        if (function_exists('gettext')) {

            if ($isDebugEnabled) {

                $this->_logger->debug('Built-in gettext detected.');
            }

        } else {

            if ($isDebugEnabled) {

                $this->_logger->debug('Built-in gettext not-detected.');
            }
        }

        require dirname(__FILE__) . '/phpgettext/gettext.inc';

        $context = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $lang    = $context->get(tubepress_plugins_procore_api_const_options_names_Advanced::LANG);

        if (!$lang) {

            if (defined('LANG')) {

                if ($isDebugEnabled) {

                    $this->_logger->debug(sprintf('LANG defined as %s.', LANG));
                }

                $lang = LANG === '' ? 'en' : LANG;

            } else {

                if ($isDebugEnabled) {

                    $this->_logger->debug('LANG undefined. Reverting to \'en\'');
                }

                $lang = 'en';
            }

        } else {

            if ($isDebugEnabled) {

                $this->_logger->debug('Lang requested to be ' . $lang);
            }

            @putenv("LANG=$lang");
        }

        if ($isDebugEnabled) {

            $this->_logger->debug(sprintf('Locales supported: %s', implode(', ', get_list_of_locales($lang))));
        }

        $textDir = realpath(TUBEPRESS_ROOT . '/src/main/resources/i18n');

        if ($isDebugEnabled) {

            $this->_logger->debug(sprintf('Binding text domain to %s', $textDir));
        }

        @putenv("LC_ALL=" . $lang);
        _setlocale(LC_ALL, $lang);
        _bindtextdomain('tubepress', $textDir);
        _textdomain('tubepress');
        _bind_textdomain_codeset('tubepress', 'UTF-8');

        $this->_isInitialized = true;
    }
}
