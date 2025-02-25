<?php
function LSB($ct_file_embedded, $mycover_object)
{
    $embedded = [];
    for ($i = 0; $i < strlen($ct_file_embedded); $i++) {
        $temp = substr("00000000" . decbin(ord(substr($ct_file_embedded, $i, 1))), -8);
        for ($j = 0; $j < 8; $j++) {
            $embedded[] = (int)substr($temp, $j, 1);
        }
    }
    $jml_embedded = count($embedded);

    $width = imagesx($mycover_object);
    $height = imagesy($mycover_object);

    $idx = 0;
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($mycover_object, $x, $y);

            // echo "RGB: " . $x .  " " . $y . " " . $rgb . "<br>";

            $r = ($rgb >> 16) & 255;
            // echo "r: " . $r . " ";
            if ($idx < $jml_embedded) {
                $r = ($r & 254) + $embedded[$idx];
                $idx++;
                //    echo "-" . $embedded[$idx - 1] . "-" . $r . " ";
            }

            $g = ($rgb >> 8) & 255;
            // echo "g: " . $g . " ";
            if ($idx < $jml_embedded) {
                $g = ($g & 254) + $embedded[$idx];
                $idx++;
                // echo "-" . $embedded[$idx - 1] . "-" . $g . " ";
            }

            $b = $rgb & 255;
            // echo "b: " . $b . " ";
            if ($idx < $jml_embedded) {
                $b = ($b & 254) + $embedded[$idx];
                $idx++;
                //    echo "-" . $embedded[$idx - 1] . "-" . $b . " ";
            }

            // tulis kembali ke mycover_object
            $warna = ($r << 16) + ($g << 8) + $b;
            // echo "X: " . $warna;
            imagesetpixel($mycover_object, $x, $y, $warna);
            // exit();
            if ($idx >= $jml_embedded) {
                $y = $height;
                $x = $width;
            }
        }
    }
    return $mycover_object;
}
