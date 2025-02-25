<?php
// inisialisasi waktu awal
$awal = microtime(true);
include "ambil_lsb.php";
include "rc4.php";
// mengambil inputan key dari user
$key = $_POST["key_dekripsi"];
$gambar_pesan = $_FILES["gambar"]["name"];
// mkdir("myhasil/");
// menaruh hasil upload ke folder myhasil
$target_dir1 = "myhasil/";

// mengambil inputan nama gambar dan upload ke folder myhasil
$target_file1 = $target_dir1 . basename($_FILES["gambar"]["name"]);

// upload gambar 
move_uploaded_file($_FILES["gambar"]['tmp_name'], $target_file1);
$fileType1 = exif_imagetype($target_file1);
// cek fileType 6=BMP 2=JPEG 3=PNG 1=GIF
if ($fileType1 != "6" && $fileType1 != "3") {
    // pesan kesalahan jika format gambar dekrip tidak sesuai 
    header("location:home.php?format_gambar");
}

// cek apakah gambar yang di inputkan PNG dan BMP
if ($fileType1 == 6) {
    $stego_object = imagecreatefrombmp($target_file1);
} elseif ($fileType1 == 3) {
    $stego_object = imagecreatefrompng($target_file1);
}
// proses dekripsi dan pengambilan bit acak pada gambar
$pesan = Retrieve_LSB($stego_object, $key);
$pesan = RC4($pesan, $key);

// struktur header
// ID                           = 2 byte(s)
// panjang header               = 1 byte(s)
// panjang pesan embed          = 6 byte(s)
// panjang key                  = 1 byte(s)
// key                          = n byte(s)
// panjang nama file embed      = 1 byte(s)
// nama file embed              = n byte(s)
// hash embed                   = 8 byte(s) 


$id = substr($pesan, 0, 2);
$pjg_header = ord(substr($pesan, 2, 1));
$pjg_pesan_embed = hexdec(substr($pesan, 3, 6));
$pjg_key = ord(substr($pesan, 9, 1));
$kunci = substr($pesan, 10, $pjg_key);
$pjg_namafile_embed = ord(substr($pesan, $pjg_key + 10, 1));
$namafile = substr($pesan, $pjg_key + 11, $pjg_namafile_embed);
$hash = substr($pesan, $pjg_key + 11 + $pjg_namafile_embed, 8);

// cek ID, apakah file yang mau di decrypt hasil dari stegano
if ($id <> "MR") {
    header("location:home.php?id_dekripsi_salah");
}

if ($key <> $kunci) {
    header("location:home.php?key_dekripsi_salah");
    exit();
}
// echo "ID: "  . $id . "<br>";
// echo "Panjang Header: " . $pjg_header  . "<br>";
// echo "Panjang Pesan embed: " . $pjg_pesan_embed .  "<br>";
// echo "Panjang Kunci: " . $pjg_key  . "<br>";
// echo "key: " . $key  . "<br>";
// echo "panjang nama file: " . $pjg_namafile_embed  . "<br>";
// echo "nama file: " . $namafile  . "<br>";
// echo "hash: " . $hash  . "<br><br>";
// echo "selesai..";

$isi_pesan = substr($pesan, $pjg_header, $pjg_pesan_embed);

// echo $isi_pesan;
// echo "<br><textarea> $isi_pesan</textarea><br>";

// exit();

$file_dl = $target_dir1 . $namafile;
$fp = fopen($file_dl, 'w');
fwrite($fp, $isi_pesan);
fclose($fp);


// echo $pesan;
// exit();
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/style.css">
<title>Dekripsi</title>
<!-- untuk menampilkan waktu lama dekripsi -->
<?php
$akhir = microtime(true);
$lama = $akhir - $awal;
echo "<p>Lama eksekusi script adalah: " . $lama . " detik</p>"
// end menampilkan waktu lama dekripsi
?>

<body>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>

    <div class="container" id="hasil_enkripsi">

        <h1 class="animate__animated animate__lightSpeedInLeft"><b>Proses Dekripsi Berhasil</b></h1>
        <!-- gambar pada pesan berhasil di dekrip -->
        <img src="my-picture/sukses.jpg" class="animate__animated animate__bounce">
        <div class="col">
            <div class="row">
                <!-- tombol untuk download hasil dekrip -->
                <a href="<?= $file_dl ?>" download id="a1"><i class="bi bi-download"></i> DOWNLOAD</a>
                <a href="home.php" id="back"><i class="bi bi-arrow-bar-left"></i>KEMBALI</a>
            </div>

        </div>
    </div>
</body>
<?php
// $nama_gambar = $file_dl;
// header("Content-Disposition:attachment; filename=" . $nama_gambar);
// header("Content-Type: application/force-download");
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header("Content-Type: text/plain");
// echo "<br>Selesai......";
exit();
