<?php
/*
-----------------------------------------------------------------------------------------
Name:        index.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     This file is the main entry point and controller for the Global Recipe
             Organizer application. It handles user requests, loads data, and displays
             the appropriate views.
-----------------------------------------------------------------------------------------

ChangeLog:
Who        When        What
---------  ----------  ------------------------------------------------------------------
DNM        2026-03-13  Original Version
DNM        2026-03-28  Updated Version for changes to file links
DNM        2026-04-04  Updated version for adding ingredient actions for list,
                       add, and delete functions
DNM        2026-04-11  Added routing cases for instruction list, add, and delete actions
DNM        2026-04-18  Updated ingredient routing to include recipe_id
                       Added redirection logic for relational navigation
DNM        2026-04-22  Added controller validation to prevent invalid input and
                       reduce PDO exceptions
DNM	   2026-05-02  Added edit_instruction controller action to display instruction    		       update form
DNM	   2026-05-02  Added update_instruction controller action to process 		  	               instruction updates
DNM	   2026-05-02  Implemented validation for instruction update inputs (ID, recipe_id, 		       step_number, step_text)
DNM	   2026-05-02  Added numeric range validation for step_number to prevent out-of-		       range database errors
DNM	   2026-05-02  Added redirect after successful update to return to recipe-specific 	
	       instructions list
DNM	   2026-05-11  Added search routing action
		       Added search functionality for recipe name and cuisine
		       Added validation message handling for recipe form input errors
		       Improved user feedback by redisplaying forms after validation failures
-----------------------------------------------------------------------------------------
*/

// Include database connection and data functions
require_once('./model/dbconnect.php');
require_once('./model/recipe_data.php');

// Determine action from query string, default to 'home'
$action = $_GET['action'] ?? 'home';

switch ($action) {

    case 'home':
        include('./view/header.php');
        include('./view/home.php');
        include('./view/footer.php');
        break;

    case 'list':
        $records = get_all_records();
        include('./view/header.php');
        include('./view/recipe_list.php');
        include('./view/footer.php');
        break;

    case 'search':
    	$search_term = trim($_GET['search_term'] ?? '');

    	if ($search_term === '') {
        $records = get_all_records();
    	} else {
        $records = search_recipes($search_term);
    	}

    	include('./view/header.php');
    	include('./view/recipe_list.php');
    	include('./view/footer.php');
    	break;

    case 'add':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $recipe_name = trim($_POST['recipe_name'] ?? '');
            $cuisine = trim($_POST['cuisine'] ?? '');
            $prep_hours = $_POST['prep_hours'] ?? null;
            $prep_minutes = $_POST['prep_minutes'] ?? null;
            $difficulty = trim($_POST['difficulty'] ?? '');

            if ($recipe_name === '' || strlen($recipe_name) > 100) {
                $error = "Recipe name is required and must be 100 characters or less.";
		
		include('./view/header.php');
    		include('./view/recipe_add_form.php');
    		include('./view/footer.php');
    		break;
		
            }

            if ($cuisine === '' || strlen($cuisine) > 50) {
                echo "Error: Cuisine is missing or too long.";
                exit();
            }

            if (!is_numeric($prep_hours) || $prep_hours < 0 || $prep_hours > 99) {
                echo "Error: Invalid prep hours.";
                exit();
            }

            if (!is_numeric($prep_minutes) || $prep_minutes < 0 || $prep_minutes > 59) {
                echo "Error: Invalid prep minutes.";
                exit();
            }

            if ($difficulty === '' || strlen($difficulty) > 50) {
                echo "Error: Difficulty is missing or too long.";
                exit();
            }

            $prep_time = ((int)$prep_hours * 60) + (int)$prep_minutes;

            add_record($recipe_name, $cuisine, $prep_time, $difficulty);

            header('Location: index.php?action=list');
            exit();
        } else {
            include('./view/header.php');
            include('./view/recipe_add_form.php');
            include('./view/footer.php');
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['recipe_id'] ?? null;
            $recipe_name = trim($_POST['recipe_name'] ?? '');
            $cuisine = trim($_POST['cuisine'] ?? '');
            $prep_hours = $_POST['prep_hours'] ?? null;
            $prep_minutes = $_POST['prep_minutes'] ?? null;
            $difficulty = trim($_POST['difficulty'] ?? '');

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid recipe ID.";
                exit();
            }

            if ($recipe_name === '' || strlen($recipe_name) > 100) {
                echo "Error: Recipe name is missing or too long.";
                exit();
            }

            if ($cuisine === '' || strlen($cuisine) > 50) {
                echo "Error: Cuisine is missing or too long.";
                exit();
            }

            if (!is_numeric($prep_hours) || $prep_hours < 0 || $prep_hours > 99) {
                echo "Error: Invalid prep hours.";
                exit();
            }

            if (!is_numeric($prep_minutes) || $prep_minutes < 0 || $prep_minutes > 59) {
                echo "Error: Invalid prep minutes.";
                exit();
            }

            if ($difficulty === '' || strlen($difficulty) > 50) {
                echo "Error: Difficulty is missing or too long.";
                exit();
            }

            $prep_time = ((int)$prep_hours * 60) + (int)$prep_minutes;

            update_record($id, $recipe_name, $cuisine, $prep_time, $difficulty);

            header('Location: index.php?action=list');
            exit();
        } else {
            $id = $_GET['id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid recipe ID.";
                exit();
            }

            $record = get_record($id);

            

            include('./view/header.php');
            include('./view/recipe_update_form.php');
            include('./view/footer.php');
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['recipe_id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid recipe ID.";
                exit();
            }

            delete_record($id);

            header('Location: index.php?action=list');
            exit();
        } else {
            $id = $_GET['id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid recipe ID.";
                exit();
            }

            $record = get_record($id);

            include('./view/header.php');
            include('./view/recipe_delete_confirm.php');
            include('./view/footer.php');
        }
        break;

    case 'ingredients_list':
        $recipe_id = $_GET['recipe_id'] ?? null;

        if ($recipe_id !== null && !is_numeric($recipe_id)) {
            echo "Error: Invalid recipe ID.";
            exit();
        }

        if ($recipe_id) {
            $ingredients = get_ingredients_by_recipe($recipe_id);
        } else {
            $ingredients = get_all_ingredients();
        }

        include('./view/header.php');
        include('./view/ingredients_list.php');
        include('./view/footer.php');
        break;

    case 'add_ingredient':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $recipe_id = $_POST['recipe_id'] ?? null;
            $ingredient_name = trim($_POST['ingredient_name'] ?? '');

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            if ($ingredient_name === '') {
                echo "Error: Ingredient name is required.";
                exit();
            }

            if (strlen($ingredient_name) > 100) {
                echo "Error: Ingredient name is too long.";
                exit();
            }

            add_ingredient($recipe_id, $ingredient_name);

            header('Location: index.php?action=ingredients_list&recipe_id=' . $recipe_id);
            exit();
        } else {
            $recipe_id = $_GET['recipe_id'] ?? null;

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            include('./view/header.php');
            include('./view/ingredient_add_form.php');
            include('./view/footer.php');
        }
        break;

    case 'delete_ingredient':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['ingredient_id'] ?? null;
            $recipe_id = $_POST['recipe_id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid ingredient ID.";
                exit();
            }

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            delete_ingredient($id);

            header('Location: index.php?action=ingredients_list&recipe_id=' . $recipe_id);
            exit();
        } else {
            $id = $_GET['id'] ?? null;
            $recipe_id = $_GET['recipe_id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid ingredient ID.";
                exit();
            }

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            $ingredient = get_ingredient($id);

            include('./view/header.php');
            include('./view/ingredient_delete_confirm.php');
            include('./view/footer.php');
        }
        break;

    case 'instructions_list':
        $recipe_id = $_GET['recipe_id'] ?? null;

        if ($recipe_id !== null && !is_numeric($recipe_id)) {
            echo "Error: Invalid recipe ID.";
            exit();
        }

        if ($recipe_id) {
            $instructions = get_instructions_by_recipe($recipe_id);
        } else {
            $instructions = get_all_instructions();
        }

        include('./view/header.php');
        include('./view/instructions_list.php');
        include('./view/footer.php');
        break;

    case 'add_instruction':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $recipe_id = $_POST['recipe_id'] ?? null;
            $step_number = $_POST['step_number'] ?? null;
            $step_text = trim($_POST['step_text'] ?? '');

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            
            if (empty($step_number) || !is_numeric($step_number)) {
                echo "Error: Step number must be numeric.";
                exit();
            }

            if ($step_number < 1 || $step_number > 1000) {
                echo "Error: Step number must be between 1 and 1000.";
                exit();
            }

            if ($step_text === '') {
                echo "Error: Step text is required.";
                exit();
            }

            if (strlen($step_text) > 255) {
                echo "Error: Step text is too long.";
                exit();
            }

            add_instruction($recipe_id, $step_number, $step_text);

            header('Location: index.php?action=instructions_list&recipe_id=' . $recipe_id);
            exit();
        } else {
            $recipe_id = $_GET['recipe_id'] ?? null;

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            include('./view/header.php');
            include('./view/instruction_add_form.php');
            include('./view/footer.php');
        }
        break;

     case 'delete_instruction':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['instruction_id'] ?? null;
            $recipe_id = $_POST['recipe_id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid instruction ID.";
                exit();
            }

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            delete_instruction($id);

            header('Location: index.php?action=instructions_list&recipe_id=' . $recipe_id);
            exit();
        } else {
            $id = $_GET['id'] ?? null;
            $recipe_id = $_GET['recipe_id'] ?? null;

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid instruction ID.";
                exit();
            }

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            $instruction = get_instruction($id);

            include('./view/header.php');
            include('./view/instruction_delete_confirm.php');
            include('./view/footer.php');
        }
        break;

    case 'edit_instruction':
        $id = $_GET['id'] ?? null;
        $recipe_id = $_GET['recipe_id'] ?? null;

        if (empty($id) || !is_numeric($id)) {
            echo "Error: Invalid instruction ID.";
            exit();
        }

        if (empty($recipe_id) || !is_numeric($recipe_id)) {
            echo "Error: Missing or invalid recipe ID.";
            exit();
        }

        $instruction = get_instruction($id);

        include('./view/header.php');
        include('./view/instruction_update_form.php');
        include('./view/footer.php');
        break;

    case 'update_instruction':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['instruction_id'] ?? null;
            $recipe_id = $_POST['recipe_id'] ?? null;
            $step_number = $_POST['step_number'] ?? null;
            $step_text = trim($_POST['step_text'] ?? '');

            if (empty($id) || !is_numeric($id)) {
                echo "Error: Invalid instruction ID.";
                exit();
            }

            if (empty($recipe_id) || !is_numeric($recipe_id)) {
                echo "Error: Missing or invalid recipe ID.";
                exit();
            }

            if (empty($step_number) || !is_numeric($step_number)) {
                echo "Error: Step number must be numeric.";
                exit();
            }

            if ($step_number < 1 || $step_number > 1000) {
                echo "Error: Step number must be between 1 and 1000.";
                exit();
            }

            if ($step_text === '') {
                echo "Error: Step text is required.";
                exit();
            }

            if (strlen($step_text) > 255) {
                echo "Error: Step text is too long.";
                exit();
            }

            update_instruction($id, $step_number, $step_text);

            header('Location: index.php?action=instructions_list&recipe_id=' . $recipe_id);
            exit();
        }
        break;
}
?>