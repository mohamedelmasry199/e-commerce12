<?php

namespace App\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManager
{

    public function uploadSingleImage($path, $image, $disk)
    {
        $file_name = $this->generateUniqueName($image);
        self::storeImageInLocal($file_name, $path, $image, $disk);
        return $file_name;
    }
    public function uploadImages($images, $model, $disk)
    {
        foreach ($images as $image) {

            $file_name = $this->generateUniqueName($image);
            $this->storeImageInLocal($file_name, '/', $image, $disk);

            $model->images()->create([
                'file_name' => $file_name,
            ]);
        }
    }
    public function deleteImageFromLocal($image_path)
    {
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }
    }

    private function storeImageInLocal($file_name, $path, $image, $disk)
    {
        $image->storeAs($path, $file_name, ['disk' => $disk]);
    }

    public function generateUniqueName($image)
    {
        $file_name = Str::uuid() . time() . $image->getClientOriginalExtension();
        return $file_name;
    }
}
