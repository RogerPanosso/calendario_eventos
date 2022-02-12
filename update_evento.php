<?php
    declare(strict_types=1);
    
    //requisita conexão com Mysql PDO
    require_once __DIR__."/connect_pdo.php";
    
    //recebe dados da requisição interna AJAX como POST
    $id = intval(filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT));
    $title = trim(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING));
    $color = trim(filter_input(INPUT_POST, "color", FILTER_SANITIZE_STRING));
    $start = trim(filter_input(INPUT_POST, "start", FILTER_SANITIZE_STRING));
    $end = trim(filter_input(INPUT_POST, "end", FILTER_SANITIZE_STRING));
    
    //converte caractere em data de inicio e fim de evento
    $start = str_replace("/", "-", $start);
    $end = str_replace("/", "-", $end);
    
    //converte data de inicio e fim para padrão MySQL(Y-m-d H:i:s)
    $start_padrao = date("Y-m-d H:i:s", strtotime($start));
    $end_padrao = date("Y-m-d H:i:s", strtotime($end));

    if(empty($id) or empty($title) or empty($color) or empty($start_padrao) or empty($end_padrao)) {
        
        echo "<script>window.location.href='index.php'</script>";
        exit();
        
    }
    
    //define array de retorno
    $array = array();
    
    //define query UPDATE
    $query = "UPDATE events SET title = :title, color = :color, start = :start, end = :end WHERE id = :id";
    $query = $pdo->prepare($query);
    $query->bindValue(":title", $title);
    $query->bindValue(":color", $color);
    $query->bindValue(":start", $start_padrao);
    $query->bindValue(":end", $end_padrao);
    $query->bindValue(":id", $id);
    $query->execute();
    
    if($query == true) {
        
        $array["return"] = "success";
        
    }else {
        
        $array["return"] = "error";
        
    }
    
    //retorna array de retorno em formato json(object)
    header("Content-Type: application/json");
    echo json_encode($array);
    exit();
?>

