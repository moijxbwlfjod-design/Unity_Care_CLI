<?php
require_once('person.php');
require_once('config.php');
require_once('departement.php');
echo "=== Unity Care CLI ===\n\n";
do{
    echo "1. Gérer les patients\n2. Gérer les médecins\n3. Gérer les départements\n4. Statistiques\n5. Quitter\n\n";
    $input = readline("Entrer votre choix: ");
    switch($input){
        case $input == 1:
            do{
                echo "1. Lister tous les patients\n2. Rechercher un patient\n3. Ajouter un patient\n4. Modifier un patient\n5. Supprimer un patient\n6. Quitter\n\n";
                $input = readline("Entrer votre choix: ");
                switch($input){
                    case $input == 1:
                        $patients->showPeople($conn_result, "patient");
                        break;
                    case $input == 2:
                        $fname = readline("Entrer Le premier nom du patient: ");
                        $lname = readline('Entrer Le deuxième nom du patient: ');
                        $patients->findPerson($conn_result, "patient", $fname, $lname);
                        break;
                    case $input == 3:
                        $fname = readline("Entrer Le premier nom du patient: ");
                        $lname = readline('Entrer Le deuxième nom du patient: ');
                        $gender = readline('Entrer Le genre du patient: ');
                        $date = readline('Entrer Le jour de naissance du patient: ');
                        $phone = readline('Entrer Le numero du patient: ');
                        $email = readline('Entrer L\'email du patient: ');
                        $add = readline('Entrer L\'address du patient: ');
                        $patients->addPatient($conn_result, $fname, $lname, $gender, $date, $phone, $email, $add);
                        break;
                    case $input == 4;
                        $id = readline("Entrer L'ID de patient vous voulez le modifier: ");
                        $patients->updatePatient($conn_result, $id);
                        break;
                    case $input == 5:
                        $id = readline('Entrer l\'ID de patient que vous voulez le suprimmer: ');
                        $patients->deletePerson($conn_result, "patient", $id);
                        break;
                    default:
                        echo "Essai un autre choix\n";
                }
            }while($input != 6);
            break;

        case $input == 2:
            do{
                echo "1. Lister tous les médcins\n2. Rechercher un médcin\n3. Ajouter un médcin\n4. Modifier un médcin\n5. Supprimer un médcin\n6. Quitter\n\n";
                $input = readline("Entrer votre choix: ");
                switch($input){
                    case $input == 1:
                        $doctors->showPeople($conn_result, "doctor");
                        break;
                    case $input == 2:
                        do{
                            echo "1. Recherche par noms.\n2. Recherche par specialization.\n3. Quitter\n\n";
                            $input = readline("Entrer votre choix: ");
                            switch($input){
                                case $input == 1:
                                    $fname = readline("Entrer Le premier nom du médcin: ");
                                    $lname = readline('Entrer Le deuxième nom du médcin: ');
                                    $doctors->findPerson($conn_result, "doctor", $fname, $lname);
                                    break;
                                case $input == 2:
                                    $spe = readline("Entrer specialization de médcin: ");
                                    $doctors->findDoctorBySpe($conn_result, $spe);
                                    break;
                            }
                        }while($input != 3);
                        break;
                    case $input == 3:
                        $fname = readline("Entrer Le premier nom du médcin: ");
                        $lname = readline('Entrer Le deuxième nom du médcin: ');
                        $spe = readline('Entrer La specialization du médcin: ');
                        $phone = readline('Entrer Le numero du médcin: ');
                        $email = readline('Entrer L\'email du médcin: ');
                        $dep_id = readline('Entrer L\'ID de departement du médcin: ');
                        $doctors->addDoctor($conn_result, $fname, $lname, $spe, $phone, $email, $dep_id);
                        break;
                    case $input == 4;
                        $id = readline("Entrer L'ID de médcin vous voulez le modifier: ");
                        $new_fname = readline("Entrer le Premier nom du médcin: ");
                        $new_lname = readline("Entrer le Deuxième nom du médcin: ");
                        $new_spe = readline("Entrer la specialization de médcin: ");
                        $new_phone = readline("Entrer le Numero de télephone: ");
                        $new_email = readline("Entrer l'Email: ");
                        $new_dep_id = readline("Entrer l'ID de departement: ");
                        $doctors->updateDoctor($conn_result, $id, $new_fname, $new_lname, $new_spe, $new_phone, $new_email, $new_dep_id);
                        break;
                    case $input == 5:
                        $id = readline("Entrer l'ID de médcin que vous voulez le suprimmer: ");
                        $doctors->deletePerson($conn_result, "doctor", $id);
                        break;
                    default:
                        echo "Essai un autre choix\n";
                }
            }while($input != 6);
            break;

        case $input == 3:
            do{
                echo "1. Lister tous les departements\n2. Rechercher une departement\n3. Ajouter une departement\n4. Modifier une departement\n5. Supprimer une departements\n6. Quitter\n\n";
                $input = readline("Entrer votre choix: ");
                switch($input){
                    case $input == 1:
                        $departements->getDepartements($conn_result);
                        break;
                    case $input == 2:
                        $dep_name = readline("Entrer le nom de departement vous voulez le trouver: ");
                        $departements->findDepartement($conn_result, $dep_name);
                        break;
                    case $input == 3:
                        $dep_name = readline("Entrer le nom de departement: ");
                        $dep_loc = readline("Entrer la location de departement: ");
                        $departements->addDepartement($conn_result, $dep_name, $dep_loc);
                        break;
                    case $input == 4:
                        $id = readline("Entrer l'ID de departement: ");
                        $dep_name = readline("Entrer le nom de departement: ");
                        $dep_loc = readline("Entrer la location de departement: ");
                        $departements->updateDepartement($conn_result, $id, $dep_name, $dep_loc);
                        break;
                    case $input == 5:
                        $id = readline("Entrer l'ID de departement: ");
                        $departements->deleteDepartement($conn_result, $id);
                        break;
                    default:
                        echo "Essai un autre choix\n";
                }
            } while($input != 6);
            break;
        default:
            echo "Essai un autre choix\n";
    }
}while($input != 5);
echo "Good Bye";