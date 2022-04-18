<?php

function getLatestEventId()
{
    try{
    global $db;

    $query = "SELECT MAX(event_ID) FROM Event_by_id";

    $statement = $db->prepare($query);
    
    $statement->execute();
    
    $results = $statement->fetch()[0];

    $statement->closeCursor();
    
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting latest Event ID');
    }

}
function deleteEvent_subscriptions($event_id)
{

 try{
    global $db;

    $query = "DELETE from Subscribes_to WHERE event_id=:event_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':event_id', $event_id);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error deleting subscriptions');
    }

}

function addToEvent_By_ID($name, $time_start, $time_end, $building, $room, $date_of_event, $cost, $food)
{
    //db handler
    // the db handler is in connect-db
    // keyword global allows us to access db in connect-db
    try{
    global $db;

    print "<pre>";
    print_r ($name);
    print_r (gettype($name));
    print_r ($time_start);
    print_r (gettype($time_start));
    print_r ($time_end);
    print_r (gettype($time_end));
    print_r ($building);
    print_r (gettype($building));
    print_r ($room);
    print_r (gettype($room));
    print_r ($date_of_event);
    print_r (gettype($date_of_event));
    print_r ($cost);
    print_r (gettype($cost));
    print_r ($food);
    // print_r (gettype($food));
    // print_r ($org_name);
    // print_r (gettype($org_name));
    // print_r ($audience);
    // print_r (gettype($audience));
    // print_r ($categories);
    // print_r (gettype($categories));
    // print_r ($restrictions);
    // print_r (gettype($restrictions));
    // print_r ($latest_event_id);
    // print_r (gettype($latest_event_id));
    print "</pre>";


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

function addInterest($interest, $user_id)
{
    //db handler
    // the db handler is in connect-db
    // keyword global allows us to access db in connect-db
    try{
    global $db;

    //sql
    $query = "INSERT INTO User_Interests (comp_id, interest) VALUES (:user_id, :interest)";

    //execute
    $statement = $db->prepare($query);

    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':interest', $interest);

    $statement->execute();

    //$statement = $db->query($query);

    //release
    $statement->closeCursor();}
    catch(Exception $execpt){
        throw new Exception('Error adding to interests');
    }
}

function getUsersEventInterests($user_id)
{
    //db handler
    // the db handler is in connect-db
    // keyword global allows us to access db in connect-db
    try{
    global $db;

    //sql
    $query = "SELECT * FROM Event_by_id, Event_categories WHERE Event_by_id.event_id = Event_categories.event_id AND Event_by_id.date_of_event >= ALL (SELECT curdate()) AND Event_categories.category_name IN (SELECT interest FROM User_Interests WHERE User_Interests.comp_id = :user_id) AND Event_by_id.event_id NOT IN (SELECT event_id FROM Subscribes_to WHERE Subscribes_to.comp_id = :user_id)";

    //execute
    $statement = $db->prepare($query);

    $statement->bindValue(':user_id', $user_id);

    $statement->execute();
    

    //$statement = $db->query($query);

    //release
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
    }

    catch(Exception $execpt){
        throw new Exception('Error adding to interests');
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

function addToSub($event_id,$userId)
{   try{
    // print_r($event_id);
    // print_r($userId);
    global $db;

    $query = "INSERT INTO Subscribes_to VALUES (:userId, :event_id)";

    $statement = $db->prepare($query);

    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':event_id', $event_id);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error adding to Subscribes to');
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

function removeFromSub($event_id,$userID)
{   try{
    global $db;

    $query = "DELETE from Subscribes_to WHERE comp_id = :userID AND event_id=:event_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':event_id', $event_id);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error deleting from subscribes to');
    }
}


function registerOrg($name, $email, $description) {
   try{
    global $db;

    $query = "INSERT INTO Organization VALUES (:name, :email, :description)";

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':description', $description);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error inserting into organization table');
    }
}


function deleteMember($comp_id) {
    try{
 
    global $db;
    echo 'I am in delete member';
    echo $comp_id;
    $query = "DELETE * FROM Is_member WHERE comp_id = :comp_id";

    $statement = $db->prepare($query);
    $statement->bindValue(':comp_id', $comp_id);
    $statement->execute();
    $statement->closeCursor();
}
     catch(Exception $execpt){
        throw new Exception('Error inserting into organization table');
    }
}

function addMemberAsExec($comp_id, $org_name) {
    try{
 
    global $db;
    $yes = 'yes';
    deleteMember($comp_id);
    echo "this got here";
    echo $comp_id;
    echo $org_name;
    $query = "INSERT INTO Is_member VALUES (:comp_id, :org_name, $yes)";

    $statement = $db->prepare($query);
    $statement->bindValue(':comp_id', $comp_id);
    $statement->bindValue(':org_name', $org_name);

    $statement->execute();

    $statement->closeCursor();
    }
    catch(Exception $execpt){
        throw new Exception('Error inserting into organization table');
    }
}

function getAllOrgs()
{
    try{
    global $db;

    $query = "SELECT DISTINCT org_name FROM Host ORDER BY org_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks
    // $statement->bindValue(':org', $event_id);
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


function getAllCats()
{
    try{
    global $db;

    $query = "SELECT DISTINCT category_name FROM Event_categories ORDER BY category_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks
    // $statement->bindValue(':org', $event_id);
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

function getUserSubs($userID)
{
    try{
    global $db;

    $query = "SELECT DISTINCT * FROM Event_by_id,Host,Subscribes_to WHERE Event_by_id.event_id = Host.event_id AND Event_by_id.event_id = Subscribes_to.event_id AND Subscribes_to.comp_id = :userID ORDER BY Event_by_id.date_of_event, Event_by_id.name, Host.org_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();
    
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting all events');
    }
}

function getUserOrgs($user_id)
{   try{
    global $db;

    $query = "SELECT DISTINCT * from Is_member WHERE comp_id='$user_id'";

    $statement = $db->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    $statement->closeCursor();

    return $result;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting user\'s organizations');
    }
}

function removeUserInterest($userID, $interest)
{   try{
    global $db;

    $query = "DELETE from User_Interests WHERE comp_id = :userID AND interest=:interest";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':interest', $interest);

    $statement->execute();

    $statement->closeCursor();

    }
    catch(Exception $execpt){
        throw new Exception('Error removing user interest');
    }
}

function removeUserOrg($userID, $org_name)
{   try{
    global $db;

    $query = "DELETE from Is_member WHERE comp_id = :userID AND org_name=:org_name";

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':org_name', $org_name);

    $statement->execute();

    $statement->closeCursor();

    }
    catch(Exception $execpt){
        throw new Exception('Error removing user from org');
    }
}

function getUserInterests($user_id)
{   try{
    global $db;

    $query = "SELECT DISTINCT * from User_Interests WHERE comp_id='$user_id'";

    $statement = $db->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    $statement->closeCursor();

    return $result;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting user\'s organizations');
    }
}

function getAllEventsByDate()
{
    try{
    global $db;

    $query = "SELECT DISTINCT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id AND Event_by_id.date_of_event >= ALL (SELECT curdate()) ORDER BY Event_by_id.date_of_event, Event_by_id.name, Host.org_name";

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

    $query = "SELECT DISTINCT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id AND Event_by_id.date_of_event >= ALL (SELECT curdate()) ORDER BY Event_by_id.name, Event_by_id.date_of_event, Host.org_name";
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

    $query = "SELECT DISTINCT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id AND Event_by_id.date_of_event >= ALL (SELECT curdate()) ORDER BY Host.org_name, Event_by_id.name, Event_by_id.date_of_event";

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
function getOrgDetail($org_name)
{
    try{
    global $db;
    // print_r($org_name);
    $query = "SELECT * FROM Organization WHERE Organization.org_name = :org_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->bindValue(':org_name', $org_name);
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

// function getOrgMembership($org_name,$user_id)
// {
//     try{
//     global $db;
//     // print_r($org_name);
//     $query = "SELECT * FROM Organization,Is_member WHERE rganization.org_name = Is_member.org_name AND Is_member.comp_id = :user_id AND Organization.org_name = :org_name";

//     // 1. prepare

//     // 2. bindValue & execute

//     // Prepare and bindValue helps protect against
//     // SQL injection attacks

//     $statement = $db->prepare($query);
//     $statement->bindValue(':user_id', $user_id);
//     $statement->bindValue(':org_name', $org_name);
//     $statement->execute();
//     $results = $statement->fetchAll();
//     //print($event_id);
//     $statement->closeCursor();
//     return $results;
//     }
//     catch(Exception $execpt){
//         throw new Exception('Error getting event details');
//     }
// }

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

function getEventsByOrg($org_name)
{
    try{
    global $db;
    //print_r($org_name);
    $query = "SELECT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id AND Event_by_id.date_of_event >= ALL (SELECT curdate()) AND Host.org_name = :org_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->bindValue(':org_name', $org_name);
    $statement->execute();
    $results = $statement->fetchAll();
    //print($event_id);
    $statement->closeCursor();
    //print($results);
    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting event details');
    }
}

function getEventsByCat($cat_name)
{
    try{
    global $db;
    //print_r($org_name);
    $query = "SELECT * FROM Event_by_id,Event_categories,Host WHERE Event_by_id.event_id = Event_categories.event_id AND Event_by_id.date_of_event >= ALL (SELECT curdate()) AND Event_by_id.event_id = Host.event_id AND Event_categories.category_name = :cat_name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->bindValue(':cat_name', $cat_name);
    $statement->execute();
    $results = $statement->fetchAll();
    //print($event_id);
    $statement->closeCursor();
    //print($results);
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

function getUserExecRoles($userID,$event_id)
{
    try{
    global $db;
    // print_r($userID);
    // print_r($event_id);
    $query = "SELECT DISTINCT * FROM Event_by_id, Is_member, Host WHERE Event_by_id.event_id = Host.event_id AND Host.org_name = Is_member.org_name AND Is_member.comp_id = :userID AND Event_by_id.event_id = :event_id AND Is_member.is_exec = \"Yes\"";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':event_id', $event_id);
    $statement->execute();
    $results = $statement->fetchAll();

    $statement->closeCursor();

    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting all events');
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
