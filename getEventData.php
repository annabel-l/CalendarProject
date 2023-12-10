<?php
    require '/home/jason.zhan/calendarSqlConnection.php';   
    header("Content-Type: application/json"); 


    ini_set("session.cookie_httponly", 1);

    $json_str = file_get_contents('php://input');
    //This will store the data into an associative array
    $json_obj = json_decode($json_str, true);

    $eventId = (string)($json_obj['eventId']);
    $sharedUsername = (string)($json_obj['sharedUsername']);

    // get event stuff
    $stmt = $mysqli->prepare("SELECT title, body, date, time, importance FROM events WHERE event_id=?");
    // get user_id
    $stmt2 = $mysqli->prepare("SELECT id FROM userInfo WHERE username=?");

    $stmt2->bind_param('s', $sharedUsername);
    $stmt2->execute();
      
    
    // Bind the results
    $stmt2->bind_result($userId);
    


    // Bind the parameter
    
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
      
    
    // Bind the results
    $stmt->bind_result($title, $body, $date,$time,$importance);

    
    $stmt->fetch();
    $stmt2->fetch();
    if(!$stmt2){
        echo json_encode(array(
            "success" => false,
            "message" => "invalid username"
        ));
        exit;

    }
    else{
        echo json_encode(array(
            "success" => true,
            "title"=> $title,
            "body"=> $body,
            "date" => $date,
            "time"=> $time,
            "importance"=> $importance,
            "sharedUserId"=> $userId
        ));
        exit;

    }

  
   

  

    ?>