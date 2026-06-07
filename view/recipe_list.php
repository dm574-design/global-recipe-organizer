<?php
/*
------------------------------------------------------------------------------------------------------------------------------------
Name:        recipe_list.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     The purpose of this file is to display all recipe records.

------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                               When                      What
----------- --------------------------- --------------------------------------------------------------------------------------------
DNM                               2026-03-13                Original Version
DNM                               2026-03-28                Updated Version to display a 							    list of all recipe records
DNM				  2026-04-18		    Added Ingredients and instructions buttons
 							    Formatted prep_time display (hours/minutes) 
							    Removed recipe_id from display 
DNM				  2026-05-11		    Added recipe search form to allow searching by recipe name or cuisine
							    Added hidden action field to route search requests through controller
							    Added “Show All Recipes” link to reset search results
							    Improved usability by placing search functionality above recipe list table
------------------------------------------------------------------------------------------------------------------------------------
*/
?>

<!-- Page heading -->
<h2>Recipe List</h2>

<form class="search-form" action="./index.php" method="get">
    <input type="hidden" name="action" value="search">

    <label for="search_term">Search Recipes:</label>
    <input type="text" name="search_term" id="search_term">

    <input type="submit" value="Search">
</form>

<!-- Link to add new recipe -->
<p><a href="./index.php?action=add">Add New Recipe</a></p>

<!-- Display recipes in table format -->

<table>
    <tr>
        <th>Recipe Name</th>
        <th>Cuisine</th>
        <th>Prep Time</th>
        <th>Difficulty</th>
        <th>Ingredients</th>
        <th>Instructions</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>

    <?php foreach ($records as $record) : ?>
    <tr>
        <td><?php echo $record['recipe_name']; ?></td>
        <td><?php echo $record['cuisine']; ?></td>
        <td>
            <?php
            $hours = floor($record['prep_time'] / 60);
            $minutes = $record['prep_time'] % 60;
            echo $hours . ' hr ' . $minutes . ' min';
            ?>
        </td>
        <td><?php echo $record['difficulty']; ?></td>
        <td><a href="./index.php?action=ingredients_list&recipe_id=<?php echo $record['recipe_id']; ?>">Ingredients</a></td>
        <td><a href="./index.php?action=instructions_list&recipe_id=<?php echo $record['recipe_id']; ?>">Instructions</a></td>
        <td><a href="./index.php?action=update&id=<?php echo $record['recipe_id']; ?>">Update</a></td>
        <td><a href="./index.php?action=delete&id=<?php echo $record['recipe_id']; ?>">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="./index.php?action=home">Back to Home</a></p>