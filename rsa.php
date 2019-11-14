<?php
  function encrypt($message, $encryption_key){
    $key = hex2bin($encryption_key);
    $nonceSize = openssl_cipher_iv_length('aes-256-ctr');
    $nonce = openssl_random_pseudo_bytes($nonceSize);
    $ciphertext = openssl_encrypt(
      $message, 
      'aes-256-ctr', 
      $key,
      OPENSSL_RAW_DATA,
      $nonce
    );
    return base64_encode($nonce.$ciphertext);
  }

  function decrypt($message,$encryption_key){
    $key = hex2bin($encryption_key);
    $message = base64_decode($message);
    $nonceSize = openssl_cipher_iv_length('aes-256-ctr');
    $nonce = mb_substr($message, 0, $nonceSize, '8bit');
    $ciphertext = mb_substr($message, $nonceSize, null, '8bit');
    $plaintext= openssl_decrypt(
      $ciphertext, 
      'aes-256-ctr', 
      $key,
      OPENSSL_RAW_DATA,
      $nonce
    );
    return $plaintext;
  }
  
  $private_secret_key = 'fed5de04cbba88aae4fa4b1d370dde5c' ;
  // $original_string = "Apa yang harus kulakukan?";
  // $encrypted = encrypt($original_string,$private_secret_key);
  // echo '<h3>Asli : '.$original_string.'</h3>';
  // echo '<h3>Enkripsi : '.$encrypted.'</h3>';
  // echo '<h3>Dekripsi : '.decrypt($encrypted,$private_secret_key).'</h3>';
  ?>