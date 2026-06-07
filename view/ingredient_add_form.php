<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        ingredient_add_form.php
Author:      Drew Miller
Date:        2026-04-04
Language:    PHP
Purpose:     The purpose of this file is to display the form for adding a new ingredient.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-04-04                Original Version
DNM				  2026-04-18		    Added hidden recipe_id field to associate ingredients with recipes 
------------------------------------------------------------------------------------------------------------------------------------
*/
?>

<h2>Add Ingredient</h2>

<form action="./index.php?action=add_ingredient" method="post">
    <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">

    <label for="ingredient_name">Ingredient Name:</label>
    <input type="text" name="ingredient_name" id="ingredient_name" required>

    <input type="submit" value="Add Ingredient">
</form>

<p>
    <a href="./index.php?action=ingredients_list&recipe_id=<?php echo $recipe_id; ?>">
        Back to Ingredient List
    </a>
</p>

<p><a href="./index.php?action=home">Back to Home</a></p>