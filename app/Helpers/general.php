<?php

// use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\DB;

define('PAGINATION_COUNT', 10);
define('db_limit', 6);
define('location', 50);


function sortArray($arr = [])
{
    for ($i = 0; $i < count($arr); $i++) {
        $val = $arr[$i];
        $j = $i - 1;
        while ($j >= 0 && $arr[$j] > $val) {
            $arr[$j + 1] = $arr[$j];
            $j--;
        }
        $arr[$j + 1] = $val;
    }
    return $arr;
}




function uploadImage($photo_name, $folder)
{
    $image = $photo_name;
    $image_name = rand( 1000000 , 100000000 ) . time() . '' . $image->getClientOriginalName();
    $destinationPath = public_path($folder);
    $image->move($destinationPath, $image_name);
    return $image_name;
}

function deleteFile($photo_name, $folder)
{
    $image_name = $photo_name;
    $image_path = public_path($folder) . $image_name;
    if (file_exists($image_path)) {
        @unlink($image_path);
    }
}






