<?php
  require_once 'vendor/autoload.php'; // twig

  require_once 'DB.class.php';
  require_once 'movie.class.php';

  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader); // no cache

  $userID=1;
  $data = array();

  $database = DB::getInstance();



  if(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'movie':
        $result = new Movie($_GET['id']);
        $sablona='movie.twig';
        $data = (array)$result;
        break;

      case 'actor':
        try {
          $result = $database->query('getActor',array('id' => $_GET['id'] ));

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
