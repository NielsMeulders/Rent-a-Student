<?PHP

    include_once("User.class.php");

    class Bezoeker extends User
    {

        public function save()
        {

            $conn = Db::getInstance();
            $statement = $conn->prepare('INSERT INTO bezoeker (name,email,fbid) VALUES  ( :name, :email,:fbid)');

            $statement->bindValue(':name',$this->Name);
            $statement->bindValue(':email',$this->Email);
            $statement->bindValue(':fbid',$this->Picture);
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

        public function checkDoubleMail($v_Vemail)
        {
            $ret = false;
            $conn = Db::getInstance();
            $allusers = $conn->query("SELECT * FROM bezoeker");
            while ($user = $allusers->fetch(PDO::FETCH_ASSOC))
            {
                if ($user['email'] == $v_Vemail)
                {
                    $ret = true;
                }
            }
            return $ret;
        }

    }

?>