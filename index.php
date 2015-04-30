<?PHP

    session_start();

    if (!empty($_SESSION['loggedIn']))
    {
        switch($_SESSION['type'])
        {
            case 'bezoeker':
                header('location: bezoeker_home.php');
                break;

            case 'student':
                header('location: bezoeker_home.php');
                break;

            case 'admin':
                header('location: bezoeker_home.php');
                break;
        }
    }

    try
    {
        if(!empty($_POST))
        {
            if (!empty($_POST['email']))
            {
                include_once("classes/Db.class.php");
                $conn = Db::getInstance();
                // errors doorsturen van de database
                // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $allmails = $conn->query("SELECT * FROM email");
                while($row = $allmails->fetch(PDO::FETCH_ASSOC)) {

                    if($row['email'] == $_POST['email'])
                    {
                        throw new Exception("Uw email adres is reeds geregistreerd");
                    }

                }
                $statement = $conn->prepare('INSERT INTO email (email) VALUES  (:email)');

                $statement->bindValue(':email',$_POST['email']);
                $statement->execute();
            }
            else
            {
                throw new Exception("Vul aub uw emailadres in");
            }
        }
    }
    catch (Exception $e)
    {
        $error = $e->getMessage();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent-a-Student</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
    <meta name="keywords" content="Rentastudent, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
	<meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/instafeed.min.js"></script>
    <script type="text/javascript">
        var feed = new Instafeed({
            get: 'tagged',
            tagName: 'weAreImd',
            clientId: 'b5d9a213f21d4b9591913672aec5053c',
            filter: function(image) {
                var blockedUsernames = [
                    'imtoofabluv'
                ];

                // check for blocked users
                for (var i=0; i<blockedUsernames.length; i++) {
                    if (image.user.username === blockedUsernames[i]) {
                        return false;
                    }
                }

                return true;
            }
        });

        feed.run();
    </script>
</head>
<body>
<div class="container-fluid" >
    <div class="row"> 
    <div class="col-md-12 no-padding">
        <div id="topbar">
           <?PHP if(isset($error)): ?>
                   
                   <div class="alert alert-danger" role="alert" style="position: fixed; top: 0; width: 100%; z-index: 101"><?PHP echo $error;?></div>
                   
               <?PHP endif; ?>
            <a href="login_page.php" class="btn">Login</a>
        </div>

        <!--jumbohead-->
        <div class="jumbotron" id="jumbohead">
        
            <h1>Welkom!</h1>
            <p><h2>Ontdek de wereld van <strong>Interactive Multimedia Design!</strong></h2></p>
        </div> <!--end jumbotron-->
    </div>
     </div><!--end row-->
   
    <div class="row rowhomepage">
    <div id="welcomewrap">
      <div id="collinks"class="col-sm-6">
        <div class="jumbotron">
            <div id="icon1"></div>
            <h3>Ontdek IMD!</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. <strong>Quam ratione</strong>, fugiat illum non corporis iure sint fuga tempora pariatur nesciunt repellat error. Non exercitationem adipisci amet voluptate eius earum vero?</p>
            <p><a class="btn btn-primary btn-lg" href="registreer_bezoeker.php" role="button">Registreer!</a></p>
        </div>
       </div><!--end collinks-->
      <div id="colrechts"class="col-sm-6">
        <div class="jumbotron">
            <div id="icon2"></div>
            <h3>Start als gids</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam ratione, fugiat illum non corporis iure sint fuga tempora pariatur nesciunt repellat error. Non exercitationem adipisci amet voluptate eius earum vero?</p>
            <p><a class="btn btn-primary btn-lg" href="registreer_student.php" role="button">Registreer!</a></p>
        </div>
       </div><!--end colrechts-->       
       <div class="jumbotron">
            <form action="" method="post">
            <p>Blijf op de hoogte van al onze <strong>updates</strong></p>
            
               <a name="form_tag" id="form_tag"></a>
            <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Uw emailadres" style="text-align: left">
                </div>
            <p><button type="submit" class="btn btn-default">Hou me op de hoogte!</button></p>
            </form>
        </div>
    </div><!--end welcomewrap-->
    </div><!-- end row -->

    <div class="row" >        
        <div class="col-md-12" id="relatedlinks">
            <div id="instafeed"></div>
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