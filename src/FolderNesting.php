<?php

namespace Ivanb\FolderNesting;

class FolderNesting
{
    const FILE_NAME = 'count';
    const FILE_EXTENSION_EMPTY = '';
    const FILE_EXTENSION_TXT = 'txt';
    const FILE_EXTENSIONS = [
        self::FILE_EXTENSION_EMPTY,
        self::FILE_EXTENSION_TXT
    ];

    /**
     * @param string $directory
     * @param float|int $sum
     * @return int|float
     */
    private function scanDirectory(string $directory, float|int $sum = 0): int|float
    {
        $openDir = opendir($directory);
        if ($openDir) {
            while (($file = readdir($openDir)) !== false) {
                $filePath = $directory . '/' . $file;
                if (!in_array($file, ['.', '..'])) {
                    if (is_dir($filePath)) {
                        $sum = $this->scanDirectory($filePath, $sum);
                    } else {
                        $sum += $this->scanFile($filePath);
                    }
                }
            }
            closedir($openDir);
        }

        return $sum;
    }

    /**
     * @param string $filePath
     * @return float|int
     */
    private function scanFile(string $filePath): float|int
    {
        $info = new \SplFileInfo($filePath);
        if (
            in_array($info->getExtension(), self::FILE_EXTENSIONS) &&
            self::FILE_NAME === $info->getBasename('.' . $info->getExtension())
        ) {
            $string = file_get_contents($filePath);
            preg_match_all('/(\+|-){0,1}\d+[\.]{0,1}\d*/', $string, $matches);
            return !empty($matches[0]) ? array_sum($matches[0]) : 0;
        }
        return 0;
    }

    /**
     * @param array $directories
     * @return int|float
     */
    public function getSumNumbersInFiles(array $directories): int|float
    {
        $sum = 0;
        foreach ($directories as $directory) {
            $sum += $this->scanDirectory($directory);
        }
        return $sum;
    }

}