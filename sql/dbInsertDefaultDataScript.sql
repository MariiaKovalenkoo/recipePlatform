USE RecipesPlatform;

INSERT INTO User (username, password, firstName, lastName, email)
VALUES
    ('user1', SHA2('password1', 256), 'John', 'Doe', 'john@example.com'),
    ('user2', SHA2('password2', 256), 'Jane', 'Smith', 'jane@example.com'),
    ('user3', SHA2('password3', 256), 'Mike', 'Johnson', 'mike@example.com'),
    ('user4', SHA2('password4', 256), 'System', 'User', 'system@example.com');


INSERT INTO Recipe (recipeName, ingredients, description, instructions, isPublic, mealType, dietaryPreference, cuisineType, userId, imgPath)
VALUES
    ('Pancakes', 'Flour, eggs, milk, sugar', 'Delicious pancakes for breakfast', 'Mix all ingredients, fry on a pan', FALSE, 'BREAKFAST', 'NOT SPECIFIED', 'NOT SPECIFIED', 1, '/img/recipes/pancakes.jpg'),
    ('Spaghetti Carbonara', 'Spaghetti, eggs, pancetta, black pepper, Parmesan cheese', 'Classic Italian pasta dish', 'Boil spaghetti, fry pancetta, mix eggs and cheese, toss together', FALSE, 'DINNER', 'NOT SPECIFIED', 'ITALIAN', 1, '/img/recipes/carbonara.jpg'),
    ('Vegetable Stir-Fry', 'Broccoli, Carrots, Bell Peppers, Soy Sauce', 'Healthy and tasty stir-fry.', '1. Chop vegetables. 2. Stir-fry with soy sauce.', FALSE, 'DINNER', 'VEGETARIAN', 'ASIAN', 2, '/img/recipes/veggies.jpg'),
    ('Chocolate Cake', 'Flour, Sugar, Cocoa Powder, Eggs', 'Decadent chocolate cake.', '1. Mix flour, sugar, cocoa powder, and eggs. 2. Bake in the oven.', TRUE, 'DESSERT', 'NOT SPECIFIED', 'NOT SPECIFIED', 3, '/img/recipes/cake.jpg'),
    ('Grilled Salmon', 'Salmon fillet, olive oil, lemon, garlic, salt, pepper', 'Healthy and flavorful grilled salmon', '1. Marinate salmon with olive oil, lemon, garlic, salt, and pepper. 2. Grill until cooked.', TRUE, 'DINNER', 'NOT SPECIFIED', 'NOT SPECIFIED', 2, '/img/recipes/salmon.jpg'),
    ('Caprese Salad', 'Tomatoes, fresh mozzarella, basil, balsamic glaze', 'Refreshing Italian salad', '1. Slice tomatoes and mozzarella. 2. Arrange on a plate with fresh basil. 3. Drizzle with balsamic glaze.', TRUE, 'LUNCH', 'VEGETARIAN', 'ITALIAN', 3, '/img/recipes/caprese.jpg'),
    ('Chicken Alfredo Pasta', 'Chicken breast, fettuccine pasta, heavy cream, Parmesan cheese', 'Creamy and satisfying pasta dish', '1. Cook pasta. 2. Sauté chicken. 3. Mix cooked pasta, chicken, heavy cream, and Parmesan cheese.', TRUE, 'DINNER', 'NOT SPECIFIED', 'NOT SPECIFIED', 4 , '/img/recipes/alfredo.jpg'),
    ('Berry Smoothie', 'Mixed berries, yogurt, banana, honey', 'Refreshing and nutritious smoothie', '1. Blend mixed berries, yogurt, banana, and honey until smooth. 2. Enjoy!', TRUE, 'BREAKFAST', 'VEGETARIAN', 'NOT SPECIFIED', 2, '/img/recipes/smoothie.jpg');