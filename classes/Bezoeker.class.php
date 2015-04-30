<?PHP

    include_once("User.class.php");

    class Bezoeker extends User
    {

        public function save()
        {

            $conn = Db::getInstance();
            // errors doorsturen van de database
            // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement = $conn->prepare('INSERT INTO bezoeker (name,email,picture,password) VALUES  ( :name, :email,:picture, :password)');

            $statement->bindValue(':name',$this->Name);
            $statement->bindValue(':email',$this->Email);
            $statement->bindValue(':picture',$this->Picture);
            $statement->bindValue(':password',$this->Password);
            $statement->execute();
        }

        public function getAll()
        {
            $conn = Db::getInstance();
            $allposts = $conn->query("SELECT * FROM bezoeker");
            return $allposts;
        }

        public function getOne($m_pId)
        {
            $conn = Db::getInstance();
            $one = $conn->prepare("SELECT * FROM bezoeker WHERE name = :id");
            $one->bindValue(':id',$m_pId);
            $one->execute();
            return $one->fetch();
        }

        public function checkPass($val1, $val2)
        {
            if ($val1 != $val2)
            {
                throw new Exception("Passwords don't match!");
            }
        }

    }

?>