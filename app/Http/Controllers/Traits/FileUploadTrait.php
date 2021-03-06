<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{

    /**
     * File upload trait used in controllers to upload files
     */
    public function saveFiles(Request $request)
    {
        if (! file_exists(public_path('uploads'))) {
            mkdir(public_path('uploads'), 0777);
            mkdir(public_path('uploads/thumb'), 0777);
        }

        $finalRequest = $request;

        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                if ($request->has($key . '_max_width') && $request->has($key . '_max_height')) {
                    // Check file width
                    $filename = time() . '-' . $request->file($key)->getClientOriginalName();
                    $file     = $request->file($key);
                    $image    = Image::make($file);
                    if (! file_exists(public_path('uploads/thumb'))) {
                        mkdir(public_path('uploads/thumb'), 0777, true);
                    }
                    Image::make($file)->resize(50, 50)->save(public_path('uploads/thumb') . '/' . $filename);
                    $width  = $image->width();
                    $height = $image->height();
                    if ($width > $request->{$key . '_max_width'} && $height > $request->{$key . '_max_height'}) {
                        $image->resize($request->{$key . '_max_width'}, $request->{$key . '_max_height'});
                    } elseif ($width > $request->{$key . '_max_width'}) {
                        $image->resize($request->{$key . '_max_width'}, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif ($height > $request->{$key . '_max_width'}) {
                        $image->resize(null, $request->{$key . '_max_height'}, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $image->save(public_path('uploads') . '/' . $filename);
                    $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                } else {
                    $filename = time() . '-' . $request->file($key)->getClientOriginalName();
                    $request->file($key)->move(public_path('uploads'), $filename);
                    $finalRequest = new Request(array_merge($finalRequest->all(), [$key => $filename]));
                }
            }
        }

        return $finalRequest;
    }
    public function saveImages($files, $folder)
    {   
       if($folder == 'event'){
        $destinationPath = '/uploads/'.$folder.'/';
        $imageFile= array();
        foreach($files as $file){
        $file_name = time().'-'.$file->getClientOriginalName();
        $image = Image::make($file);
        $image->resize(500, 500, function ($constraint) {
              $constraint->aspectRatio();
        })->save(public_path() . $destinationPath . $file_name);
         array_push($imageFile,$destinationPath.''.$file_name);
    }
  
        return $imageFile;
    }elseif($folder == 'eventimage'){
        $imageFile = array();
        $destinationPath = '/uploads/'.$folder.'/';

        $file_name = time().'-'.$files->getClientOriginalName();
        $image = Image::make($files);
        $image->resize(500, 500, function ($constraint) {
              $constraint->aspectRatio();
        })->save(public_path() . $destinationPath . $file_name);
         array_push($imageFile,$destinationPath.''.$file_name);
        return $imageFile;
    }else{
        $imageFile = array();
        $destinationPath = '/uploads/'.$folder.'/';

        $file_name = time().'-'.$files->getClientOriginalName();
        $image = Image::make($files);
        $image->resize(500, 500, function ($constraint) {
              $constraint->aspectRatio();
        })->save(public_path() . $destinationPath . $file_name);
         array_push($imageFile,$destinationPath.''.$file_name);
        return $imageFile;
    }
}
}