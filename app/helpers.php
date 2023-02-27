<?php

function uploadSingleImage ($file, $name, $path, $width = false, $height = false) {
    $file_name = $name . '.' . $file->getClientOriginalExtension();
    if (file_exists($path . '/' . $file_name)) {
        unlink($path . "/" . $file_name);
    }

    $file->move(public_path($path), $file_name);

    return $path . '/' . $file_name;
}
