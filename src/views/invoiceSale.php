<?php
use Helpers\SessionHelper;
SessionHelper::startSession();
ob_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $sale->sales_id ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { width: 100%; padding: 20px; border: 1px solid #ddd; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>Invoice #<?= $sale->sales_id ?></h2>
        <p>Date: <?= date("d-m-Y", strtotime($sale->sale_date)) ?></p>
        <p>patient: <?= htmlspecialchars($sale->patient_name) ?></p>
        <table>
            <thead>
                <tr>
                    <th>Medicament</th>
                    <th>Quantity</th>
                    <th>Price (€)</th>
                    <th>Total (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->medicament_name) ?></td>
                    <td><?= $item->quantity ?></td>
                    <td><?= $item->price ?></td>
                    <td><?= $item->total ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total">
                    <td colspan="3"> total Amount:</td>
                    <td><?= $sale->total_price ?> €</td>
                </tr>
            </tbody>
        </table>
    </div>
   
</body>
</html>


