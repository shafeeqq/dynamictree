<?
//header("Content-type:application/json;charset=utf-8");
include "class/connect.php"; 
@extract($_GET);
@extract($_POST);
$param=json_decode($param);

if(!$param->startfrom)
$startfrom=0;


    $sql="select ID,PARENTID,NAME from tree where PARENTID=:PARENTID";
    $stmt=$db->conn->prepare($sql);
    $stmt->execute(array("PARENTID"=> $param->startfrom));
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    
                     $i=0;
  
                    foreach($result as $key=>$value)
                    {
                             
                            $stmt_sub=$db->conn->prepare("select id from tree where parentid=:parentid");
                            $stmt_sub->execute(array("parentid" => $value["ID"]));
                            $leaf=$stmt_sub->rowCount();
                            $result[$i]["leaf"]=$leaf;
                     
                            $i++;
                    }
         
    

    echo json_encode($result);

?>