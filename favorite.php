<?php
require_once 'Movie.class.php';


function favorite(){
    $movie = new Movie($_POST['movieID']);
    $movie->toggleFavorite();
}

function comment(){
    $db = DB::getInstance();
    $db->query(Query::movieAddComment, array('movieID' => $_POST['movieID'], 'userID' => $_POST['userID'], 'text' => $_POST['text']));
}

// choose correct action
switch ($_POST['action']){
    case 'favorite': favorite(); break;
    case 'comment': comment(); break;
}