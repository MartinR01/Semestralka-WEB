<?php
  require_once 'vendor/autoload.php';

  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader); // no cache

  $data = array();
  
  if(isset($_GET['page'])){
    switch ($_GET['page']) {
      case 'movie':
        $sablona='movie.twig';
        $data['title'] = 'Revenant';
        $data['poster'] = 'poster.jpeg';
        $data['info'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        $data['actors'] = 'Jakie Chan';
        $data['comments'] = 'Love this movie';
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
