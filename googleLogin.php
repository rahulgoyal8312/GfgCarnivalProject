<?php
include_once "config.php";
include_once "dynamoDbFunctions.php";
session_start();

if (@$_GET['code'] && $_GET['code'] != "") {
    if (!@$_SESSION["state"] || $_SESSION["state"] != $_GET["state"]) {
        header('Location: '.HOST_URL);
    }

    $url = "https://oauth2.googleapis.com/token";
    $data = [
        "code" => $_GET["code"],
        "client_id" => G_CLIENT_ID,
        "client_secret" => G_CLIENT_SECRET,
        "redirect_uri" => HOST_URL."googleLogin.php",
        "grant_type" => "authorization_code"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $response = json_decode($response, true);

    authenticateUser($response['id_token'], $data['client_id']);
    //error_log(print_r($response, true));

    if (curl_error($ch)) {
        $error_msg = curl_error($ch);
        error_log($error_msg);
    }

    $callbackAuthUrl = HOST_URL;
    header('Location: '.$callbackAuthUrl);
} else {
    // Create a state token to prevent request forgery.
    // Store it in the session for later validation.
    $state = bin2hex(random_bytes(128 / 8));
    $_SESSION["state"] = $state;
    $clientId = "702211924799-4ac7m2l7n610pd11stc4o3am78cqcboj.apps.googleusercontent.com";
    $openIdUrl = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=".$clientId."&scope=openid%20email%20https://www.googleapis.com/auth/userinfo.profile&redirect_uri=".HOST_URL."googleLogin.php&state=".$state;
    header('Location: ' . $openIdUrl);
}

function authenticateUser($tokenId, $clientId){
    $url = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=".$tokenId;
    $response = file_get_contents($url);
    $response = json_decode($response, true);

    if($response['aud'] == $clientId){
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $response['name'];
        $_SESSION['picture'] = $response['picture'];
        $_SESSION['email'] = $response['email'];
        $userDetails = isUserExists($response['email']);
        $userId = @$userDetails['id'];
        if(@$userDetails['level']){
            $_SESSION['level'] = $userDetails['level'];
        }

        if($userId){
            error_log("User Exists");
            //updateUserLoginTime($userId);
        }
        else{
            $userId = createUserEntry([
                "name"=> $response['name'],
                "email"=> $response['email'],
                "picture"=> $response['picture']
            ]);
        }
        $_SESSION['userid'] = $userId;
    }
    else{
        $_SESSION['loggedin'] = false;
    }
}
?>
