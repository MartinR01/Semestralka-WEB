<?php
  require_once 'DB.class.php';

  class Movie{
    public $id;
    public $title;
    public $poster;
    public $info;
    public $genre;
    public $isFavorite;
    public $actors;


    public function __construct($id){
      $this->id = $id;
      $db = DB::getInstance();
      $result = $db->query('getMovie',array('id' => $id ))->fetch(PDO::FETCH_ASSOC);

      $this->title = $result['titul'];
      $this->poster = 'images/movie_posters/'.$result['plakat_url'];
      $this->info = $result['popis'];
      $this->genre = $result['zanr'];

      $result = $db->query('movieIsFaved', array('userID' => 1, 'movieID' => $id ))->fetchColumn();
      $this->isFavorite = $result;

      $this->actors = $db->query('movieActors', array('movieID' => $id))->fetchAll(PDO::FETCH_ASSOC);
    }

  }
 ?>
