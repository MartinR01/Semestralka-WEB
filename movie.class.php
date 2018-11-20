<?php
  require_once 'DB.class.php';

  class Movie{
    public $title;
    public $poster;
    public $info;
    public $genre;
    public $isFavorite;


    public function __construct($id){
      $db = DB::getInstance();
      $result = $db->query('getMovie',array('id' => $id ));

      $this->title = $result['titul'];
      $this->poster = 'images/movie_posters/'.$result['plakat_url'];
      $this->info = $result['popis'];
      $this->genre = $result['zanr'];

      $result = $db->query('movieIsFaved', array('userID' => 1, 'movieID' => $id ), true);
      $this->isFavorite = $result;
    }

  }
 ?>
