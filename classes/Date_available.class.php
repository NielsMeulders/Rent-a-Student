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
                    if ($this->checkDate($p_vValue))
                    {
                        $this->m_dDate = $p_vValue;
                    }
                    else
                    {
                        throw new Exception("Deze datum is al geregistreerd.");
                    }
                }
                else
                {
                    throw new Exception("Datum is verplicht!");
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
        $allposts = $conn->query("SELECT id,DATE_FORMAT(date,'%d-%c-%Y') as date FROM date_available ORDER BY Year(date), Month(date), Day(date)");
        return $allposts;
    }

    public function getAllOriginal()
    {
        $conn = Db::getInstance();
        $allposts = $conn->query("SELECT * FROM date_available ORDER BY Year(date), Month(date), Day(date)");
        return $allposts;
    }

    public function remove($p_vValue)
    {
        $conn = Db::getInstance();
        $allposts = $conn->query("DELETE FROM date_available WHERE id=$p_vValue;");
    }

    public function checkDate($p_sDate)
    {
        $ret = true;

        $all_dates = $this->getAllOriginal();
        while($row = $all_dates->fetch(PDO::FETCH_ASSOC)) {

            if($row['date'] == $p_sDate)
            {
                $ret = false;
            }

        }

        return $ret;
    }

}

?>