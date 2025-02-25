<?php
session_start();

/**
 * Isi dengan detail database.
 */
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'skripsi';

/**
 * Cek koneksi ke database
 */
$connect = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($connect->errno) {
    echo $connect->error;
    exit;
}
