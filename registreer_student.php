<?PHP

include_once("classes/User.class.php");
include_once("classes/Imd_student.class.php");

session_start();
$b = new Imd_student();

if (!empty($_POST))
{
    try
    {
        $b->checkPass($_POST['pass'],$_POST['pass_rep']);

        $b->Name = $_POST['name'];
        $b->Email = $_POST['email'];
        $b->Password = $_POST['pass'];
        $b->Picture = "lel";
        $b->Year = $_POST['year'];
        $b->Branch = $_POST['branch'];
        $b->Description = $_POST['description'];
        $b->save();
        
        //header("Location: index.php");
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}

$all_users = $b->getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent-a-Student</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="keywords" content="Rentastudent, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
    <meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>

    <form action="" method="post">
        <label for="name">Naam</label>
        <input type="text" name="name" id="name" />

        <label for="email">Email</label>
        <input type="email" name="email" id="email"/>

        <label for="pass">Wachtwoord</label>
        <input type="password" name="pass" id="pass"/>

        <label for="pass_rep">Herhaal wachtwoord</label>
        <input type="password" name="pass_rep" id="pass_rep"/>

        <label for="year">Opleidingsjaar</label>
        <select name="year">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>

        <label for="branch">Keuzerichting</label>
        <select name="branch">
            <option value="1">Design</option>
            <option value="2">Development</option>
        </select>

        <label for="description">Motivatie</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>

        <label for="pic">Profielfoto</label>
        <input type="file" id="pic"/>

        <button id="post_btn">Registreer!</button>
    </form>

</body>
</html>