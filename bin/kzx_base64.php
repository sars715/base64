<?php
function format_8bit($binaryStr) {
    if ($binaryStr == "") return "";

    $len = strlen($binaryStr);
    $ret = $binaryStr;
    for ($i=$len; $i<8; $i++) {
        $ret = '0'.$ret;
    }
    return $ret;
}
function kzx_base64_encode($str, $hashTable=null) {
    if ($str == "") return "";
    $hashStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    $stringLen = strlen($hashStr);
    for ($i=0; $i<$stringLen; $i++) {
        $table[$i] = $hashStr[$i];
    }
    if ($hashTable != null) {
        if (count($hashTable) != 64) {
        }else{
            $table = $hashTable;
        }
    }
    $stringLen = strlen($str);
    $binaryStr = "";
    for ($i = 0; $i<$stringLen; $i++) {
        $binaryStr .= format_8bit(decbin(ord($str[$i])));
    }
    $binaryStrLen = strlen($binaryStr);
    $remainder = $binaryStrLen % 6;
    $supplement = (6-$remainder == 6) ? 0 : 6-$remainder;
    for ($i=0; $i<$supplement; $i++){
        $binaryStr .= '0';
    }
    $ret = "";
    for ($i=0; $i<$binaryStrLen+$supplement; $i+=6) {
        $wordBinary = substr($binaryStr, $i, 6);
        $wordNum = bindec($wordBinary);
        $ret .= $table[$wordNum];
    }
    for ($i=0; $i<$supplement/2; $i++) {
        $ret .= "=";
    }
    return $ret;
}

//print kzx_base64_encode('Man is distinguished, not only by his reason, but by this singular passion from other animals, which is a lust of the mind') . "\n";
//print base64_encode("Man is distinguished, not only by his reason, but by this singular passion from other animals, which is a lust of the mind") . "\n";
