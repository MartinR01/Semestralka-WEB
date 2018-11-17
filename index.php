<?php
  require_once 'vendor/autoload.php';

  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader); // no cache

  $data = array();

  //DB variables
  $host="localhost";
  $dbname="semestralka_db1";
  $username="root";
  $password="";

  $dns = "mysql:host=$host;dbname=$dbname;charset=utf8"; //charset pro české znaky!



  try {
  	$db = new PDO($dns,$username,$password);
  	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $dotaz = $db->prepare('SELECT * FROM film WHERE idFilm=:id');
    $dotaz->bindParam(':id',$id);
    $id=$_GET['id'];
    $dotaz->execute();
    $result = $dotaz->fetch(PDO::FETCH_ASSOC); // jinak to duplikuje data

  } catch(PDOException $e){
  	echo "Error: " . $e->getMessage();
  }


  if(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'movie':
        $sablona='movie.twig';
        $data['title'] = $result['nazev'];
        $data['poster'] = 'images/movie_posters/'.$result['plakat_url'];
        $data['info'] = $result['popis'];
        $data['actors'] = 'Placeholder actor';
        $data['comments'] = 'Placeholder comment';
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
