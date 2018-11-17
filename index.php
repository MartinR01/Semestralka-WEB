<?php
  require_once 'vendor/autoload.php';

  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader); // no cache


  $sablona='movie.twig';
  $template = $twig->loadTemplate($sablona);
  $data['title'] = 'Revenant';
  ///// vypsani vysledku
  echo $template->render($data);
?>
