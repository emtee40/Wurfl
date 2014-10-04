<?php
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
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace Wurfl\Handlers;

/**
 * OperaHandlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class OperaMiniHandler
    extends AbstractHandler
{

    protected $prefix = "OPERA_MINI";

    public static $constantIDs = array(
        'Opera Mini/1' => 'generic_opera_mini_version1',
        'Opera Mini/2' => 'generic_opera_mini_version2',
        'Opera Mini/3' => 'generic_opera_mini_version3',
        'Opera Mini/4' => 'generic_opera_mini_version4',
        'Opera Mini/5' => 'generic_opera_mini_version5',
        'Opera Mini/6' => 'generic_opera_mini_version6',
        'Opera Mini/7' => 'generic_opera_mini_version7',
    );

    /**
     * @param string $userAgent
     *
     * @return bool
     */
    public function canHandle($userAgent)
    {
        if (Utils::isDesktopBrowser($userAgent)) {
            return false;
        }

        return Utils::checkIfContainsAnyOf($userAgent, array('Opera Mini', 'Opera Mobi'));
    }

    /**
     * @param string $userAgent
     *
     * @return null|string
     */
    public function applyConclusiveMatch($userAgent)
    {
        $operaMiniIndex = strpos($userAgent, 'Opera Mini');

        if ($operaMiniIndex !== false) {
            // Match up to the first '.' after 'Opera Mini'
            $tolerance = strpos($userAgent, '.', $operaMiniIndex);

            if ($tolerance !== false) {
                // +1 to match just after the '.'
                return $this->getDeviceIDFromRIS($userAgent, $tolerance + 1);
            }
        }

        return $this->getDeviceIDFromRIS($userAgent, Utils::firstSlash($userAgent));
    }

    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function applyRecoveryMatch($userAgent)
    {
        foreach (self::$constantIDs as $keyword => $deviceId) {
            if (Utils::checkIfContains($userAgent, $keyword)) {
                return $deviceId;
            }
        }

        if (Utils::checkIfContains($userAgent, 'Opera Mobi')) {
            return 'generic_opera_mini_version4';
        }

        return 'generic_opera_mini_version1';
    }
}