<?php

namespace App\Services;

class ImageHandlerService
{
    public function storeImage($image)
    {
        if (empty($image)) {
            return false;
        }

        return $image->store('post-thumbnails', 'public');
    }
}
