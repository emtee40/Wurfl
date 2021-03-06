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

namespace Wurfl\Handlers\Normalizer\Specific;

use Wurfl\Handlers\AndroidHandler;
use Wurfl\Handlers\Normalizer\NormalizerInterface;
use Wurfl\Handlers\OperaMobiOrTabletOnAndroidHandler;
use Wurfl\Handlers\Utils;
use Wurfl\WurflConstants;

/**
 * User Agent Normalizer
 */
class OperaMobiOrTabletOnAndroid implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $isOperaMobile = Utils::checkIfContains($userAgent, 'Opera Mobi');
        $isOperaTablet = Utils::checkIfContains($userAgent, 'Opera Tablet');

        if ($isOperaMobile || $isOperaTablet) {
            $operaVersion   = OperaMobiOrTabletOnAndroidHandler::getOperaOnAndroidVersion($userAgent, false);
            $androidVersion = AndroidHandler::getAndroidVersion($userAgent, false);

            if ($operaVersion !== null && $androidVersion !== null) {
                $operaModel = $isOperaTablet ? 'Opera Tablet' : 'Opera Mobi';
                $prefix     = $operaModel . ' ' . $operaVersion . ' Android ' . $androidVersion . WurflConstants::RIS_DELIMITER;

                return $prefix . $userAgent;
            }
        }

        return $userAgent;
    }
}
