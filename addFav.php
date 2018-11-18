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

  $dotaz = $db->prepare('INSERT INTO oblibene_filmy (Film_idFilm, Uzivatel_idUzivatel)
                          VALUES (:movieID,:userID)');
  $dotaz->bindParam(':userID',$_POST['userID']);
  $dotaz->bindParam(':movieID',$_POST['movieID']);

  $dotaz->execute();

} else{
  echo "Error";
}
?>
