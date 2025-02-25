<?php
function Retrieve_LSB($stego_image)
{ // $stego_image --> string

    // struktur header
    // ID                  = 2 byte \
    // panjang header      = 1 byte / 5 pixel
    // panjang file embed  = 3 byte
    // panjang key         = 1 bytes(s)
    // nama file embed     = n byte  <--
    // hash embed          = 8 byte 
    // key                 = n byte


    $width = imagesx($stego_image);
    $height = imagesy($stego_image);

    $temp = "";
    $embed = "";
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($stego_image, $x, $y);
            //echo $rgb . " ";
            $r = ($rgb >> 16) & 1;
            $g = ($rgb >> 8) & 1;
            $b = $rgb & 1;
            $temp .= $r;
            $temp .= $g;
            $temp .= $b;
            if (strlen($temp) >= 8) {
                $temp1 = substr($temp, 0, 8);
                $embed .= chr(bindec($temp1));
                $temp = substr($temp, 8);
            }
        }
    }
    if (strlen($temp) > 0) {
        $temp = substr($temp . "0000000", 0, 8);
        $embed .= chr(bindec($temp));
    }
    return $embed;
}
