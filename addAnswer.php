<?php
    include "rsa.php";
    require 'vendor/autoload.php';

    $client = new \GuzzleHttp\Client();
    
    $siswa =  $_POST['siswa'];
    $soal =  $_POST['soal'];
    $sekolah =  encrypt($_POST['sekolah'],$private_secret_key);
    $jawaban =  encrypt($_POST['jawaban'],$private_secret_key);

    $url = "https://tugas.ammarprojects.com/Sister/CTF/api/CTFjawaban";

    $response = $client->request('POST', $url, [
    'form_params' => [
        'kunci' => 'sister',
        'id_soal' => $soal,
        'id_siswa' => $siswa,
        'sekolah' => $sekolah,
        'jawaban' => $jawaban
    ]
]);
?>