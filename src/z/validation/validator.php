<?php
declare(strict_types=1);

    /**
     * Cette fonction permet au validateur de valider les données reçues
     * et retourne le tableau contenant les erreurs s'il y en a.
     *
     * @param array $data
     * @param array $all_rules
     * @param array $all_messages
     * 
     * @return array
     */
    function make_validation(array $data, array $all_rules, array $all_messages) : array
    {
        // Protection du serveur contre les failles de type XSS
        $data_clean = xssProtection($data);
        $errors = [];

        foreach ($all_rules as $input_name => $rules) 
        {
            if ( array_key_exists($input_name, $data_clean) ) 
            {
                foreach ($rules as $rule) 
                {
                    foreach ($all_messages as $key_message => $message) 
                    {
                        if ( ($rule === "required") && ($key_message === "$input_name.required") ) 
                        {
                            if ( required_($data_clean[$input_name]) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }
                        else if( ($rule === "string") && ($key_message === "$input_name.string") )
                        {
                            if ( string_($data_clean[$input_name]) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }
                        else if( (substr($rule, 0, 3) === "max") && ($key_message === "$input_name.max") )
                        {
                            if ( max_($data_clean[$input_name], $rule) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }
                        else if( (substr($rule, 0, 3) === "min") && ($key_message === "$input_name.min") )
                        {
                            if ( min_($data_clean[$input_name], $rule) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }
                        else if( ($rule === "email") && ($key_message === "$input_name.email") )
                        {
                            if ( email_($data_clean[$input_name]) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }
                        else if( (substr($rule, 0, 6) === "unique") && ($key_message === "$input_name.unique") )
                        {
                            if ( unique_($data_clean[$input_name], $rule) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }
                        else if( (substr($rule, 0, 5) === "regex") && ($key_message === "$input_name.regex") )
                        {
                            if ( regex_($data_clean[$input_name], $rule) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }
                        else if( (substr($rule, 0, 4) === "same") && ($key_message === "$input_name.same") )
                        {
                            if ( same_($data_clean[$input_name], $rule, $data_clean) ) 
                            {
                                $errors[$input_name][] = $message;
                            }
                        }

                    }
                }
            }
        }

        return $errors;
    }


    /**
     * Cette fonction permet de récupérer les données provenant du formulaire qui ont mis au propre.
     *
     * @return array
     */
    function old_values(array $data) : array
    {
        $data_clean = [];

        $data_clean = xssProtection($data);

        return $data_clean;
    }


    /**
     * Cette fonction vérifie si la valeur actuelle correspond 
     * à la valeur de l'input dont on souhaite effectuer la comparaison.
     *
     * @param string $value
     * @param string $rule
     * @param array $data_clean
     * 
     * @return boolean
     */
    function same_(string $value, string $rule, array $data_clean) : bool
    {
        $cut = strstr($rule, "::");
        $input_name = str_replace("::", "", $cut);

        if ( $value === $data_clean[$input_name] ) 
        {
            return false;
        }
        return true;
    }


    /**
     * Cette fonction vérifie si la valeur envoyée par l'utilisateur
     * respecte l'expression régulière prévue par le système.
     *
     * @param string $value
     * @param string $rule
     * 
     * @return boolean
     */
    function regex_(string $value, string $rule) : bool
    {
        $cut = strstr($rule, "::");
        $pattern = str_replace("::", "", $cut);

        if ( ! preg_match($pattern, $value) ) 
        {
            return true;
        }
        return false;
    }


    /**
     * Cette fonction vérifie si la valeur envoyée par l'utilisateur 
     * existe déjà dans la table ciblée de la base données ou non.
     *
     * @param string $value
     * @param string $rule
     * 
     * @return boolean
     */
    function unique_(string $value, string $rule) : bool
    {
        $cut = strstr($rule, "::");
        $cut = str_replace("::", "", $cut);
        $tab = explode(",", $cut);

        $table   = $tab[0];
        $column  = $tab[1];

        require DB;

        $req = $db->prepare("SELECT * FROM {$table} WHERE {$column} =:{$column}");
        $req->bindValue(":{$column}", $value);
        $req->execute();
        $row = $req->rowCount();

        if ( $row == 1 ) 
        {
            return true;
        }
        return false;
    } 


    /**
     * Cette fonction permet de vérifier si l'email 
     * envoyé par l'utilisateur est valide ou non.
     *
     * @param string $value
     * 
     * @return boolean
     */
    function email_(string $value) : bool
    {
        if ( ! filter_var($value, FILTER_VALIDATE_EMAIL) ) 
        {
            return true;
        }
        return false;
    }


    /**
     * Cette fonction vérifie si la valeur envoyée par l'utilisateur 
     * est inférieur ou non à celle prévue par le système.
     *
     * @param string $value
     * @param string $rule
     * 
     * @return boolean
     */
    function min_(string $value, string $rule) : bool
    {
        if(preg_match("/\d+/", $rule, $matches))
        {
            $min = (int) $matches[0];

            if ( mb_strlen($value) < $min ) 
            {
                return true;
            }
            return false;
        }
    }



    /**
     * Cette fonction vérifie si la valeur envoyée par l'utilisateur 
     * est supérieur ou non à celle prévue par le système.
     *
     * @param string $value
     * @param string $rule
     * 
     * @return boolean
     */
    function max_(string $value, string $rule) : bool
    {
        if(preg_match("/\d+/", $rule, $matches))
        {
            $max = (int) $matches[0];

            if ( mb_strlen($value) > $max ) 
            {
                return true;
            }
            return false;
        }
    }


    /**
     * Cette fonction vérifie si la valeur est de type chaîne de caractères.
     *
     * @param string $value
     * 
     * @return boolean
     */
    function string_(string $value) : bool
    {
        if ( ! is_string($value) ) 
        {
            return true;
        }

        return false;
    }


    /**
     * Cette fonction vérifie si la valeur de l'input existe et qu'elle n'est pas vide
     *
     * @param string $value
     * 
     * @return boolean
     */
    function required_(string $value) : bool
    {
        if ( !isset($value) || empty($value) ) 
        {
            return true;
        }

        return false;
    }
    

    /**
     * Cette fonction protège le serveur contre de l'injection de code sous forme de scripts malveillants
     *
     * @param array $data
     * 
     * @return void
     */
    function xssProtection($data) : array
    {
        $data_clean = [];

        foreach ($data as $key => $value) 
        {
            $data_clean[$key] = strip_tags(trim($value));
        }

        return $data_clean;
    }