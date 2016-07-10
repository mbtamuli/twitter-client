<?php
    require_once ('twitteroauth/autoload.php');
    require_once ('constants.php');
    session_start();
    use Abraham\TwitterOAuth\TwitterOAuth;

    if (!empty($_SESSION['access_token']) && isset($_SESSION['access_token'])) {
        $access_token = $_SESSION['access_token'];
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $statuses = $connection->get("statuses/user_timeline", ["screen_name" => $_GET['screen_name'],"count" => 10, "exclude_replies" => true]);

        $_SESSION['statuses'] = $statuses;

        header('Location: index.php');
    }
    else {
        echo "Please Sign In again";
    }
?>