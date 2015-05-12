<?PHP

    include_once("User.class.php");

    class Imd_student extends User
    {

        private $m_iYear;
        private $m_sBranch;
        private $m_sDescription;

        public function __set($p_sProperty, $p_vValue)
        {

            switch ($p_sProperty)
            {
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
        
        public function update($name, $pass, $year, $branch, $description)
        {
            $conn = Db::getInstance();
            $current_id = $_SESSION['id'];
            if (empty($pass))
            {
                $statement = $conn->prepare('UPDATE student SET name=:name,year=:year,branch=:branch,description=:description WHERE id=:id');

            }
            else
            {
                $this->Password = $pass;
                $statement = $conn->prepare('UPDATE student SET name=:name,password=:password,year=:year,branch=:branch,description=:description WHERE id=:id');
                $statement->bindValue(':password',$this->Password);
            }
            $statement->bindValue(':name',$name);
            $statement->bindValue(':year',$year);
            $statement->bindValue(':branch',$branch);
            $statement->bindValue(':description',$description);
            $statement->bindValue(':id',$current_id);
            $statement->execute();

            header('location: student_home.php');

            /*$statement = $conn->prepare('UPDATE student SET name=?,email=?,password=?,picture=?,year=?,branch=?,description=?');
            $statement->execute(array($this->Name, $this->Email, $this->Password, $this->Picture, $this->Year, $this->Branch, $this->Description));*/
        }

        public function getAll()
        {
            $conn = Db::getInstance();
            $allposts = $conn->query("SELECT * FROM student");
            return $allposts;
        }

        public function getOne($m_pId)
        {
            $conn = Db::getInstance();
            $one = $conn->prepare("SELECT * FROM student WHERE id = :id");
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