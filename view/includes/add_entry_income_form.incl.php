<?php
/**
 * Created by PhpStorm.
 * User: assen.kovachev
 * Date: 26.10.2017 г.
 * Time: 01:28 ч.
 */

?>
<div class="form-row">
    <form class="form-group" action="../controller/add_incomes_ctrl.php" method="post">
        <!--    account id: <input type="number" name="account_id" value="26" placeholder="26"><br>-->


        <label class="" for="account_id">to account:</label>
        <select class="form-control input-lg" name="account_id" id="account_id">
            <?php
            include "../controller/get_user_account_list.php";

            foreach ($result_accounts as $row) {
                echo "<option value=\"" . $row['account_id'] . "\" selected>".$row['account_name'] . " (" .$row['ammount'] . "$)</option>";
            }

            ?>
        </select><br>

        Value: $$$ <input class="form-control input-lg" type="number" name="value" min="0" step=".01" required><br>
        <!--    <input type="text" name="exp" value="exp" hidden><br>-->

        <input type="radio" class="radio-inline input-lg"  name="recurent_bill" value="0" checked> Onetime
        <input type="radio" class="radio-inline" name="recurent_bill" value="1"> Recurent<br>

        Category <select class="form-control input-lg icon-menu" name="category" id="category">
            <?php
            //            include "../controller/get_exp_union_categories_ctrl.php";
            //            foreach ($united_list as $row) {
            //                echo "<option value=\"" . $row['category_id'] . "\"> " . $row['category_name'] . "</option>";
            //            }
            include "show_inc_union_list.incl.php"

            ?>

        </select><br>
        Description: <input class="form-control input-lg" type="text" name="description"><br>



        <input class="btn btn-success pull-right" type="submit" name="add_inc" value="Add Income">

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
    </form>
    <br>
</div>
<div class="alert">
    <?php
//    if(!empty($_SESSION['exp-err'])) {
//        echo "
//        <div class='alert alert-dismissible alert-danger'>
//            <button type='button' class='close' data-dismiss='alert'>&times;</button>
//            <strong>" . $_SESSION["exp-err"] . "</strong>
//        </div>";
//
//    }
    ?>
</div>
