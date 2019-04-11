<?php

namespace PHPStanMagento1\Autoload\Magento;

use Mage;
use ReflectionClass;

function includeFile(string $file)
{
    include $file;
}

class ModuleControllerAutoLoader
{
    /**
     * @var string
     */
    private $magentoRoot;

    private $codePool;

    public function __construct($codePool, $magentoRoot = null)
    {
        if (empty($magentRoot)) {
            $mageClass = new ReflectionClass(Mage::class);
            $magentoRoot = dirname($mageClass->getFileName(), 2);
        }
        $this->codePool = $codePool;
        $this->magentoRoot = $magentoRoot;
    }

    public function register()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    public function autoload($className)
    {
        if (preg_match('/^([a-zA-Z0-9\x7f-\xff]*)_([a-zA-Z0-9\x7f-\xff]*)_([a-zA-Z0-9_\x7f-\xff]+)/', $className, $match) === 1) {
            $controllerFilename = sprintf('%s/app/code/%s/%s/%s/controllers/%s.php', $this->magentoRoot, $this->codePool, $match[1], $match[2], $match[3]);
            if (file_exists($controllerFilename)) {
                includeFile($controllerFilename);
            }
        }
    }
}
