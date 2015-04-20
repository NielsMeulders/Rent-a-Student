<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Bezoeker</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container-fluid" >

<!--nav-->
     <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Rent-a-Student</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Browse</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Instellingen</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a class="btn" id="btnlogout" href="../navbar-fixed-top/">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav><!--end nav-->

    <div class="col-md-12" id="bezhometitle">          
               <h1>Kies je gids</h1>
    </div>

   
    <div class="row rowhomepage">
    <div id="welcomewrap">
      <div id="collinks"class="col-sm-6">
        <div class="jumbotron">
            <div id="icon2"></div>
            <h3>Per Soon</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <strong>Quam ratione</strong>, fugiat illum non corporis iure sint fuga tempora pariatur nesciunt repellat error. Non exercitationem adipisci amet voluptate eius earum vero?</p>
            <p><a class="btn btn-primary btn-lg" href="registreer_bezoeker.php" role="button">Maak afspraak</a></p>
        </div>
       </div><!--end collinks-->
      <div id="colrechts"class="col-sm-6">
        <div class="jumbotron">
            <div id="icon2"></div>
            <h3>Per Soon</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam ratione, fugiat illum non corporis iure sint fuga tempora pariatur nesciunt repellat error. Non exercitationem adipisci amet voluptate eius earum vero?</p>
            <p><a class="btn btn-primary btn-lg" href="registreer_student.php" role="button">Maak afspraak</a></p>
        </div>
       </div><!--end colrechts-->
    </div><!--end welcomewrap-->
    </div><!-- end row -->

    <div class="row" >        
        <div class="col-md-12" id="relatedlinks">
            <ul>
                <li><a href="http://www.thecreativitygym.be/"><img src="img/gym_logo.png" alt="Creativity Gym logo"></a></li>
                <li><a id="weareimd" href="http://www.weareimd.be/"><img src="img/weareimd_logo.svg" alt="We Are IMD logo"></a></li>
                <li><a id="thomasmore" href="http://www.thomasmore.be/interactive-multimedia-design-imd"><img src="img/thomasmore_logo.png" alt="Thomas More logo"></a></li>
            </ul>
        </div><!--end relatedlinks-->
    </div><!--end row-->
    <footer class="footer">&copy Thomas More</footer>


</div> <!--end container-->
</body>
</html>