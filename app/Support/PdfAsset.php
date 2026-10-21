<?php

namespace App\Support;

class PdfAsset
{
    public static function image(string $relativePath): string
    {
        $root = realpath(public_path());
        $file = realpath(public_path(ltrim($relativePath, '/\\')));
        if (! $root || ! $file || ! str_starts_with($file, $root . DIRECTORY_SEPARATOR) || ! is_file($file)) {
            return '';
        }

        $mime = mime_content_type($file);
        if (! in_array($mime, ['image/png', 'image/jpeg', 'image/gif'], true)) {
            return '';
        }

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file));
    }
}
