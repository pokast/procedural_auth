<?php

    get("/",            ["visitor/welcome/welcomeController", "index"]);

    /* -------------------------Registration-------------------- */
    get("/register",    ["visitor/registration/registrationController", "register"]);
    post("/register",   ["visitor/registration/registrationController", "register"]);


    /* -------------------------Authentication-------------------- */
    get("/login",       ["visitor/authentication/loginController", "login"]);
    post("/login",      ["visitor/authentication/loginController", "login"]);
    get("/logout",      ["visitor/authentication/loginController", "logout"]);