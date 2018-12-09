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
            $result = $this->db->getMovie($id);
            $this->title = $result['titul'];
            $this->poster = 'images/movie/'.$result['plakat_url'];
            $this->info = $result['popis'];
            $this->genre = $result['zanr'];

            // actors
            $this->actors = $this->db->getMovieActors($id);
            // comments
            $this->comments = $this->db->getMovieComments($id);
            // average rating
            $this->rating = $this->db->getMovieAvgRating($id);


            // user logged in
            if(isset($_SESSION['id'])){
                // user rating
                $this->userRating = $this->db->getMovieUserRating($id, $_SESSION['id']);
                // favorite
                $this->isFavorite  = $this->db->isMovieFaved($id, $_SESSION['id']);
            }
        }

        public function toggleFavorite(){
            if($this->isFavorite == 1){
                $this->db->movieDeleteFav($this->id, $_SESSION['id']);
            } else {
                $this->db->movieAddFav($this->id, $_SESSION['id']);
            }
        }

    }
 ?>
