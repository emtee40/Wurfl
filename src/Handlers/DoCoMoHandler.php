<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
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
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace Wurfl\Handlers;

/**
 * DoCoMoUserAgentHandler
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class DoCoMoHandler extends AbstractHandler
{
    protected $prefix = 'DOCOMO';

    public static $constantIDs = array(
        'docomo_generic_jap_ver1',
        'docomo_generic_jap_ver2',
    );

    public function canHandle($userAgent)
    {
        if (Utils::isDesktopBrowser($userAgent)) {
            return false;
        }

        return Utils::checkIfStartsWith($userAgent, 'DoCoMo');
    }

    public function applyConclusiveMatch($userAgent)
    {
        $tolerance = Utils::ordinalIndexOf($userAgent, '/', 2);
        if ($tolerance === -1) {
            //  DoCoMo/2.0 F01A(c100;TB;W24H17)
            $tolerance = Utils::indexOfOrLength('(', $userAgent);
        }

        return $this->getDeviceIDFromRIS($userAgent, $tolerance);
    }

    public function applyRecoveryMatch($userAgent)
    {
        $versionIndex = 7;
        $version      = $userAgent[$versionIndex];

        return ($version === '2') ? 'docomo_generic_jap_ver2' : 'docomo_generic_jap_ver1';
    }
}
