<?php

    // configuration
    require("../includes/config.php");
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (!isset($_POST["username"]) || !isset($_POST["password"]) ||
            $_POST["password"] != $_POST["confirmation"])
        {
            apologize("Error: Missing username/ password or password doesn't match confirmation");
        }
        else
        {
            if (query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"])) === false)
            {
                apologize("Error creating account");     
            }
            else
            {
                $rows = query("SELECT LAST_INSERT_ID() AS id");
                $id = $rows[0]["id"];
                $_SESSION["id"] = $id;
                
                redirect("/");
            }
        }
    }
    else
    {
        // else render form
        render("register_form.php",["title" => "register"]);
    }

?>
