<?php
function string_conversion($string)
{
$caractere = array(">", "<",  ":", "*", "/", "|", "?", '"', '<', '>', "'","&");
$string = str_replace($caractere, "", $string);
$string = mb_strtolower($string, 'UTF-8');
$string = str_replace(
array(
'à', 'â', 'ä', 'á', 'ã', 'å',
'î', 'ï', 'ì', 'í',
'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
'ù', 'û', 'ü', 'ú',
'é', 'è', 'ê', 'ë',
'ç', 'ÿ', 'ñ','  '
),
array(
'a', 'a', 'a', 'a', 'a', 'a',
'i', 'i', 'i', 'i',
'o', 'o', 'o', 'o', 'o', 'o',
'u', 'u', 'u', 'u',
'e', 'e', 'e', 'e',
'c', 'y', 'n',' '
),
$string
);
return $string;
}
?>
