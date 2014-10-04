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

namespace Wurfl\Request\Normalizer\Specific;

use Wurfl\Request\Normalizer\NormalizerInterface;

/**
 * User Agent Normalizer - Return the Chrome string with the major version
 *
 * @package    \Wurfl\Request\Normalizer\Specific
 */
class Chrome
    implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        return $this->chromeWithMajorVersion($userAgent);
    }

    /**
     * Returns Google Chrome's Major version number
     *
     * @param string $userAgent
     *
     * @return string Version number
     */
    private function chromeWithMajorVersion($userAgent)
    {
        $startIndex = strpos($userAgent, 'Chrome');
        $endIndex   = strpos($userAgent, '.', $startIndex);

        if ($endIndex === false) {
            return substr($userAgent, $startIndex);
        } else {
            return substr($userAgent, $startIndex, ($endIndex - $startIndex));
        }
    }
}