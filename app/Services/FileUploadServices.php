<?php
namespace App\Services;
use Image;

class FileUploadServices{
    
    // ============== its for for single file upload with resize ===========
    public function imageUpload($request, $field_name, $upload_path, $widthsize, $heightsize){
        if ($request->file($field_name)) {
          $image = $request->file($field_name);
          $filenamewithextension = $image->getClientOriginalName();
          //get filename without extension
          $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
          //get file extension
          $extension = $image->getClientOriginalExtension();
          //filename to store
          $picturename = $filename.'_'.uniqid().'.'.$extension;
          $filePath = public_path($upload_path);
          $img = Image::make($image->path());
          $img->resize($widthsize,$heightsize, function ($const) {
          })->save($filePath.'/'.$picturename);
          $picture = $upload_path.'/'.$picturename;
        }else{
          $picture = '';
        }
        return $picture;
    }
}