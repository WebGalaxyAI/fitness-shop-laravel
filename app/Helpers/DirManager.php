<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class DirManager
{
    public function copyFiles(string $sourcePath, $destinationPath)
    {
        // Перевірка наявності папки
        if (!File::exists($destinationPath)) {
            // Створення папки, якщо вона відсутня
            File::makeDirectory($destinationPath, $mode = 0755, true, true);
        }

        $files = File::files($sourcePath);

        foreach ($files as $file) {
            $filename = $file->getFilename();
            File::copy($sourcePath . '/' . $filename, $destinationPath . '/' . $filename);
        }

    }
}
