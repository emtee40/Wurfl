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

namespace Wurfl\VirtualCapability\Single;

use Wurfl\VirtualCapability\VirtualCapability;

/**
 * Virtual capability helper
 *
 * @package    WURFL_VirtualCapability
 */
class CompleteDeviceName
    extends VirtualCapability
{
    /**
     * @var array
     */
    protected $required_capabilities = array(
        'brand_name',
        'model_name',
        'marketing_name',
    );

    /**
     * @return mixed|string
     */
    protected function compute()
    {
        $parts = array($this->device->brand_name);
        if (strlen($this->device->model_name)) {
            $parts[] = $this->device->model_name;
        }
        if (strlen($this->device->marketing_name)) {
            $parts[] = "({$this->device->marketing_name})";
        }

        return implode(' ', $parts);
    }
}