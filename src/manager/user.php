<?php

    /**
     * ---------------------------------------------------------------------
     * Le manager de la table "user"
     * 
     * Le rôle du manager est d'effectuer toutes les requêtes prévues 
     * pour intéragir avec la base de données
     * ---------------------------------------------------------------------
    */

    /**
     * Grâce à cette fonction, le manager de la table "user" inscrit un nouvel utilisateur
     *
     * @return void
     */
    function createUser(array $data) : void
    {
        require DB;

        $req = $db->prepare("INSERT INTO user (first_name, last_name, email, password, created_at, updated_at) VALUES (:first_name, :last_name, :email, :password, now(), now() ) ");

        $req->bindValue(":first_name", $data['first_name']);
        $req->bindValue(":last_name",  $data['last_name']);
        $req->bindValue(":email",      $data['email']);
        $req->bindValue(":password",   password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]));

        $req->execute();
        $req->closeCursor();
    }