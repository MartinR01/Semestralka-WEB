<?php
  class DB{
    private $db;
    public static $INSTANCE;

      private static $queries = array(
          'getMovie' =>             'SELECT film.nazev AS titul, zanr.nazev AS zanr, popis, plakat_url FROM film JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE idFilm=:movieID',
          'getActor' =>             'SELECT * FROM herec WHERE idHerec=:actorID',

          'movieIsFaved' =>         'SELECT COUNT(*) FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
          'movieDeleteFav' =>       'DELETE FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
          'movieAddFav' =>          'INSERT INTO oblibene_filmy (Film_idFilm, Uzivatel_idUzivatel) VALUES (:movieID,:userID)',
          'movieActors' =>          'SELECT Herec_idHerec AS id, role, jmeno FROM hraje JOIN herec ON herec.idHerec=hraje.Herec_idHerec WHERE hraje.Film_idFilm=:movieID',
          'movieComments' =>        'SELECT Uzivatel_idUzivatel, text, datum, uzivatel.jmeno FROM komentar JOIN uzivatel ON uzivatel.idUzivatel=komentar.Uzivatel_idUzivatel WHERE Film_idFilm=:movieID ORDER BY datum ',
          'movieAddComment' =>      'INSERT INTO komentar (Film_idFilm, Uzivatel_idUzivatel, text, datum) VALUES (:movieID, :userID, :text, NOW())',
          'movieAddRating' =>       'INSERT INTO hodnoceni (Film_idFilm, Uzivatel_idUzivatel, pocet_hvezdicek, text, datum) VALUES (:movieID, :userID, :rating, :text, NOW()) ON DUPLICATE KEY UPDATE pocet_hvezdicek=:rating, text=:text, datum=NOW()',
          'movieGetUserRating' =>   'SELECT pocet_hvezdicek FROM hodnoceni WHERE Uzivatel_idUzivatel=:userID AND Film_idFilm=:movieID',
          'movieGetAvgRating' =>    'SELECT AVG(pocet_hvezdicek) FROM hodnoceni WHERE Film_idFilm=:movieID',

          'registerUser' =>         'INSERT INTO uzivatel (jmeno, heslo) VALUES (:username, :password)',
          'loginUser' =>            'SELECT idUzivatel AS id,heslo FROM uzivatel WHERE jmeno=:username',

          'userFavs' =>             'SELECT * FROM oblibene_filmy JOIN film ON film.idFilm=oblibene_filmy.Film_idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE oblibene_filmy.Uzivatel_idUzivatel=:userID',
          'actorMovieRoles' =>      'SELECT idFilm AS id, film.nazev AS nazev, role FROM film JOIN hraje ON hraje.Film_idFilm=film.idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE hraje.Herec_idHerec=:actorID'
      );


    private function __construct(){
      //DB variables
      $host="localhost";
      $dbname="semestralka_db1";
      $username="root";
      $password="";
      $dns = "mysql:host=$host;dbname=$dbname;charset=utf8"; //charset pro české znaky!

      $this->db = new PDO($dns,$username,$password);
      $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

      /**
       * @return DB database class instance
       */
    public static function getInstance(){
      if(DB::$INSTANCE == false){
        DB::$INSTANCE = new DB;
      }
      return DB::$INSTANCE;
    }

    public function getMovie($movieID){
        return $this->query('getMovie', compact("movieID"))->fetch(PDO::FETCH_ASSOC);
    }

    public function getMovieActors($movieID){
        return $this->query('movieActors', compact("movieID"))->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActor($actorID){
        return $this->query('getActor', compact("actorID"))->fetch(PDO::FETCH_ASSOC);
    }

    public function isMovieFaved($movieID, $userID){
        return $this->query('movieIsFaved', compact("userID", "movieID"))->fetchColumn();
    }

    public function movieDeleteFav($movieID, $userID){
        $this->query('movieDeleteFav', compact("userID", "movieID"));
    }

    public function movieAddFav($movieID, $userID){
        $this->query('movieAddFav', compact("userID", "movieID"));
    }

    public function movieAddComment($movieID, $userID, $text){
        $this->query('movieAddComment', compact("userID", "movieID", "text"));
    }

    public function movieAddRating($movieID, $userID, $rating, $text){
        $this->query('movieAddRating', compact("userID", "movieID", "rating", "text"));
    }

    public function getMovieUserRating($movieID, $userID){
        return $this->query('movieGetUserRating', compact("userID", "movieID"))->fetchColumn();
    }

    public function getMovieAvgRating($movieID){
        return $this->query('movieGetAvgRating', compact("movieID"))->fetchColumn();
    }

    public function getMovieComments($movieID){
        return $this->query('movieComments', compact("movieID"))->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerUser($username, $password){
        $this->query('registerUser', compact("username", "password"));
    }

    public function loginUser($username){
        return $this->query('loginUser', compact("username"))->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserFavs($userID){
        return $this->query('userFavs', compact("userID"))->fetch(PDO::FETCH_ASSOC);
    }

    public function getActorRoles($actorID){
        return $this->query('actorMovieRoles', compact("actorID"))->fetchAll(PDO::FETCH_ASSOC);
    }

    private function query($query, $arguments){
        $dotaz = $this->db->prepare(self::$queries[$query]);
        $dotaz->execute($arguments);

        return $dotaz;

    }
  }
?>
