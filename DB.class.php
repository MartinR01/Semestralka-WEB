<?php
    class Query{
        const getMovie =            'getMovie';
        const getActor =            'getActor';

        const movieIsFaved =        'movieIsFaved';
        const movieDeleteFav =      'movieDeleteFav';
        const movieAddFav =         'movieAddFav';
        const movieActors =         'movieActors';
        const movieComments =       'movieComments';
        const movieAddComment =     'movieAddComment';
        const movieAddRating =      'movieAddRating';
        const movieGetUserRating =  'movieGetUserRating';
        const movieGetAvgRating =   'movieGetAvgRating';

        const registerUser =        'registerUser';
        const loginUser =           'loginUser';

        const userFavs =            'userFavs';
        const actorMovieRoles =     'actorMovieRoles';
    }

  class DB{
    private $db;
    public static $INSTANCE;

      private static $queries = array(
          'getMovie' =>             'SELECT film.nazev AS titul, zanr.nazev AS zanr, popis, plakat_url FROM film JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE idFilm=:id',
          'getActor' =>             'SELECT * FROM herec WHERE idHerec=:id',

          'movieIsFaved' =>         'SELECT COUNT(*) FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
          'movieDeleteFav' =>       'DELETE FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID',
          'movieAddFav' =>          'INSERT INTO oblibene_filmy (Film_idFilm, Uzivatel_idUzivatel) VALUES (:movieID,:userID)',
          'movieActors' =>          'SELECT Herec_idHerec AS id, role, jmeno FROM hraje JOIN herec ON herec.idHerec=hraje.Herec_idHerec WHERE hraje.Film_idFilm=:id',
          'movieComments' =>        'SELECT Uzivatel_idUzivatel, text, datum, uzivatel.jmeno FROM komentar JOIN uzivatel ON uzivatel.idUzivatel=komentar.Uzivatel_idUzivatel WHERE Film_idFilm=:id ORDER BY datum ',
          'movieAddComment' =>      'INSERT INTO komentar (Film_idFilm, Uzivatel_idUzivatel, text, datum) VALUES (:movieID, :userID, :text, NOW())',
          'movieAddRating' =>       'INSERT INTO hodnoceni (Film_idFilm, Uzivatel_idUzivatel, pocet_hvezdicek, text, datum) VALUES (:movieID, :userID, :rating, :text, NOW()) ON DUPLICATE KEY UPDATE pocet_hvezdicek=:rating, text=:text, datum=NOW()',
          'movieGetUserRating' =>   'SELECT pocet_hvezdicek FROM hodnoceni WHERE Uzivatel_idUzivatel=:userID AND Film_idFilm=:movieID',
          'movieGetAvgRating' =>    'SELECT AVG(pocet_hvezdicek) FROM hodnoceni WHERE Film_idFilm=:movieID',

          'registerUser' =>         'INSERT INTO uzivatel (jmeno, heslo) VALUES (:username, :password)',
          'loginUser' =>            'SELECT idUzivatel AS id,heslo FROM uzivatel WHERE jmeno=:username',

          'userFavs' =>             'SELECT * FROM oblibene_filmy JOIN film ON film.idFilm=oblibene_filmy.Film_idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE oblibene_filmy.Uzivatel_idUzivatel=:id',
          'actorMovieRoles' =>      'SELECT idFilm AS id, film.nazev AS nazev, role FROM film JOIN hraje ON hraje.Film_idFilm=film.idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE hraje.Herec_idHerec=:id'
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

    public function query($query, $arguments){


        $dotaz = $this->db->prepare(self::$queries[$query]);
        $dotaz->execute($arguments);

        return $dotaz;

    }
  }
?>
