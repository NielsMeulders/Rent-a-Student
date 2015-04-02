<?PHP

    include_once("User.class.php");

    class Imd_student extends User
    {

        private $m_sPassword;
        private $m_iYear;
        private $m_sBranch;
        private $m_sDescription;

        public function __set($p_sProperty, $p_vValue)
        {

            switch ($p_sProperty)
            {
                case 'Password':
                    if ($p_vValue!="")
                    {
                        $options = array('cost' => 12);
                        $this->m_sPassword = password_hash($p_vValue, PASSWORD_BCRYPT, $options);
                    }
                    else
                    {
                        throw new Exception("Password is required!");
                    }
                    break;

                case 'Year':
                    $this->m_iYear = $p_vValue;
                    break;

                case 'Branch':
                    if ($p_vValue!="")
                    {
                        $this->m_sBranch = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Branch required!");
                    }
                    break;

                case 'Description':
                    if ($p_vValue!="")
                    {
                        $this->m_sDescription = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Description required!");
                    }
                    break;

                default:
                    parent::__set($p_sProperty,$p_vValue);
                    break;
            }

        }

        public function __get($p_sProperty)
        {
            switch ($p_sProperty)
            {
                case 'Password':
                    $vResult = $this->m_sPassword;
                    break;

                case 'Year':
                    $vResult = $this->m_iYear;
                    break;

                case 'Branch':
                    $vResult = $this->m_sBranch;
                    break;

                case 'Description':
                    $vResult = $this->m_sDescription;
                    break;

                default:
                    $vResult = parent::__get($p_sProperty);
                    break;
            }

            return $vResult;

        }

        public function save()
        {

            $conn = Db::getInstance();
            // errors doorsturen van de database
            // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $statement = $conn->prepare('INSERT INTO student (name,email,password,picture,year,branch,description) VALUES  ( :name,:email,:password,:picture,:year,:branch,:description)');

            $statement->bindValue(':name',$this->Name);
            $statement->bindValue(':email',$this->Email);
            $statement->bindValue(':password',$this->Password);
            $statement->bindValue(':picture',$this->Picture);
            $statement->bindValue(':year',$this->Year);
            $statement->bindValue(':branch',$this->Branch);
            $statement->bindValue(':description',$this->Description);
            $statement->execute();
        }

        public function getAll()
        {
            $conn = Db::getInstance();
            $allposts = $conn->query("SELECT * FROM student");
            return $allposts;
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