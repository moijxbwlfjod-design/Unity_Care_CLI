<?php
require_once('config.php');

class Departement{
    protected $dep_name;
    protected $location;
    function getDepName(){
        return $this->dep_name;
    }

    function getLocation(){
        return $this->location;
    }

    function getDepartements($pdo){
        echo "ID   |   Departement Name   |   Location\n";
        echo "----------------------------------------\n";
        $sql = "select * from departement";
        $m = $pdo->query($sql);
        while($row = $m->fetch(PDO::FETCH_ASSOC)){
            foreach($row as $key => $value){
                echo $value."   |   ";
            }
            echo "\n\n";
        }
    }

    function findDepartement($pdo,$dep_name){
        if(!empty($dep_name)){
            $sql = 'select * from departement where departementName = ?';
            $m = $pdo->prepare($sql);
            $m->execute(array($dep_name));
            echo "ID   |   Departement Name   |   Location\n";
            echo "----------------------------------------";
            echo "\n\n";
            while($result = $m->fetch(PDO::FETCH_ASSOC)){
                foreach($result as $key => $value){
                    echo $value."    |    ";
                }
                echo "\n";
            }
        }
        echo "\n\n";
    }

    function addDepartement($pdo, $dep_name, $dep_loc){
        if(!empty($dep_loc) && !empty($dep_loc)){
            $sql = "insert into departement (departementName, location) values (?, ?)";
            $m = $pdo->prepare($sql);
            $m->execute(array($dep_name, $dep_loc));
            echo "Departement {$dep_name} est ajouté.\n\n";
        } else{
            echo "Entrer une data valide.\n\n";
        }
    }

    function updateDepartement($pdo,$id, $dep_name, $dep_loc){
        if(!empty($dep_loc) && !empty($dep_loc) && !empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
            $sql = "update departement set departementName = ?, location = ? where id = ?";
            $m = $pdo->prepare($sql);
            $m->execute(array($dep_name, $dep_loc, $id));
            echo "Departement est modifier.\n\n";
        }else{
            echo "Entrer une data valide.\n\n";
        }
    }

    function deleteDepartement($pdo, $id){
        if(!empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
            $sql = "delete from departement where id = ?";
            $m = $pdo->prepare($sql);
            $m->execute(array($id));
            echo "Departement est suprimmé.\n\n";
        } else{
            echo "Entrer une data valide.\n\n";
        }
    }
}

$departements = new Departement();