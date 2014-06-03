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
class tubepress_plugins_procore_impl_filters_embeddedtemplate_EmbeddedPlayerHttpsFilter
{
    public function onEmbeddedTemplate(tubepress_api_event_TubePressEvent $event)
    {
        $context = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

        /**
         * If the user doesn't want HTTPS...
         */
        if (! $context->get(tubepress_api_const_options_names_Advanced::HTTPS)) {

            return;
        }

        $template = $event->getSubject();
        $dataUrl  = $event->getArgument('dataUrl');

        $dataUrl->setScheme('https');

        $template->setVariable(tubepress_api_const_template_Variable::EMBEDDED_DATA_URL, $dataUrl->toString());
     }
}