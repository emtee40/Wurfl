<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the LICENSE file distributed with this package.
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace Wurfl\Handlers;

use Wurfl\WurflConstants;

/**
 * FennecOnAndroidUserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class FennecOnAndroidHandler extends AbstractHandler
{
    protected $prefix = 'FENNECONANDROID';

    public static $constantIDs = array(
        'generic_android_ver2_0_fennec',
        'generic_android_ver2_0_fennec_tablet',
        'generic_android_ver2_0_fennec_desktop',
    );

    public function canHandle($userAgent)
    {
        if (Utils::isDesktopBrowser($userAgent)) {
            return false;
        }

        return (Utils::checkIfContains($userAgent, 'Android')
            && Utils::checkIfContainsAnyOf($userAgent, array('Fennec', 'Firefox'))
        );
    }

    /**
     * @param string $userAgent
     *
     * @return null|string
     */
    public function applyConclusiveMatch($userAgent)
    {
        // Captures the index of the first decimal point in the Firefox verison 'rv:nn.nn.nn'
        // Example:
        //   Mozilla/5.0 (Android; Tablet; rv:17.0) Gecko/17.0 Firefox/17.0
        //   Mozilla/5.0 (Android; Tablet; rv:17.
        if (preg_match('|^.+?\(.+?rv:\d+(\.)|', $userAgent, $matches, PREG_OFFSET_CAPTURE)) {
            return $this->getDeviceIDFromRIS($userAgent, $matches[1][1] + 1);
        }

        return WurflConstants::NO_MATCH;
    }

    /**
     * @param string $userAgent
     *
     * @return null|string
     */
    public function applyRecoveryMatch($userAgent)
    {
        $isFennec  = Utils::checkIfContains($userAgent, 'Fennec');
        $isFirefox = Utils::checkIfContains($userAgent, 'Firefox');

        if ($isFennec || $isFirefox) {
            if ($isFennec || Utils::checkIfContains($userAgent, 'Mobile')) {
                return 'generic_android_ver2_0_fennec';
            }

            if (Utils::checkIfContains($userAgent, 'Tablet')) {
                return 'generic_android_ver2_0_fennec_tablet';
            }

            if (Utils::checkIfContains($userAgent, 'Desktop')) {
                return 'generic_android_ver2_0_fennec_desktop';
            }
        }

        return WurflConstants::NO_MATCH;
    }
}
