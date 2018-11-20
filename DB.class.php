<?php
  class DB{

    public $db;
    public static $INSTANCE = false;

    private static $queries = array(
      'getMovie' => 'SELECT film.nazev AS titul, zanr.nazev AS zanr, popis, plakat_url FROM film JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE idFilm=:id',
      'getActor' => 'SELECT * FROM herec WHERE idHerec=:id'

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

    public function query($query, $arguments){
      $dotaz = $this->db->prepare(self::$queries[$query]);
      $dotaz->execute($arguments);
      return $dotaz->fetch(PDO::FETCH_ASSOC); // jinak to duplikuje data
    }
  }
?>
