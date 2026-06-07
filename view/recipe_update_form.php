<?php
/*
---------------------------------------------------------------------------------------------------------------------------------
Name:        recipe_update_form.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     The purpose of this file is to display the form for updating a recipe.

--------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                       What
----------- -------------------------- -----------------------------------------------------------------------------------------
DNM                               2026-03-13                 Original Verison
DNM                               2026-03-28                 Updated Version to display the form when updating one recipe
--------------------------------------------------------------------------------------------------------------------------------
*/

?>

<?php
$prep_hours = floor($record['prep_time'] / 60);
$prep_minutes = $record['prep_time'] % 60;
?>

<!-- Display update form heading -->
<h2>Update Recipe</h2>

<!-- Form to submit updated recipe data -->
<form method="post" action="./index.php?action=update">

    <!-- Hidden field to store recipe ID -->
    <input type="hidden" name="recipe_id" value="<?php echo $record['recipe_id']; ?>">

    <label>Recipe Name</label>
    <input type="text" name="recipe_name" value="<?php echo $record['recipe_name']; ?>" required>

    <label>Cuisine</label>
    <input type="text" name="cuisine" value="<?php echo $record['cuisine']; ?>" required>

    <label>Prep Time Hours:</label>
    <input type="number" name="prep_hours" value="<?php echo $prep_hours; ?>" min="0" required>
    
    <label>Prep Time Minutes:</label>
    <input type="number" name="prep_minutes" value="<?php echo $prep_minutes; ?>" min="0" max="59" required>
      
    <label>Difficulty</label>
    <input type="text" name="difficulty" value="<?php echo $record['difficulty']; ?>" required>

    
    <br><br>
    <input type="submit" value="Update Recipe">
</form>

<p><a href="./index.php?action=list">Back to Recipe List</a></p>
<p><a href="./index.php?action=home">Back to Home</a></p>

