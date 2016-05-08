<?php

namespace oz;

/**
 * Class CacheConfiguration, manages the configurations required to store the cache.
 * @package oz
 */
class CacheConfiguration
{
    /**
     * Path where the cache folder is located.
     * @var string
     */
    private $folder;

    /**
     * Extension used when naming the cache files.
     * @var string
     */
    private $extension;

    /**
     * Encoding method used when naming the cache files.
     * @var string
     */
    private $hashMethod;

    /**
     * CacheConfiguration constructor.
     * @param string $folder Path where the cache folder is located.
     * @param string $extension Extension used when naming the cache files.
     * @param string $hasMethod Encoding method used when naming the cache files.
     */
    public function __construct($folder, $extension, $hasMethod)
    {
        $this->folder = (string) $folder;
        $this->extension = (string) $extension;
        $this->hashMethod = (string) $hasMethod;
    }

    /**
     * Default configuration used in the cache class.
     * @return CacheConfiguration
     */
    public static function getDefaultConfiguration()
    {
        return new CacheConfiguration(
            $_SERVER['DOCUMENT_ROOT'] . '/.cache',
            'cache',
            'sha1'
        );
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     * @return CacheConfiguration
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return CacheConfiguration
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * @return string
     */
    public function getHashMethod()
    {
        return $this->hashMethod;
    }

    /**
     * @param string $hashMethod
     * @return CacheConfiguration
     */
    public function setHashMethod($hashMethod)
    {
        $this->hashMethod = $hashMethod;

        return $this;
    }
}