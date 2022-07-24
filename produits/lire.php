<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){  

        //inclure les fichiers de config et access

        include_once '../config/Database.php';
        include_once '../models/Produits.php';

        // instancier la DB
        $database= new Database();
        $db = $database->getConnection();

        // on instancie un prod

        $produit = new Produits($db);


        // recuperons les données

        $stmt = $produit->lire();

        // verifions
        if($stmt->rowCount()>0){
            // initialise tableau 
            $tableauProtuis=[];
            $tableauProtuis['produits']=[];

            // parcourir

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                // elle permet de recupéré sous forme de variable chacune des colonne de notre tables pour évité davoir a parcourir tout les colone individuellement
                extract($row);


                $prod = [
                    "id"=> $id,
                    "nom"=>$nom,
                    "description"=>$description,
                    "prix"=>$prix,
                    "categories_id"=>$categories_id,
                    "categories_nom"=>$categories_nom
                ];

                $tableauProtuis['produits'][]=$prod;

            }

           http_response_code(200);
           echo json_encode($tableauProtuis);


        }





    }

else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
