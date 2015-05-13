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

    public function getAllJoin($student_id)
    {
        $conn = Db::getInstance();
        $allposts = $conn->query("SELECT DATE_FORMAT(date,'%d-%c-%Y') as date, date_available.id as id FROM date_available LEFT JOIN (SELECT * FROM date_gids_available WHERE date_gids_available.student_id = $student_id) AS b ON date_available.id = b.date_id WHERE b.student_id IS NULL");
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
        $conn->query("DELETE FROM date_available WHERE id=$p_vValue;");
        $conn->query("DELETE FROM date_gids_available WHERE date_id=$p_vValue;");
        $conn->query("DELETE FROM boeking WHERE date_id=$p_vValue;");
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

    public function bookDate($p_vFrom, $p_vTo, $p_vDate)
    {
        $conn = Db::getInstance();
        $conn->query("INSERT INTO boeking(user_id,student_id,date_id) VALUES ($p_vFrom, $p_vTo,$p_vDate)");
    }

    public function getBookingForStudent($p_vId)
    {
        $conn = Db::getInstance();
        $allBookings = $conn->query("SELECT name, email, DATE_FORMAT(date,'%d-%c-%Y') as date FROM boeking inner join bezoeker ON boeking.user_id = bezoeker.id inner join date_available on boeking.date_id = date_available.id WHERE student_id = $p_vId");
        return $allBookings;
    }

    public function getBookingForAdmin()
    {
        $conn = Db::getInstance();
        $allBookings = $conn->query("SELECT student.name as student_name, student.email as student_email, date, bezoeker.name as visitor_name, bezoeker.email as visitor_email FROM boeking inner join student ON boeking.student_id = student.id inner join date_available on boeking.date_id = date_available.id inner join bezoeker ON boeking.user_id = bezoeker.id");
        return $allBookings;
    }
}

?>