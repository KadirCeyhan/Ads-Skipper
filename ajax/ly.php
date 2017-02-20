<?php
header('Content-Type: application/json; charset=utf-8');
function Search($f, $l, $n) {
    @preg_match_all('/'.preg_quote($f, '/').'(.*?)'.preg_quote($l, '/').'/s', $n, $m);
    return @$m[1];
}
function decodeYsmm($ysmm) {
    $A = $B = '';
    for ($j = 0; $j < strlen($ysmm); $j++) {
        if ($j % 2 == 0) $A .= $ysmm[$j];
        else $B = $ysmm[$j].$B; 
    } 
    return substr(base64_decode($A.$B), 2); 
}
function cURL($url) {
	$ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $html = curl_exec($curl);
    curl_close($curl);
    return $html;
}
$id = $_POST['id'];
$url = 'http://adf.ly/'.$id;
 
$s = Search('var ysmm = \'', '\';', cURL($url));
$ysmm = $s[0];
$link = decodeYsmm($ysmm);

$output = array('Code' => 200, 'Message' => $link);
if (!$link) $output = array('Code' => 404, 'Message' => 'URL Çözümlenemedi');
exit(json_encode($output));
?>