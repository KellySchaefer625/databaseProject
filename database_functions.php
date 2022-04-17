<?php

function getLatestEventId()
{
    try{
    global $db;

    $query = "SELECT MAX(event_ID) FROM Event_by_id";

    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $results = $statement->fetch();

    $statement->closeCursor();
    
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting latest Event ID');
    }

}

function addToEvent_By_ID($name, $time_start, $time_end, $building, $room, $date_of_event, $cost, $food)
{
    //db handler
    // the db handler is in connect-db
    // keyword global allows us to access db in connect-db
    try{
    global $db;

    //sql
    $query = "INSERT INTO Event_by_id (name, time_start, time_end, building, room, date_of_event, cost, food) VALUES (:name, :time_start, :time_end, :building, :room, :date_of_event, :cost, :food)";

    //execute
    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);
    $statement->bindValue(':time_start', $time_start);
    $statement->bindValue(':time_end', $time_end);
    $statement->bindValue(':building', $building);
    $statement->bindValue(':room', $room);
    $statement->bindValue(':date_of_event', $date_of_event);
    $statement->bindValue(':cost', $cost);
    $statement->bindValue(':food', $food);


    $statement->execute();

    //$statement = $db->query($query);

    //release
    $statement->closeCursor();}
    catch(Exception $execpt){
        throw new Exception('Error adding to event by ID');
    }
}

function updateEvent_By_ID($event_id, $name, $time_start, $time_end, $building, $room, $date_of_event, $cost, $food)
{
    //db handler
    //the db handler is in connect-db
    // keyword global allows us to access db in connect-db
    try{
    global $db;

    //sql
    $query = "UPDATE Event_by_id SET name='$name', time_start='$time_start', time_end='$time_end', building='$building', room='$room', date_of_event='$date_of_event', cost=$cost, food='$food' WHERE event_id=$event_id";
    // $query = "INSERT INTO Event_by_id (name, time_start, time_end, building, room, date_of_event, cost, food) VALUES (:name, :time_start, :time_end, :building, :room, :date_of_event, :cost, :food)";

    //execute
    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);
    $statement->bindValue(':time_start', $time_start);
    $statement->bindValue(':time_end', $time_end);
    $statement->bindValue(':building', $building);
    $statement->bindValue(':room', $room);
    $statement->bindValue(':date_of_event', $date_of_event);
    $statement->bindValue(':cost', $cost);
    $statement->bindValue(':food', $food);


    $statement->execute();

    //$statement = $db->query($query);

    //release
    $statement->closeCursor();}
    catch(Exception $execpt){
        throw new Exception('Error adding to event by ID');
    }
}

function deleteEvent_By_ID($event_id)
{
    $event_id = intval($event_id);
    //db handler
    //the db handler is in connect-db
    // keyword global allows us to access db in connect-db
    try{
    global $db;

    //sql
    $query = "DELETE Event_by_id WHERE event_id=$event_id";

    //execute
    $statement = $db->prepare($query);

    $statement->execute();

    //$statement = $db->query($query);

    //release
    $statement->closeCursor();}
    catch(Exception $execpt){
        throw new Exception('Error adding to event by ID');
    }
}

function addToEvent_restrictions($event_id, $restrictions)
{ try{
    global $db;

    $query = "INSERT INTO Event_restrictions VALUES (:event_id, :restrictions)";

    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    
   
    $statement->bindValue(':restrictions', $restrictions);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error restrictions to event');
    }

}

function updateEvent_restrictions($event_id, $restrictions)
{ try{
    global $db;

    $query = "UPDATE Event_restrictions SET restrictions='$restrictions' WHERE event_id=$event_id";
    // $query = "INSERT INTO Event_restrictions VALUES (:event_id, :restrictions)";

    $statement = $db->prepare($query);

    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':restrictions', $restrictions);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error restrictions to event');
    }

}

function deleteEvent_restrictions($event_id)
{ try{
    global $db;

    $query = "DELETE from Event_restrictions WHERE event_id=$event_id";

    $statement = $db->prepare($query);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error restrictions to event');
    }

}

function addToEvent_categories($event_id, $categories)
{   try{
    global $db;

    $query = "INSERT INTO Event_categories VALUES (:event_id, :categories)";

    $statement = $db->prepare($query);

    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':categories', $categories);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding categories to events');
    }
}

function updateEvent_categories($event_id, $categories)
{   try{
    global $db;

    $query = "UPDATE Event_categories SET categories='$categories' WHERE event_id=$event_id";
    // $query = "INSERT INTO Event_categories VALUES (:event_id, :categories)";

    $statement = $db->prepare($query);

    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':categories', $categories);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding categories to events');
    }
}

function deleteEvent_categories($event_id)
{   try{
    global $db;

    $query = "DELETE from Event_categories WHERE event_id=$event_id";
    // $query = "INSERT INTO Event_categories VALUES (:event_id, :categories)";

    $statement = $db->prepare($query);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding categories to events');
    }
}

function addToEvent_audience($event_id, $audience)
{   try{
    global $db;

    $query = "INSERT INTO Event_audience VALUES (:event_id, :audience)";

    $statement = $db->prepare($query);

    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':audience', $audience);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding audience to event');
    }
}

function updateEvent_audience($event_id, $audience)
{   try{
    global $db;

    $query = "UPDATE Event_audience SET audience='$audience' WHERE event_id=$event_id";

    $statement = $db->prepare($query);

    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':audience', $audience);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding audience to event');
    }
}

function deleteEvent_audience($event_id)
{   try{
    global $db;

    $query = "DELETE from Event_audience WHERE event_id=$event_id";

    $statement = $db->prepare($query);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding audience to event');
    }
}

function addToHost($org_name, $event_id)
{   try{
    global $db;

    $query = "INSERT INTO Host VALUES (:org_name, :event_id)";

    $statement = $db->prepare($query);

    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':org_name', $org_name);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding to host');
    }
}

function updateHost($org_name, $event_id)
{   try{
    global $db;

    $query = "UPDATE Host SET org_name='$org_name' WHERE event_id=$event_id";

    $statement = $db->prepare($query);

    $statement->bindValue(':event_id', $event_id);
    $statement->bindValue(':org_name', $org_name);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding to host');
    }
}

function deleteHost($event_id)
{   try{
    global $db;

    $query = "DELETE from Host WHERE event_id=$event_id";

    $statement = $db->prepare($query);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding to host');
    }
}


function getAllEventsByDate()
{
    try{
    global $db;

    $query = "SELECT DISTINCT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id ORDER BY Event_by_id.date_of_event, Event_by_id.name, Host.org_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();
    
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting all events');
    }
}

function getAllEventsByName()
{
    try{
    global $db;

    $query = "SELECT DISTINCT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id ORDER BY Event_by_id.name, Event_by_id.date_of_event, Host.org_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();
    
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting all events');
    }
}

function getAllEventsByOrg()
{
    try{
    global $db;

    $query = "SELECT DISTINCT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id ORDER BY Host.org_name, Event_by_id.name, Event_by_id.date_of_event";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();
    
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting all events');
    }
}

function getEventDetail($event_id)
{
    try{
    global $db;

    $query = "SELECT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id AND Event_by_id.Event_id=:event_id";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $results = $statement->fetchAll();
    //print($event_id);
    $statement->closeCursor();
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting event details');
    }
}

function getEventAudience($event_id)
{
    try{
    global $db;

    $query = "SELECT * FROM Event_by_id,Event_audience WHERE Event_by_id.event_id = Event_audience.event_id AND Event_by_id.event_id=:event_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting audience');
    }
}

function getEventCategories($event_id)
{
    try{
    global $db;

    $query = "SELECT * FROM Event_by_id,Event_categories WHERE Event_by_id.event_id = Event_categories.event_id AND Event_by_id.event_id=:event_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting event categories');
    }
}


function getEventRestrictions($event_id)
{
    try{
    global $db;

    $query = "SELECT * FROM Event_by_id,Event_restrictions WHERE Event_by_id.event_id = Event_restrictions.event_id AND Event_by_id.event_id=:event_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting restrictions');
    }
}
//TODO: make get username and get password function
function getUserCredentials($userName,$userpassword)
{ //not finished
    //HASH THE PASSWORDS FIJI DONT FORGET, YA STUPID!
    try{
    global $db;
    //Prep SQL query
    $query = "SELECT comp_id, pword FROM User_by_id WHERE comp_id=:userName";
    $statement = $db->prepare($query);
//$statement =; //Prep statement and bind Values
    $statement->bindValue(':userName',$userName);

    $paramUsername = $userName;
    $execStatement = $statement->execute();
    if($execStatement){
        if($statement->rowCount()==1){
            $userData = $statement->fetch();
            $userName = $userData["comp_id"];
            //uncomment after hashing passwords
            $hashPass = $userData["pword"];
            // echo "gets item";
            // echo $userName;
            // echo $hashPass;
            if(password_verify($userpassword,$hashPass)){
                //if correct, return all data, but send password hashed
                //echo "this runs";
                $statement->closeCursor();    
                return $userData;
            }
            else{
                $statement->closeCursor();    
                return -1;//"invalid user or pass"
            }

            }
            else{
                echo $execStatement;
                echo "rowcount issue";
                return -4;
            }
        }
    else{
        echo "ohno";
        return -3;//"server error"
    }
} 
    //$results = $statement->fetch();
catch(PDOException $execption){
    throw new Exception($execption->getMessage(), (int)$execption->getCode());
}    
catch(Exception $execpt){
        throw new Exception($statement->error);
        print_r($db->errorInfo());
    }
}
function addNewUser($desiredName,$desiredpassword)
{ //register a new user
    //post username and hashed pw to db
    //this will be an insert method
    //HASH THE PASSWORDS FIJI DONT FORGET, YA STUPID!
    try{
    global $db;
    //Prep SQL query
    $query = "SELECT comp_id, pword FROM User_by_id WHERE comp_id=:givenUName AND pword=:givenPword";
    $statement = $db->prepare($query);
//$statement =; //Prep statement and bind Values
    $statement->bindValue(':givenUName',$userName);
    $statement->bindValue(':givenPword',$userpassword);

    $paramUsername = $userName;
    $execStatement = $statement->execute();
    if($execStatement){
        if($statement->rowCount()==1){
            $userData = $statement->fetch();
            $userName = $userData["comp_id"];
            //uncomment after hashing passwords
            $hashPass = $userData["pword"];
            echo "gets item";
            echo $userName;
            if($userpassword==$hashPass/*password_verify($userpassword,$hashPass)*/){
                //if correct, return all data, but send password hashed
                echo "this runs";
                $statement->closeCursor();    
                return $userData;
            }
            else{
                $statement->closeCursor();    
                return -1;//"invalid user or pass"
            }

            }
            else{
                echo $execStatement;
                echo "rowcount issue";
                return -4;
            }
        }
    else{
        echo "ohno";
        return -3;//"server error"
    }
} 
    //$results = $statement->fetch();
catch(PDOException $execption){
    throw new Exception($execption->getMessage(), (int)$execption->getCode());
}    
catch(Exception $execpt){
        throw new Exception($statement->error);
        print_r($db->errorInfo());
    }
}
?>
