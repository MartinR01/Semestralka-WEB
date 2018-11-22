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
    public $comments;
    public $rating;


    public function __construct($id){
      $this->id = $id;
      $db = DB::getInstance();
      $result = $db->query(Query::getMovie,array('id' => $id ))->fetch(PDO::FETCH_ASSOC);

      $this->title = $result['titul'];
      $this->poster = 'images/movie_posters/'.$result['plakat_url'];
      $this->info = $result['popis'];
      $this->genre = $result['zanr'];

      $result = $db->query(Query::movieIsFaved, array('userID' => 1, 'movieID' => $id ))->fetchColumn();
      $this->isFavorite = $result;

      $this->actors = $db->query(Query::movieActors, array('id' => $id))->fetchAll(PDO::FETCH_ASSOC);

      $this->loadComments();

      $this->rating = $db->query(Query::movieGetAvgRating, array('movieID' => $id))->fetchColumn();
    }

    public function toggleFavorite(){
        $db = DB::getInstance();
        if($this->isFavorite == 1){
          $db->query(Query::movieDeleteFav, array('movieID' => $this->id, 'userID' => 1));
        } else {
          $db->query(Query::movieAddFav, array('movieID' => $this->id, 'userID' => 1));
        }
    }

    public function loadComments(){
        $db = DB::getInstance();
        $this->comments = $db->query(Query::movieComments,array('id' => $this->id))->fetchAll(PDO::FETCH_ASSOC);
    }

  }
 ?>
