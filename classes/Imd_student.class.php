<?PHP

    include_once("User.class.php");

    class Imd_student extends User
    {

        private $m_sBranch;
        private $m_sDescription;

        public function __set($p_sProperty, $p_vValue)
        {
            parent::__set($p_sProperty,$p_vValue);
            switch ($p_sProperty)
            {
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
            }
        }

        public function __get($p_sProperty)
        {
            $vResult = parent::__get($p_sProperty);
            switch ($p_sProperty)
            {
                case 'Branch':
                    $vResult = $this->m_sBranch;
                    break;

                case 'Description':
                    $vResult = $this->m_sDescription;
                    break;
            }

            return $vResult;
        }


    }

?>