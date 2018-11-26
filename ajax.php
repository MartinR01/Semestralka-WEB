<?php
require_once 'Movie.php';
session_start();


function favorite(){
    $movie = new Movie($_POST['movieID']);
    $movie->toggleFavorite();
}

function comment(){
    $db = DB::getInstance();
    $db->query(Query::movieAddComment, array('movieID' => $_POST['movieID'], 'userID' => $_SESSION['id'], 'text' => $_POST['text']));
}

function rate(){
    $db = DB::getInstance();
    $db->query(Query::movieAddRating, array('movieID' => $_POST['movieID'], 'userID' => $_SESSION['id'], 'text' => $_POST['text'], 'rating' => $_POST['rating']));
}

// choose correct action
switch ($_POST['action']){
    case 'favorite': favorite(); break;
    case 'comment': comment(); break;
    case 'rate': rate(); break;
}