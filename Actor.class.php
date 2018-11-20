<?php
  class Actor{
    public $name;
    public $bio;
    public $photo;

    public function __construct($id){
      $data = DB::getInstance()->query('getActor', array('id' => $id ))->fetch(PDO::FETCH_ASSOC);

      $this->name = $data['jmeno'];
      $this->bio = $data['bio'];
      $this->photo = 'images/actors/'.$data['foto_url'];
    }
  }
?>
