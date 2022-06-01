<?php

namespace App\Http\Traits;

trait PictureUtils
{
    public function ConvertAndSaveImage($filename)
    {
        $file = fopen($filename, "rb");
        $contents = fread($file, filesize($filename));

        $image = new \Imagick();
        $image->readImageBlob($contents);
        $image->setImageFormat("jpeg");
        $image->setImageCompressionQuality(100);

        $filenameWithExt = $filename->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $filenameToStore = $filename . '_' . time() . '.jpeg';

        $image->writeImage('uploads/' . $filenameToStore);

        return $filenameToStore;
    }
}
