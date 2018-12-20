<?php
    require_once 'DB.class.php';

    class User {
        private $db;

        public function __construct(){
            $this->db = DB::getInstance();
        }

        public static function login($username, $password){
            $db = DB::getInstance();
            $row =  $db->loginUser($username);
            if(password_verify($password,$row['heslo'])){
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $username;
                // is admin
                if ($row['content_admin'] == TRUE){
                    $_SESSION['content_admin'] = TRUE;
                }
                $response['status']='success';
            } else {
                $response['status']='error';
                $response['message']="Invalid username/password!";
            }
            return json_encode($response);
        }

        public function logout(){
            session_unset();
            session_destroy();
        }

        public function register($username, $password){
            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->registerUser($username, $passHash);
            $this->login($username, $password);
        }

        public static function getUsers(){
            $db=DB::getInstance();
            return $db->getUsers();
        }

        public static function deleteUser($userID){
            if($userID != $_SESSION['id']){
                DB::getInstance()->deleteUser($userID);
                $response['status']='success';
            } else {
                $response['status']='error';
                $response['message']="You can't delete yourself!";
            }
            echo json_encode($response);
        }

        public static function toggleAdmin($userID){
            if($userID != $_SESSION['id']){
                DB::getInstance()->toggleAdmin($userID);
                $response['status']='success';
            } else {
                $response['status']='error';
                $response['message']="!You can't remove your own admin rights!";
            }
            echo json_encode($response);
        }

    }



