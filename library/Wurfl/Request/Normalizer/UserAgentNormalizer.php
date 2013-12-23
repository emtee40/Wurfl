<?php
namespace Wurfl\Request\Normalizer;

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
     * @category   WURFL
     * @package    WURFL_Request
     * @copyright  ScientiaMobile, Inc.
     * @license    GNU Affero General Public License
     * @author     Fantayeneh Asres Gizaw
     * @version    $id$
     */
/**
 * User Agent Normalizer
 *
 * @package    WURFL_Request
 */
class UserAgentNormalizer implements NormalizerInterface
{
    /**
     * UserAgentNormalizer chain - array of \Wurfl\Request\Normalizer\UserAgentNormalizer objects
     *
     * @var array
     */
    protected $normalizers = array();

    /**
     * Set the User Agent Normalizers
     *
     * @param array $normalizers Array of \Wurfl\Request\Normalizer\UserAgentNormalizer objects
     */
    public function __construct($normalizers = array())
    {
        if (is_array($normalizers)) {
            $this->normalizers = $normalizers;
        }
    }

    /**
     * Adds a new UserAgent Normalizer to the chain
     *
     * @param \Wurfl\Request\Normalizer\NormalizerInterface $normalizer
     *
     * @return UserAgentNormalizer
     */
    public function addUserAgentNormalizer(NormalizerInterface $normalizer)
    {
        $userAgentNormalizers   = $this->normalizers;
        $userAgentNormalizers[] = $normalizer;
        return new UserAgentNormalizer($userAgentNormalizers);
    }

    /**
     * Return the number of normalizers currently registered
     *
     * @return int count
     */
    public function count()
    {
        return count($this->normalizers);
    }

    /**
     * Normalize the given $userAgent by passing down the chain
     * of normalizers
     *
     * @param string $userAgent
     *
     * @return string Normalized user agent
     */
    public function normalize($userAgent)
    {
        // Don't normalize generic user agents
        if (substr($userAgent, 0, 12) == 'DO_NOT_MATCH') {
            return $userAgent;
        }

        $normalizedUserAgent = $userAgent;

        foreach ($this->normalizers as $normalizer) {
            /** @var $normalizer \Wurfl\Request\Normalizer\NormalizerInterface */
            $normalizedUserAgent = $normalizer->normalize($normalizedUserAgent);
        }

        return $normalizedUserAgent;
    }
}
