<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

?>

<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- css -->
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <!-- Favicon -->
    <link rel="icon" type="image" href="my-picture/logo.png">

    <!-- <link rel="stylesheet" href="css/style_login.css" type="text/css"> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- end css -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <title>PT. SAFARI DARMA SAKTI</title>

</head>

<body>

    <!-- Untuk menampilkan pesan kesalahan -->
    <?php if (isset($_GET["format_gambar"])) { ?>
        <script>
            swal("Warning!", "Maaf format gambar yang anda masukan tidak terdaftar, hanya gambar yang berformat .PNG dan .BMP!", "warning");
        </script>
    <?php } ?>
    <?php if (isset($_GET["size_file"])) { ?>
        <script>
            swal("Warning!", "Size file yang anda masukan tidak boleh berukuran 0 KB!", "warning");
        </script>
    <?php } ?>
    <?php if (isset($_GET["id_dekripsi_salah"])) { ?>
        <script>
            swal("Warning!", "Gambar Dekripsi yang anda masukan salah!,", "warning");
        </script>
    <?php } ?>
    <?php if (isset($_GET["key_dekripsi_salah"])) { ?>
        <script>
            swal("Warning!", "Kunci yang anda masukan salah!", "warning");
        </script>
    <?php } ?>
    <!-- end pesan kesalahan -->

    <!-- Untuk Menampilkan Info penggunaan aplikasi -->
    <section id="modal">
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h4 class="modal-title">Selamat Datang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body ">
                        <p class="p-modal">Ikuti langkah-langkah di bawah ini untuk proses enkripsi</p>
                        <p class="p-modal">1. Klik tombol Enkripsi untuk menampilkan form enkripsi</p>
                        <p class="p-modal">2. masukan kunci enkripsi, file yang ingin di sisipkan, serta gambar untuk menjadi tempat penyisipan file yang dipilih.</p>
                        <p class="p-modal">3. pilih tombol enkripsi untuk memproses inputan, dan tunggu beberapa saat sampai proses enkripsi selesai.</p>
                        <p class="p-modal">4. ketika proses enkripsi selesai, anda akan di alihkan ke halaman lain.</p>
                        <p class="p-modal">5. pesan berhasil atau tidak akan tampil.</p>
                        <hr>
                        <br>
                        <p class="p-modal">Ikuti langkah-langkah di bawah ini untuk proses Dekripsi</p>
                        <p class="p-modal">1. Klik tombol Dekripsi untuk menampilkan form Dekrispi</p>
                        <p class="p-modal">2. masukan kunci Dekripsi, dan gambar yang digunakan untuk enkripsi tadi.</p>
                        <p class="p-modal">3. pilih tombol Dekripsi untuk memproses inputan yang telah di masukan, dan tunggu beberapa saat sampai proses Dekripsi selesai.</p>
                        <p class="p-modal">4. ketika proses Dekripsi selesai, anda akan di alihkan ke halaman lain.</p>
                        <p class="p-modal">5. pesan berhasil atau tidak akan tampil.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end Info -->

    <div class="text-center">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <p class="container-p mt-3 text-white">IMPLEMENTASI PENGAMANAN DATA BERBASIS WEB <br> DENGAN ALGORITMA RC4 DAN STEGANOGRAFI LEAST SIGNIFICANT BIT (LSB) <br>PT.SAFARI DHARMA SAKTI</p>
            </div>
        </div>

        <a href="logout.php" class="btn btn-primary"><i class="fa fa-sign-out"></i> Logout </a>
        <a href="#" class="btn btn-primary"><i class="fa fa-file"></i> History </a>


        <!-- <button type="button" class="btn btn-dark">Logout</button> -->
    </div>

    <!-- jumbotron / form awal aplikasi -->
    <div class="container p-5 mb-5 mt-5 ">

        <h2 class="text-center text-dark"><i class="fa fa-shield"></i> &nbsp Kodein Data Security </h2>

        <!-- button untuk memunculkan form enkripsi dan dekripsi -->
        <button class="enkripsi mt-3"><i class="fa fa-lock"></i> Enkripsi</button>
        <button class="dekripsi mt-3"><i class="fa fa-unlock"></i> Dekripsi</button>

        <!-- form enkripsi -->
        <section id="form-enkripsi">
            <form action="enkripsi.php" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="key" class="mt-3">Kunci Enkripsi</label>
                    <!-- <input type="password" class="form-control input" id="key" name="key_enkripsi" aria-describedby="emailHelp" placeholder="Masukan Kunci Rahasia"> -->

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" name="key_enkripsi" id="key" placeholder="Masukan Kunci Rahasia" required>
                    </div>

                    <input type="checkbox" onclick="showpassword()">
                    <small style="color: #0F0F0F;">Lihat Password</small>
                </div>
                <div class="form-group">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon02"><i class="fa fa-file"></i></span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="file" aria-describedby="inputGroupFileAddon02" onchange="displayFileDetails('file', 'fileLabel')">
                            <label class="custom-file-label" for="inputGroupFile02" id="fileLabel">Masukan File</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input">Gambar pembawa pesan (bmp, png):</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon03"><i class="fa fa-image"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="gambar" id="gambarEnkripsi" aria-describedby="inputGroupFileAddon03" onchange="updateFileNameEnkripsi()">
                                <label class="custom-file-label" for="inputGroupFile03" id="labelEnkripsi">Masukan Gambar</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn" id="btn-enkrip" style="background-color: #0F0F0F; color:#fff;">Encrypt Now <i class="fa fa-check"></i></button>
                    </div>
            </form>

            <div class="mt-3 mb-3">
                <p class="text-center text-dark"><i class="fa fa-exclamation-circle"></i> Aplikasi ini tidak terhubung ke database, semua gambar dan informasi rahasia yang dimasukan tidak disimpan di server. </p>
            </div>

        </section>
        <!-- end form enkripsi -->

        <!-- form dekripsi -->
        <section id="form-dekripsi">
            <div class="form-group">
                <form action="dekripsi.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="key">Kunci Dekripsi</label>
                        <!-- <input type="password" class="form-control input" id="key2" name="key_dekripsi" aria-describedby="emailHelp" placeholder="Masukan Kunci Rahasia"> -->

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="key_dekripsi" id="key2" placeholder="Masukan Kunci Rahasia" required>
                        </div>

                        <input type="checkbox" onclick="showpassword2()">
                        <small style="color: #0F0F0F;">Lihat Password</small>
                    </div>
                    <div class="form-group">
                        <label for="input">Gambar pembawa pesan (bmp, png):</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon03"><i class="fa fa-image"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="gambar" id="gambarDeskripsi" aria-describedby="inputGroupFileAddon03" onchange="updateFileNameDeskripsi()">
                                <label class="custom-file-label" for="inputGroupFile03" id="labelDeskripsi">Masukan Gambar</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn" id="btn-enkrip" style="background-color: #0F0F0F; color:#fff;">Decrypt Now <i class="fa fa-check"></i></button>
                    </div>
                    <div class="mt-3 mb-3">
                </form>

                <div class="mt-3 mb-3">
                    <p class="text-center text-dark"><i class="fa fa-exclamation-circle"></i> Aplikasi ini tidak terhubung ke database, semua gambar dan informasi rahasia yang dimasukan tidak disimpan di server. </p>
                </div>

                <!-- <div class="mt-3 mb-3">
                <p class="text-center"><i class="fa fa-exclamation-circle"></i> Aplikasi ini tidak terhubung ke database, semua gambar dan informasi rahasia yang dimasukan tidak disimpan di server. </p>
	        </div> -->

        </section>
        <!-- end form dekripsi -->

    </div>

    <div class="pb-5"></div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- untuk memunculkan informasi setiap kali aplikasi di refresh -->
    <script src="js/js.js"></script>
    <script>
        $('#myModal').modal('show');
    </script>

    <script>
        function displayFileDetails(inputId, labelId) {
            var input = document.getElementById(inputId);
            var label = document.getElementById(labelId);

            if (input.files.length > 0) {
                label.innerText = input.files[0].name;
            } else {
                label.innerText = 'Masukan File';
            }
        }

        function updateFileNameEnkripsi() {
            // Dapatkan input file
            var input = document.getElementById('gambarEnkripsi');

            // Dapatkan label file
            var label = document.getElementById('labelEnkripsi');

            // Periksa apakah pengguna telah memilih file
            if (input.files.length > 0) {
                // Update label dengan nama file yang dipilih
                label.innerHTML = input.files[0].name;
            } else {
                // Jika tidak ada file yang dipilih, kembalikan label ke teks default
                label.innerHTML = 'Masukan Gambar';
            }
        }

        function updateFileNameDeskripsi() {
            // Dapatkan input file
            var input = document.getElementById('gambarDeskripsi');

            // Dapatkan label file
            var label = document.getElementById('labelDeskripsi');

            // Periksa apakah pengguna telah memilih file
            if (input.files.length > 0) {
                // Update label dengan nama file yang dipilih
                label.innerHTML = input.files[0].name;
            } else {
                // Jika tidak ada file yang dipilih, kembalikan label ke teks default
                label.innerHTML = 'Masukan Gambar';
            }
        }

        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $("#form-enkripsi").hide();
        });
        $(".enkripsi").click(function() {
            $("#form-enkripsi").show();
            $("#form-dekripsi").hide();
        });


        $(document).ready(function() {
            $("#form-dekripsi").hide();
        });
        $(".dekripsi").click(function() {
            $("#form-dekripsi").show();
            $("#form-enkripsi").hide();
        });
        // });
    </script>
</body>

</html>