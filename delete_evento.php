<?php
    declare(strict_types=1);
    
    //conexão com Mysql PDO
    require_once "connect_pdo.php";
    
    //recebe id via GET(URL) para exclusão
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    
    //define array de retorno
    $array = array();
    
    if(!empty($id)) {
        
        //query DELETE
        $query = "DELETE FROM events WHERE id = :id";
        $query = $pdo->prepare($query);
        $query->bindValue(":id", $id);
        
        if($query->execute()) {
            
            $array["return"] = "success";
            
        }else {
            
            $array["return"] = "error";
            
        }
        
    }else {
        
        $array["return"] = "error";
        
    }
    
    //retorno array em formato json(object)
    header("Content-Type: application/json");
    echo json_encode($array);
    exit();
?>

