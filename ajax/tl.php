<?php
header('Content-Type: application/json; charset=utf-8');
function isNull($str) {
	if (strlen($str) > 0) return FALSE;
	else return TRUE;
}
function Search($f, $l, $n) {
    @preg_match_all('/'.preg_quote($f, '/').'(.*?)'.preg_quote($l, '/').'/s', $n, $m);
    return @$m[1];
}
function cURL_GetLID($url) {
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
function cURL_GetLink($url,$lid,$id) {
    $t = "x3_view_".$lid."_9999999=".(gettimeofday(true) + 10).";";
    $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Referer:http://link.tl/'.$id));
    curl_setopt($curl, CURLOPT_COOKIE, $t); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $html = curl_exec($curl);
    curl_close($curl);
    return $html;
}
$id = $_POST['id'];
$url = 'http://link.tl/'.$id;
$ajax = 'http://link.tl/fly/go.php?to='.$id;
 
$s = Search('lid|', '|else', cURL_GetLID($url));
$lid = $s[0];
 
$s = Search('<div class="skip_btn2"><a href="', '">Skip!', cURL_GetLink($ajax,$lid,$id));
$link = $s[0];

$output = array('Code' => 200, 'Message' => $link);
if (isNull($link)) $output = array('Code' => 404, 'Message' => 'URL Çözümlenemedi');
exit(json_encode($output));
?>