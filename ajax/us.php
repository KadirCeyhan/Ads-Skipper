<?php
header('Content-Type: application/json; charset=utf-8');
function Search($f, $l, $n) {
    @preg_match_all('/'.preg_quote($f, '/').'(.*?)'.preg_quote($l, '/').'/s', $n, $m);
    return @$m[1];
}
function cURL($url) {
	$ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, $ua);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'));
	$html = curl_exec($curl);curl_close($curl);
	return $html;
}
$id = $_POST['id'];
$url = 'http://adfoc.us/'.$id;
 
$s = Search('var click_url = "', '";', cURL($url));
$link = $s[0];

$output = array('Code' => 200, 'Message' => $link);
if ($link == NULL) $output = array('Code' => 404, 'Message' => 'URL Çözümlenemedi');
exit(json_encode($output));
?>