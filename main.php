<?php
/**
 * Created by PhpStorm.
 * User: antoni
 * Date: 20/05/18
 * Time: 22.11
 */
error_reporting(1);

session_start();

include_once("include/config.php");
include_once("include/OAuth.php");
include_once("include/TwitterAPIExchange.php");
include_once("include/twitteroauth.php");

?>

<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title>Promo API</title>
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'verified') {
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


    ?>
</head>

<body>

    <div class="container">
        <h2 class="jumbotron">Promo Around APP</h2>
        <div class="row">
            <div class="col-md-4">
                <?php

                $usershow = "https://api.twitter.com/1.1/users/show.json";
                $requestMethod = "GET";
                $getfield = '?screen_name='.$screenname.'&count=10';
                $twitter = new TwitterAPIExchange($settings);
                $usershowresponse = json_decode($twitter -> setGetfield($getfield)
                    -> buildOauth($usershow,$requestMethod)
                    -> performRequest(),$assoc=TRUE);
                $profilepic = $usershowresponse['profile_image_url'];

                //My Profile
                echo "<hr>";
                echo '<img class="img-thumbnail" src=' . $profilepic . ' alt="my profile"></img>';
                echo ' Welcome,<i><b>' . $screenname .'</i></b> ';

                //log out
                echo '<a class="btn btn-outline-primary btn-sm" href="logout.php">Logout</a>';
                //echo '<button type="button" class="btn btn-outline-danger"><a href="logout.php" >Logout</a></button>';
                echo "<br><hr>";
                echo "<hr>";

                ?>

            </div>


            <div class="col-md-7">
                <div class="card" style="width: 400px">
                    <?php
                    $tweetsearch = "https://api.twitter.com/1.1/search/tweets.json";
                    $requestMethod = "GET";
                    $getfieldsearch = '?q=image&result_type=recent';

                    $twitter = new TwitterAPIExchange($settings);
                    $tweetresponse = json_decode($twitter -> setGetfield($getfieldsearch)
                        -> buildOauth($tweetsearch,$requestMethod)
                        -> performRequest(),$assoc=TRUE);

                    //$tweets = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=php&result_type=recent&count=20');

                    $counter = 0;
                    foreach ($tweetresponse as $key)
                    {
                        foreach ($key as $t)
                        {
                            if ($counter <2)
                            {
                                $mediaTweet = $t['entities']['media']['0']['media_url'];
                                $userArray = $t['user'];

                                //$entitiesArray = $t['entities'];
                                //$imageArray = $entitiesArray['urls'];

                                echo '<img src='. $userArray['profile_image_url'] .' class="rounded-circle" alt="profile picture" width="20%"></img>';
                                //echo " <b>". $userArray['name'] ."</b></br>";
                                echo "<b>". $userArray['screen_name'] ."</b></br>";

                                if ($mediaTweet != '')
                                {
                                    echo '<img class="myImg" id="myImg" class="img-thumbnail mx-auto d-block" src='. $mediaTweet
                                    .' class="img-rounded" alt="image tweet" width="50%"></img>';
                                    echo "<i> gambar : " . $mediaTweet ."</i></br>";
                                }
                                else
                                {
                                    echo "</br></<br>";
                                }
                                echo "Tweet : ". $t['text'] ."</br>";
                                //echo $mediaArray['media_url'];
                                //echo "Media :". $userArray['id']."</br>";
                                //echo "Media :". $imageArray['url'] ."</br>";
                                //echo '<img src='. $mediaArray['media']['id'] .'></img>';
                                echo "<hr>";
                            }
                        }
                        break;
                        echo "<hr>";
                    }
                    }
                    else
                    {
                        echo '<a href="process.php"><img src="images/login.png"/></a>';
                    }
                    ?>
                </div>

                <!--MASUKIN KE FOUREACH GIMANA ???????????-->
                <div id="myModal" class="modal">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01" width="50%">
                    <div id="caption"></div>
                </div>
            </div>

        </div>

    </div>

    <script>
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById('myImg');
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        //var captionText = document.getElementById("caption");
        for(j=0;j<i;j++) {
            img[j].onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
          //  captionText.innerHTML = this.alt;
        }


        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>


</body>

</html>
