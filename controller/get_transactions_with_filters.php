<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "../model/DBManager.php";

$date = $etype = $entry_type = $uid = $filt_cat = $rowCounts = $resulta = "";

$order_date = "DESC";

include "../model/dao/TransactionDao.php";

if (isset($_GET['etype'])) {
    $etype = intval($_GET['etype']);
}
$uid = "";
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
}

if (isset($_GET['date'])) {
    //$date = intval($_GET['date']);

    if (intval($_GET['date']) == "") {
        $date = "";
    } elseif (intval($_GET['date']) == 1) {
        $date = "DATE(`date_time`) = CURDATE() AND"; //today
    } elseif (intval($_GET['date']) == 2) {
        $date = "DATE(`date_time`) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(`date_time`) < CURDATE() AND"; //yday
    } elseif (intval($_GET['date']) == 3) {
        $date = "DATE(date_time) > DATE_SUB(NOW(), INTERVAL 1 MONTH) AND"; // this month
    } elseif (intval($_GET['date']) == 4) {
        $date = "YEAR(date_time) = YEAR(NOW()) AND"; //current year
    } elseif (intval($_GET['date']) == 0) {
        $date = ""; //yday
    }


} else {
    $date = "";
}
//$date = "DATE(`date_time`) = CURDATE() AND";

$filt_cat = "(1,2,3,4,5)";



if (!isset($_GET['etype'])) {
    $entry_type = "AND `exp_inc` IN ('exp', 'inc')";
}
else {
    if ($_GET['etype'] == "both") {
        $entry_type = "AND `exp_inc` IN ('exp', 'inc')";

    }
    if ($_GET['etype'] == "exp") {
        $entry_type = "AND `exp_inc` = 'exp'";
    }
    if ($_GET['etype'] == "inc") {
        $entry_type = "AND `exp_inc` = 'inc'";
    }
}

//if(isset($_GET['etype'])) {
//    var_dump($_GET['etype']);
//}
//$uid = 26;
//$entry_type = "";
//var_dump($date, $filt_cat, $uid);

//var_dump($date);
//$sql1 = "SELECT * FROM `transactions` WHERE $date AND user_id = 26";
//$sql2 = "SELECT * FROM `transactions` WHERE DATE(`date_time`) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(`date_time`) < CURDATE()";
//SELECT * FROM `transactions` WHERE $date AND user_id = $uid AND category_id = $filt_cat
try {
    if (!isset($pdo)) {
        $pdo = \model\DBManager::getInstance()->getConnection();
    }

    //$sql = "SELECT * FROM `transactions` WHERE $date AND user_id = $uid AND category_id = $filt_cat";
    //$sql = "SELECT * FROM `transactions` WHERE $date user_id = $uid AND `category_id`  IN $filt_cat";
    //$sql = "SELECT * FROM `transactions` WHERE $date user_id = $uid $entry_type ORDER BY `date_time` $order_date";
    $sql = "SELECT * FROM `transactions` WHERE $date user_id = $uid $entry_type ORDER BY `date_time` $order_date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resulta = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $rowCounts = $stmt->rowCount();
    //var_dump($stmt);

    //return $resulta;
} catch (PDOException $e) {
    echo "erewrwer" . $e->getMessage();

}

?>
<div><?php echo "entries: " . $rowCounts; ?></div>
<table class="table table-bordered">
    <tr class="bg_h">
        <th>Date</th>
        <th>Category</th>
        <th>Description</th>
        <th>Ammount</th>
        <th>Recurent</th>
        <th>Moify</th>
    </tr>

    <?php foreach ($resulta as $item) { ?>
        <tr>
            <td><?php
                $dt = $item['date_time'];
                $date = explode(' ', $dt);
                echo ($date[0]) . " / " . ($date[1]);

                ?></td>

            <td><?= $item['category_id'] ?></td>
            <td><?= $item['description'] ?></td>

            <td class="
            <?php
            if ($item['exp_inc'] == "exp") {
                echo "row-exp";
            } else {
                echo "row-inc";
            }
            ?>">
                <span class="pull-right"><?php
                    if ($item['exp_inc'] == "exp") {
                        echo "-";
                    } else {
                        echo "";
                    } ?>

                    <?= $item['amount'] ?>$</span></td>

            <td><?php
                if ($item['recurent_bill'] == 0) {
                    echo "no";
                } else {
                    echo "yes";
                }
                //$item['recurent_bill'] ?></td>
            <!--        <td>--><? //= $item['user_id'] ?><!--</td>-->
            <!-- <td><a href="#" class="btn btn-danger delete_m" onclick="delete_account(<?php echo $item['account_id']; ?>)">Delete</a></td> -->
            <td><a data-toggle="modal" data-target="#modal-add-exp" href="#" class="btn btn-success btn-xs"
                   onclick="mod_transaction('modala', '<?= $item['transaction_id']; ?>')">Modify</a></td>

        </tr>

        <?php
    }
    ?>
</table>
