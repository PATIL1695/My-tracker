<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function encryptPassword( $password ) {
    $cryptKey  = '0123456CDEFGHIJKLMNOPQRSTUVWXYZ789abcdefghijklmnopqrstuvwxyzAB';
    $passwordEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $password, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $passwordEncoded );
}

function decryptPassword( $password ) {
    $cryptKey  = '0123456CDEFGHIJKLMNOPQRSTUVWXYZ789abcdefghijklmnopqrstuvwxyzAB';
    $passwordDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $password ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $passwordDecoded );
}
?>