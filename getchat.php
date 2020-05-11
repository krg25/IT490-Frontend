<?php
require_once('rabbit/path.inc');
require_once('rabbit/get_host_info.inc');
require_once('rabbit/rabbitMQLib.inc');

$client = new rabbitMQClient("rabbit/rabbit.ini","database");

$request = array();
$request['type'] = "GetChatLog";


$response = $client->send_request($request);

switch($response['0']){
	case 1:

	print('<table width="100%">');
	for ($i=1; $i<count($response); $i++){
		print('<tr width="100%">');
		print('<td width="128px" align="right" valign="top">' . $response[$i]['username'] . ':</td><td style="max-width:512px;text-wrap:normal;word-wrap:break-word">' . 				$response[$i]['content'] . '</td><td width="155px" align="right" valign="top">' . $response[$i]['timestamp']);
		print('</td></tr>');
	}
	print('</table>');
	break;
	case 2:
		echo ("Input Error");
		break;

}//switch




?>
