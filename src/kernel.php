<?php
declare(strict_types=1);

session_set_cookie_params(['secure' => true, 'httponly' => true, 'samesite' => 'lax']);

session_start();

    /**
     * ------------------------------------------------------------
     *                          Le Kernel
     * 
     * Ce fichier représente le noyau de l'application
     * 
     * @author Jean-Claude AZIAHA <aziaha.formations@gmail.com>
     * 
     * @version 1.0.0
     * ------------------------------------------------------------
    */


    // Chargement des raccourcis (constantes)
    require __DIR__ . "/../config/constants.php";


    // Chargement de l'autoloader de composer
    require ROOT . "vendor/autoload.php";


    // Chargement du routeur 
    require ROUTER;


    // Chargement des routes dont l'application attend la réception
    require ROUTES;


    // Exécution du router
    $router_response = run();

    
    return getControllerResponse($router_response);



    /**
     * C'est grâce à cette fonction que le kernel demande au controller de s'exécuter
     * et de lui retourner la réponse correspondante à la requête
     *
     * @param array|null $router_response
     * @return string
     */
    function getControllerResponse(array|null $router_response) : string
    {
        // Si aucun controller n'a été trouvé par le router, 
        // Le noyau demande au contrôleur des erreurs d'activer sa méthode notFound()
        if ( $router_response === null ) 
        {
            require CONTROLLER . "error/errorController.php";
            http_response_code(404);
            return notFound();
        }

        // Dans le cas contraire, 
        // Récupérer le contrôleur et la méthode
        $controller = $router_response['controller'];
        $method     = $router_response['method'];


        // S'il y a des paramètres, 
        // Charger le controller
        // Executer sa méthode prévue en lui passant les paramètres 
        if ( isset($router_response['parameters']) && !empty($router_response['parameters']) ) 
        {
            $parameters = $router_response['parameters'];
            require CONTROLLER . "$controller.php";
            return $method($parameters);
        }
        
        // Dans le cas contraire,
        // Charger le controller
        // Executer sa méthode prévue sans paramètres.
        require CONTROLLER . "$controller.php";
        return $method();
    }

