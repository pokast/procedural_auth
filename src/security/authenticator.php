<?php

    /**
     * Cette méthode vérifie 
     *       - si l'email récupéré depuis le formulaire correspond à celui d'un utilisateur de la table "user"
     *       - si le mot de passe récupéré depuis le formulaire correspond à celui de cet utilisateur 
     *
     * @return array|null
     */
    function authenticateUser(array $data) : ?array
    {
        // /Etablir une connexion avec la base de données
        require DB;

        // Effectuer la requête pour récupérer les données de l'utilisateur 
        // dont l'email a été récupéré depuis le formulaire
        $req = $db->prepare("SELECT * FROM user WHERE email=:email");
        $req->bindValue(":email", $data['email']);
        $req->execute();
        $row = $req->rowCount();

        // Si le nombre d'enregistrement n'est pas égal à 1,
        if ($row != 1) 
        {
            // Cela veut dire que cet email n'existe pas dans la table "user"
            // Retourner null et arrêter le script
            return null; 
        }
        
        // Dans le cas contraire, récupérer les données de l'utilisateur dont l'email a matché
        $user = $req->fetch();
        
        // Ensuite, 
        // si le mot de passe de l'utilisateur récupéré de la table "user" 
        // ne match pas avec celui récupéré depuis le formulaire
        if ( ! password_verify($data['password'], $user['password']) ) 
        {
            // Cela veut dire que le mot de passe n'est correspond pas
            // Retourner null et arrêter le script
            return null;
        }

        // Dans le cas contraire, 
        // Retouner toutes les données de cet utilisateur 
        return $user;
    }