<?php
class Database{
private $db_host = "localhost";  // Change as required
private $db_user = "root";       // Change as required
private $db_pass = "";   // Change as required
private $db_name = "shopping_db";   // Change as required
private $result = array(); // Any results from a query will be stored here
private $mysqli = ""; // This will be our mysqli object
private $myquery = "";// used for debugging process with SQL return
private $conn = false;
public function __construct(){

    if(!$this->conn){

        $this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
        // Check connection
        if ($this->mysqli->connect_errno > 0){
          array_push($this->result,$this->mysqli->connect_error);
          return false; // Problem selecting database return FALSE
        }
    }
    else{
        return true;
    }
}

    /* Function for Insert query */ 

    public function insert($table,$params = array()){

        if ($this->tableExists($table)) {
            $table_columns = implode(", ",array_keys($params)); /*  ['name'] = 'mkarim' */
            $table_values = implode("', '", $params); // 'mkarim','email','password'
            $sql = "INSERT INTO $table($table_columns) VALUES('$table_values')";
            $this->myquery = $sql;

            if($this->mysqli->query($this->myquery)){
                array_push($this->result,$this->mysqli->insert_id); // First is array,2nd is value
               return true;
            }else{
                array_push($this->result,$this->mysqli->error);
                return false;
            }

        }
        else{
            return false;
        }
    }


    /* Update Query Function Method Here */
    public function update($table,$params = array(), $where = null){

        if($this->tableExists($table)){

            $arguments = array();

            foreach($params as $columnKey=>$columnValue){ 
                $arguments[] = "$columnKey ='$columnValue'";
            }
            $KeyValue = implode(", ",$arguments);

            $sql = "UPDATE $table SET $KeyValue";

            if($where != null){
                $sql.= "WHERE $where";
            }
            $this->myquery = $sql;
            if($this->mysqli->query($sql)){
                array_push($this->result,$this->mysqli->affected_rows);
                return true;
            }
            else{
                array_push($this->result,$this->mysqli->connect_error);
                return false;
            }

        }
        else{
            return false;
        }
    }
   
/* Delete Function Method Here */
public function delete($table,$where= null){
    if ($this->tableExists($table)) {
        $sql = "DELETE FROM $table ";
        if ($where != null) {
            $sql.= " WHERE $where ";
        //    print_r($sql);
             
            if ($this->mysqli->query($sql)) {
                $this->myquery = $sql;
                array_push($this->result,$this->mysqli->affected_rows);
                return true;

            }else{
                // echo "Table not deleted";
                array_push($this->result,$this->mysqli->connect_error);
                return false;
            }
            
        }
        
    }
    else{

        return false;
    }
}

/* Select Query Method Here */
public function select($table,$row = "*",$join = null,$where = null,$order = null,$limit = null)
{
  if ($this->tableExists($table)){
    
    $sql = " SELECT $row FROM $table ";
    if ($join != null) {
        $sql .= " JOIN ". $join;
        # code...
    }
    if ($where != null) {
        $sql .= " WHERE ". $where;
        # code...
    }
    if ($order != null) {
        $sql .= " ORDER by ". $order;
        # code...
    }
    if ($limit != null) {
       if (isset($_GET['page'])) {
        $page = $_GET['page'];
        # code...
       }else{
        $page = 1;
       } 
       
$start = ($page -1) * $limit;
$sql .= " LIMIT ".$start. "," .$limit;

    }
$this->myquery = $sql;
$query = $this->mysqli->query($sql);
if ($query) {
    
   $this->result = $query->fetch_all(MYSQLI_ASSOC);
   /*  $this->mysqli->query($sql)->fetch_all(MYSQLI_ASSOC); */
   return true;
}
    else{
        array_push($this->result,$this->mysqli->connect_error);
        return false;
    }

  }
  
  else{
    return false;
  }

}

//  value store in this->result based on SQL command
public function sql($sql)
{
  $this->myquery = $sql;
  $query = $this->mysqli->query($sql); // example argument of $sql parameter UPDATE tbl_user SET column='value'; 
  if($query){
    $query_arr = explode(' ',$sql); // mkarim,dulal,rashed
            switch ($query_arr[0]) { // this switch case is allias of if condition $query_arr[0] == 'INSERT';
               case 'INSERT':
               array_push($this->result,
            $this->mysqli->insert_id);
                break;
                case "UPDATE":
                array_push($this->result,$this->mysqli->affected_rows);
                break;
                case 'DELETE':
                array_push($this->result,$this->mysqli->affected_rows);
                break;
                case 'SELECT':
                array_push($this->result,$query->fetch_all(MYSQLI_ASSOC));
        }
        return true;
  }
  
  else{
    array_push($this->result,$this->mysqli->connect_error);
    return false;
  }

} 

    /*  Function Method to check whether table exist or not in database */
    private function tableExists($table)
    {
       $tableIndb = $this->mysqli->query("SHOW TABLES FROM $this->db_name LIKE '$table'");
       if ($tableIndb) {
        if ($tableIndb->num_rows == 1) {
            return true;
        }
        else{
            array_push($this->result,$table." table doesn't exist");
            return false;
        }
        
       }
    }

    /* This function to get the result of fetch and error */
    function getSql(){
        $sqlval = $this->myquery;
         $this->myquery = array();
        return $sqlval;
    }

    /* This function to escape String from input value */
function escapeString($data){
   $input_val = trim($data);
   $input_val = stripslashes($input_val);
   $input_val = htmlspecialchars($input_val);
   $result = $this->mysqli->real_escape_string($input_val);
    return $result;
}

/* To get Result of fetching data from $this->result */
function getResult(){
    $resultVal = $this->result;
     $this->result = array();
    return $resultVal;
}

/* this Function is for Input Validattion */

/* Destruct Method to destroy the mysqli function of construct method */

function __destruct()
{
    if($this->conn){
        if($this->mysqli->close()){
            $this->conn = false;
            return true;
        }
        else{
            return false;
        }
    }
}

};


/*  This Database class for test */

/* class TestDatabase {
private $db_name = "";
private $db_host = "localhost";
private $db_user = "root";
private $db_pass = '';
public $mysqli = '';
private $result = [];
private $myquery = '';
private $conn= false;

function __construct(){

    if(!$this->conn){
        $this->mysqli = new mysqli($this->db_name,$this->db_host,$this->db_user,$this->db_pass);
        if($this->mysqli->connect_errno > 0){
            array_push($this->result,$this->mysqli->connect_error);
            return false;
        }
        else{
            return true;
        }
    }
    else {
        return true;
    }
}

public function tableExists2($table){
    $tableInDb = $this->mysqli->query("SHOW TABLES FROM $this->db_name LIKE '$table'");
    if($tableInDb){
        return true;
    }else{
        array_push($this->result,$table . "doesn't exists in the $this->db_name");
    }
}
 // INSERT INTO TABLE tbl_users(name,email,password) values('mkarim','m.karimcu@gmail.com','mmk12345'); 
    // or
 // $params = [];
  // $params['name'] = 'mkarim';  
  // $params['email'] = 'm.karimcu@gmail.com';
  // $params['password'] = 'mmk12345';
   // or
  // array($name =>''mkarim',$email=>'m.karimcu@gmail.com',$password=>'mmk12345');
 public function insert($table,$params = []){
    if($this->tableExists2($table)){
        $table_columns = implode(", ",array_keys($params));
        $table_values = implode("','",$params);
        $sql = "INSERT INTO $table($table_columns) VALUES('$table_values')";
        $this->myquery = $sql;
        if($this->mysqli->query($this->myquery)){

            array_push($this->result,$this->mysqli->insert_id);
        }else{
            array_push($this->result,$this->mysqli->error);
            return false;
        }
    }
}


// Select Table of Database 
public function select($table,$row = "*",$join = null,$where=null,$order=null,$limit=null){
    if($this->tableExists2($table)){
        $sql = "SELECT $row FROM $table";
        if ($join != null) {
            $sql .= " JOIN $join ";
        }
        if($where != null){
            $sql .= " WHERE $where";
        }if($order != null){
            $sql .= " ORDER BY $order";
        }
        if($limit !=null){
            
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
            $start = ($page - 1) * $limit;
            $sql .= " LIMIT " . $start . "," . $limit;
            
        }

        $this->myquery = $sql;
        $query  = $this->mysqli->query($this->myquery);
        if($query){
            array_push($this->result,$query->fetch_all(MYSQLI_ASSOC));
            return true;
        }
        else{
            array_push($this->result,$this->mysqli->connect_error);
            return false;
        }

    }
    return false;
}

// Update Query 

public function update($table,$params=[],$where=null){
    if($this->tableExists2($table)){
        // $sql = "UPDATE $table SET";
        $args = [];
        foreach ($params as $keys => $values) {
            $args[] = "$keys = '$values'";
        }
        $columns_values = implode(',',$args);
        $sql = "UPDATE $table SET " . $columns_values;
        if($where != null){
            $sql .= " WHERE $where";
        }
        $this->myquery = $sql;
        $query = $this->mysqli->query($sql);
        if ($query) {
            array_push($this->result,$this->mysqli->affected_rows);
            return true;
        }else{
            array_push($this->result,$this->mysqli->error);
            return false;
        }
    }

}
public function delete($table,$where = null){

    if($this->tableExists2($table)){

        $sql = "DELETE FROM $table";
        if($where != null){
            $sql .= " WHERE $where";
        }
        $this->myquery = $sql;
        $query = $this->mysqli->query($sql);
        if($query){
            array_push($this->result,$this->mysqli->affected_rows);
            return true;
        }else{
            array_push($this->result,$this->mysqli->error);
            return true;
        }
    }
}

public function sql($sql){
    $this->myquery = $sql;
    $query = $this->mysqli->query($sql);
    $sql_arr = implode(" ",$sql);
    if($query){

    switch($sql_arr[0]){
        case "INSERT":
            array_push($this->result,$this->mysqli->insert_id);
            break;
        case "SELECT":
            array_push($this->result,$query->fetch_all(MYSQLI_ASSOC));
            break;
        case "UPDATE":
            array_push($this->result,$this->mysqli->affected_rows);
            break;
        case "DELETE":
           array_push($this->result,$this->mysqli->affected_rows);
           break;
    }
    return true;
}
else{
    array_push($this->result,$this->mysqli->error);
    return false;
}

}

public function escapeString($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $this->mysqli->real_escape_string($data);
}

public function getSql()
{
    $val = $this->myquery;
    $this->myquery = array();
    return $val;
}

public function getResult()
{
    $val = $this->result;
    $this->result = array();
    return $val;
}

public function __destruct(){
    if($this->conn){
        if($this->mysqli->close()){
           $this->conn = false;
           return true;
        }else{
            return false;
        }
    }
}

};

$dbObj = new Database;
echo $dbObj;echo "<br>";
$dbObj->insert("user",array("f_name"=>"mahmodul","l_name"=>'karim',"email"=>'mkarim@gmail.com')); 
*/
// $dbObj->select('user','*',null,null,null,null);
//  print_r($select);



 /* $dbObj = new Database();

print_r($dbObj->getResult()); */
//  $tableExist = $dbObj->tableExists('user');
//  print_r($tableExist);
// print_r($dbObj->result);

/* $insert = $dbObj->insert('user',array());
 echo $insert; echo "<br>";
print_r($dbObj->result); */
/*  $update = $dbObj->update('user',array('name'=>"mahmodul karim",'email'=>'mkarim10@gmail.com'),"id = 3");
 print_r($update); */

 /* $delete = $dbObj->delete('user','id=3');
 print_r($delete); */

/*  $select = $dbObj->select('user','*',null,null,null,null);
 print_r($select); */