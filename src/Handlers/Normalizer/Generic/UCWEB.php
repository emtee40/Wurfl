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

namespace Wurfl\Handlers\Normalizer\Generic;

use Wurfl\Handlers\Normalizer\NormalizerInterface;

/**
 * User Agent Normalizer - removes UCWEB garbage from user agent
 */
class UCWEB implements NormalizerInterface
{
    /**
     * This method remove the 'UP.Link' substring from user agent string.
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize($userAgent)
    {
        // Starts with 'JUC' or 'Mozilla/5.0(Linux;U;Android'
        if (strpos($userAgent, 'JUC') === 0 || strpos($userAgent, 'Mozilla/5.0(Linux;U;Android') === 0) {
            $userAgent = preg_replace('/^(JUC \(Linux; U;)(?= \d)/', '$1 Android', $userAgent);
            $userAgent = preg_replace('/(Android|JUC|[;\)])(?=[\w|\(])/', '$1 ', $userAgent);
        }

        return $userAgent;
    }
}
