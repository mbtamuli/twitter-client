<?php
  require_once ('twitteroauth/autoload.php');
  require_once ('constants.php');
  session_start();
  use Abraham\TwitterOAuth\TwitterOAuth;

  if (!empty($_SESSION['access_token']) && isset($_SESSION['access_token'])) {
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Twitter</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/bjqs.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Twitter Timeline</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="auth.php">Sign In</a></li>
            <li><a href="signout.php">Sign Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
      <div class="mybody">
        <div id="my-slideshow">
          <ul class="bjqs">
            <?php
              if (!empty($access_token) && isset($access_token)) {
                if (!empty($_SESSION['statuses']) && isset($_SESSION['statuses'])) {
                  $statuses = $_SESSION['statuses'];
                }
                else {
                  $statuses = $connection->get("statuses/home_timeline", ["count" => 10, "exclude_replies" => true]);
                }
                foreach ($statuses as $status) {
            ?>
              <li>
                <div>
                  <?php echo $status->text; ?>
                  ?>
                </div>
              </li>
            <?php
                }
              }
              else {
                echo "Please Sign In again";
              }
            ?>            
          </ul>
        </div>
        <?php
          if (!empty($access_token) && isset($access_token) && isset($connection)) {
            $followers_ids = $connection->get("followers/ids", ["count" => 10]);
            $comma_separated = implode(",", $followers_ids->ids);
            $users = $connection->get("users/lookup", ["user_id" => $comma_separated]);

            foreach ($users as $user) {
                echo "<a href='follower.php?screen_name=" . $user->screen_name . "'>" . $user->name . "</a><br>";
            }
          }
          else {
              echo "Please Sign In again";
          }          
        ?>
      </div>
    </div>
    <script src="js/jquery-latest.min.js"></script>
    <script src="js/bjqs-1.3.min.js"></script>
    <script>
      jQuery(document).ready(function($) {
        $('#my-slideshow').bjqs({
          'height' : 320,
          'width' : 620,
          'responsive' : true
        });
      });
    </script>
  </body>
</html>
