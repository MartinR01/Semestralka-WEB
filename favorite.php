<?php
require_once('queries.class.php');

if(isset($_POST['userID']) && isset($_POST['movieID']) && isset($_POST['action'])){
  //DB variables
  $host="localhost";
  $dbname="semestralka_db1";
  $username="root";
  $password="";

  $dns = "mysql:host=$host;dbname=$dbname;charset=utf8"; //charset pro české znaky!

  $db = new PDO($dns,$username,$password);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


  $dotaz = $db->prepare(Queries::$movieIsFaved);
  $dotaz->bindParam(':userID',$_POST['userID']);
  $dotaz->bindParam(':movieID',$_POST['movieID']);
  $dotaz->execute();
  $isFav=($dotaz->fetch(PDO::FETCH_ASSOC)['COUNT(*)']);


  // co je to za dotaz??
  switch($_POST['action']){
    case 'isFav':
      echo($isFav);
      break;
    case 'toggle':
      if($isFav == TRUE){
        $dotaz = $db->prepare(Queries::$movieDeleteFav);
      } else {
        $dotaz = $db->prepare(Queries::$movieAddFav);
      }
      $dotaz->bindParam(':userID',$_POST['userID']);
      $dotaz->bindParam(':movieID',$_POST['movieID']);

      $dotaz->execute();
      break;
  }


} else{
  echo "Error";
}
?>
