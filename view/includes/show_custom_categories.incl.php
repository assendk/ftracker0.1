<?php
/**
 * Created by PhpStorm.
 * User: assen.kovachev
 * Date: 24.10.2017 г.
 * Time: 15:48 ч.
 */
?>
<h2>Custom categories</h2>
<table class="table table-bordered table_list table-hover" id="whole_table" cellspacing="2" cellpadding="0">
    <tr class="bg_h">
        <th>Category name</th>
        <th>Description</th>
    </tr>
    <?php
    //$pdo = \model\DBManager::getInstance()->getConnection();
    //$result = AccountDao::getAInstance()->getUserAcountsList($oi);
    //$result = CategoryDao::getCategoryInstance()->getAllDefaultCategories();
    //$result = UserCategoriesDao::getUserCategoryInstance()->getAllCustomCategories($oi);

    foreach ($result_cust_categories as $row) {
        ?>
        <tr >

            <td style="color: <?php echo $row['user_cat_color'] ?>"><img width="20px" height="20px" src="images/icons/<?php echo $row['user_cat_icon']; ?>" alt=""> <?php echo $row['user_cat_name'] ?></td>
            <td><?php echo $row['user_cat_desc'] ?></td>

            <td><a href="#" class="btn btn-danger" onclick="rm_cust_cat(<?php echo $row['uc_id']; ?>)">Delete</a></td>
        </tr>

        <?php
    } //end foreach
    ?>
</table>
