<?php
    require_once 'DB.class.php';

    class User {
        private $db;

        public function __construct(){
            $this->db = DB::getInstance();
        }

        public function login($username, $password){
            $row =  $this->db->loginUser($username);
            if(password_verify($password,$row['heslo'])){
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $username;
                // is admin
                if ($row['content_admin'] == TRUE){
                    $_SESSION['content_admin'] = TRUE;
                }
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public function logout(){
            echo "lgoutou";
            session_unset();
            session_destroy();
        }

        public function register($username, $password){
            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->registerUser($username, $passHash);
            return $this->login($username, $password);
        }

    }



