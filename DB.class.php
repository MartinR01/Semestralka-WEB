<?php
  class DB{
    private $db;
    public static $INSTANCE = false;

    private static $queries = array(
      'getMovie' => 'SELECT film.nazev AS titul, zanr.nazev AS zanr, popis, plakat_url FROM film JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE idFilm=:id',
      'getActor' => 'SELECT * FROM herec WHERE idHerec=:id',

      'movieIsFaved' => 'SELECT COUNT(*) FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
      'movieDeleteFav' => 'DELETE FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
      'movieAddFav' => 'INSERT INTO oblibene_filmy (Film_idFilm, Uzivatel_idUzivatel) VALUES (:movieID,:userID)',
      'movieActors' => 'SELECT Herec_idHerec AS id, role, jmeno FROM hraje JOIN herec ON herec.idHerec=hraje.Herec_idHerec WHERE hraje.Film_idFilm=:id',

      'userFavs' => 'SELECT * FROM oblibene_filmy JOIN film ON film.idFilm=oblibene_filmy.Film_idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE oblibene_filmy.Uzivatel_idUzivatel=:id',

      'actorMovieRoles' => 'SELECT idFilm AS id, film.nazev AS nazev, role FROM film JOIN hraje ON hraje.Film_idFilm=film.idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE hraje.Herec_idHerec=:id'
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

      return $dotaz;

    }
  }
?>
