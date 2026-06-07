<?php
/*
----------------------------------------------------------------------------------------------------------------------------------
Name:        recipe_add_form.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     The purpose of this file is to display the form for adding a new recipe.

----------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                            When                    What
----------- ------------------------ ---------------------------------------------------------------------------------------------
DNM                            2026-03-13              Original Version
DNM                            2026-03-28              Updated Version to just display the 					               form for adding a new recipe
DNM			       2026-04-18              Updated prep time input to use hours and minutes
DNM			       2026-05-11	       Added validation error message display support
----------------------------------------------------------------------------------------------------------------------------------  
*/

?>

<!-- Display page heading -->
<h2>Add Recipe</h2>

<?php if (!empty($error)) : ?>
    <p class="error-message"><?php echo $error; ?></p>
<?php endif; ?>

<!-- Form to submit new recipe data to controller -->
<form method="post" action="./index.php?action=add">

    <!-- Recipe name input -->
    <label>Recipe Name</label>
    <input type="text" name="recipe_name" required>

    <label>Cuisine</label>
    <input type="text" name="cuisine" required>

    <label>Prep Time Hours:</label>
    <input type="number" name="prep_hours" min="0" required>

    <label>Prep Time Minutes:</label>
    <input type="number" name="prep_minutes" min="0" max="59" required>

    <label>Difficulty</label>
    <input type="text" name="difficulty" required>

    <br><br>
    <input type="submit" value="Add Recipe">
</form>

<p><a href="./index.php?action=list">Back to Recipe List</a></p>

