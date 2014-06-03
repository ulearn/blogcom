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
 * Records the order of the videos into the context so that it can be placed into
 * the DOM later down the road...
 */
class tubepress_plugins_procore_impl_filters_videogallerypage_SequenceLogger
{
	public function onVideoGalleryPage(tubepress_api_event_TubePressEvent $event)
    {
	    $context = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

	    if ($context->get(tubepress_api_const_options_names_Embedded::SEQUENCE) != '') {

	        return;
	    }

        $videoGalleryPage = $event->getSubject();
		$videos           = $videoGalleryPage->getVideos();
		$videoIds         = $this->_getVideoIds($videos);

        $context->set(tubepress_api_const_options_names_Embedded::SEQUENCE, $videoIds);
	}

	private function _getVideoIds($videos)
	{
	    $toReturn = array();

	    foreach ($videos as $video) {

	        $toReturn[] = $video->getAttribute(tubepress_api_video_Video::ATTRIBUTE_ID);
	    }

	    return $toReturn;
	}
}