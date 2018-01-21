<?php

// Get parameter
$bot_name = '';
if(isset($_GET['b']))
    $bot_name = $_GET['b'];

// LINE API
$access_token = 'nn18S4hmFbfuUkRl+F8HchDPZvKKWASTSxM8ARegSiwUK2GMWJjjU17K1gENjBxkd/Lha+mLBK7nqHH5Uj3RuC08tUIY3x+uowMlwrVLQxjWQBAl5NUBHtLEfbcc2oXC5klWeUIexOgeCHvCT7xLTwdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";

        }

        

        // mLAB
        $mlab_key="cprtOzFzDYo8B7IRUwpZ5Evi4AazXrbl";
        $mlab_database="proxy-line-devoo";
        $mlab_collection="events-line";
        $mlab_url = "https://api.mlab.com/api/1/databases/" . $mlab_database . "/collections/" . $mlab_collection . "?apiKey=" . $mlab_key ;

        // Generate data
        $current_key = $bot_name . '_' . $event['type']  . '_' . date('YmdHis');

        //Post New Data
        $newData = json_encode(
            array(
            'key' => $current_key,
            'value'=> $content
            )
        );

        $opts = array(
            'http' => array(
                'method' => "POST",
                'header' => "Content-type: application/json",
                'content' => $newData
             )
          );

        // Call API
        $context = stream_context_create($opts);
        $returnValue = file_get_contents($mlab_url,false,$context);
    

	}
}

echo "OK";


?>
