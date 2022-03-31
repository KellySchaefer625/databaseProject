<?php

function addEvent($name, $time_start, $time_end, $building, $room, $date_of_event, $cost, $food)
{
    //db handler
    //the db handler is in connect-db
    // keyword global allows us to access db in connect-db
    global $db;

    //sql
    $query = "INSERT INTO Event_by_id 
         (name, time_start, time_end, building, room, date_of_event, cost, food) 
            VALUES (:name, :time_start, :time_end, :building, :room, :date_of_event, :cost, :food)";

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
    $statement->closeCursor();
}

function updateZombie($name, $Danger, $Speed)
{
    global $db;

    $query = "UPDATE zombies SET Danger=:Danger, Speed=:Speed WHERE name=:name";

    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);
    $statement->bindValue(':Danger', $Danger);
    $statement->bindValue(':Speed', $Speed);

    $statement->execute();

    $statement->closeCursor();

}

function deleteZombie($name, $Danger, $Speed)
{
    global $db;

    $query = "DELETE FROM zombies WHERE name=:name AND Danger=:Danger AND Speed=:Speed";

    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);
    $statement->bindValue(':Danger', $Danger);
    $statement->bindValue(':Speed', $Speed);

    $statement->execute();

    $statement->closeCursor();

}



function getAllEvents()
{

    global $db;

    $query = "SELECT DISTINCT * FROM Event_by_id,Host WHERE Event_by_id.event_id = Host.event_id ORDER BY Event_by_id.date_of_event";

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

function getZombie_byName($name)
{

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

?>