<?php
require_once 'php/Movie.class.php';
require_once 'php/User.class.php';
session_start();


function favorite(){
    $movie = new Movie($_POST['movieID']);
    $movie->toggleFavorite();
}

function comment(){
    $db = DB::getInstance();
    $db->movieAddComment($_POST['movieID'], $_SESSION['id'],  $_POST['text']);
}

function rate(){
    $db = DB::getInstance();
    $db->movieAddRating($_POST['movieID'], $_SESSION['id'], $_POST['rating'], $_POST['text']);
}

function deleteUser(){
    User::deleteUser($_POST['userID']);
}

function toggleAdmin(){
    return User::toggleAdmin($_POST['userID']);
}

// choose correct action
switch ($_POST['action']){
    case 'favorite': favorite(); break;
    case 'comment': comment(); break;
    case 'rate': rate(); break;
    case 'deleteUser': deleteUser(); break;
    case 'toggleAdmin':toggleAdmin();break;
}
