<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use StdClass;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;

use App\Http\Controllers\Controller;

class MediaLibraryController extends Controller
{
    public function deleteMediaFile(Request $request){
        $mediaAttr = json_decode($request->input('mediaJson'));
        for($i=0; $i<sizeof($mediaAttr);$i++){
            $path = public_path(substr($mediaAttr[$i]->src,1));
            $pathThumb = public_path(substr($mediaAttr[$i]->src_thumb,1));
            if(file_exists($path)){
                unlink($path);
            }else{
                return ('{"success":false,"msg":"Something wrong during deletion!"}');
            }
            if(file_exists($pathThumb)){
                if(unlink($pathThumb)){
                    $father = DB::table('media_library')->where('id', '=', $mediaAttr[$i]->id)->get();
                    $father = $father[0]->father;
                    DB::table('media_library')->where('id', '=', $mediaAttr[$i]->id)->delete();
                    DB::table('media_portfolio')->where('media_id', '=', $mediaAttr[$i]->id)->delete();
                }
            }else{
                return ('{"success":false,"msg":"Something wrong during deletion of thumb image!"}');
            }
        }
        $media = DB::table('media_library')->where('father', $father)->get();
        $media = json_encode($media);
        return ('{"success":true,"mediaFiles":'.$media.'}');
    }

    public function deleteFile(Request $request){
        $file = $request->input('file');
        if(file_exists($file['src'])){
            unlink($file['src']);
            DB::table('documents')->where('id', '=', $file['id'])->delete();
        }else{
            return ('{"success":false,"msg":"Something wrong during deletion!"}');
        }
    }

    public function fileUpload(Request $request){
        $files = $request->file();
        $target_dir = public_path("assets/styleguide/");
        foreach($files as $key => $file){
            $fileType = $files[$key]->getClientOriginalExtension();
            $fileType = strtolower($fileType);
            if ($fileType != "pdf"){
                return '{"success":false, "msg": "Sorry, only PDF allowed!"}';
            }
            $filename = $file->getClientOriginalName();
            $file->move($target_dir,$filename);
            $path = "http://cheee.com.au/assets/styleguide/" . $filename;
            $src = "assets/styleguide/" . $filename;
            DB::table('documents')->insert([ 'url'=>$path, 'category'=>'styleguide', 'src'=>$src ]);
        }
        return ('{"success":true,"msg": "Style Guide Upload Success"}');
    }

    public function mediaUpload(Request $request){
        $files = $request->file();

        foreach($files as $key => $val){
            $fileType = $files[$key]->getClientOriginalExtension();
            $fileType = strtolower($fileType);
            if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" ) {
                return '{"success":false, "msg": "Sorry, only JPG, JPEG, PNG and GIF allowed! For the file ('.$files[$key]->getClientOriginalName().')"}';
            }
        }

        $mediaIDs = [];
        foreach($files as $key => $val){
            $id = $this->imageUpload($files[$key]);
            array_push($mediaIDs,$id);
        }

        $media = DB::select('select * from media_library');
        $media = json_encode($media);

        $mediaInfo = DB::table('media_library')
            ->whereIn('id', $mediaIDs)
            ->get();

        foreach($mediaInfo as $index => $value){
            $value->featured = 0;
            $value->narrow = 0;
        }
        return ('{"success":true,"mediaFiles":'.$media.',"mediaInfo":'. json_encode($mediaInfo) .'}');
    }

    public function mediaUploadToFolder(Request $request){
        $father = $request->input('father');
        DB::update("UPDATE media_library SET father = ? WHERE father = 999", array($father));
        return response()->json(array('status' => 1,'msg' => 'ok'));
    }
    
    public function imageUpload($file){

        $target_dir = public_path("assets/media/");
        $target_dir_thumb = public_path("assets/media/thumb/");

        $filename = time() . $file->getClientOriginalName();
        $fileType = $file->getClientOriginalExtension();
        $fileType = strtolower($fileType);


        if($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg" || $fileType == "gif"){
            $category = "image";
        }else{
            $category = "others";
        }

        $file->move($target_dir,$filename);

        $this->createThumbnail($filename, 500, 500, $target_dir, $target_dir_thumb);

        $imgSrc = "/assets/media/" . $filename;
        $imgSrcThumb = "/assets/media/thumb/" . $filename;

        $recordID = DB::table('media_library')->insertGetId(
            ['src' => $imgSrc, 'src_thumb' => $imgSrcThumb, 'category' => $category, 'father' => "999"]
        );
        return $recordID;
    }

    public function mediaModalGetFolder(Request $request){
        $id = $request->input('id');
        $portfolioId = $request->input('portfolioid');
        $fatherId = DB::table('media_library')->where('id', '=', $id)->get(array('father'));
        $subFolders = DB::table('media_library')->where('father', '=', $id)->where('category', '=', 'folder')->get();
        $medias = DB::table('media_library')->where('father', '=', $id)->where('category', '!=', 'folder')->get();
        $mediaList = DB::table('media_portfolio')->where('portfolio_id', '=' ,$portfolioId)->get();
        foreach ($medias as $media) {
            $media->featured = 0;
            $media->narrow = 0;
            $media->tickClass = "";
            if ($media->father != 0) {
                $data = DB::table('media_library')->where("id", $media->father)->get(["name"]);
                $folderName = $data[0]->name;
            } else {
                $folderName = "";
            }
            $media->foldername = $folderName;
            foreach ($mediaList as $mediaPhoto) {
                if($media->id == $mediaPhoto->media_id){
                    $media->featured = $mediaPhoto->featured;
                    $media->narrow = $mediaPhoto->narrow;
                    $media->tickClass = "mediaTick";
                    $media->sortID = $mediaPhoto->id;
                }
            }
        }
        $result = array(
            'fatherId' => isset($fatherId[0]) ? $fatherId[0]->father : "",
            'subFolder' => $subFolders,
            'medias' => $medias
        );
        return response()->json($result);
    }
    
    function createThumbnail($image_name, $new_width, $new_height, $uploadDir, $moveToDir)
    {
        $path = $uploadDir . '/' . $image_name;

        $mime = getimagesize($path);

        if ($mime['mime'] == 'image/png') {
            $src_img = imagecreatefrompng($path);
        }
        if ($mime['mime'] == 'image/jpg') {
            $src_img = imagecreatefromjpeg($path);
        }
        if ($mime['mime'] == 'image/jpeg') {
            $src_img = imagecreatefromjpeg($path);
        }
        if ($mime['mime'] == 'image/gif') {
            $src_img = imagecreatefromgif($path);
        }

        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);

        if($old_x <= 500 && $old_y <= 500){
            $thumb_w = $old_x;
            $thumb_h = $old_y;
        } else {
            if ($old_x > $old_y) {
                $thumb_w = $new_width;
                $thumb_h = $old_y * ($new_height / $old_x);
            }

            if ($old_x < $old_y) {
                $thumb_w = $old_x * ($new_width / $old_y);
                $thumb_h = $new_height;
            }

            if ($old_x == $old_y) {
                $thumb_w = $new_width;
                $thumb_h = $new_height;
            }
        }

        $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);

        $background = imagecolorallocate($dst_img , 0, 0, 0);

        imagecolortransparent($dst_img, $background);

        imagealphablending($dst_img, false);

        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);

        imagesavealpha($dst_img, true);

        // New save location
        $new_thumb_loc = $moveToDir . $image_name;

        if ($mime['mime'] == 'image/png') {
            $result = imagepng($dst_img, $new_thumb_loc, 8);
        }
        if ($mime['mime'] == 'image/jpg') {
            $result = imagejpeg($dst_img, $new_thumb_loc, 80);
        }
        if ($mime['mime'] == 'image/jpeg') {
            $result = imagejpeg($dst_img, $new_thumb_loc, 80);
        }
        if ($mime['mime'] == 'image/pjpeg') {
            $result = imagejpeg($dst_img, $new_thumb_loc, 80);
        }
        if ($mime['mime'] == 'image/gif') {
            $result = imagegif($dst_img, $new_thumb_loc, 80);
        }

        imagedestroy($dst_img);
        imagedestroy($src_img);

        return $result;
    }

    function contentMediaUpload(){
        // Allowed extentions.
        $allowedExts = array("gif", "jpeg", "jpg", "png", "blob");

        // Get filename.
        $temp = explode(".", $_FILES["file"]["name"]);

        // Get extension.
        $extension = end($temp);

        // An image check is being done in the editor but it is best to
        // check that again on the server side.
        // Do not use $_FILES["file"]["type"] as it can be easily forged.

        $mime = $_FILES["file"]["type"];

        if ((($mime == "image/gif")
        || ($mime == "image/jpeg")
        || ($mime == "image/pjpeg")
        || ($mime == "image/x-png")
        || ($mime == "image/png"))
        && in_array(strtolower($extension), $allowedExts)) {
            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;

            $target_dir = public_path("assets/media/");
            // Save file in the uploads folder.
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $name);

            // Generate response.
            $response = new StdClass;

            $response->link = '../assets/media/' . $name;
            echo stripslashes(json_encode($response));
        }
    }
}