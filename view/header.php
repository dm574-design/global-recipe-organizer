<?php
/*
---------------------------------------------------------------------------------------------------------
-------------------------------------
Name:        header.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     The purpose of this file is to use this shared header file for all project pages.

---------------------------------------------------------------------------------------------------------
--------------------------------
ChangeLog:
Who                        When                  What
----------- -------------------- ----------------------------------------------------------------------------------------------------
-----------------------------------
DNM                        2026-03-13            Original Version
DNM                        2026-03-28            Updated version that includes change to css file link and added section comments
DNM                        2026-04-04		 Updated version with navigation bar for consistent access 
                                                 to key application pages
DNM			   2026-04-18            Updated navigation to include recipe_id parameters 
--------------------------------------------------------------------------------------------------------------------------------------
----------------------------------
*/
?>

<!-- HTML document setup and metadata -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- Page title -->
    <title>Global Recipe Organizer</title>

    <!-- Link to main stylesheet -->
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="container">

        <!-- Application Heading --> 
        <h1>Global Recipe Organizer</h1>
        <hr>


	<nav>
    	    <a href="./index.php?action=home">Home</a> |
            <a href="./index.php?action=list">View Recipes</a> |
            <a href="./index.php?action=add">Add Recipe</a> |
            <a href="./index.php?action=ingredients_list">Ingredients</a> |
            <a href="./index.php?action=instructions_list">Instructions</a> 
	        |
	</nav>

	<hr>