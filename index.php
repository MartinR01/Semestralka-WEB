<?php
    session_start();
    spl_autoload_register("autoload");
    require_once 'vendor/autoload.php'; // twig


    $loader = new Twig_Loader_Filesystem('views');
    $twig = new Twig_Environment($loader); // no cache

    $data = array();

    $router = new RouterController();
    echo $router->route($_SERVER['REQUEST_URI']);

    // resolve action
    if(isset($_GET['action'])){
        $user = new UserController();
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



function autoload($class){
    if (preg_match('/Controller$/', $class)){
        require ('controllers/'.$class.".php");
    } else {
        require ('models/'.$class.".php");
    }

}
?>
