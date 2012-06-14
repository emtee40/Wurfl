<?php
namespace WURFL\Storage;

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
 * @package    WURFL_Storage
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
/**
 * WURFL Storage factory
 * @package    WURFL_Storage
 */
class Factory
{
    /**
     * @var array Default configuration
     */
    private static $_defaultConfiguration = array(
        'provider' => 'memory',
        'params'   => array()
    );
    
    /**
     * Create a configuration based on the default configuration with the differences from $configuration
     * @param array $configuration
     * @return WURFL_Storage_Base Storage object, initialized with the given $configuration
     */
    public static function create($configuration)
    {
        $currentConfiguration = is_array($configuration) ?
                array_merge(self::$_defaultConfiguration, $configuration)
                : self::$_defaultConfiguration;
        $class = self::_className($currentConfiguration);
        return new $class($currentConfiguration['params']);
    }
    
    /**
     * Return the Storage Provider Class name from the given $configuration by using its 'provider' element
     * @param array $configuration
     * @return string WURFL Storage Provider class name
     */
    private static function _className($configuration)
    {
        $provider = $configuration['provider'];
        return '\\WURFL\\Storage\\' . ucfirst($provider);
    }
}