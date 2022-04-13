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
    $query = "UPDATE Event_by_id SET name=$name, time_start=$time_start, time_end=$time_end, building=$building, room=$room, date_of_event=$date_of_event, cost=$cost, food=$food  WHERE event_id=$event_id";
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
    echo "this ran";

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
    foreach($event_id as $id_number) {
        echo $id_number;
        echo "this is a loop";
    }
   
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

    $query = "UPDATE Event_restrictions SET restrictions=$restrictions WHERE event_id=$event_id";
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

    $query = "UPDATE Event_categories SET categories=$categories WHERE event_id=$event_id";
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

    $query = "UPDATE Event_audience SET audience=$audience WHERE event_id=$event_id";
    // $query = "INSERT INTO Event_audience VALUES (:event_id, :audience)";

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

    $query = "UPDATE Host SET org_name=$org_name WHERE event_id=$event_id";
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


function getAllEvents()
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

function getZombie_byName($name)
{
    try{
    global $db;

    $query = "SELECT * FROM zombies WHERE name = :name";

    // 1. prepare

    // 2. bindValue & execute

    // Prepare and bindValue helps protect against
    // SQL injection attacks

    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);

    $statement->execute();

    // $statement = $db->query($query);

    $results = $statement->fetch();

    $statement->closeCursor();

    return $results;
    }
    catch(Exception $execpt){
        throw new Exception('Error getting Zombie by name');
    }
}

?>
