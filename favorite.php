<?php
require_once 'Movie.class.php';

$movie = new Movie($_POST['movieID']);
$movie->toggleFavorite();