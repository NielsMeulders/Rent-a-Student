<?PHP

include_once("Db.class.php");
class Date_available
{

    private $m_dDate;


    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty)
        {
            case 'Date':
                if ($p_vValue!="")
                {
                    $this->m_dDate = $p_vValue;
                }
                else
                {
                    throw new Exception("Date is required!");
                }
                break;
        }
    }

    public function __get($p_sProperty)
    {
        switch ($p_sProperty)
        {
            case 'Date':
                return $this->m_dDate;
                break;
        }
    }

    public function save()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare('INSERT INTO date_available (date) VALUES  ( :date)');
        $statement->bindValue(':date',$this->Date);
        $statement->execute();
    }

    public function getAll()
    {
        $conn = Db::getInstance();
        $allposts = $conn->query("SELECT DATE_FORMAT(`date`,'%d-%c-%Y') as date FROM date_available");
        return $allposts;
    }

}

?>