<?php
/**
 * Created by PhpStorm.
 * User: antoni
 * Date: 19/05/18
 * Time: 17.44
 */

session_start();

include_once("include/config.php");
include_once("include/OAuth.php");
include_once("include/TwitterAPIExchange.php");
include_once("include/twitteroauth.php");

?>

<html>
<head>
    <title>Twitter API</title>
    <style type="text/css">

    </style>
</head>

<body>
    <div id="header">
        <h2>Promo Around APP</h2>
    </div>
    <div id="content">
        <?php
        if (isset($_SESSION['status']) && $_SESSION['status'] == 'verified')
        {
            $screenname = $_SESSION['request_vars']['screen_name'];
            $twitterid = $_SESSION['request_vars']['user_id'];
            $oauth_token = $_SESSION['request_vars']['oauth_token'];
            $oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

            $settings = array(
                'oauth_access_token' => "75233001-osAxBXJ6YrXgMcWLeAi7TduoLqaIq02T5MeVOJGzu",
                'oauth_access_token_secret' => "HkT6YmNGDZJbIutfx2HFSXjGWggkocLRvKtoMgIpu4ryK",
                'consumer_key' => "E3zTGculcU0BJbvZVT0zBUOEB",
                'consumer_secret' => "Zj8x110ohTG9Ussn5quo3OrthPjURU4n5Z64P7YoFqJX1gqoGq"
            );

            $usershow = "https://api.twitter.com/1.1/users/show.json";
            //$profilebanner = "https://api.twitter.com/1.1/users/profile_banner.json";
            $followerslist = "https://api.twitter.com/1.1/followers/list.json";
            $tweets = "https://api.twitter.com/1.1/statuses/user_timeline.json";

            $requestMethod = "GET";

            $getfield = '?screen_name='.$screenname.'&count=10';


            //user info
            $twitter = new TwitterAPIExchange($settings);

            /**
            $twitter = $twitter -> setGetfield($getfield)
                -> buildOauth($usershow,$requestMethod)
                -> performRequest();

             */
            $usershowresponse = json_decode($twitter -> setGetfield($getfield)
                -> buildOauth($usershow,$requestMethod)
                -> performRequest(),$assoc=TRUE);

            //list of tweets
            $twitter = new TwitterAPIExchange($settings);

            /**
            $twitter = $twitter -> setGetfield($getfield)
                -> buildOauth($usershow,$requestMethod)
                -> performRequest();
            */
            $tweetsresponse = json_decode($twitter -> setGetfield($getfield)
                -> buildOauth($tweets,$requestMethod)
                -> performRequest(),$assoc=TRUE);

            $profilepic = $usershowresponse['profile_image_url'];

            //DISPLAY INFO

            // 1. profile pic and welcome text
            echo "<hr>";
            echo '<img src='.$profilepic.'></img>';
            echo ' Welcome, '.$screenname;

            //log out
            echo '<button><a href="logout.php" >Logout</a></button>';
            echo "<br><hr>";

            echo '<button><a href="main.php">To APP >></a></button>';
            // 2. user information
            echo "<h4>User Information</h4></br>";
            echo "<br>Name: ". $usershowresponse['name'];
            echo "<br>ScreenName: ". $usershowresponse['screen_name'];
            echo "<br>Location: ". $usershowresponse['location'];
            echo "<br>Info: ". $usershowresponse['description'];
            echo "<br>Followers: ". $usershowresponse['followers_count'];
            echo "<br>Following: ". $usershowresponse['friends_count'];
            echo "<br>Tweets: ". $usershowresponse['statuses_count'];
            echo "<hr>";

            // 3. list of tweets
            /**foreach ($tweetsresponse as $key)
            {
                $profilepic =$key['user']['profile_image_url'];
                echo '<img src='.$profilepic.'></img>';

                echo "Time And Date: ".$key['created_at']."</br>";
                echo "Tweet: ".$key['text']."</br>";
                echo "Screen Name: ".$key['user']['screen_name']."</br>";
                echo "Retweet count: ".$key['retweet_count']."</br>";
                echo "<hr>";
            }
            echo "<hr>";*/
        }
        else
        {
            echo '<a href="process.php"><img src="images/login.png"/></a>';
        }

        ?>
    </div>


</body>
</html>
