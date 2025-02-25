<?php
function RC4($pt, $key)
{

    $panjangkey = 8;
    $dupkey = (int)(strlen($key) / $panjangkey) + 1;
    for ($i = 0; $i < $dupkey; $i++) $key .= $key;
    $key = substr($key, 0, $panjangkey);
    $myhasil = "";
    $s = [];
    for ($i = 0; $i < 256; $i++) $s[$i] = $i;
    $j = 0;
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $s[$i] + ord(substr($key, $i % strlen($key), 1))) % 256;
        $temp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $temp;
    }
    $i = 0;
    $j = 0;
    for ($idx = 0; $idx < strlen($pt); $idx++) {
        $i = ($i + 1) % 256;
        $j = ($j + $s[$i]) % 256;
        $temp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $temp;
        $t = ($s[$i] + $s[$j]) % 256;
        $k = $s[$t];
        $myhasil .= chr(ord(substr($pt, $idx, 1)) ^ $k);
    }
    // echo $myhasil;
    return $myhasil;
}
