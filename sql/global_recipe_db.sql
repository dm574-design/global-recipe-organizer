/*
----------------------------------------------------------------------------------------------------------------------------------------------------
------------------------------------
Name:           global_recipe_db.sql
Author:         Drew Miller
Date:           2026-03-13
Language:       SQL
Purpose:        This code creates the global_recipe_db database and the recipes, ingredients and instructions tables with recipe_id relationships for the project.

----------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------
ChangeLog:
Who                           When                        What
----------- -----------------------------------------------------------------------------------------------------------------------------------------------------
DNM                           2026-03-13                  Original Version
DNM			      2026-03-28		  Renamed file to global_recipe_db.sql and updated schema to
		                                          normalized design with ingredient and instruction tables
DNM			      2026-05-02		  Updated file with redesign of the schema to add recipe_id to the ingredients and  													  instructions tables	                                             
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
*/


DROP DATABASE IF EXISTS global_recipe_db;
CREATE DATABASE global_recipe_db;
USE global_recipe_db;

CREATE TABLE recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_name VARCHAR(100) NOT NULL,
    cuisine VARCHAR(50) NOT NULL,
    prep_time INT NOT NULL,
    difficulty VARCHAR(20) NOT NULL
);

CREATE TABLE ingredients (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    ingredient_name VARCHAR(255) NOT NULL,
    recipe_id INT NOT NULL,
    CONSTRAINT fk_ingredients_recipes
        FOREIGN KEY (recipe_id)
        REFERENCES recipes(recipe_id)
        ON DELETE CASCADE
);

CREATE TABLE instructions (
    instruction_id INT AUTO_INCREMENT PRIMARY KEY,
    step_number INT NOT NULL,
    step_text TEXT NOT NULL,
    recipe_id INT NOT NULL,
    CONSTRAINT fk_instructions_recipes
        FOREIGN KEY (recipe_id)
        REFERENCES recipes(recipe_id)
        ON DELETE CASCADE
);

