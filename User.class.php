<?php
    require_once 'DB.class.php';

    class User {
        private $db;

        public function __construct(){
            $this->db = DB::getInstance();
        }

        public function login($username, $password){
            $row =  $this->db->query(Query::loginUser, array('username' => $username))->fetch(PDO::FETCH_ASSOC);

            if(password_verify($password,$row['heslo'])){
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $username;
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public function logout(){
            session_unset();
            session_destroy();
        }

        public function register($username, $password){
            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $this->db->query(Query::registerUser, array('username' => $username, 'password' => $passHash));
            return $this->login($username, $password);
        }

    }



