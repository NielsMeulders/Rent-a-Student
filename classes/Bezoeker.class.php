<?PHP

    include_once("User.class.php");

    class Bezoeker extends User
    {

    public function save()
    {

        $conn = Db::getInstance();
        // errors doorsturen van de database
        // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $conn->prepare('INSERT INTO bezoeker (name,email,picture) VALUES  ( :name, :email,:picture )');

        $statement->bindValue(':name',$this->Name);
        $statement->bindValue(':email',$this->Email);
        $statement->bindValue(':picture',$this->Picture);
        $statement->execute();
    }

    public function getAll()
    {
        $conn = Db::getInstance();
        $allposts = $conn->query("SELECT * FROM bezoeker");
        return $allposts;
    }

    }

?>