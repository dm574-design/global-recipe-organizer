<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        innstructions_delete_confirm.php
Author:      Drew Miller
Date:        2026-04-11
Language:    PHP
Purpose:     The purpose of this file is to confirm deletion of an instruction record.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-04-11                Original Version that adds a confirmation page for instruction deletion
                                                            and displays slected instruction and provides cancel option.
------------------------------------------------------------------------------------------------------------------------------------
*/
?>

<h2>Delete Instruction</h2>

<p>Are you sure you want to delete this instruction?</p>

<p><strong><?php echo $instruction['step_text']; ?></strong></p>

<form action="./index.php?action=delete_instruction" method="post">
    <input type="hidden" name="instruction_id" value="<?php echo $instruction['instruction_id']; ?>">
    <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
    <input type="submit" value="Delete Instruction">
</form>

<p>
    <a href="./index.php?action=instructions_list&recipe_id=<?php echo $recipe_id; ?>">Cancel / Back to Instruction List</a>
</p>

<p>
    <a href="./index.php?action=home">Back to Home</a>
</p>
