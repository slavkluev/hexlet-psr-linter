<?php

namespace PSRLinter;

class Utils
{
    public static function getFiles($dir)
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
        } else {
            $files[] = $dir;
        }
        return $files;
    }

    public static function getRules()
    {
        return [["\\PSRLinter\\Rules\\FunctionRule", "check"],
                ["\\PSRLinter\\Rules\\MethodRule", "check"],
                ["\\PSRLinter\\Rules\\VariableRule", "check"]];
    }
}
