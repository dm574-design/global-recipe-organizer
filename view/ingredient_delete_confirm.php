<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        ingredient_delete_confirm.php
Author:      Drew Miller
Date:        2026-04-04
Language:    PHP
Purpose:     The purpose of this file is to confirm deletion of an ingredient record.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-04-04                Original Version
dnm				  2026-04-18		    Added recipe_id to maintain context after deletion
------------------------------------------------------------------------------------------------------------------------------------
*/
?>

<h2>Delete Ingredient</h2>

<p>Are you sure you want to delete this ingredient?</p>

<p><strong><?php echo $ingredient['ingredient_name']; ?></strong></p>

<form action="./index.php?action=delete_ingredient" method="post">
    <input type="hidden" name="ingredient_id" value="<?php echo $ingredient['ingredient_id']; ?>">
    <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">

    <input type="submit" value="Delete Ingredient">
</form>

<p>
    <a href="./index.php?action=ingredients_list&recipe_id=<?php echo $recipe_id; ?>">
        Cancel
    </a>
</p>

<p><a href="./index.php?action=home">Back to Home</a></p>