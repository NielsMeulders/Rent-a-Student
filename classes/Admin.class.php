<?PHP

include_once("User.class.php");

class Admin extends User
{

    private $m_sPassword;

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
        $statement = $conn->prepare('INSERT INTO admin (name,password,email) VALUES  ( :name,:password,:email)');

        $statement->bindValue(':name',$this->Name);
        $statement->bindValue(':email',$this->Email);
        $statement->bindValue(':password',$this->Password);
        $statement->execute();
    }

    public function getAll()
    {
        $conn = Db::getInstance();
        $allposts = $conn->query("SELECT * FROM admin");
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