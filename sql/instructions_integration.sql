/*
-----------------------------------------------------------------------------------------
Name:        instructions_integration.sql
Author:      Drew Miller
Date:        2026-05-02
Language:    SQL / MySQL
Purpose:     Integration script used to update the existing database structure
             by linking instructions and ingredients to recipes using recipe_id.
-----------------------------------------------------------------------------------------

ChangeLog:
Who        When        What
---------  ----------  ------------------------------------------------------------------
DNM        2026-05-02  Added recipe_id column to instructions table
DNM        2026-05-02  Populated recipe_id for existing instruction records
DNM        2026-05-02  Added foreign key constraint linking instructions to recipes
DNM        2026-05-02  Verified no NULL recipe_id values remain in instructions table

DNM        2026-05-02  Added recipe_id column to ingredients table
DNM        2026-05-02  Populated recipe_id for existing ingredient records
DNM        2026-05-02  Added foreign key constraint linking ingredients to recipes
DNM        2026-05-02  Verified no NULL recipe_id values remain in ingredients table

DNM        2026-05-02  Removed orphaned records with NULL recipe_id values
DNM        2026-05-02  Performed validation queries to confirm referential integrity
-----------------------------------------------------------------------------------------
*/

ALTER TABLE instructions
ADD COLUMN recipe_id INT;

ALTER TABLE instructions
ADD CONSTRAINT fk_recipe_instruction
FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id);

SELECT * FROM instructions;
WHERE recipe_id IS NULL;

UPDATE instructions
SET recipe_id = 3;
WHERE recipe_id IS NULL;

SELECT recipe_id, recipe_name
FROM recipes;

SELECT * FROM instructions;

INSERT INTO recipes (recipe_name, cuisine, prep_time, difficulty)
upVALUES ('Boiled Eggs', 'American', 10, 'Easy');

SELECT recipe_id, recipe_name
FROM recipes;

update instructions
set recipe_id = 3
where recipe_id is null;

DELETE FROM instructions
WHERE recipe_id IS NULL;

ALTER TABLE ingredients
ADD COLUMN recipe_id INT;

UPDATE ingredients
SET recipe_id = 3
WHERE ingredient_id = 1;

ALTER TABLE ingredients
ADD CONSTRAINT fk_ingredients_recipes
FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id);

SELECT * FROM ingredients;

SELECT * FROM ingredients WHERE recipe_id IS NULL;

SELECT * FROM instructions WHERE recipe_id IS NULL;