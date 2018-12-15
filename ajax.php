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
    $text = strip_tags($_POST['text'],'<p><u><s><strong><a><ol><ul><li>');
    $db->movieAddComment($_POST['movieID'], $_SESSION['id'],  $text);
}

function rate(){
    return Movie::addRating($_POST['movieID'], $_POST['rating'], $_POST['text']);
}

function deleteUser(){
    return User::deleteUser($_POST['userID']);
}

function toggleAdmin(){
    return User::toggleAdmin($_POST['userID']);
}

function login(){
    return User::login($_POST['username'],$_POST['password']);
}

// choose correct action
switch ($_POST['action']){
    case 'favorite': favorite(); break;
    case 'comment': comment(); break;
    case 'rate': rate(); break;
    case 'deleteUser': deleteUser(); break;
    case 'toggleAdmin':toggleAdmin();break;
    case 'login':login();break;

}
