<?php 
$proxy='192.168.53.130:8080';
$proxyauth='bis\chennl:Happynewyear!';
/** Get提交获取数据
 * @desc 获取access_token 
 * @return String access_token 
 */ 
function getAccessToken(){  
 	//获取access token
	$appid = 'wx743b2ddda1bec8b8';
	$appsecret = '76da573cba7fb93b7f2bb3a4e03540a9';
	$url =  "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret."";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURL_SSLVERSION_SSL, 2);  
	curl_setopt($ch, CURLOPT_TIMEOUT, 200); // http request timeout 20 seconds
	//curl_setopt($ch, CURLOPT_PROXY, $proxy);     // PROXY details with port
	//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);    // Use if proxy have username and password
	//curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); // If expected to call with specific PROXY type
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
	$result=curl_exec($ch);
	$errno = curl_errno( $ch );
	$error = curl_error ( $ch );
	echo $error;
	$info  = curl_getinfo( $ch );
	$response = json_decode($result);
	curl_close($ch);
	return $response->access_token; 
}
// echo getAccessToken();
 
/** Post提交获取数据
 * @desc 实现天气内容回复
 */
 function testWeixin(){
	$access_token =  getAccessToken();
	$customMessageSendUrl = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
	$description = '今天天气的详细信息（从第三方获取）。';
	$url = 'http://www.hzgbjy.com/index_layout.html';
	$picurl = 'http://www.hzgbjy.com/index_layout.html';
	$postDataArr = array(
			"touser"=>"oceanwish",
			"msgtype"=>"news",
			"news"=>array(
					"articles"=>array(
							"title"=>"当天天气",
							"description"=>$description,
							"url"=>$url,
							"picurl"=>$picurl,
					),
			),
	); 
	$postDataArr="{\"touser\":\"gh_5bff41f7f6a4\",\"msgtype\":\"text\",\"text\":{\"content\":\"Hello World\"}}";
 
	$postJosnData = json_encode($postDataArr);
	$ch = curl_init($customMessageSendUrl);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataArr);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	$data = curl_exec($ch);
	var_dump($data);
}
testWeixin();
?>