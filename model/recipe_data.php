<?php
/*
---------------------------------------------------------------------------------------------------------------------------------
Name:        recipe_data.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     This file contain functions for reading and writing recipe data.

---------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                              When                      What
------------ ------------------------ -------------------------------------------------------------------------------------------
DNM                              2026-03-13                Original Version
DNM                              2026-03-28                Updated Version to reflect name change to php to recipe_data.php
DNM				 2026-04-04		   Updated Version to reflect adding ingredient functions for add
							      and delete 
DNM				 2026-04-11       Added functions for instruction CRUD operations
                                  Includes get_all_instructions, get_instruction, add_instruction, and delete_instruction
DNM				 2026-04-18		   Added function to retrieve ingredients by recipe_id 
	                               Updated add_ingredient to include recipe_id 
DNM				 2026-05-02		   Added update_instruction function to update step_number and step_text in instructions table
DNM				 2026-05-02		   Maintained use of prepared statements for secure database updates
DNM              2026-05-02        Updated delete_record function to remove related ingredients
                                   and instructions before deleting a recipe to prevent
                                   foreign key constraint errors
DNM		 		 2026-05-11		   Added search_recipes function to search by recipe name or cuisine.	 
---------------------------------------------------------------------------------------------------------------------------------
*/

require_once('dbconnect.php');

// Retrieves all recipes from the database
function get_all_records() {
    global $db;
    $query = 'SELECT * FROM recipes ORDER BY recipe_id';
    $statement = $db->prepare($query);
    $statement->execute();
    $records = $statement->fetchAll();
    $statement->closeCursor();
    return $records;
}

function get_record($id) {
    global $db;
    $query = 'SELECT * FROM recipes WHERE recipe_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $record = $statement->fetch();
    $statement->closeCursor();
    return $record;
}

// Inserts a new recipe into the database
function add_record($recipe_name, $cuisine, $prep_time, $difficulty) {
    global $db;
    $query = 'INSERT INTO recipes
              (recipe_name, cuisine, prep_time, difficulty)
              VALUES
              (:recipe_name, :cuisine, :prep_time, :difficulty)';
    $statement = $db->prepare($query);
    $statement->bindValue(':recipe_name', $recipe_name);
    $statement->bindValue(':cuisine', $cuisine);
    $statement->bindValue(':prep_time', $prep_time);
    $statement->bindValue(':difficulty', $difficulty);
    $statement->execute();
    $statement->closeCursor();
}

// Updates a record in the database
function update_record($id, $recipe_name, $cuisine, $prep_time, $difficulty) {
    global $db;
    $query = 'UPDATE recipes
              SET recipe_name = :recipe_name,
                  cuisine = :cuisine,
                  prep_time = :prep_time,
                  difficulty = :difficulty
                  WHERE recipe_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':recipe_name', $recipe_name);
    $statement->bindValue(':cuisine', $cuisine);
    $statement->bindValue(':prep_time', $prep_time);
    $statement->bindValue(':difficulty', $difficulty);
    $statement->execute();
    $statement->closeCursor();
}

// Deletes a recipe by ID
function delete_record($id) {
    global $db;

    // Delete ingredients
    $query = 'DELETE FROM ingredients WHERE recipe_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();

    // Delete instructions
    $query = 'DELETE FROM instructions WHERE recipe_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();

    // Delete recipe
    $query = 'DELETE FROM recipes WHERE recipe_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}

//Searches a recipe by recipe name
function search_recipes($search_term) {
    global $db;

    $query = 'SELECT * FROM recipes
              WHERE recipe_name LIKE :search_term
                 OR cuisine LIKE :search_term
              ORDER BY recipe_name';

    $statement = $db->prepare($query);
    $statement->bindValue(':search_term', '%' . $search_term . '%');
    $statement->execute();

    $records = $statement->fetchAll();
    $statement->closeCursor();

    return $records;
}

// ==============================
// INGREDIENT FUNCTIONS
// ==============================

// Get all ingredients


function get_ingredients_by_recipe($recipe_id) {
    global $db;
    $query = 'SELECT * FROM ingredients
              WHERE recipe_id = :recipe_id
              ORDER BY ingredient_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':recipe_id', $recipe_id);
    $statement->execute();
    $ingredients = $statement->fetchAll();
    $statement->closeCursor();
    return $ingredients;
}

function get_all_ingredients() {
    global $db;
    $query = 'SELECT * FROM ingredients ORDER BY ingredient_id';
    $statement = $db->prepare($query);
    $statement->execute();
    $ingredients = $statement->fetchAll();
    $statement->closeCursor();
    return $ingredients;
}

// Get single ingredient
function get_ingredient($id) {
    global $db;
    $query = 'SELECT * FROM ingredients WHERE ingredient_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $ingredient = $statement->fetch();
    $statement->closeCursor();
    return $ingredient;
}




// Add new ingredient
function add_ingredient($recipe_id, $name) {
    global $db;
    $query = 'INSERT INTO ingredients (recipe_id, ingredient_name)
              VALUES (:recipe_id, :name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':recipe_id', $recipe_id);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $statement->closeCursor();
}

// Delete ingredient
function delete_ingredient($id) {
    global $db;
    $query = 'DELETE FROM ingredients
              WHERE ingredient_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}

// ==============================
// INSTRUCTION FUNCTIONS
// ==============================

// Get all instructions
function get_all_instructions() {
    global $db;
    $query = 'SELECT * FROM instructions ORDER BY instruction_id';
    $statement = $db->prepare($query);
    $statement->execute();
    $instructions = $statement->fetchAll();
    $statement->closeCursor();
    return $instructions;
}

// Get single instruction
function get_instruction($id) {
    global $db;
    $query = 'SELECT * FROM instructions WHERE instruction_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $instruction = $statement->fetch();
    $statement->closeCursor();
    return $instruction;
}

// Add new instruction
function add_instruction($recipe_id, $step_number, $step_text) {
    global $db;
    $query = 'INSERT INTO instructions (recipe_id, step_number, step_text)
              VALUES (:recipe_id, :step_number, :step_text)';
    $statement = $db->prepare($query);
    $statement->bindValue(':recipe_id', $recipe_id);
    $statement->bindValue(':step_number', $step_number);
    $statement->bindValue(':step_text', $step_text);
    $statement->execute();
    $statement->closeCursor();
}


// Delete instruction
function delete_instruction($id) {
    global $db;
    $query = 'DELETE FROM instructions
              WHERE instruction_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}

// Get instructions by recipe
function get_instructions_by_recipe($recipe_id) {
    global $db;
    $query = 'SELECT * FROM instructions
              WHERE recipe_id = :recipe_id
              ORDER BY step_number';
    $statement = $db->prepare($query);
    $statement->bindValue(':recipe_id', $recipe_id);
    $statement->execute();
    $instructions = $statement->fetchAll();
    $statement->closeCursor();
    return $instructions;
}
// Update instruction
function update_instruction($id, $step_number, $step_text) {
    global $db;
    $query = 'UPDATE instructions
              SET step_number = :step_number,
                  step_text = :step_text
              WHERE instruction_id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':step_number', $step_number);
    $statement->bindValue(':step_text', $step_text);
    $statement->execute();
    $statement->closeCursor();
}

?>
