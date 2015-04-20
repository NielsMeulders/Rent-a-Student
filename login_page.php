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
                case 1:
                    $_SESSION['type']='bezoeker';
                    header('location: http://nielsmeulders.be');
                    break;

                case 2:
                    $_SESSION['type']='student';
                    header('location: http://nielsmeulders.be');
                    break;

                case 3:
                    $_SESSION['type']='admin';
                    header('location: http://nielsmeulders.be');
                    break;
            }
        }
        elseif (!isset($row['password']))
        {
            throw new Exception('User does not exist!');
        } else {
            throw new Exception("Password is incorrect!");
        }
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
    <div class="row">
        <div class="col-xs-12 no-padding">
        <div id="topbar"></div>
        <div class="jumbotron" id="jumbologin"><h1>Login</h1></div> <!--end jumbotron-->
            <form id="loginform" method="post" action="">
                <div class="form-group">
                    <label for="type">Ik ben een </label>
                    <select name="type" id="type">
                        <option value="1">bezoeker</option>
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
                <button type="submit" class="btn btn-default">Log in!</button>
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