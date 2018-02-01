<?php

    // configuration
    require("../includes/config.php"); 
    
    $rows = query("SELECT * FROM portfolio WHERE id = ?", $_SESSION["id"]); 
    
    $symbols = [];
    foreach ($rows as $row)
    {
        $symbols[] = $row["symbol"];
    }
      
    render("sell_form.php", ["symbols" => $symbols]);
    
    // if form was submitted
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["symbol"] != "blank") && isset($_POST["symbol"]))
    {
        $table = query("SELECT * FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]); 
        foreach ($table as $rows)
        {
            $row = $rows;
        }
        
        $stock = lookup($_POST["symbol"]);
        $symbol = $stock["symbol"];
        $stock = $stock["price"];
        $price = $row["shares"] * $stock;
        
        query("DELETE FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);       
        query("UPDATE users SET cash = cash + ? WHERE id = ?", $price, $_SESSION["id"]);
        query("INSERT INTO history (id, transaction, datetime, symbol, shares, price) VALUES(?, 'SELL', CURRENT_TIMESTAMP, ?, ?, ?)", $_SESSION["id"], $symbol, $row["shares"], $price);
        
        redirect("/");   
    }
  
?>
