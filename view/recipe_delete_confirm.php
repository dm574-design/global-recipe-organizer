<?php
/*
----------------------------------------------------------------------------------------------------------------------------------
Name:        recipe_delete_confirm.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     The purpose of this file is to display a confirmation page for deleting a recipe.

----------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                                When                    What
------------ --------------------------- -----------------------------------------------------------------------------------------
DNM                                2026-03-13              Original Verison
DNM			                       2026-03-28              Updated Version to display page for when a recipe is deleted
----------------------------------------------------------------------------------------------------------------------------------
*/

?>

<!-- Display delete confirmation heading -->
<h2>Delete Recipe</h2>

<p>Are you sure you want to delete this recipe?</p>

<!-- Show selected recipe details -->
<p><strong>Recipe Name:</strong> <?php echo $record['recipe_name']; ?></p>
<p><strong>Cuisine:</strong> <?php echo $record['cuisine']; ?></p>

<!-- Form to confirm deletion -->
<form method="post" action="./index.php?action=delete">
    <input type="hidden" name="recipe_id" value="<?php echo $record['recipe_id']; ?>">
    <input type="submit" value="Confirm Delete">
</form>

<p><a href="./index.php?action=list">Cancel and Return to Recipe List</a></p>
<p><a href="./index.php?action=home">Back to Home</a></p>
