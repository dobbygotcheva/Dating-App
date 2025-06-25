CREATE TABLE mismatch_category (
  category_id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(48)
);

INSERT INTO mismatch_category (category_id, name) VALUES 
(1, 'Appearance'),
(2, 'Entertainment'),
(3, 'Food'),
(4, 'People'),
(5, 'Activities'); 