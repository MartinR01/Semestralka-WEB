<?php
if(isset($_POST['userID']) && isset($_POST['movieID'])){
  //DB variables
  $host="localhost";
  $dbname="semestralka_db1";
  $username="root";
  $password="";

  $dns = "mysql:host=$host;dbname=$dbname;charset=utf8"; //charset pro české znaky!

  $db = new PDO($dns,$username,$password);
  $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $dotaz = $db->prepare('SELECT COUNT(*) FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID');
  $dotaz->bindParam(':userID',$_POST['userID']);
  $dotaz->bindParam(':movieID',$_POST['movieID']);

  $dotaz->execute();
  echo implode(" ",$dotaz->fetch(PDO::FETCH_ASSOC));
} else{
  echo "Error";
}
?>
