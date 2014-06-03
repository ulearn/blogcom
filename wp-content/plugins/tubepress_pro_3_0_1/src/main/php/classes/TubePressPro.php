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
 * TubePress Pro. Aren't you lucky!
 */
class TubePressPro
{
    public static function getHtmlForHead($includeJQuery = false)
    {
        self::_bootIfNecessary();

        $htmlGenerator = tubepress_impl_patterns_sl_ServiceLocator::getHeadHtmlGenerator();
        
        $jQueryIncludeString = $includeJQuery ? $htmlGenerator->getHeadJqueryInclusion() : '';
        $inlineJsString      = $htmlGenerator->getHeadInlineJs();
        $jsIncludeString     = $htmlGenerator->getHeadJsIncludeString();
        $cssIncludeString    = $htmlGenerator->getHeadCssIncludeString();
        $metaString          = $htmlGenerator->getHeadHtmlMeta();

        return <<<EOT
$jQueryIncludeString
$inlineJsString
$jsIncludeString
$cssIncludeString
$metaString
EOT;
    }
    
    public static function getHtmlForShortcode($raw_shortcode = '')
    {
        self::_bootIfNecessary();

        /* pad the shortcode if it doesn't start and end with the right stuff */
        $shortcode = self::_conditionalPadShortcode($raw_shortcode);

        $htmlGenerator = tubepress_impl_patterns_sl_ServiceLocator::getShortcodeHtmlGenerator();
        
        /* parse the shortcode and return the output */
        try {
        	
        	return $htmlGenerator->getHtmlForShortcode($shortcode);
        
        } catch (Exception $e) {

        	return $e->getMessage();
        }
    }

    private static function _conditionalPadShortcode($shortcode)
    {
        $context = tubepress_impl_patterns_sl_ServiceLocator::getOptionStorageManager();
        $trigger = $context->get(tubepress_api_const_options_names_Advanced::KEYWORD);
        $lookFor = "[$trigger ";
        
        /* make sure it starts with [tubepress */
        if (substr($shortcode, 0, 11) != "[$trigger ") {
            
            $shortcode = $lookFor . $shortcode;
        }

        /* make sure it ends with a bracket */
        if (substr($shortcode, strlen($shortcode) - 1) != ']') {
            
            $shortcode = "$shortcode]";
        }
        
        return $shortcode;
    }

    private static function _bootIfNecessary()
    {
        if (!defined('TUBEPRESS_ROOT')) {

            require dirname(__FILE__) . '/../scripts/boot.php';
        }
    }
}
