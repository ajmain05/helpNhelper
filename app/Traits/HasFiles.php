<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasFiles
{
    private function storeFile($directoryName, $file, $prefix = 'file')
    {
        $fileName = str_replace([' ', '%'], '', $prefix.'-'.Str::ulid(now())).'.'.$file?->extension();

        $path = $file?->storeAs('public/'.$directoryName, $fileName);

        return 'storage/'.$directoryName.'/'.$fileName;
    }

    private function removeFile($filePath = null)
    {
        if ($filePath) {
            return ! file_exists($filePath) ?: unlink(public_path('/'.$filePath));
        } else {
            return 0;
        }
    }
}
