<?php
namespace Wurfl\Handlers;

/**
 * Copyright (c) 2012 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

use Wurfl\Constants;

/**
 * HTCUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class HTCHandler extends AbstractHandler
{

    protected $prefix = "HTC";

    public static $constantIDs
        = array(
            'generic_ms_mobile',
        );

    public function canHandle($userAgent)
    {
        if (Utils::isDesktopBrowser($userAgent)) {
            return false;
        }
        return Utils::checkIfContainsAnyOf($userAgent, array('HTC', 'XV6875'));
    }

    public function applyConclusiveMatch($userAgent)
    {
        if (preg_match('#^.*?HTC.+?[/ ;]#', $userAgent, $matches)) {
            // The length of the complete match (from the beginning) is the tolerance
            $tolerance = strlen($matches[0]);
        } else {
            $tolerance = strlen($userAgent);
        }

        return $this->getDeviceIDFromRIS($userAgent, $tolerance);
    }

    public function applyRecoveryMatch($userAgent)
    {
        if (Utils::checkIfContains($userAgent, 'Windows CE;')) {
            return 'generic_ms_mobile';
        }

        return Constants::NO_MATCH;
    }
}
