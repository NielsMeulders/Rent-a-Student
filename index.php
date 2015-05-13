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
                header('location: student_home.php');
                break;

            case 'admin':
                header('location: admin_home.php');
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
                $feedback = "Uw email adres werd geregistreerd!";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
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
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/jssocials.css" />
    <link rel="stylesheet" type="text/css" href="css/jssocials-theme-flat.css" />
    <script src="js/jssocials.min.js"></script>
</head>
<body>
<div class="container-fluid " >
    <nav class="navbar navbar-default navbar-static-top">
        <?PHP if(isset($error)): ?>

            <div class="alert alert-danger" role="alert"><?PHP echo $error; ?></div>

        <?PHP endif; ?>
        <?PHP if(isset($feedback)): ?>

            <div class="alert alert-success" role="alert"><?PHP echo $feedback; ?></div>

        <?PHP endif; ?>
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <a class="navbar-brand" id="logo" href="index.php"><img src="img/logo.svg" alt="Logo"/></a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn" id="btnlogout" href="login_page.php">Login</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav><!--end nav-->

    <div class="slideshow">
        <div class="images"></div>
    </div>
    <div class="textoverlay">

        <h1>Welkom!</h1>
        <h2>Graag een <strong>openlesdag</strong> meevolgen?</h2>
        <h2>Kies hier je <strong>peter</strong> of <strong>meter</strong> en</h2>
        <h2>ontdek de wereld van <strong>Interactive Multimedia Design!</strong></h2>
    </div>
   
    <div class="row rowhomepage">
    <div id="welcomewrap">
      <div id="collinks"class="col-sm-6">
        <div class="jumbotron">
            <div id="icon1"></div>
            <h3>Ontdek IMD!</h3>
            <p>Ga je verder studeren en ben je net als ons helemaal <strong>zot van pixels en programmeren?</strong> In de professionele bachelor-opleiding Interactive Multimedia Design leer je de volledige mix tussen <strong>web design en development.</strong></p>
            <p>Om je hierop voor te bereiden organiseren wij <strong>openlesdagen</strong> waar je samen met je peter of meter alles leert kennen over IMD.</p>
            <p>Registreer je hieronder snel en gemakkelijk via Facebook.</p>
            <a class="btn btn-primary btn-lg" id="loginwithfb" href="fbconfig.php" role="button">Login with Facebook</a>
        </div>
       </div><!--end collinks-->
      <div id="colrechts"class="col-sm-6">
        <div class="jumbotron">
            <div id="icon2"></div>
            <h3>Start als gids</h3>
            <p>Om de potentieel <strong>nieuwe generatie IMD'ers</strong> klaar te stomen voor onze richting zijn de huidige studenten onze eerste hulp en daarom hebben we jouw hulp nodig.</p>
            <p>Zie jij het zitten om jouw <strong>passie</strong> uit IMD te delen met jonge pixel-freaks? Registreer je dan hier en stel je beschikbaar als <strong>peter of meter</strong>!</p>
            <a class="btn btn-primary btn-lg" href="registreer_student.php" role="button">Registreer!</a>
        </div>
       </div><!--end colrechts-->
        <div class="clearfix"></div>
       <div class="jumbotron">
            <form action="" method="post">
            <p>Blijf op de hoogte van al onze <strong>updates</strong></p>
            
               <a name="form_tag" id="form_tag"></a>
            <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Uw emailadres" style="text-align: left">
                </div>
            <p><button type="submit" class="btn btn-default">Hou me op de hoogte!</button></p>
            </form>
           <script>

               $('#email').keyup(function(){
                   console.log("hello");
               });

           </script>
        </div>
    </div><!--end welcomewrap-->
    </div><!-- end row -->

    <div class="row" >        
        <div class="col-md-12" id="relatedlinks">
            <h3>Instagram met ons mee! &#35;WeAreImd</h3>
            <div id="instafeed"></div>
            <table class="table" id="footer_images">
                <tbody>
                <tr>
                    <td><a href="http://www.thecreativitygym.be/"><img src="img/gym_logo.png" alt="Creativity Gym logo"></a></td>
                    <td><a id="weareimd" href="http://www.weareimd.be/"><img src="img/weareimd_logo.svg" alt="We Are IMD logo"></a></td>
                    <td><a id="thomasmore" href="http://www.thomasmore.be/interactive-multimedia-design-imd"><img src="img/thomasmore_logo.png" alt="Thomas More logo"></a></td>
                </tr>
                </tbody>
            </table>
        </div><!--end relatedlinks-->
    </div><!--end row-->

    <footer class="footer"><div id="share"></div>&copy Thomas More</footer>
    <script>  console.log("here");$("#share").jsSocials({shares: ["twitter", "facebook", "googleplus"]});  </script>

</div> <!--end container-->
</body>
</html>