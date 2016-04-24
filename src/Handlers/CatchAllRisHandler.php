<?php
/**
 * Copyright (c) 2014 ScientiaMobile, Inc.
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * Refer to the LICENSE file distributed with this package.
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace Wurfl\Handlers;

/**
 * CatchAllUserAgentHandler
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */
class CatchAllRisHandler extends AbstractHandler
{
    protected $prefix = 'CATCH_ALL_RIS';

    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $userAgent
     *
     * @return bool always true
     */
    public function canHandle($userAgent)
    {
        return true;
    }

    /**
     * Apply RIS on Firts slash
     *
     * @param string $userAgent
     *
     * @return string
     */
    public function applyConclusiveMatch($userAgent)
    {
        if (Utils::checkIfStartsWith($userAgent, 'CFNetwork/')) {
            $tolerance = Utils::firstSpace($userAgent);
        } else {
            $tolerance = Utils::firstSlash($userAgent);
        }

        return $this->getDeviceIDFromRIS($userAgent, $tolerance);
    }
}