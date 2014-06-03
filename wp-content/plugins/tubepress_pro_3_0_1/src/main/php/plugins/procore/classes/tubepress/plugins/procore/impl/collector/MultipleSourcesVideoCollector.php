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
 * Video provider that can handle multiple sources.
 */
class tubepress_plugins_procore_impl_collector_MultipleSourcesVideoCollector implements tubepress_spi_collector_VideoCollector
{
    private $_singleSourceVideoCollector;

    private $_logger;

    private $_largestBatchOfVideosSeenInASingleIteration;

    public function __construct(tubepress_spi_collector_VideoCollector $singleSourceVideoCollector)
    {
        $this->_singleSourceVideoCollector = $singleSourceVideoCollector;
        $this->_logger                     = ehough_epilog_api_LoggerFactory::getLogger('Multiple Sources Video Collector');
    }

    /**
     * Collects a video gallery page.
     *
     * @return tubepress_api_video_VideoGalleryPage The video gallery page, never null.
     */
    public final function collectVideoGalleryPage()
    {
        $execContext     = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $eventDispatcher = tubepress_impl_patterns_sl_ServiceLocator::getEventDispatcher();
        $isDebugging     = $this->_logger->isDebugEnabled();

        /** See if we're using multiple modes */
        if (! $this->_usingMultipleModes($execContext)) {

            if ($isDebugging) {

                $this->_logger->debug('Multiple video sources not detected.');
            }

            $result = $this->_singleSourceVideoCollector->collectVideoGalleryPage();

        } else {

            if ($isDebugging) {

                $this->_logger->debug('Multiple video sources detected.');
            }

            $this->_largestBatchOfVideosSeenInASingleIteration = 0;

            $result = $this->_collectVideosFromMultipleSources($execContext, $isDebugging);

            $this->_setResultsPerPageAppropriately($result);
        }

        $event = new tubepress_api_event_TubePressEvent($result);
        $eventDispatcher->dispatch(

            tubepress_api_const_event_CoreEventNames::VIDEO_GALLERY_PAGE_CONSTRUCTION,
            $event
        );

        return $event->getSubject();
    }

    /**
     * Fetch a single video.
     *
     * @param string $customVideoId The video ID to fetch.
     *
     * @return tubepress_api_video_Video The video, or null if there's a problem.
     */
    public final function collectSingleVideo($customVideoId)
    {
        return $this->_singleSourceVideoCollector->collectSingleVideo($customVideoId);
    }

    private function _collectVideosFromMultipleSources(tubepress_spi_context_ExecutionContext $execContext, $isDebuggingEnabled)
    {
    	/** Save a copy of the original options. */
        $originalCustomOptions = $execContext->getCustomOptions();

        /** Build the result. */
        $result = $this->__collectVideosFromMultipleSources($execContext, $isDebuggingEnabled);

        /** Restore the original options. */
        $execContext->setCustomOptions($originalCustomOptions);

        return $result;
    }

    private function __collectVideosFromMultipleSources(tubepress_spi_context_ExecutionContext $execContext, $isDebuggingEnabled)
    {
    	/** Figure out which modes we're gonna run. */
    	$suppliedModeValue = $execContext->get(tubepress_api_const_options_names_Output::GALLERY_SOURCE);
    	$modesToRun        = $this->_splitByPlusSurroundedBySpaces($suppliedModeValue);
    	$modeCount         = count($modesToRun);
    	$index             = 1;

    	$result = new tubepress_api_video_VideoGalleryPage();

        if ($isDebuggingEnabled) {

            $this->_logger->debug(sprintf('Detected %d modes (%s)', $modeCount, implode(', ', $modesToRun)));
        }

    	/** Iterate over each mode and collect the videos */
    	foreach ($modesToRun as $mode) {

            if ($isDebuggingEnabled) {

                $this->_logger->debug(sprintf('Start collecting videos for mode %s (%d of %d modes)', $mode, $index, $modeCount));
            }

    		try {

    			$result = $this->_createCombinedResult($mode, $result, $isDebuggingEnabled);

    		} catch (Exception $e) {

                $this->_logger->error('Caught exception getting videos: ' . $e->getMessage(). '. We will continue with the next mode');
    		}

            if ($isDebuggingEnabled) {

                $this->_logger->debug(sprintf('Done collecting videos for mode %s (%d of %d modes)', $mode, $index++, $modeCount));
            }
    	}

        if ($isDebuggingEnabled) {

            $this->_logger->debug(sprintf('After full collection, we now have %d videos', count($result->getVideos())));
        }

    	return $result;
    }

    private function _createCombinedResult($mode, tubepress_api_video_VideoGalleryPage $resultToAppendTo, $isDebuggingEnabled)
    {
    	$odr         = tubepress_impl_patterns_sl_ServiceLocator::getOptionDescriptorReference();
    	$execContext = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();

        $execContext->set(tubepress_api_const_options_names_Output::GALLERY_SOURCE, $mode);

        /** Some modes don't take a parameter */
        if ($odr->findOneByName($mode . 'Value') === null) {

        	$modeResult = $this->_collectedValuelessModeResult($mode, $isDebuggingEnabled);

            $this->_recordBatchSize($modeResult);

        } else {

        	$modeResult = $this->_collectedValuefulModeResult($execContext, $mode, $isDebuggingEnabled);
        }

        $newCombinedResult = $this->_combineFeedResults($resultToAppendTo, $modeResult);

        return $newCombinedResult;
    }

    private function _collectedValuelessModeResult($mode, $isDebuggingEnabled)
    {
        if ($isDebuggingEnabled) {

            $this->_logger->debug(sprintf('Now collecting videos for value-less "%s" mode', $mode));
        }

        return $this->_singleSourceVideoCollector->collectVideoGalleryPage();
    }

    private function _collectedValuefulModeResult(tubepress_spi_context_ExecutionContext $execContext, $mode, $isDebuggingEnabled)
    {
    	$rawModeValue   = $execContext->get($mode . 'Value');
    	$modeValueArray = $this->_splitByPlusSurroundedBySpaces($rawModeValue);
    	$modeValueCount = count($modeValueArray);
    	$index          = 1;

    	$resultToReturn = new tubepress_api_video_VideoGalleryPage();

        foreach ($modeValueArray as $modeValue) {

            if ($isDebuggingEnabled) {

                $this->_logger->debug(sprintf('Start collecting videos for mode %s with value %s (%d of %d values for mode %s)', $mode, $modeValue, $index, $modeValueCount, $mode));
            }

            $execContext->set($mode . 'Value', $modeValue);

            try {

                $modeResult = $this->_singleSourceVideoCollector->collectVideoGalleryPage();

                $this->_recordBatchSize($modeResult);

                $resultToReturn = $this->_combineFeedResults($resultToReturn, $modeResult);

            } catch (Exception $e) {

                $this->_logger->error(sprintf('Problem collecting videos for mode "%s" and value "%s": %s', $mode, $modeValue, $e->getMessage()));
            }

            if ($isDebuggingEnabled) {

                $this->_logger->debug(sprintf('Done collecting videos for mode %s with value %s (%d of %d values for mode %s)', $mode, $modeValue, $index++, $modeValueCount, $mode));
            }
        }

        return $resultToReturn;
    }

    private function _combineFeedResults(tubepress_api_video_VideoGalleryPage $first, tubepress_api_video_VideoGalleryPage $second)
    {
        $result = new tubepress_api_video_VideoGalleryPage();

        /** Merge the two video arrays into a single one */
        $result->setVideos(array_merge($first->getVideos(), $second->getVideos()));

        /** The total result count is the max of the two total result counts */
        $result->setTotalResultCount($first->getTotalResultCount() + $second->getTotalResultCount());

        return $result;
    }

    private function _usingMultipleModes(tubepress_spi_context_ExecutionContext $execContext)
    {
        $mode = $execContext->get(tubepress_api_const_options_names_Output::GALLERY_SOURCE);

        if (count($this->_splitByPlusSurroundedBySpaces($mode)) > 1) {

            return true;
        }

        $odf = tubepress_impl_patterns_sl_ServiceLocator::getOptionDescriptorReference();

        if ($odf->findOneByName($mode . 'Value') !== null) {

            $modeValue = $execContext->get($mode . 'Value');

            return strpos($modeValue, '+') !== false;
        }

        return false;
    }

    private function _splitByPlusSurroundedBySpaces($string)
    {
    	return preg_split('/\s*\+\s*/', $string);
    }

    private function _recordBatchSize(tubepress_api_video_VideoGalleryPage $page)
    {
        $this->_largestBatchOfVideosSeenInASingleIteration = max(

            $this->_largestBatchOfVideosSeenInASingleIteration,
            $page->getTotalResultCount()
        );
    }

    /**
     * OK, follow closely because this can be complicated. We need to adjust the resultsPerPage setting, otherwise
     * pagination will be completely screwed up. Here's an example
     *
     * Source 1 produces 100 videos
     * Source 2 produces 200 videos
     * Source 3 produces 300 videos
     * Source 4 produces 400 videos
     *
     * resultsPerPage was set by the user to 25
     *
     * Since there are 1000 videos, TubePress will generate pagination for 40 pages (25 * 40 = 1000). But in reality
     * there will be no more videos after the 8th page (8 * 25 = 400).
     *
     * So the solution is to record the maximum results that any provider returns. We divide that by the user's setting
     * for resultsPerPage and get a number: desired page count.
     *
     * Now we have to set resultsPerPage to a number that tricks TubePress's pagination into producing the desired page
     * count. That's easy, just take the total videos and divide it by the desired page count. In our example,
     * 1000 / 8 = 125. So resultsPerPage="125"
     */
    private function _setResultsPerPageAppropriately(tubepress_api_video_VideoGalleryPage $page)
    {
        $context               = tubepress_impl_patterns_sl_ServiceLocator::getExecutionContext();
        $currentResultsPerPage = $context->get(tubepress_api_const_options_names_Thumbs::RESULTS_PER_PAGE);
        $currentResultsPerPage = intval($currentResultsPerPage);
        $maxResultsSeen        = intval($this->_largestBatchOfVideosSeenInASingleIteration);
        $totalResultCount      = intval($page->getTotalResultCount());
        $isDebugging           = $this->_logger->isDebugEnabled();

        /**
         * Prevent a divide-by-zero.
         */
        if ($currentResultsPerPage < 1) {

            $this->_logger->warn("resultsPerPage was somehow set to a non-positive integer. This should never happen!");
            return;
        }

        if ($isDebugging) {

            $this->_logger->debug(sprintf('After full collection, we have %d video(s). The largest batch was %d video(s). resultsPerPage is currently set to %d.',
                $totalResultCount, $maxResultsSeen, $currentResultsPerPage));
        }

        $desiredPageCount  = ceil($maxResultsSeen / $currentResultsPerPage);
        $newResultsPerPage = intval(ceil($totalResultCount / $desiredPageCount));

        if ($isDebugging) {

            $this->_logger->debug(sprintf('Now setting resultsPerPage to %d so that we have %d pages for pagination',
                $newResultsPerPage, $desiredPageCount));
        }

        $context->set(tubepress_api_const_options_names_Thumbs::RESULTS_PER_PAGE, $newResultsPerPage);
    }
}
