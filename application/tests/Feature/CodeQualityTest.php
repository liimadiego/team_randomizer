<?php

namespace Tests\Feature;

use Tests\TestCase;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class CodeQualityTest extends TestCase
{
    public function test_no_dd_or_dump_in_code()
    {
        $directories = [
            app_path('Http/Controllers'),
            app_path('Repositories')
        ];

        $forbiddenFunctions = ['dd(', 'dump('];
        $errors = [];

        foreach ($directories as $directory) {
            $files = $this->getAllPhpFiles($directory);

            foreach ($files as $file) {
                $contents = file_get_contents($file);
                foreach ($forbiddenFunctions as $function) {
                    if (strpos($contents, $function) !== false) {
                        $errors[] = "Found '{$function}' in file {$file}";
                    }
                }
            }
        }

        $this->assertEmpty($errors, implode("\n", $errors));
    }

    private function getAllPhpFiles($dir)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir)
        );
        $phpFiles = [];
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $phpFiles[] = $file->getRealPath();
            }
        }
        return $phpFiles;
    }
}
