<?php
session_start();
$awal = microtime(true);
include "rc4.php";
include "lsb_biasa.php";
$target_dir = "mycover_object/";
// mengambil inputan key_enkripsi user
$key = $_POST["key_enkripsi"];
// mengambil inputan gambar dan nama gambar
$target_file = $target_dir . basename($_FILES["gambar"]["name"]);

// upload gambar 
move_uploaded_file($_FILES["gambar"]['tmp_name'], $target_file);
$fileType = exif_imagetype($target_file);

// cek fileType 6=BMP 2=JPEG 3=PNG 1=GIF
if ($fileType != "6" && $fileType != "3") {
    // tampilkan pesan kesalahan bahwa format gambar 
    header("location:home.php?format_gambar");
    exit();
}

// mengambil inputan file dan nama file
$target_file1 = $target_dir . basename($_FILES["file"]["name"]);

// strlen berfungsi untuk menghitung jumlah string yang ada di dalam file
if ($_FILES['file']['size'] == 0) {
    // PERIKSA APAKAH FILE "file" size-nya  0 ?
    header("location:home.php?size_file");
    exit();
}
// jika size-nya lebih dari 0 maka upload file ke target folder
move_uploaded_file($_FILES["file"]['tmp_name'], $target_file1);
$namafile = $_FILES["file"]["name"]; // nama file pesan yang akan di-embed

// buat id untuk di sisipkan ke gambar sebanyak 2 karakter
// Baca file embedded message "file"
// baca file
$file = fopen($target_file1, "r") or die("Unable to open file!");
$file_embedded = fread($file, filesize($target_file1));

fclose($file);

$ID_Gue = "MR";
$pjg_pesan_embed = substr("000000" . dechex(strlen($file_embedded)), -6);
$pjg_key = strlen($key);
$pjg_namafile_embed = strlen($namafile);
$pjg_header = 19 + $pjg_key + $pjg_namafile_embed;  // 16 didapat dari 2+1+6+1+1=8
$md5_pesan_embed = substr(md5($file_embedded), 0, 8); // potong 8 karakter.

// struktur header
// ID                           = 2 byte(s)
// panjang header               = 1 byte(s)
// panjang pesan embed          = 6 byte(s)
// panjang key                  = 1 byte(s)
// key                          = n byte(s)
// panjang nama file embed      = 1 byte(s)
// nama file embed              = n byte(s)
// hash embed                   = 8 byte(s) 

$header_stego = $ID_Gue . chr($pjg_header) . $pjg_pesan_embed . chr($pjg_key) . $key . chr($pjg_namafile_embed) . $namafile . $md5_pesan_embed;

$file_embedded = $header_stego . $file_embedded;

//echo "Len header: " . strlen($header_stego);
//echo "<br>";
//for ($z = 0; $z < strlen($header_stego); $z++) {
//    echo substr($header_stego, $z, 1) . " ";
//}
//echo "<br>";
//for ($z = 0; $z < strlen($header_stego); $z++) {
//    echo ord(substr($header_stego, $z, 1)) . " ";
//}
//echo "<br>";
//for ($z = 0; $z < strlen($header_stego); $z++) {
//    echo dechex(ord(substr($header_stego, $z, 1))) . " ";
//}

if ($fileType == 6) {
    $mycover_object = imagecreatefrombmp($target_file);
} elseif ($fileType == 3) {
    $mycover_object = imagecreatefrompng($target_file);
}

$ukuranimage = imagesx($mycover_object) * imagesy($mycover_object) * 3;
$besar_file = floatval($file_embedded) * 8;

// periksa ukuran cover object harus minimal 8x dari $file_embedded
if ($ukuranimage >= strlen($besar_file)) {
    // echo "<script> alert('Kamu berhasil membuat Stego Object');
    // </script>";
} else {
    echo "<script>
      alert('Yaaah, Gagal membuat Stego Object');'
    </script>";
}

//enkripsi isi variabel $file_embedded
// $key = $_POST["key_deskripsi"];
$ct_file_embedded = RC4($file_embedded, $key);
// $cipher = RC4($ct_file_embedded, $key);


// sispkan $file_embedded ke $mycover_object
// $height = imagesx($mycover_object);
// $width = imagesy($mycover_object);

// echo "<br> key : " . $key . "";
// echo "<br> width : " . $width . "<br>";
// echo " height: " . $height . "<br>";

// echo "<br>";
// for ($i = 0; $i < 30; $i++) {
//     echo ord(substr($file_embedded, $i, 1)) . " ";
// }
// echo "<br>";
// for ($i = 0; $i < 30; $i++) {
//     echo ord(substr($ct_file_embedded, $i, 1)) . " ";
// }
// echo "<br>";

// echo $target_file . "<br>";
$stego_image = LSB($ct_file_embedded, $mycover_object);
$file_stego = $target_file;
$mpos = strpos($file_stego, ".");
$mposx = 0;
while ($mpos <> 0) {
    $mposx = $mpos;
    $mpos = strpos($file_stego, ".", $mpos + 1);
}
$file_stego = substr($file_stego, 0, $mposx) . "_stego" . substr($file_stego, $mposx);

if ($fileType == 6) {
    imagebmp($stego_image, $file_stego);
} elseif ($fileType == 3) {
    imagepng($stego_image, $file_stego);
}

// echo $ct_file_embedded;
// exit();
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<!-- untuk  menampilkan waktu lama enkripsi -->
<?php
$akhir = microtime(true);
$lama = $akhir - $awal;
echo "<p>Lama eksekusi script adalah: " . $lama . " detik</p>"
?>
<!-- end untuk menampilkan waktu lama enkripsi -->

<body>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>

    <div class="container" id="hasil_enkripsi">

        <h1 class="animate__animated animate__lightSpeedInLeft"><b>Proses Enkripsi Berhasil</b></h1>
        <!-- gambar pada pesan berhasil enkripsi -->
        <img src="my-picture/sukses.jpg" class="animate__animated animate__bounce">
        <div class="col">

            <div class="row">
                <a href="<?= $file_stego ?>" download id="a1"><i class="bi bi-download"></i> DOWNLOAD</a>
                <a href="home.php" id="back"><i class="bi bi-arrow-bar-left"></i>KEMBALI</a>
            </div>

        </div>
    </div>
</body>
<?php

// echo "<a href=$file_stego download>Link download</a>";
// echo $ct_file_embedded;
// echo "<br>";
// echo "<a href='home.php'>Back</a>";
// $nama_gambar = $file_stego;
// header("Content-Type: application/octet-stream");
// header("Content-Disposition: attachment; filename=$nama_gambar");
// header('Content-Transfer-Encoding: binary');
// header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
// ImagePNG($outpic);

// simpan $mycover_object ke file (stego object)
// echo "<br>";
// echo "proses selesai...";

exit();
