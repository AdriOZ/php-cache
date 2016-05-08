<?php

namespace oz;

/**
 * Class Cache used to store data in cache files.
 * @package oz
 */
class Cache implements \ArrayAccess
{
    /**
     * Configuration used to store and retrieve data.
     * @var CacheConfiguration
     */
    private $conf;

    /**
     * Cache used in order to avoid getting contents of the files all the time.
     * @var array
     */
    private $cache;

    /**
     * Cache constructor.
     * @param CacheConfiguration $conf Configuration used to store and retrieve
     * data.
     */
    public function __construct(CacheConfiguration $conf)
    {
        $this->conf = $conf;
        $this->cache = array();
        $this->checkDir();
    }

    public function offsetExists($offset)
    {
        $hash = $this->hash($offset);
        return isset($this->cache[$hash])
            || file_exists($this->buildPath($hash));
    }

    public function offsetGet($offset)
    {
        $hash = $this->hash($offset);

        if (isset($this->cache[$hash])) {
            return $this->cache[$hash];
        }

        // Obtain from the files
        $path = $this->buildPath($hash);

        if (!file_exists($path)) {
            trigger_error("The value of '$offset' doesn't exist", E_USER_NOTICE);
            return null;
        }

        $value = json_decode(file_get_contents($path), true);
        $this->cache[$hash] = $value;

        return $value;
    }

    public function offsetSet($offset, $value)
    {
        $hash = $this->hash($offset);
        $path = $this->buildPath($hash);
        $this->cache[$hash] = $value;
        file_put_contents($path, json_encode($value));
    }

    public function offsetUnset($offset)
    {
        $hash = $this->hash($offset);
        $path = $this->buildPath($hash);

        if (isset($this->cache[$hash])) {
            unset($this->cache[$hash]);
        }

        if (file_exists($path)) {
            unlink($path);
        }
    }

    // Util
    /**
     * Encode a string using the hash method of the configuration.
     * @param string $str String to be encoded.
     * @return string The encoded string.
     */
    private function hash($str)
    {
        return hash($this->conf->getHashMethod(), $str);
    }

    /**
     * Generate the path to a file using the key of the cache.
     * @param string $fileName Key of the cache.
     * @return string Path of the file.
     */
    private function buildPath($fileName)
    {
        return $this->conf->getFolder()
            . '/'
            . $fileName
            . '.'
            . $this->conf->getExtension();
    }

    /**
     * Checks if the class can use the cache folder and, if not, creates the
     * directory and give it read/write access.
     */
    private function checkDir()
    {
        $path = $this->conf->getFolder();

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        } elseif (!is_readable($path) || !is_writable($path)) {
            chmod($path, 0777);
        }
    }
}