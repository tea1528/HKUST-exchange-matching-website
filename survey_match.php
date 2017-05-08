
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

      .font-weight-bold{
        font-weight: bold;
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
        <h2>Match Result <br><small>These are all the universities you can apply to!</small></h2>
      </div>

      <?php
      $conn = mysql_connect('localhost', 'root', '111111');
      // Check connection

      mysql_query('SET NAMES utf8');
      if (!$conn) {
          echo "Unable to connect to DB: " . mysql_error();
          exit;
      }
      if (!mysql_select_db("survey")) {
          echo "Unable to select mydbname: " . mysql_error();
          exit;
      }

      // the three arrays
      $database_array = array();
      $survey_array = array();
      $match_array = array();

      // filling in the database_array
      $sql = "SELECT * FROM `databasetable`";
      $result = mysql_query($sql);
      while ($row = mysql_fetch_array($result)) {
          array_push($database_array, $row);
      }

      // filling in the match_array
      $sql = "select * from `survey` where ID = (select max(ID) from `survey`)";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      $survey_array["Answer1"] = $row["Answer1"];
      $survey_array["Answer2"] = $row["Answer2"];
      $survey_array["Answer3"] = $row["Answer3"];
      $survey_array["Answer4"] = $row["Answer4"];


      foreach ($database_array as $row){

          // checking for english requirements
          $eng_require_country = "United States, Canada, United Kingdom";
          if (trim(strtolower($survey_array["Answer4"])) === "no"){
              if (strpos(strtolower($eng_require_country), trim(strtolower($row["country"]))) !== false) {
                  continue;
              }
          }

          // checking for country
          if (strpos(trim(strtolower($survey_array["Answer3"])), trim(strtolower($row["country"]))) === false) {
              continue;
          }

          // checking for department
          if (strpos(strtolower($row["department"]), trim(strtolower($survey_array["Answer2"]))) === false){
              continue;
          }

          // checking for term
          if (strpos(strtolower($row["term"]), "regular") === false) {
              if (strpos(strtolower($row["term"]), trim(strtolower($survey_array["Answer1"]))) === false){
                  continue;
              }
          }

          $row["department"] = trim($row["department"]);
          if(substr($row["department"], -1) == "+"){
              $row["department"] = substr($row["department"], 0, -1);
          }

          array_push($match_array, $row);

      }

      foreach ($match_array as $row){
          if(!$row["image"]){
            $choice = rand(1, 8);
            switch ($choice) {
              case 1:
                $link = "http://www.lipscomb.edu/uploads/41278.jpg";
                break;
              case 2:
                $link = "https://wustl.edu/wp-content/uploads/2014/09/danforth-aerial.jpg";
                break;
              case 3:
                $link = "https://www.utoronto.ca/sites/default/files/cover-utm-hazel-mccallion-bldg.jpg";
                break;
              case 4:
                $link = "https://farm9.static.flickr.com/8059/8231788295_430d4a09eb_b.jpg";
                break;
              case 5:
                $link = "http://media.gettyimages.com/photos/australia-sydney-university-of-sydney-education-campus-student-fisher-picture-id543528256";
                break;
              case 6:
                $link = "http://cfile25.uf.tistory.com/image/124D3F354FB0DE281DCD0F";
                break;
              case 7:
                $link = "http://willamette.edu/admission/images/campus-visit-header.jpg";
                break;
              case 8:
                $link = "https://wustl.edu/wp-content/uploads/2015/10/bike-rider-1-2col.jpg";
                break;
              default:
                break;
            }
          } else{
            $link = $row["image"];
          }

          if(!$row["english"]){
            $row["english"]="Not required";
          }


          echo '<div class="row"><div class="col-md-5"><a href="#">
                  <img class="img-responsive" src="'.$link.'"alt="">
                  </a></div>';

          echo '<div class="col-md-7">
                  <h3>'.$row["name"].'<a class="btn btn-primary pull-right" href='.$row["url"].'id="button">School Link <span class="glyphicon glyphicon-chevron-right"></span></a></h3>';
          echo '<h4>'.$row["country"].'<small>'.$row["location"].'</h4>';
          echo '<div class="col-md-3 text-center"><h3 class="font-weight-bold">Term Offered</h3><h3>'.$row["term"].'</h3></div>';
          echo '<div class="col-md-6 text-center"><h3 class="font-weight-bold">Departments</h3><h3>'.$row["department"].'</h3></div>';

          // Edit here for adding english score
          echo '<div class="col-md-3 text-center"><h3 class="font-weight-bold">English Score</h3><h3>'.$row["english"].'</h3></div>';
          echo '</div></div>';
          echo '<hr>';

      }
      ?>





      <a href="matching.html" class="btn btn-primary">Return</a>
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
