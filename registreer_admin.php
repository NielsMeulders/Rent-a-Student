<?PHP

include_once("classes/User.class.php");
include_once("classes/Admin.class.php");

session_start();
$a = new Admin();

if (!empty($_POST))
{
    try
    {
        $a->checkPass($_POST['pass'],$_POST['pass_rep']);

        $a->Name = $_POST['name'];
        $a->Email = $_POST['email'];
        $a->Password = $_POST['pass'];
        $a->save();

        header("Location: admin_home.php");
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}

$all_users = $a->getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent-a-Student | Admin registratie</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
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

<div class="container-fluid registercontainer">

    <!--nav-->
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
                <ul class="nav navbar-nav">
                    <li><a href="admin_home.php">Home</a></li>
                    <li class="active"><a href="registreer_admin.php">Account toevoegen</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn" id="btnlogout" href="logout.php">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav><!--end nav-->

    <div class="row rowhomepage">
        <div class="col-md-1 styleguide">
            <h2>Admin registratie</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="pass">Wachtwoord</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <div class="form-group">
                    <label for="pass_rep">Wachtwoord herhalen</label>
                    <input type="password" class="form-control" id="pass_rep" name="pass_rep">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div> <!-- end rowhomepage -->

</div> <!-- end container -->
</body>
</html>