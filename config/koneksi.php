<?php 
    $hostname = "localhost";
    $hostusername = "root";
    $hostpassword = "";
    $hostdatabase = "lms_angkatan_2";
    $config = mysqli_connect($hostname, $hostusername, $hostpassword, $hostdatabase);
    if(!$config){
        echo "Koneksi gagal";
    }
?>