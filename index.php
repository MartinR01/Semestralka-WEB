<?php
    require_once 'vendor/autoload.php'; // twig
    session_start();
    require_once 'php/User.class.php';
    require_once 'php/DB.class.php';
    require_once 'php/Movie.class.php';
    require_once 'php/Actor.class.php';
    require_once 'php/ContentCreator.php';
    require_once 'php/FileProcessor.class.php';


    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader); // no cache

    $data = array();

    // resolve action
    // předělat na get - jinak nefunguje odhlasovani
    if(isset($_GET['action'])){
        $user = new User();
        switch ($_GET['action']){
            case 'login':
                $user->login($_POST['username'], $_POST['password']);
                break;
            case 'logout':
                $user->logout();
                break;
            case 'register':
                $user->register($_POST['username'], $_POST['password']);
                break;
            case 'createActor':
                Actor::createActor($_POST['name'], FileProcessor::process("photo", FileProcessor::ACTOR), $_POST['bio'], $_POST['movies']);
                break;
            case 'createMovie':
                Movie::createMovie($_POST['name'],FileProcessor::process("poster", FileProcessor::MOVIE),$_POST['description'],$_POST['year'],$_POST['country'],$_POST['genreID'],$_POST['actors']);
                break;
        }
    }


    // resolve page
    if(isset($_GET['page'])){
        switch ($_GET['page']) {
            case 'movie':
                $result = new Movie($_GET['id']);
                $sablona='movie.twig';
                $data = (array)$result; // posila to i id lidi v komentech. to nechceš
                break;

            case 'favMovieList':
                $sablona = 'list.twig';
                $data['list'] = DB::getInstance()->getUserFavs($_SESSION['id']);
                $data['itemType'] = "movie";
                break;

            case 'movieList':
                $sablona = 'list.twig';
                $data['list'] = DB::getInstance()->getMovies();
                $data['itemType'] = "movie";
                break;

            case 'actorList':
                $sablona = 'list.twig';
                $data['list'] = DB::getInstance()->getActors();
                $data['itemType'] = "actor";
                break;

            case 'actor':
                $result = new Actor($_GET['id']);
                $sablona='actor.twig';
                $data = (array)$result;
                break;

            case 'register':
                $sablona='register.twig';
                break;
            case 'login':
                $sablona='login.twig';
                break;
            case 'create':
                $db = DB::getInstance();
                $data['genres'] = $db->getGenres();
                $data['movies'] = $db->getMovies();
                $data['actors'] = $db->getActors();
                $sablona='create.twig';
                break;

            default:
                $sablona = "home.twig";
                break;
        }
    }else{
        $sablona = "home.twig";
    }

    // resolve login
    if(isset($_SESSION['username'])){
        $data['username'] = $_SESSION['username'];

        if(isset($_SESSION['content_admin'])){
            $data['content_admin'] = $_SESSION['content_admin'];
        }
    }

    try {
        echo $twig->render($sablona, $data);
    } catch (Twig_Error_Loader $e) {
    } catch (Twig_Error_Runtime $e) {
    } catch (Twig_Error_Syntax $e) {
    }
?>
