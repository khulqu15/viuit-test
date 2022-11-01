<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function upload_photo(Request $request, $model, $path, $data): string|null
    {
        if($request->hasFile('photo'))
        {
            $file = $request->file('photo');
            if (!File::isDirectory($path))
                File::makeDirectory($path, 0777, true, true);

            if($data && $data->photo)
                unlink($path.$data->photo);

            $filename = $model.'-'.time().'-'.uniqid().'.'.$file->extension();
            $img = Image::make($file->path());
            $img->resize(750, 750, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$filename);
            return $filename;
        }
        return null;
    }
}
