<?php
    require 'vendor/autoload.php';

    $client = new \GuzzleHttp\Client();
    
    $response = $client->request('GET', 'https://tugas.ammarprojects.com/Sister/CTF/api/CTF', [
       'query' => [
           'kunci' => 'sister',
        ]
    ]);
        
    $result = json_decode($response->getBody()->getContents(), true);
    $result = $result['data'];
?>