<?PHP

include_once("classes/Db.class.php");

if (!empty($_POST))
{
    session_start();
    try
    {
        $conn = Db::getInstance();
        switch($_POST['type'])
        {
            case 1:
                $post = $conn->prepare("SELECT * FROM bezoeker WHERE email=?");
                break;

            case 2:
                $post = $conn->prepare("SELECT * FROM student WHERE email=?");
                break;

            case 3:
                $post = $conn->prepare("SELECT * FROM admin WHERE email=?");
                break;
        }

        $post->execute(array($_POST['email']));
        $row = $post->fetch(PDO::FETCH_ASSOC);

        if (password_verify($_POST['pass'], $row['password'])) {
            $_SESSION['loggedIn']=true;
            switch($_POST['type'])
            {
                case 2:
                    $_SESSION['type']='student';
                    $getId = $conn->prepare("SELECT id FROM student WHERE email=?");
                    $getId->execute(array($_POST['email']));
                    header('location: student_home.php');
                    break;

                case 3:
                    $_SESSION['type']='admin';
                    $getId = $conn->prepare("SELECT id FROM admin WHERE email=?");
                    $getId->execute(array($_POST['email']));
                    header('location: admin_home.php');
                    break;
            }
            $getterId = $getId->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id']=$getterId['id'];
        }
        elseif (!isset($row['password']))
        {
            throw new Exception('Ongeldig emailadres. Probeer het opnieuw!');
        } else {
            throw new Exception("Ongeldig wachtwoord!");
        }
    }
    catch(Exception $e)
    {
        $error = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent-a-Student | Login</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="img/logo_badge.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/logo_badge.png" type="image/x-icon"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="keywords" content="Rent-a-student, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
    <meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>

<div class="container-fluid">
    <nav class="navbar navbar-default navbar-static-top">
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
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div class="row">
        <div class="col-xs-12 no-padding">
        <div class="jumbotron" id="jumbologin"><h1>Login</h1></div> <!--end jumbotron-->
            <form id="loginform" method="post" action="">

                <?PHP if(isset($error)): ?>

                    <div class="alert alert-danger" role="alert"><?PHP echo $error; ?></div>

                <?PHP endif; ?>
                <?PHP if(isset($feedback)): ?>

                    <div class="alert alert-success" role="alert"><?PHP echo $feedback; ?></div>

                <?PHP endif; ?>
                <div class="form-group">
                    <label for="type">Ik ben een </label>
                    <select name="type" id="type">
                        <option value="2">student</option>
                        <option value="3">administrator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="pass">Wachtwoord</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <button type="submit" class="btn btn-default">Log in</button>
            </form>
        </div>
    </div> <!--end row-->

    <div class="row" >        
    <div class="col-xs-12" id="relatedlinks">
        <ul>
           <li><a href="http://www.thecreativitygym.be/"><img src="img/gym_logo.png" alt="Creativity Gym logo"></a></li>
           <li><a id="weareimd" href="http://www.weareimd.be/"><img src="img/weareimd_logo.svg" alt="We Are IMD logo"></a></li>
           <li><a id="thomasmore" href="http://www.thomasmore.be/interactive-multimedia-design-imd"><img src="img/thomasmore_logo.png" alt="Thomas More logo"></a></li>
        </ul>
    </div><!--end relatedlinks-->
    </div><!--end row-->
    <footer class="footer">&copy Thomas More</footer>

</div> <!-- end container -->

</body>
</html>