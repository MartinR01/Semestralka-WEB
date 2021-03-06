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
            $this->poster = $result['plakat_url'];
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

        public static function createMovie($name, $poster_url, $description, $year, $country, $genreID, $actors){
            var_dump($actors);
            $db = DB::getInstance();
            $insertID = $db->addMovie($name, $poster_url, $description, $year, $country, $genreID);
            foreach ($actors as $actor){
                if($actor['id'] != null){
                    $db->addRole($actor['id'], $insertID, $actor['role']);
                }
            }
            header("Location: index.php?page=movie&id=".$insertID);
        }

        public static function addRating($movieID, $rating, $text){
            if($rating >= 1 && $rating <= 5){
                DB::getInstance()->movieAddRating($movieID,$_SESSION['id'], $rating, $text);
                $response['status']='success';
            } else {
                $response['status']='error';
                $response['message']="Rating must be between 1 and 5 stars!";
            }
            echo json_encode($response);
        }

    }
 ?>
