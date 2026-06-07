<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        ingredients_list.php
Author:      Drew Miller
Date:        2026-04-04
Language:    PHP
Purpose:     The purpose of this file is to display all ingredients.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-04-04                Original Version
DNM				  2026-04-18	            Updated to display recipe-specific ingredients
							    Added dynamic links with recipe_id
------------------------------------------------------------------------------------------------------------------------------------
*/
?>



<h2>
<?php if (!empty($recipe_id)) : ?>
    Ingredients for Recipe <?php echo $recipe_id; ?>
<?php else : ?>
    All Ingredients
<?php endif; ?>
</h2>


<?php if (!empty($recipe_id)) : ?>
<p>
    <a href="./index.php?action=add_ingredient&recipe_id=<?php echo $recipe_id; ?>">
        Add New Ingredient
    </a>
</p>
<?php endif; ?>


<?php if (empty($ingredients)) : ?>
    <p>No ingredients found.</p>
<?php else : ?>
    <table>
        <tr>
            <th>Ingredient Name</th>
            <?php if (!empty($recipe_id)) : ?>
                <th>Delete</th>
            <?php endif; ?>
        </tr>

        <?php foreach ($ingredients as $ingredient) : ?>
        <tr>
            <td><?php echo $ingredient['ingredient_name']; ?></td>
            <?php if (!empty($recipe_id)) : ?>
            <td>
                <a href="./index.php?action=delete_ingredient&id=<?php echo $ingredient['ingredient_id']; ?>&recipe_id=<?php echo $recipe_id; ?>">
                    Delete
                </a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>


<p><a href="./index.php?action=list">Back to Recipe List</a></p>
<p><a href="./index.php?action=home">Back to Home</a></p>