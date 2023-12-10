<?php
    require '/home/jason.zhan/calendarSqlConnection.php';
    header("Content-Type: application/json"); 


    ini_set("session.cookie_httponly", 1);

    session_start();

    $json_str = file_get_contents('php://input');
    //This will store the data into an associative array
    $json_obj = json_decode($json_str, true);

    // getting variables
    $importance = (string)($json_obj['importance']);
    $title = (string)($json_obj['title']);
    $body = (string)($json_obj['body']);
    $date = (string)($json_obj['date']);
    $time = (string)($json_obj['time']);
    $userId= (string)($json_obj['sendUserId']);

    //inserting events into certain user's calendar AKA sending it
    if(!(strlen($title)==0)){

        $stmt = $mysqli->prepare("insert into events (title, body, date, time, ,importance) values (?,?,?,?,?) where user_id=?");
        if(!$stmt){
            printf ("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('sssssi', $title, $body, $date, $time, $importance, $userId);
        $stmt->execute();
        $stmt->close();
        
        echo json_encode(array(
            "success"=>true,
        ));
    }
    else{
        echo json_encode(array(
            "success"=> false,
            "message"=> "invalid username"
        ));
    }

?>