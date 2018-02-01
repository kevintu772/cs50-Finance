<?php

    // configuration
    require("../includes/config.php"); 
    
    $rows = query("SELECT * FROM portfolio WHERE id = ?", $_SESSION["id"]);
    
    if (isset($rows))
    {
        $positions = [];
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                    "name" => $stock["name"],
                    "price" => number_format($stock["price"],2),
                    "shares" => $row["shares"],
                    "symbol" => $row["symbol"]
                ];
            }
        }
    }
    
    $cash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    
    if (isset($cash))
    {
        $balance = [];
        foreach ($cash as $cash)
        {
            $balance = $cash["cash"];
        }
        
        $balance = number_format($balance,2);
    }
    
    
    // render portfolio
    render("portfolio.php", ["title" => "Portfolio", "positions" => $positions, "balance" => $balance]);

?>
