<?php
require_once('config.php');
require_once("validation.php");
class Person{
    protected $firstName;
    protected $lastName;
    protected $phoneNum;
    protected $email;
    function getFullName(){
        $fullName = $this->firstName." ".$this->lastName;
        return $fullName;
    }
    function getPhone(){
        return $this->phoneNum;
    }
    function getEmail(){
        return $this->email;
    }

    function showPeople($pdo, $who){
        if($who == "patient"){
            $m = $pdo->query('select * from patient');
            echo "ID   |   First Name   |   Last Name   |   Gender   |   Date Of Birth   |   Phone   |   Email   |   Address\n";
            echo "----------------------------------------------------------------------------------------------------------";
            echo "\n\n";
        } else if($who == "doctor"){
            $m = $pdo->query('select * from doctor');
            echo "ID   |   First Name   |   Last Name   |   Specialization   |   Phone   |   Email   |   Departement ID\n";
            echo "-----------------------------------------------------------------------------------------------------";
            echo "\n\n";
        }
        while($row = $m->fetch(PDO::FETCH_ASSOC)){
            foreach($row as $key => $value){
                echo $value."   |   ";
            }
            echo "\n\n";
        }
    }

    function findPerson($pdo,$who, $firstName, $lastName){
        if($who == "patient" && Validator::isNotEmpty($firstName) && Validator::isNotEmpty($lastName)){
            $sql = 'select * from patient where firstName = ? and lastName = ?';
            $m = $pdo->prepare($sql);
            $m->execute(array($firstName, $lastName));
            $result = $m->fetch(PDO::FETCH_ASSOC);
            echo "\nID   |   First Name   |   Last Name   |   Gender   |   Date Of Birth   |   Phone   |   Email   |   Address\n";
            echo "----------------------------------------------------------------------------------------------------------\n\n";
        } else if($who == "doctor" && Validator::isNotEmpty($firstName) && Validator::isNotEmpty($lastName)){
            $sql = 'select * from doctor where firstName = ? and lastName = ?';
            $m = $pdo->prepare($sql);
            $m->execute(array($firstName, $lastName));
            $result = $m->fetch(PDO::FETCH_ASSOC);
            echo "\nID   |   First Name   |   Last Name   |   Specialization   |   Phone   |   Email   |   Departement ID\n";
            echo "-----------------------------------------------------------------------------------------------------\n\n";
        } else{
            echo "Entrer une data qu'est valide.\n";
        }
        if(!empty($result)){
            foreach($result as $key => $value){
                echo $value."   |   ";
            }
        } else{
            echo "Pardons, on n'a trouver aucun patient, Essai autre fois.";
        }
        echo "\n\n";
    }

    function deletePerson($pdo, $who, $id){
        if(!empty($id) && filter_var($id, FILTER_VALIDATE_INT)){
            $sql = "delete from {$who} where id = ?";
            $m = $pdo->prepare($sql);
            $m->execute(array($id));
            echo "{$who} suprimmer.\n\n";
        } else{
            echo "Entrer une data qu'est valide";
        }
    }
}

class Patient extends Person{
    protected $gender;
    protected $date;
    protected $address;

    function getGender(){
        return $this->gender;
    }

    function getDate(){
        return $this->date;
    }

    function getAddress(){
        return $this->address;
    }
    
    function addPatient($pdo, $fname, $lname, $gender, $date, $phone, $email, $addr){
        if (!empty($fname) && !empty($lname) && !empty($gender) && !empty($date) && !empty($phone) && !empty($email) && !empty($addr) && Validator::phoneValidator($phone) && Validator::dateValidator($date)){
            $sql = "insert into patient (firstName, lastName, gender, dateOfBirth, phoneNum, email, address) values (?, ?, ?, ?, ?, ?, ?)";
            $m = $pdo->prepare($sql);
            $m->execute(array($fname, $lname, $gender, $date, $phone, $email, $addr));
        } else{
            echo "Entrer une data qu'est valide.\n";
        }
    }

    function updatePatient($pdo,$id){
        if(!empty($id) && filter_var($id, FILTER_VALIDATE_INT)){#
            $new_fname = readline("Entrer le Premier nom: ");
            $new_lname = readline("Entrer le Deuxième nom: ");
            $new_gender = readline("Entrer le Genre: ");
            $new_date = readline("Entrer le Date de naissance: ");
            $new_phone = readline("Entrer le Numero de télephone: ");
            $new_email = readline("Entrer l'Email: ");
            $new_addr = readline("Entrer l\'Address: ");
            if (!empty($fname) && !empty($lname) && !empty($gender) && !empty($date) && !empty($phone) && !empty($email) && !empty($addr) && Validator::phoneValidator($phone) && Validator::dateValidator($date)){
                $sql = "update patient set firstName = ?, lastName = ?, gender = ?, dateOfBirth = ?, phoneNum = ?, email = ?, address = ? where id = ?";
                $m = $pdo->prepare($sql);
                $m->execute(array($new_fname, $new_lname, $new_gender, $new_date, $new_phone, $new_email, $new_addr, $id));
            } else{
                echo "Entrer une data qu'est valide.\n";
            }
        }
    }

    function calculateAverageAge($pdo){
        try{
            $sql = "SELECT ROUND(AVG(TIMESTAMPDATE(YEAR, dateOfBirth, CURDATE()), 2) AS Average FROM patient";
            $m = $pdo->query($sql);
            $result = $m->fetch(PDO::FETCH_ASSOC);
            echo "L'age moyen des patients est: " . $result['Average'] . " ans" ."\n\n";
        }catch(Exception $e){
            echo "Error: $e";
        }
    }
}

class Doctor extends Person{
    protected $specialization;
    protected $dep_id;

    function findDoctorBySpe($pdo, $spe){
        if(!empty($spe)){
            $sql = "select * from doctor where specialization = ?";
            $m = $pdo->prepare($sql);
            $m->execute(array($spe));
            echo "\nID   |   First Name   |   Last Name   |   Specialization   |   Phone   |   Email   |   Departement ID\n";
            echo "-----------------------------------------------------------------------------------------------------\n\n";
            while($row = $m->fetch(PDO::FETCH_ASSOC)){
                foreach($row as $key => $value){
                    echo $value."    |    ";
                }
                echo "\n\n";
            }
        } else{
            echo "Entrer une data qu'est valide.`n";
        }
    }

    function addDoctor($pdo, $fname, $lname, $spe, $phone, $email ,$dep_id){
        if (!empty($fname) && !empty($lname) && !empty($spe) && !empty($phone) && !empty($email) && !empty($dep_id) && filter_var($dep_id, FILTER_VALIDATE_INT) && Validator::phoneValidator($phone)){
            try{
                $sql = "insert into doctor (firstName, lastName, specialization, phoneNum, email, departement_id) values (?, ?, ?, ?, ?, ?)";
                $m = $pdo->prepare($sql);
                $m->execute(array($fname, $lname, $spe, $phone, $email, $dep_id));
                echo "\n";
            } catch(Exception $e){
                echo "Error (Verifer votre input) => {$e}";
            }
        } else{
            echo "Entrer une data qu'est valide.\n\n";
        }
    }

    function updateDoctor($pdo,$id, $fname, $lname, $spe, $phone, $email ,$dep_id){
        if (!empty($id) && filter_var($id, FILTER_VALIDATE_INT) && !empty($fname) && !empty($lname) && !empty($spe) && !empty($phone) && !empty($email) && !empty($dep_id) && filter_var($dep_id, FILTER_VALIDATE_INT) && Validator::phoneValidator($phone)){
            try{
                $sql = "update doctor set firstName = ?, lastName = ?, specialization = ?, phoneNum = ?, email = ?, departement_id = ? where id = ?";
                $m = $pdo->prepare($sql);
                $m->execute(array($fname, $lname, $spe, $phone, $email, $dep_id, $id));
                echo "Médcin ajouter.\n\n";
            } catch(Exception $e){
                echo "Error (Verifer votre input) => {$e}";
            }
        } else{
            echo "Entrer une data qu'est valide.\n\n";
        }
    }

    function calculateAverageServiseYears($pdo){
        try{
            $sql = "SELECT round(avg(case when suspensionDate = 'En cours' then timestampdiff(year, hiringDate, curdate()) else timestampdiff(year, hiringDate, suspensionDate) end), 2) as average from doctor";
            $m = $pdo->query($sql);
            $result = $m->fetch(PDO::FETCH_ASSOC);
            echo "Le moyen des années de services des médcins est: ".$result['average']." ans"."\n\n";
        } catch(Exception $e){
            echo "Error: $e";
        }
    }
}

$patients = new Patient();
$doctors = new Doctor();
