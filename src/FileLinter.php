<?php

namespace PSRLinter;

use PSRLinter\Exceptions\EmptyListOfFiles;

class FileLinter
{
    private $linter;

    public function __construct($pathToConfigFile = __DIR__ . "/config.json")
    {
        $this->linter = new Linter($pathToConfigFile);
    }

    public function lint($path)
    {
        $reports = [];
        $files = $this->getFiles($path);
        foreach ($files as $file) {
            $code = file_get_contents($file);
            $reports[$file] = $this->linter->lint($code);
        }
        return $reports;
    }

    public function fix($path)
    {
        $reports = [];
        $files = $this->getFiles($path);
        foreach ($files as $file) {
            $code = file_get_contents($file);
            list($code, $reports[$file]) = $this->linter->fix($code);
            file_put_contents($file, $code);
        }
        return $reports;
    }

    private function getFiles($dir)
    {
        $files = [];
        if (is_dir($dir)) {
            $iter = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iter as $path) {
                if ($path->isFile() && $path->getExtension() == 'php') {
                    $files[] = $path->getPathname();
                }
            }
        } elseif (is_file($dir) && pathinfo($dir, PATHINFO_EXTENSION) == 'php') {
            $files[] = $dir;
        }
        if ($files == null) {
            throw new EmptyListOfFiles();
        }
        return $files;
    }
}
