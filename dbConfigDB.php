<?php 
include 'constanVaribles.php';
//include header(error_reporting(0));
class dbconfigDB
{
    private $hostName = hostName;
    private $userName = userName;
    private $hostPassword = userPassword;
    private $dbName = dbName;
    private $conn ="";
    private $mysql = false;
    Private $result = array();

    public function  __construct (){
        if(!$this->mysql){
            $this->conn = new mysqli($this->hostName,$this->userName,$this->hostPassword,$this->dbName);  
           
            $this->mysql = true; 
           
            if($this->conn->connect_error){
                array_push($this->result, $this->conn->connect_error);
                return false;
            }    
        }else{
            return true;
        }    
    }
    
    public function __distruct(){
        if($this->mysql){
            if($this->conn->close())
            {
                $this->mysql = false;
                return true;
            }
        
        }else{
            return false;
        }    
    }

    public function insertData($table , $parms = array()){
    
        if($this->tableExist($table)){
            $tblCol = implode(',' , array_keys($parms));
            $tblVal = implode("','" , $parms);
            $tblInSQL = " INSERT INTO  $table ($tblCol) VALUES ('$tblVal') ";
            $run = $this->conn->query($tblInSQL);
            if($run){
                array_push($this->result, $this->conn->insert_id);
                return true;
            }else{
                array_push($this->result,$table."Data not feed in table");
                return false;
            }

        }else{
             return false;
        }     
               

    }
    public function selectData($table){
        if($this->tableExist($table)){

            $qury = " SELECT * from $table "; 
            $runQury = $this->conn->query($qury);
            if( $res = $runQury->num_rows>0){
                while($res = $runQury->fetch_assoc()){
                    
                    // echo "<pre>";
                    // print_r($res);
                }
                array_push($this->result,$table."Data  fetchech");
            }else{
                array_push($this->result,$table."Data not fetch");
                return false;
            }
        }else{
            array_push($this->result,$table."Table Not fond");
           return false;
        }

    }
    public function updateRec($table, $parms = array(), $where = null){
        if($this->tableExist($table)){
            $args[] = array();
            foreach ($parms as $key => $value) {
                $args[] = " $key = '$value' "; 
            } 
            $qury = " UPDATE `$table`   SET ". implode(',', $args);
            if($where != null){
                $qury .= " WHERE  $where ";
            }
            if($runQur = $this->conn->query($qury)){
                array_push($this->result, $table. "Data updated");
                return true;

            }else{
                array_push($this->result, $this->conn->affected_rows);
            }
         
        }else{
            return false;
        }
    }
    public function getResult(){
        $val = array();
        $val[] = $this->result;
        
        return $val;
    }

    private function tableExist($table){
       $veryTbl = " SHOW TABLES FROM $this->dbName LIKE '$table' ";
       $run = $this->conn->query($veryTbl);
       if($run){
           if($run->num_rows == 1){
               return true;
           }else{
               array_push($this->result , $table."Table not found");
                return false;
           }
       }else{
           return false;
       }
    }
    public function delRecorde($table, $where = null){
        if($this->tableExist($table)){
            $quryTbl = " DELETE FROM `$table` ";
            if($where != null){
                $quryTbl .= " where $where ";
            }
            if($this->conn->query($quryTbl)){
                array_push($this->result, $this->conn->affected_rows);
                return true;
            }else{
                array_push($this->result,"Record not Deleted");
                return true;
            }
        }else{
               return false;
        }

    }
}

?>