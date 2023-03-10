<?php

namespace Valet\Drivers;

class Concrete5ValetDriver extends BasicValetDriver
{
    /**
     * If a concrete directory exists, it's probably c5.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        return file_exists($sitePath.'/concrete/config/install/base');
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (stripos($uri, '/application/files') === 0) {
            return $sitePath.$uri;
        }

        return parent::isStaticFile($sitePath, $siteName, $uri);
    }

    /**
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        if (! getenv('CONCRETE5_ENV')) {
            putenv('CONCRETE5_ENV=valet');
        }

        $matches = [];
        if (preg_match('/^\/(.*?)\.php/', $uri, $matches)) {
            $filename = $matches[0];

            if (file_exists($sitePath.$filename) && ! is_dir($sitePath.$filename)) {
                $_SERVER['SCRIPT_FILENAME'] = $sitePath.$filename;
                $_SERVER['SCRIPT_NAME'] = $filename;

                return $sitePath.$filename;
            }
        }

        $_SERVER['SCRIPT_FILENAME'] = $sitePath.'/index.php';
        $_SERVER['SCRIPT_NAME'] = '/index.php';

        return $sitePath.'/index.php';
    }
}
