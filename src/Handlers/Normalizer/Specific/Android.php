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
use Wurfl\WurflConstants;

/**
 * User Agent Normalizer
 */
class Android implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        // Normalize Android version
        $model   = AndroidHandler::getAndroidModel($userAgent, false);
        $version = AndroidHandler::getAndroidVersion($userAgent, false);
        if ($model !== null && $version !== null) {
            $prefix = $version . ' ' . $model . WurflConstants::RIS_DELIMITER;

            return $prefix . $userAgent;
        }

        return $userAgent;
    }
}
