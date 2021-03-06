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
 * HTCMacUserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class HTCMacHandler extends AbstractHandler
{
    protected $prefix = 'HTCMAC';

    public static $constantIDs = array(
        'generic_android_htc_disguised_as_mac',
    );

    /**
     * @param string $userAgent
     *
     * @return bool
     */
    public function canHandle($userAgent)
    {
        return Utils::checkIfStartsWith($userAgent, 'Mozilla/5.0 (Macintosh')
            && Utils::checkIfContains($userAgent, 'HTC');
    }

    /**
     * @param string $userAgent
     *
     * @return null|string
     */
    public function applyConclusiveMatch($userAgent)
    {
        $delimiterIndex = strpos($userAgent, WurflConstants::RIS_DELIMITER);

        if ($delimiterIndex !== false) {
            $tolerance = $delimiterIndex + strlen(WurflConstants::RIS_DELIMITER);

            return $this->getDeviceIDFromRIS($userAgent, $tolerance);
        }

        return WurflConstants::NO_MATCH;
    }

    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function applyRecoveryMatch($userAgent)
    {
        return 'generic_android_htc_disguised_as_mac';
    }

    /**
     * @param string $userAgent
     *
     * @return string|null
     */
    public static function getHTCMacModel($userAgent)
    {
        if (preg_match('/(HTC[^;\)]+)/', $userAgent, $matches)) {
            $model = preg_replace('#[ _\-/]#', '~', $matches[1]);

            return $model;
        }

        return null;
    }
}
