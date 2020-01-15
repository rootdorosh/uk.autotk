<?php
declare( strict_types = 1 );

namespace App\Services\Storage;

use App\Services\Storage\lib\StorageManager;
use Illuminate\Support\Str;

/**
 * Class ImageStorageManager
 * @package App\Services\Storage
 */
class ImageStorageManager extends StorageManager
{
    /**
     * @return string
     */
    public function getStoragePath() : string
    {
        return strtolower(Str::random(2)) . '/' . strtolower(Str::random(2)) . '/';
    }
}
