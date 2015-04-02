<?PHP

    include("Db.class.php");
    abstract class User
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
                        if ($this->checkEmail($p_vValue) === true)
                        {
                            $this->m_sEmail = $p_vValue;
                        }
                        else
                        {
                            throw new Exception("Email is already in use!");
                        }
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

        public function checkEmail($p_sCheckEmail)
        {
            $ret = true;

            $all_mails = $this->getAll();
            while($row = $all_mails->fetch(PDO::FETCH_ASSOC)) {

                if($row['email'] == $p_sCheckEmail)
                {
                    $ret = false;
                }

            }

            return $ret;
        }

    }

?>