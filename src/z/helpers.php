<?php

    /**
     * Cette fonction permet d'afficher le premier message d'erreur
     * de l'input dont on lui passe le nom en paramètre. 
     *
     * @param string $input_name
     * 
     * @return null|string
     */
    function formErrors(string $input_name) : ?string
    {
        if ( isset($_SESSION['errors'][$input_name]) && !empty($_SESSION['errors'][$input_name]) ) 
        {
            $messages = $_SESSION['errors'][$input_name];
            unset($_SESSION['errors'][$input_name]);

            foreach ($messages as $message) 
            {
                return $message;
            }
        }

        return null;
    }



    /**
     * Cette fonction prend le nom d'un input en paramètre et retourne la valeur qui lui est associée
     *
     * @param string $input_name
     * 
     * @return null|string
     */
    function old(string $input_name) : ?string
    {
        if ( isset($_SESSION['old'][$input_name]) && !empty($_SESSION['old'][$input_name]) ) 
        {
            $value = $_SESSION['old'][$input_name];
            unset($_SESSION['old'][$input_name]);

            return $value;
        }

        return null;
    }


    /**
     * Cette fonction effectue une redirection vers la page de laquelle proviennent les informations
     *
     * @return void
     */
    function redirect_back() : void
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }



    /**
     * Cette fonction prend une url en paramètre et y effectue une redirection
     *
     * @param string $url
     * 
     * @return void
     */
    function redirect_to_url(string $url) : void
    {
        header("Location: $url");
    }


    