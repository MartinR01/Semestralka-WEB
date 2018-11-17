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

  $dns = "mysql:host=$host;dbname=$dbname";



  try {
  	$db = new PDO($dns,$username,$password);
  	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $dotaz = $db->prepare('SELECT * FROM test');
    $dotaz->execute();
    $result = $dotaz->fetch(PDO::FETCH_ASSOC); // jinak to duplikuje data

    print_r($result);

  } catch(PDOException $e){
  	echo "Error: " . $e->getMessage();
  }


  if(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'movie':
        $sablona='movie.twig';
        $data['title'] = 'Revenant';
        $data['poster'] = 'poster.jpeg';
        $data['info'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        $data['actors'] = 'Jakie Chan';
        $data['comments'] = $result['text'];
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
