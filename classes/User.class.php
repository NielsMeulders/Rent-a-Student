<?PHP

    include("Db.class.php");
    class User
    {

        private $m_sName;
        private $m_sEmail;
        private $m_sPicture;

        public function __set($p_sProperty, $p_vValue)
        {
            switch ($p_sProperty)
            {
                case 'Name':
                    if ($p_vValue!="")
                    {
                        $this->m_sName = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Name is required!");
                    }
                    break;

                case 'Email':
                    if ($p_vValue!="")
                    {
                        $this->m_sEmail = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Email is required!");
                    }
                    break;

                case 'Picture':
                    if ($p_vValue!="")
                    {
                        $this->m_sPicture = $p_vValue;
                    }
                    else
                    {
                        $this->m_sPicture = null;
                    }
                    break;
            }
        }

        public function __get($p_sProperty)
        {
            switch ($p_sProperty)
            {
                case 'Name':
                    return $this->m_sName;
                    break;

                case 'Email':
                    return $this->m_sEmail;
                    break;

                case 'Picture':
                    return $this->m_sPicture;
                    break;
            }
        }

        public function save()
        {

            $conn = Db::getInstance();
            // errors doorsturen van de database
            // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement = $conn->prepare('INSERT INTO user (name,email,picture) VALUES  ( :name, :email,:picture )');

            $statement->bindValue(':name',$this->m_sName);
            $statement->bindValue(':email',$this->m_sEmail);
            $statement->bindValue(':picture',$this->m_sPicture);
            $statement->execute();
        }

        public function getAll()
        {
            $conn = Db::getInstance();
            $allposts = $conn->query("SELECT * FROM user");
            return $allposts;
        }

    }

?>