<?php

    /**
     * ---------------------------------------------------------------------
     * Ce fichier contient toutes les constantes de notre application
     * 
     * Une constante dans notre contexte va contenir un chemin
     * 
     * C'est donc un raccourci. 
     * ---------------------------------------------------------------------
    */


    /** Ce raccourci représente la racine du projet */
    const ROOT                  = __DIR__ . "/../";


    /** Ce raccourci représente le router */
    const ROUTER                = ROOT . "src/z/routing/router.php";


    /** Ce raccourci représente les routes dont l'application attend la réception */
    const ROUTES                = __DIR__ . "/routes.php";


    /** Ce raccourci représente la racine du dossier des contrôleurs */
    const CONTROLLER            = ROOT . "src/controller/"; 


    /** Ce raccourci représente la racine du dossier des vues */
    const TEMPLATES             = ROOT . "templates/";


    /** Ce raccourci représente le controller abstrait */
    const ABSTRACT_CONTROLLER   = ROOT . "/src/z/abstractController/abstractController.php";
    
    
    /** Ce raccourci représente le validateur des données */
    const VALIDATOR             = ROOT . "/src/z/validation/validator.php";
    

    /** Ce raccourci représente la connexion à la base de données */
    const DB                    = __DIR__ . "/database.php";


    /** Ce raccourci représente le manager de la table "user" */
    const USER                  = ROOT . "/src/manager/user.php";


    /** Ce raccourci représente l'authentificateur */
    const AUTHENTICATOR         = ROOT . "/src/security/authenticator.php";