<?php
  class DB{

    public $db;
    public static $INSTANCE = false;

    private static $queries = array(
      'getMovie' => 'SELECT film.nazev AS titul, zanr.nazev AS zanr, popis, plakat_url FROM film JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE idFilm=:id',
      'getActor' => 'SELECT * FROM herec WHERE idHerec=:id',

      'movieIsFaved' => 'SELECT COUNT(*) FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
      'movieDeleteFav' => 'DELETE FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
      'movieAddFav' => 'INSERT INTO oblibene_filmy (Film_idFilm, Uzivatel_idUzivatel) VALUES (:movieID,:userID)',
      'movieActors' => 'SELECT * FROM herec JOIN hraje ON hraje.Herec_idHerec=herec.idHerec WHERE hraje.Film_idFilm=:movieID',

      'userFavs' => 'SELECT * FROM oblibene_filmy JOIN film ON film.idFilm=oblibene_filmy.Film_idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE oblibene_filmy.Uzivatel_idUzivatel=:userID',

      'actorMovieRoles' => 'SELECT * FROM film JOIN hraje ON hraje.Film_idFilm=film.idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE hraje.Herec_idHerec=:actorID'
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

    public static function getInstance(){
      if(DB::$INSTANCE == false){
        DB::$INSTANCE = new DB;
      }
      return DB::$INSTANCE;
    }

    public function query($query, $arguments, $oneValue = false){
      $dotaz = $this->db->prepare(self::$queries[$query]);
      $dotaz->execute($arguments);

      if($oneValue == true){
        return $dotaz->fetchColumn(); // vrátí první sloupec v prvním řádku
      } else {
        return $dotaz->fetch(PDO::FETCH_ASSOC); // jinak to duplikuje data
      }
    }
  }
?>
