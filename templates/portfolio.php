
<ul class="nav nav-tabs ">
    <li><a href="quote.php">Quote</a></li>
    <li><a href="buy.php">Buy</a></li>
    <li><a href="sell.php">Sell</a></li>
    <li><a href="history.php">History</a></li>
    <li><a href="logout.php"><strong>Log Out</strong></a></li>
</ul>

<table class="table table-striped">
    
    <thead>
        <tr>
            <th><?= "Symbol" ?></th>
            <th><?= "Name" ?></th>
            <th><?= "Shares" ?></th>
            <th><?= "Price" ?></th>
            <th><?= "TOTAL" ?></th>
        </tr>
    </thead>    
    
    <?php foreach ($positions as $position): ?>

        <tr>
            <td class="text-left"><?= strtoupper($position["symbol"]) ?></td>
            <td class="text-left"><?= $position["name"] ?></td>
            <td class="text-left"><?= $position["shares"] ?></td>
            <td class="text-left"><?= "$". $position["price"] ?></td>
            <td class="text-left"><?= "$". $position["shares"] * $position["price"] ?></td>
        </tr>

    <?php endforeach ?>
    
    <tr>
        <td class="text-left success"; colspan="4"; font-weight:bold><strong>BALANCE</strong></td>
        <td class="text-left success"><?= "$".$balance ?></td>
    </tr>
    
</table>
<div>
    <a href="logout.php">Log Out</a>
</div>
