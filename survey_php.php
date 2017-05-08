<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Match result</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- Font Awesome's Brand-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
      body{
        padding-top: 40px;
      }
    </style>
  </head>

  <!-- Navbar -->
  <body data-spy="scroll" data-target="#my-navbar">
    <nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a href="index.html" class="navbar-brand">EXCHANGE MATCHING</a>
        </div><!-- Navbar Header-->
        <div class="collapse navbar-collapse" id="navbar-collapse">

        <!-- <a href="" class="btn btn-warning navbar-btn navbar-right">Download Now</a> -->
          <ul class="nav navbar-nav">
            <li><a href="index.html">About</a>
            <li><a href="matching.html">Matching</a>
            <li><a href="comment.html">Review</a>
            <li><a href="index.html">More info</a>
          </ul>
        </div>
      </div><!-- End Container-->
    </nav><!-- End navbar -->

    <div class="container">
      <div class="page-header" id="matching">
        <h2>Result <br><small>This is the result!</small></h2>
      </div>


      <?php
        $conn = mysql_connect('localhost', 'root', '111111');
        mysql_query('SET NAMES utf8');
        if (!$conn) {
            echo "Unable to connect to DB: " . mysql_error();
            exit;
        }

        if (!mysql_select_db("survey")) {
            echo "Unable to select mydbname: " . mysql_error();
            exit;
        }

        $answer1 = $_POST["answer1"];
        $answer2 = $_POST["answer2"];
        $answer3 = concatenate($_POST["answer3"]);
        $answer4 = $_POST["answer4"];
        $sql = "INSERT INTO `survey` (Answer1, Answer2, Answer3, Answer4) VALUES (\"$answer1\", \"$answer2\", \"$answer3\", \"$answer4\")";

        $result = mysql_query($sql);

        if($result){
            echo header('Location: survey_match.php');
        } else {
            echo "upload not successful";
        }

        function concatenate($array){
            $string = "";
            for($i = 0; $i < count($array); $i++){
                $string.=($array[$i]."\n");
            }
            return $string;
        }

        ?>

    </div>

    <footer>
      <hr>
        <div class="container text-center">
          <ul class="list-inline">
           <div class="container text-center">Share your result to your friends!</div>
            <a href="https://www.facebook.com/"><i class="fa fa-facebook-square fa-3x social"></i></a>
            <a href="https://twitter.com/"><i class="fa fa-twitter-square fa-3x social"></i></a>
            <a href="https://plus.google.com/"><i class="fa fa-google-plus-square fa-3x social"></i></a>
            <a href="mailto:lixin@connect.ust.hk"><i class="fa fa-envelope-square fa-3x social"></i></a>
          </ul>

        <p>&copy; Copyright @2017 COMP2021 Group A-team</p>


      </div><!-- end Container-->


    </footer>

    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
  	<!-- Latest compiled and minified JavaScript -->
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>
</html>
