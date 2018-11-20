<?php
  class Actor{
    public $id;
    public $name;
    public $bio;
    public $photo;
    public $movies;

    public function __construct($id){
      $this->id = $id;
      $db = DB::getInstance();
      $data = $db->query('getActor', array('id' => $id ))->fetch(PDO::FETCH_ASSOC);

      $this->name = $data['jmeno'];
      $this->bio = $data['bio'];
      $this->photo = 'images/actors/'.$data['foto_url'];

      $this->movies = $db->query('actorMovieRoles', array('id' => $id))->fetchAll(PDO::FETCH_ASSOC);
    }
  }
?>
