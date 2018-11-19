<?php
class Queries{
  public static $movieIsFaved = 'SELECT COUNT(*) FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID';
  public static $movieDeleteFav = 'DELETE FROM oblibene_filmy WHERE Film_idFilm=:movieID AND Uzivatel_idUzivatel=:userID';
  public static $movieAddFav = 'INSERT INTO oblibene_filmy (Film_idFilm, Uzivatel_idUzivatel) VALUES (:movieID,:userID)';
  public static $movieActors = 'SELECT * FROM herec JOIN hraje ON hraje.Herec_idHerec=herec.idHerec WHERE hraje.Film_idFilm=:movieID';

  public static $userFavs = 'SELECT * FROM oblibene_filmy JOIN film ON film.idFilm=oblibene_filmy.Film_idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE oblibene_filmy.Uzivatel_idUzivatel=:userID';

  public static $actorMovieRoles = 'SELECT * FROM film JOIN hraje ON hraje.Film_idFilm=film.idFilm JOIN zanr ON zanr.idZanr=film.Zanr_idZanr WHERE hraje.Herec_idHerec=:actorID';
}
?>
