<?php

class ContentCreator{
    private $db;

    public function __construct(){
        $this->db = DB::getInstance();
    }

    public function create($type, $args){
        $funcitonName = 'add'.$type;

        $this->db->$funcitonName($args );
    }

}