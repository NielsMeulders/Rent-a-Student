<?PHP

include_once("Db.class.php");
class Rating
{

    private $m_iRating;
    private $m_sComment;


    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty)
        {
            case 'Rating':
                if ($p_vValue!="")
                {
                    $this->m_iRating = $p_vValue;
                }
                else
                {
                    throw new Exception("Rating is verplicht!");
                }
                break;

            case 'Comment':
                if ($p_vValue!="")
                {
                    $this->m_sComment = $p_vValue;
                }
                else
                {
                    throw new Exception("Commentaar is verplicht!");
                }
                break;
        }
    }

    public function __get($p_sProperty)
    {
        switch ($p_sProperty)
        {
            case 'Rating':
                return $this->m_iRating;
                break;

            case 'Comment':
                return $this->m_sComment;
                break;
        }
    }

    public function save($bezoeker_id, $student_id)
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("INSERT INTO rating(bezoeker_id,student_id,rating,comment,date) VALUES ($bezoeker_id,$student_id,:rating,:comment,CURRENT_DATE);");
        $statement->bindValue(":rating",$this->m_iRating);
        $statement->bindValue(":comment",$this->m_sComment);
        $statement->execute();
    }

    public function getAll($user)
    {
        $conn = Db::getInstance();
        $allratings = $conn->query("SELECT rating, comment, name, DATE_FORMAT(date,'%d-%c-%Y') as date FROM rating INNER JOIN bezoeker on rating.bezoeker_id = bezoeker.id WHERE student_id = $user");
        return $allratings;
    }
}

?>