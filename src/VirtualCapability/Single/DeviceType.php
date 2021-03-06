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

namespace Wurfl\VirtualCapability\Single;

use Wurfl\VirtualCapability\VirtualCapability;

/**
 * Virtual capability helper
 */
class DeviceType extends VirtualCapability
{
    /**
     * @var array
     */
    protected $requiredCapabilities = array(
        'is_wireless_device',
        'is_tablet',
        'can_assign_phone_number',
        'is_bot',
        'is_smarttv',
        'ux_full_desktop',
    );

    /**
     * @return string
     */
    protected function compute()
    {
        $apiMob     = ('true' === $this->device->getCapability('is_wireless_device'));
        $apiBot     = ('true' === $this->device->getVirtualCapability('is_robot'));
        $apiTv      = ('true' === $this->device->getCapability('is_smarttv'));
        $apiDesktop = ('true' === $this->device->getCapability('ux_full_desktop'));
        $apiTab     = ('true' === $this->device->getCapability('is_tablet'));
        $apiPhone   = ('true' === $this->device->getCapability('can_assign_phone_number'));

        if ($apiBot) {
            $deviceType = 'Bot';
        } elseif (!$apiMob) {
            if ($apiTv) {
                $deviceType = 'TV Device';
            } elseif ($apiDesktop) {
                $deviceType = 'Desktop';
            } else {
                $deviceType = 'general Device';
            }
        } else {
            if ($apiTab && $apiPhone) {
                $deviceType = 'FonePad';
            } elseif ($apiTab) {
                $deviceType = 'Tablet';
            } elseif ($apiPhone) {
                $deviceType = 'Mobile Phone';
            } else {
                $deviceType = 'Mobile Device';
            }
        }

        return $deviceType;
    }
}
