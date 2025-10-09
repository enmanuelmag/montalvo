<?php

if (! function_exists('asset_versioned')) {
    function asset_versioned($path)
    {
        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            return asset($path) . '?v=' . filemtime($fullPath);
        }
        return asset($path);
    }
}

