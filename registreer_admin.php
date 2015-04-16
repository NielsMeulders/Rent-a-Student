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

        //header("Location: index.php");
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

</div> <!-- end container -->
</body>
</html>