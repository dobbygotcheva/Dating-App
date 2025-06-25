CREATE TABLE mismatch_user (
  user_id INTEGER PRIMARY KEY AUTOINCREMENT,
  username VARCHAR(32),
  password VARCHAR(40),
  join_date DATETIME,
  first_name VARCHAR(32),
  last_name VARCHAR(32),
  gender VARCHAR(1),
  birthdate DATE,
  city VARCHAR(32),
  state VARCHAR(2),
  picture VARCHAR(32)
);

INSERT INTO mismatch_user (user_id, username, password, join_date, first_name, last_name, gender, birthdate, city, state, picture) VALUES 
(1, 'sidneyk', 'sidneyk', '2008-06-03 14:51:46', 'Sidney', 'Kelsow', 'F', '1984-07-19', 'Tempe', 'AZ', 'sidneypic.jpg'),
(2, 'nevilj', 'nevilj', '2008-06-03 14:52:09', 'Nevil', 'Johansson', 'M', '1973-05-13', 'Reno', 'NV', 'nevilpic.jpg'),
(3, 'alexc', 'alexc', '2008-06-03 14:53:05', 'Alex', 'Cooper', 'M', '1974-09-13', 'Boise', 'ID', 'alexpic.jpg'),
(4, 'sdaniels', 'sdaniels', '2008-06-03 14:58:40', 'Susannah', 'Daniels', 'F', '1977-02-23', 'Pasadena', 'CA', 'susannahpic.jpg'),
(5, 'ethelh', 'ethelh', '2008-06-03 15:00:37', 'Ethel', 'Heckel', 'F', '1943-03-27', 'Wichita', 'KS', 'ethelpic.jpg'),
(6, 'oklugman', 'oklugman', '2008-06-03 15:00:48', 'Oscar', 'Klugman', 'M', '1968-06-04', 'Providence', 'RI', 'oscarpic.jpg'),
(7, 'belitac', 'belitac', '2008-06-03 15:01:08', 'Belita', 'Chevy', 'F', '1975-07-08', 'El Paso', 'TX', 'belitapic.jpg'),
(8, 'jasonf', 'jasonf', '2008-06-03 15:01:19', 'Jason', 'Filmington', 'M', '1969-09-24', 'Hollywood', 'CA', 'jasonpic.jpg'),
(9, 'dierdre', 'dierdre', '2008-06-03 15:01:51', 'Dierdre', 'Pennington', 'F', '1970-04-26', 'Cambridge', 'MA', 'dierdrepic.jpg'),
(10, 'baldpaul', 'baldpaul', '2008-06-03 15:02:02', 'Paul', 'Hillsman', 'M', '1964-12-18', 'Charleston', 'SC', 'paulpic.jpg'),
(11, 'jnettles', 'jnettles', '2008-06-03 15:02:13', 'Johan', 'Nettles', 'M', '1981-11-03', 'Athens', 'GA', 'johanpic.jpg'),
(12, 'rubyr', 'rubyr', '2008-06-03 15:02:24', 'Ruby', 'Reasons', 'F', '1972-09-18', 'Conundrum', 'AZ', 'rubypic.jpg'),
(13, 'theking', 'theking', '2008-06-05 14:19:20', 'Elmer', 'Priestley', 'M', '1979-01-08', 'Tupelo', 'MS', 'elmerpic.jpg'),
(14, 'owenb', 'owenb', '2008-06-26 08:25:48', 'Owen', 'Bugsby', 'M', '1982-06-22', 'Kokomo', 'IN', 'owenpic.jpg'); 