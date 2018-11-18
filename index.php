<?php
  require_once 'vendor/autoload.php';

  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader); // no cache

  $userID=1;
  $data = array();

  //DB variables
  $host="localhost";
  $dbname="semestralka_db1";
  $username="root";
  $password="";

  $dns = "mysql:host=$host;dbname=$dbname;charset=utf8"; //charset pro české znaky!

  $db = new PDO($dns,$username,$password);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);





  if(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'movie':
        try {
          $dotaz = $db->prepare('SELECT film.nazev AS titul, zanr.nazev AS zanr, plakat_url, popis FROM film JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE idFilm=:id');
          $dotaz->bindParam(':id',$id);
          $id=$_GET['id'];
          $dotaz->execute();
          $result = $dotaz->fetch(PDO::FETCH_ASSOC); // jinak to duplikuje data

        } catch(PDOException $e){
          echo "Error: " . $e->getMessage();
        }
        $sablona='movie.twig';
        $data['title'] = $result['titul'];
        $data['poster'] = 'images/movie_posters/'.$result['plakat_url'];
        $data['info'] = $result['popis'];
        $data['movieID'] = $id;
        $data['genre'] = $result['zanr'];
        $data['actors'] = 'Placeholder actor';
        $data['comments'] = 'Placeholder comment';
        break;

      case 'actor':
        try {
          $dotaz = $db->prepare('SELECT * FROM herec WHERE idHerec=:id');
          $dotaz->bindParam(':id',$id);
          $id=$_GET['id'];
          $dotaz->execute();
          $result = $dotaz->fetch(PDO::FETCH_ASSOC); // jinak to duplikuje data

          $sablona='actor.twig';
          $data['name'] = $result['jmeno'];
          $data['bio'] = $result['bio'];
          $data['photo'] = 'images/actors/'.$result['foto_url'];

        } catch(PDOException $e){
          echo "Error: " . $e->getMessage();
        }
        break;

      default:
        $sablona = "home.twig";
        break;
    }
  }else{
    $sablona = "home.twig";
  }

  $template = $twig->loadTemplate($sablona);
  echo $template->render($data);
?>
