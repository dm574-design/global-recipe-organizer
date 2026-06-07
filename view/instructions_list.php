<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        instructions_list.php
Author:      Drew Miller
Date:        2026-04-11
Language:    PHP
Purpose:     The purpose of this file is to display all instructions.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-04-11                Original Version that adds a display table for instruction records
                                                            and includes delete action and navigation links
DNM                               2026-04-22                Updated to support both all instructions and recipe-specific views
DNM				  2026-05-02		    Added Update column to instructions table for recipe-specific view
DNM				  2026-05-02		    Added Update button linking to edit_instruction controller action
DNM				  2026-05-02		    Ensured Update and Delete actions only display when recipe_id is present 
DNM				  2026-05-02		    Verified dual-view functionality remains intact (global vs recipe-specific) 
------------------------------------------------------------------------------------------------------------------------------------
*/
?>

<h2>
   
<?php if (!empty($recipe_id)) : ?>
    Instructions for Recipe <?php echo $recipe_id; ?>
<?php else : ?>
    All Instructions
<?php endif; ?>
</h2>


<?php if (!empty($recipe_id)) : ?>
<p>
    <a href="./index.php?action=add_instruction&recipe_id=<?php echo $recipe_id; ?>">
        Add Instruction
    </a>
</p>
<?php endif; ?>

<?php if (empty($instructions)) : ?>
    <p>No instructions found.</p>
<?php else : ?>
<table>
    <tr>
        <th>Step Number</th>
        <th>Step Text</th>
        <?php if (!empty($recipe_id)) : ?>
	    <th>Update</th>
            <th>Delete</th>
        <?php endif; ?>
    </tr>

    <?php foreach ($instructions as $instruction) : ?>
    <tr>
        <td><?php echo $instruction['step_number']; ?></td>
        <td><?php echo $instruction['step_text']; ?></td>
        <?php if (!empty($recipe_id)) : ?>
	    <td>
    <a href="./index.php?action=edit_instruction&id=<?php echo $instruction['instruction_id']; ?>&recipe_id=<?php echo $recipe_id; ?>">
        Update
    </a>
</td>
<td>
    <a href="./index.php?action=delete_instruction&id=<?php echo $instruction['instruction_id']; ?>&recipe_id=<?php echo $recipe_id; ?>">
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

