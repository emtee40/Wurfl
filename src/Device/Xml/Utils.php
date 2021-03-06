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

namespace Wurfl\Device\Xml;

use Wurfl\Exception;
use Wurfl\FileUtils;

/**
 * WURFL XML Utilities Static Class
 */
class Utils
{
    /**
     *
     */
    private function __construct()
    {
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     * Returns the file path of the $xmlResource; if the $xmlResource is zipped it is uncompressed first
     *
     * @param string $xmlResource XML Resource file
     *
     * @return string XML Resource file
     */
    public static function getXMLFile($xmlResource)
    {
        if (self::isZipFile($xmlResource)) {
            return self::getZippedFile($xmlResource);
        }

        return $xmlResource;
    }

    /**
     * Returns a XML Resource filename for the uncompressed contents of the provided zipped $filename
     *
     * @param string $filename of zipped XML data
     *
     * @throws Exception ZipArchive extension is not loaded or the ZIP file is corrupt
     *
     * @return string Full filename and path of extracted XML file
     */
    private static function getZippedFile($filename)
    {
        if (!self::zipModuleLoaded()) {
            throw new Exception('The ZipArchive extension is not loaded. Load the extension or use the flat wurfl.xml file');
        }

        $tmpDir = FileUtils::getTempDir();
        $zip    = new \ZipArchive();

        if ($zip->open($filename) !== true) {
            throw new Exception('The Zip file <$filename> could not be opened');
        }

        $zippedFile = $zip->statIndex(0);
        $wurflFile  = $zippedFile['name'];

        $zip->extractTo($tmpDir);
        $zip->close();

        return FileUtils::cleanFilename($tmpDir . DIRECTORY_SEPARATOR . $wurflFile);
    }

    /**
     * Returns true if the $filename is that of a Zip file
     *
     * @param string $fileName
     *
     * @return bool
     */
    private static function isZipFile($fileName)
    {
        return strcmp('zip', substr($fileName, -3)) === 0 ? true : false;
    }

    /**
     * Returns true if the ZipArchive extension is loaded
     *
     * @return bool
     */
    private static function zipModuleLoaded()
    {
        return class_exists('ZipArchive');
    }
}
