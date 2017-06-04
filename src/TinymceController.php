<?php

namespace Petehouston\Tinymce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TinymceController extends Controller
{
    /**
     * Handle image upload from TinyMCE file browser window
     *
     * @param  Request $request
     * @return Response
     */
   
    function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('image');

        $filename = 'image_'.time().'_'.$image->hashName();
        $image = $image->move(public_path('img'), $filename);

        $source_img = public_path('img').'/'.$filename;
        $destination_img = public_path('img').'/'.$filename;

        $d = $this->compress($source_img, $destination_img, 40);
        return mce_back($filename);
    }

}
