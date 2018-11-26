<?php
    require_once 'DB.class.php';

    class Movie{
        private $db;
        public $id;
        public $title;
        public $poster;
        public $info;
        public $genre;
        public $actors;
        public $comments;
        public $rating;

        public $isFavorite;
        public $userRating;


        public function __construct($id){
            $this->id = $id;
            $this->db = DB::getInstance();

            // general info
            $result = $this->db->query(Query::getMovie,array('id' => $id ))->fetch(PDO::FETCH_ASSOC);
            $this->title = $result['titul'];
            $this->poster = 'images/movie_posters/'.$result['plakat_url'];
            $this->info = $result['popis'];
            $this->genre = $result['zanr'];

            // actors
            $this->actors = $this->db->query(Query::movieActors, array('id' => $id))->fetchAll(PDO::FETCH_ASSOC);
            // comments
            $this->comments = $this->db->query(Query::movieComments,array('id' => $this->id))->fetchAll(PDO::FETCH_ASSOC);
            // average rating
            $this->rating = $this->db->query(Query::movieGetAvgRating, array('movieID' => $id))->fetchColumn();


            // user logged in
            if(isset($_SESSION['id'])){
                // user rating
                $this->userRating = DB::getInstance()->query(Query::movieGetUserRating, array('movieID' => $_GET['id'], 'userID' => $_SESSION['id']))->fetchColumn();
                // favorite
                $this->isFavorite  = $this->db->query(Query::movieIsFaved, array('userID' => $_SESSION['id'], 'movieID' => $id ))->fetchColumn();
            }
        }

        public function toggleFavorite(){
            if($this->isFavorite == 1){
                $this->db->query(Query::movieDeleteFav, array('movieID' => $this->id, 'userID' => $_SESSION['id']));
            } else {
                $this->db->query(Query::movieAddFav, array('movieID' => $this->id, 'userID' => $_SESSION['id']));
            }
        }

    }
 ?>
