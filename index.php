<?php
  require_once 'vendor/autoload.php'; // twig

  require_once 'DB.class.php';
  require_once 'Movie.class.php';
  require_once 'Actor.class.php';

  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader); // no cache

  $userID=1;
  $data = array();

  if(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'movie':
        $result = new Movie($_GET['id']);
        $sablona='movie.twig';
        $data = (array)$result;
//         echo '<pre>';
//           var_dump($result->comments);
//          echo '</pre>';
        break;

      case 'actor':
        $result = new Actor($_GET['id']);
        $sablona='actor.twig';
        $data = (array)$result;

        break;

      default:
        $sablona = "home.twig";
        break;
    }
  }else{
    $sablona = "home.twig";
  }

try {
    echo $twig->render($sablona, $data);
} catch (Twig_Error_Loader $e) {
} catch (Twig_Error_Runtime $e) {
} catch (Twig_Error_Syntax $e) {
}
?>