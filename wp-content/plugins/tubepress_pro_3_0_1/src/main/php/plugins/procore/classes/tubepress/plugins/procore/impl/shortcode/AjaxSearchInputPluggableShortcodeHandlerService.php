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
class tubepress_plugins_procore_impl_shortcode_AjaxSearchInputPluggableShortcodeHandlerService implements tubepress_spi_shortcode_PluggableShortcodeHandlerService
{
    private $_logger;

    public function __construct()
    {
        $this->_logger = ehough_epilog_api_LoggerFactory::getLogger('Ajax Search Input Shortcode Handler');
    }

    /**
     * @return string The name of this shortcode handler. Never empty or null. All lowercase alphanumerics and dashes.
     */
    public final function getName()
    {
        return 'ajax-search-input';
    }

    /**
     * @return boolean True if this handler is interested in generating HTML, false otherwise.
     */
    public final function shouldExecute()
    {
        $execContext = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

        return $execContext->get(tubepress_api_const_options_names_Output::OUTPUT) === tubepress_api_const_options_values_OutputValue::AJAX_SEARCH_INPUT;
    }

    /**
     * @return string The HTML for this shortcode handler.
     */
    public final function getHtml()
    {
        $execContext     = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $jsonEncoder     = tubepress_impl_patterns_sl_ServiceLocator::getJsonEncoder();
        $eventDispatcher = tubepress_impl_patterns_sl_ServiceLocator::getEventDispatcher();
        $galleryId       = $execContext->get(tubepress_api_const_options_names_Advanced::GALLERY_ID);

        if ($galleryId == '') {

            $galleryId = mt_rand();
        }

        if ($this->_logger->isDebugEnabled()) {

            $this->_logger->debug('Handling execution');
        }

        $nvp = $this->_getGalleryInitParams($eventDispatcher, $execContext);

        $th       = tubepress_impl_patterns_sl_ServiceLocator::getThemeHandler();
        $template = $th->getTemplateInstance('search/ajax_search_input.tpl.php', TUBEPRESS_ROOT . '/src/main/php/plugins/procore/resources/templates');

        $template->setVariable(tubepress_plugins_procore_api_const_template_Variable::NVP_AS_JSON, $jsonEncoder->encode($nvp));
        $template->setVariable(tubepress_api_const_template_Variable::GALLERY_ID, $galleryId);

        $event = new tubepress_api_event_TubePressEvent($template);

        $eventDispatcher->dispatch(

            tubepress_api_const_event_CoreEventNames::SEARCH_INPUT_TEMPLATE_CONSTRUCTION,
            $event
        );

        $template = $event->getSubject();
        $html = $template->toString();

        $event = new tubepress_api_event_TubePressEvent($html);

        $eventDispatcher->dispatch(

            tubepress_api_const_event_CoreEventNames::SEARCH_INPUT_HTML_CONSTRUCTION,
            $event
        );

        $html = $event->getSubject();

        return $html;
    }

    private function _getGalleryInitParams(ehough_tickertape_api_IEventDispatcher $eventDispatcher, tubepress_spi_context_ExecutionContext $execContext)
    {
        $execContext->set(tubepress_api_const_options_names_Output::OUTPUT, tubepress_api_const_options_values_OutputValue::SEARCH_RESULTS);
        $execContext->set(tubepress_api_const_options_names_Thumbs::AJAX_PAGINATION, true);

        $jsEvent = new tubepress_api_event_TubePressEvent(array());

        $eventDispatcher->dispatch(tubepress_api_const_event_CoreEventNames::GALLERY_INIT_JS_CONSTRUCTION, $jsEvent);

        $args = $jsEvent->getSubject();

        return $args;
    }

}
