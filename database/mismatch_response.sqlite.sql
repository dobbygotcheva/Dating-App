CREATE TABLE mismatch_response (
  response_id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  topic_id INTEGER,
  response INTEGER
);

-- Sample responses for user 1 (sidneyk)
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 1, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 2, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 3, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 4, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 5, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 6, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 7, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 8, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 9, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 10, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 11, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 12, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 13, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 14, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 15, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 16, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 17, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 18, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 19, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 20, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 21, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 22, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 23, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 24, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (1, 25, 1);

-- Sample responses for user 2 (nevilj)
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 1, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 2, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 3, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 4, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 5, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 6, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 7, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 8, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 9, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 10, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 11, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 12, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 13, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 14, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 15, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 16, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 17, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 18, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 19, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 20, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 21, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 22, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 23, 2);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 24, 1);
INSERT INTO mismatch_response (user_id, topic_id, response) VALUES (2, 25, 1); 