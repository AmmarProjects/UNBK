<?php
        include 'rsa.php';
        require 'vendor/autoload.php';

        $ID = $_POST['userid'];
        $Password = $_POST['password'];
        $client = new \GuzzleHttp\Client();
        
        $response = $client->request('GET', 'https://tugas.ammarprojects.com/Sister/CLA/api/CLA', [
        'query' => [
            'kunci' => 'sister',
            ]
        ]);

        $foo = false;
        $id_siswa = "";
        $result = json_decode($response->getBody()->getContents(), true);
        $result = $result['data'];
        foreach($result as $data):
            if (decrypt($data["nisn"],$private_secret_key) === $ID && decrypt($data["nisn"],$private_secret_key) === $Password) {
                header("location:test.php");
                $foo = true;
                $id_siswa = $data["id"];
                break;
            }
        endforeach;


        if ($foo == true) {
            header("location:test.php?id=$id_siswa");
        }else{
            header("location:login.php");
        }

?>