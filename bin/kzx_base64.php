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
function format_6bit($binaryStr) {
    if ($binaryStr == "") return "";

    $len = strlen($binaryStr);
    $ret = $binaryStr;
    for ($i=$len; $i<6; $i++) {
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
            for ($i=0; $i<64; $i++){
                $table[$i] = $hashTable[$i];
            }
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

function kzx_base64_decode($str, $hashTable=null) {
    if ($str=="") return "";
    $hashStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    $stringLen = strlen($hashStr);
    for ($i=0; $i<$stringLen; $i++) {
        $table[$i] = $hashStr[$i];
    }
    if ($hashTable != null) {
        if (count($hashTable) != 64) {
        }else{
            for ($i=0; $i<64; $i++){
                $table[$i] = $hashTable[$i];
            }
        }
    }
    $char2num = array();
    foreach($table as $key => $value) {
        $char2num[$value] = $key;
    }
    $len = strlen($str);
    $supplement = 0;
    while ($str[$len-1] == '=') {
        $supplement++;
        $str = substr($str, 0, $len-1);
        $len--;
    }
    $binaryStr = "";
    for ($i=0; $i<$len; $i++){
        $binaryStr .= format_6bit(decbin($char2num[$str[$i]]));
    }
    $binaryStrLen = strlen($binaryStr);
    $binaryStrLen = $binaryStrLen-$supplement*2;
    $binaryStr = substr($binaryStr, 0, $binaryStrLen);
    $ret = "";
    for ($i=0; $i<$binaryStrLen; $i+=8) {
        $wordBinary = substr($binaryStr, $i, 8);
        $wordNum = bindec($wordBinary);
        $ret .= chr($wordNum);
    }
    return $ret;
}

