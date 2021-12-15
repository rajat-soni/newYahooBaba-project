<?PHP
include "dbConfigDB.php";
$obj = new dbconfigDB();
// $obj->insertData("add_data_tbl",["name"=>"monty","edu"=>"MCA","email"=>"rj.rajesh@gmail.com","mobile"=>"9935526860"]);

// $obj->updateRec("add_data_tbl",["name"=>"himani","edu"=>"MA","email"=>"rj.himani@gmail.com","mobile"=>"9914567823"]," id = '1' ");

// $obj->selectData("add_data_tbl");

$obj->delRecorde("add_data_tbl"," id = '1' ");

$obj->getResult();
echo "<pre>";
print_r($obj->getResult());




?>