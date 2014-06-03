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
 * Pro mods for video construction.
 */
class tubepress_plugins_procore_impl_filters_video_ProVideoConstructionFilter
{
    public function onVideoConstruction(tubepress_api_event_TubePressEvent $event)
    {
        $this->_handleHttpsThumbs($event);
        $this->_handleVimeoHqThumbs($event);
        $this->_handleYouTubeHqThumbs($event);
    }

    private function _handleHttpsThumbs(tubepress_api_event_TubePressEvent $event)
    {

        $context = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $video   = $event->getSubject();

        /**
        * If the user doesn't want HTTPS, or this is Vimeo...
        */
        if (! $context->get(tubepress_api_const_options_names_Advanced::HTTPS)) {

           return;
        }

        $url = $video->getAttribute(tubepress_api_video_Video::ATTRIBUTE_THUMBNAIL_URL);

        /**
        * If, on the off chance, the URL doesn't begin with "http://" then just bail.
        */
        if (substr($url, 0, 7) !== 'http://') {

           return;
        }

        $url = tubepress_impl_util_StringUtils::replaceFirst('http://', 'https://', $url);

        $video->setAttribute(tubepress_api_video_Video::ATTRIBUTE_THUMBNAIL_URL, $url);
    }

    private function _handleVimeoHqThumbs(tubepress_api_event_TubePressEvent $event)
    {
        $video = $event->getSubject();

        if ($video->getAttribute(tubepress_api_video_Video::ATTRIBUTE_PROVIDER_NAME) !== 'vimeo') {

            return;
        }

        $tpom = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

        if (! $tpom->get(tubepress_api_const_options_names_Thumbs::HQ_THUMBS)) {

            return;
        }

        $videoArray = $event->getArgument('videoArray');
        $index      = $event->getArgument('zeroBasedFeedIndex');

        $node           = $videoArray[$index];
        $thumbnailArray = $node->thumbnails->thumbnail;
        $size           = count($thumbnailArray);

        do {

            $size--;
            $thumb = $thumbnailArray[$size]->_content;
            $width = $thumbnailArray[$size]->width;

        } while ($size > 0 && (strpos($thumb, 'defaults') !== FALSE || intval($width) > 640));

        $video->setAttribute(tubepress_api_video_Video::ATTRIBUTE_THUMBNAIL_URL, $thumb);
    }

    private function _handleYouTubeHqThumbs(tubepress_api_event_TubePressEvent $event)
    {
        $video = $event->getSubject();

        if ($video->getAttribute(tubepress_api_video_Video::ATTRIBUTE_PROVIDER_NAME) !== 'youtube') {

            return;
        }

        $tpom = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

        if (! $tpom->get(tubepress_api_const_options_names_Thumbs::HQ_THUMBS)) {

            return;
        }

        $index  = $event->getArgument('zeroBasedFeedIndex');
        $xpath  = $event->getArgument('xPath');
        $thumbs = $xpath->query('//atom:entry[' . ($index + 1) . ']/media:group/media:thumbnail');
        $x      = $thumbs->length - 1;

        do {

            $url = $thumbs->item($x--)->getAttribute('url');

        } while (strpos($url, 'hqdefault') === FALSE);

        $video->setAttribute(tubepress_api_video_Video::ATTRIBUTE_THUMBNAIL_URL, $url);
    }
}