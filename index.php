<?php
    require_once 'vendor/autoload.php'; // twig
    session_start();
    require_once 'User.class.php';
    require_once 'DB.class.php';
    require_once 'Movie.class.php';
    require_once 'Actor.class.php';
    require_once 'ContentCreator.php';
    require_once 'FileProcessor.class.php';


    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader); // no cache

    $data = array();
//    //test
//    $data = array('name' => 'test',
//                    'poster_url' => 'test',
//                    'info' => 'tohel je test',
//                    'year' => '2076',
//                    'country' => 'Great Republic of Kazachstan',
//                    'genreID' => 1);
//    $typ = "Movie";
//
//    $con = new ContentCreator();
//    $con->create($typ, $data);
//    //endtest

    // resolve action
    if(isset($_POST['action'])){
        $user = new User();
        switch ($_POST['action']){
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
                Actor::createActor($_POST['name'], FileProcessor::process("photo", FileProcessor::ACTOR), $_POST['bio']);
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
