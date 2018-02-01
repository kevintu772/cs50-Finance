<?php

    // configuration
    require("../includes/config.php"); 
    
    render("buy_form.php");
    
    $cash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    
    if (isset($cash))
    {
        $balance = [];
        foreach ($cash as $cash)
        {
            $balance = $cash["cash"];
        }
        
        $balance = floatval($balance);
    }
     
    if (($_SERVER["REQUEST_METHOD"] == "POST"))
    {         
        if (empty($_POST["shares"]) || empty($_POST["symbol"]))
        {
            apologize("Missing shares or symbol");
        }       
        else if (!is_numeric($_POST["shares"]) || $_POST["shares"] < 1 || $_POST["shares"] != round($_POST["shares"]))
        {
            apologize("Input shares must be a positive integer");
        }
        else
        { 
            $stock = lookup($_POST["symbol"]);
            
            if ($stock !== false)
            {    
                $price = floatval($stock["price"]) * $_POST["shares"];
                $symbol = $stock["symbol"];
                
                if ($balance >= $price)
                {
                    query("UPDATE users SET cash = cash - ? WHERE id = ?", $price, $_SESSION["id"]);
                    query("INSERT INTO portfolio (id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $symbol, $_POST["shares"]);
                    query("INSERT INTO history (id, transaction, datetime, symbol, shares, price) VALUES(?, 'BUY', CURRENT_TIMESTAMP, ?, ?, ?)", $_SESSION["id"], $symbol, $_POST["shares"], $price);
                    redirect("/");  
                }
                else
                    apologize("Insufficient funds. Balance is $balance, cost is $price");               
            }
            else
                apologize("Invalid stock symbol");
        }
    }
  
?>
