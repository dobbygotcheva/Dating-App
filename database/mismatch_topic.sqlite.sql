CREATE TABLE mismatch_topic (
  topic_id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(48),
  category_id INTEGER
);

INSERT INTO mismatch_topic (topic_id, name, category_id) VALUES 
(1, 'Tattoos', 1),
(2, 'Muscles', 1),
(3, 'Body piercings', 1),
(4, 'Moustache', 1),
(5, 'Long hair', 1),
(6, 'Reality TV', 2),
(7, 'Professional wrestling', 2),
(8, 'Horror movies', 2),
(9, 'Easy listening music', 2),
(10, 'The opera', 2),
(11, 'Sushi', 3),
(12, 'Spam', 3),
(13, 'Spicy food', 3),
(14, 'Peanut butter & banana sandwiches', 3),
(15, 'Martinis', 3),
(16, 'Slavi Trifonov', 4),
(17, 'Bill Gates', 4),
(18, 'Boris Soltariiski', 4),
(19, 'Pavel Vezhinov', 4),
(20, 'Martha Vatchkova', 4),
(21, 'Yoga', 5),
(22, 'Weightlifting', 5),
(23, 'Cube puzzles', 5),
(24, 'Karaoke', 5),
(25, 'Hiking', 5); 