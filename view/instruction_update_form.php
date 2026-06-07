<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        instruction_update_form.php
Author:      Drew Miller
Date:        2026-05-02
Language:    PHP
Purpose:     The purpose of this file is to display the form for updating a current instruction.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-05-02               Original Version that updates form for current instructions
							   and includes step number and step text fields and
							   validation and navigation links
------------------------------------------------------------------------------------------------------------------------------------
*/
?>



<h2>Edit Instruction</h2>

<form action="./index.php?action=update_instruction" method="post">

    <input type="hidden" name="instruction_id" value="<?php echo $instruction['instruction_id']; ?>">
    <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">

    <label for="step_number">Step Number:</label>
    <input type="number" name="step_number" id="step_number"
           value="<?php echo $instruction['step_number']; ?>"
           min="1" max="1000" required>

    <label for="step_text">Step Text:</label>
    <input type="text" name="step_text" id="step_text"
           value="<?php echo $instruction['step_text']; ?>"
           required>

    <input type="submit" value="Update Instruction">
</form>

<p>
    <a href="./index.php?action=instructions_list&recipe_id=<?php echo $recipe_id; ?>">
        Back to Instruction List
    </a>
</p>

<p><a href="./index.php?action=home">Back to Home</a></p>