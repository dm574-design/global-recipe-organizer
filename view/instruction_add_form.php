<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        instruction_add_form.php
Author:      Drew Miller
Date:        2026-04-11
Language:    PHP
Purpose:     The purpose of this file is to display the form for adding a new instruction.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-04-11               Original Version that adds form for new instructions
							   and includes step number and step text fields and
							   validation and navigation links
------------------------------------------------------------------------------------------------------------------------------------
*/
?>


<h2>Add Instruction</h2>

<form action="./index.php?action=add_instruction" method="post">
    <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">

    <label for="step_number">Step Number:</label>
    <input type="number" name="step_number" id="step_number" required>

    <label for="step_text">Step Text:</label>
    <input type="text" name="step_text" id="step_text" required>

    <input type="submit" value="Add Instruction">
</form>


<p><a href="./index.php?action=instructions_list&recipe_id=<?php echo $recipe_id; ?>">Back to Instruction List</a></p>

<p>
    <a href="./index.php?action=home">Back to Home</a>
</p>
