<?php
    
    // configuration
    require("../includes/config.php"); 
    
    $rows = query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
    
    if (isset($rows))
    {
        $positions = [];
        foreach ($rows as $row)
        {
            $positions[] = [
                "transaction" => $row["transaction"],
                "datetime" => $row["datetime"],
                "symbol" => $row["symbol"],
                "shares" => $row["shares"],
                "price" => number_format($row["price"],2)
            ];
        }
        $positions = array_reverse($positions);
    }
    
    render("history_display.php", ["positions" => $positions]);

?>
