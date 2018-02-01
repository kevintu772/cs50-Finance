<?php

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a valid symbol");
        }
        
        $stock = lookup($_POST["symbol"]);
        
        if ($stock === false)
        {
            apologize("You must provide a valid symbol");
        }
        
        $stock = $stock["price"];
        $stock = number_format($stock,2);
        
        render("symbol_display.php", ["stock" => $stock]);
        
    }
    else
    {
        // else render form
        render("symbol_search.php", ["title" => "Search"]);
    }

?>
