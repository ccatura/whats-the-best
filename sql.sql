DROP TABLE categories;
DROP TABLE genre;
DROP TABLE cat_genre;
DROP TABLE users;



--Create all tables
CREATE TABLE users (
    user_name   VARCHAR(32) UNIQUE NOT NULL,
    name        VARCHAR(255) NOT NULL,
    year_born   INT(4) NOT NULL,
    pword       VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    PRIMARY KEY (user_name)
);

CREATE TABLE categories (
    id      INT NOT NULL auto_increment,
    name    VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE genres (
    id              INT NOT NULL auto_increment,
    name            VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE cat_genre (
    cat_id          INT NOT NULL,
    genre_id        INT NOT NULL,
    FOREIGN KEY (cat_id) REFERENCES categories (id),
    FOREIGN KEY (genre_id) REFERENCES genres (id),
    CONSTRAINT uq_cat_genre UNIQUE(cat_id, genre_id)
);

CREATE TABLE data (
    id              INT NOT NULL auto_increment,
    name            VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
-- took off:
-- cat_id          INT NOT NULL,
-- FOREIGN KEY (cat_id) REFERENCES categories (id)


CREATE TABLE answers (
    users_user_name VARCHAR(32) NOT NULL,
    data_id         INT NOT NULL,
    genre_id        INT NOT NULL,
    cat_id          INT NOT NULL,
    FOREIGN KEY (genre_id) REFERENCES genres (id),
    FOREIGN KEY (data_id)  REFERENCES data (id),
    FOREIGN KEY (cat_id)   REFERENCES categories (id),
    CONSTRAINT uq_answer UNIQUE(users_user_name, cat_id, genre_id)
);

CREATE TABLE messages (
    id                  INT NOT NULL auto_increment,
    user_name_from      VARCHAR(32) NOT NULL,
    user_name_to        VARCHAR(32) NOT NULL,
    subject             VARCHAR(128) NOT NULL,
    messages            TEXT NOT NULL,
    timestamp           DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (user_name_from) REFERENCES users (user_name),
    FOREIGN KEY (user_name_to) REFERENCES users (user_name)
);


-- Make some users
INSERT INTO `users`(`user_name`, `name`, `year_born`, `pword`) VALUES ('ccatura', 'Charles Catura', 1973, 'abc123');
INSERT INTO `users`(`user_name`, `name`, `year_born`, `pword`) VALUES ('bcatura', 'Barles Catura', 1971, 'abc123');
INSERT INTO `users`(`user_name`, `name`, `year_born`, `pword`) VALUES ('acatura', 'Arles Catura', 1972, 'abc123');
INSERT INTO `users`(`user_name`, `name`, `year_born`, `pword`) VALUES ('dcatura', 'Darles Catura', 1979, 'abc123');
INSERT INTO `users`(`user_name`, `name`, `year_born`, `pword`) VALUES ('ecatura', 'Earles Catura', 1979, 'abc123');
INSERT INTO `users`(`user_name`, `name`, `year_born`, `pword`) VALUES ('fcatura', 'Farles Catura', 1980, 'abc123');


-- Make some categories
INSERT INTO `categories`(`name`) VALUES ('Books'),
                                        ('Movies'),
                                        ('Actors'),
                                        ('Music - Bands'),
                                        ('Video Game Consoles'),
                                        ('Video Games - Home'),
                                        ('Video Games - Arcade'),
                                        ('Toys'),
                                        ('Forgotten Restaurants'),
                                        ('Forgotten Stores');

INSERT INTO `categories`(`name`) VALUES ('Electronics');
INSERT INTO `categories`(`name`) VALUES ('Music - Singers');
INSERT INTO `categories`(`name`) VALUES ('TV Shows');




-- Make some genres
INSERT INTO `genres`(`name`) VALUES ('Horror'),
                                    ('Comedy'),
                                    ('Rom-com'),
                                    ('Documentary'),
                                    ('Action'),
                                    ('Crime'),
                                    ('Mystery'),
                                    ('Romance'),
                                    ('Sci-Fi'),
                                    ('History');

INSERT INTO `genres`(`name`) VALUES ('Rock');
INSERT INTO `genres`(`name`) VALUES ('R and B');
INSERT INTO `genres`(`name`) VALUES ('Jazz');
INSERT INTO `genres`(`name`) VALUES ('Metal');
INSERT INTO `genres`(`name`) VALUES ('Classical');
INSERT INTO `genres`(`name`) VALUES ('Rap');

INSERT INTO `genres`(`name`) VALUES ('Buffet');
INSERT INTO `genres`(`name`) VALUES ('Ice Cream');
INSERT INTO `genres`(`name`) VALUES ('Asian');
INSERT INTO `genres`(`name`) VALUES ('Vegetarian');
INSERT INTO `genres`(`name`) VALUES ('Fast Food');

INSERT INTO `genres`(`name`) VALUES ('Clothing');
INSERT INTO `genres`(`name`) VALUES ('Recreational');
INSERT INTO `genres`(`name`) VALUES ('Malls');
INSERT INTO `genres`(`name`) VALUES ('Convenient');
INSERT INTO `genres`(`name`) VALUES ('Gas Stations');

INSERT INTO `genres`(`name`) VALUES ('Adventure');
INSERT INTO `genres`(`name`) VALUES ('Role Playing');
INSERT INTO `genres`(`name`) VALUES ('Shoot ''em');
INSERT INTO `genres`(`name`) VALUES ('Sports');
INSERT INTO `genres`(`name`) VALUES ('Art');

INSERT INTO `genres`(`name`) VALUES ('Infant');
INSERT INTO `genres`(`name`) VALUES ('Toddler');
INSERT INTO `genres`(`name`) VALUES ('Outdoor');
INSERT INTO `genres`(`name`) VALUES ('Construction');
INSERT INTO `genres`(`name`) VALUES ('Electronic');

INSERT INTO `genres`(`name`) VALUES ('All');
INSERT INTO `genres`(`name`) VALUES ('Maze/Puzzle');



-- Make some genre-category links
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('1', '1');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('1', '3');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('1', '4');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('1', '7');

INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('2', '2');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('2', '3');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('2', '5');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('2', '9');

INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('3', '2');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('3', '3');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('3', '6');
INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ('3', '10');


-- Make some data
INSERT INTO `data` (`name`) VALUES ('Tom Hanks');
INSERT INTO `data` (`name`) VALUES ('Tom Cruise');
INSERT INTO `data` (`name`) VALUES ('Jennifer Lawrence');

INSERT INTO `data` (`name`) VALUES ('Goosebumps');
INSERT INTO `data` (`name`) VALUES ('The Hardy boys');

INSERT INTO `data` (`name`) VALUES ('Die Hard');
INSERT INTO `data` (`name`) VALUES ('The Breakfast Club');
INSERT INTO `data` (`name`) VALUES ('Ferris Beuler''s Day Off');


-- Make some answers
INSERT INTO `answers` (`users_user_name`, `data_id`, `genre_id`, `cat_id`) VALUES ('ccatura', '1', '3', '3');


-- Join answers to genre
SELECT data.name as 'data_name', genres.name as 'genres_name'
FROM `answers`
INNER JOIN `data` ON data.id = answers.data_id
INNER JOIN `genres` ON genres.id = answers.genre_id
ORDER BY data.name


-- Join answers to category
-- SELECT data.name as 'data_name', genres.name as 'genres_name'
-- FROM `answers`
-- INNER JOIN `categories` ON categories.id = answers.cat_id
-- INNER JOIN `data`       ON data.id = answers.data_id
-- INNER JOIN `genres`     ON genres.id = answers.genre_id
-- WHERE categories.name = 'Actors'
-- ORDER BY data.name


-- counts - Join answers to category - finds the most popular in the answers
SELECT data.name, count(*) as totals
FROM answers
INNER JOIN `data` ON data.id = answers.data_id
WHERE data.cat_id = 3 -- this is for  actors
GROUP BY answers.data_id
ORDER BY totals DESC


-- Get specific data name and their genre votes
SELECT genres.name, count(*) as 'totals'
FROM answers
INNER JOIN `genres` ON genres.id = answers.genre_id
WHERE answers.data_id = 1 -- tom hanks
GROUP BY genres.name





-- joins boards to find genres related to categories
SELECT
categories.name as 'catergories_name',
genres.name as 'genres_name'
FROM `cat_genre`
INNER JOIN categories ON categories.id = cat_genre.cat_id
INNER JOIN genres ON genres.id = cat_genre.genre_id
ORDER BY categories.name



-- get all genres for each category
SELECT categories.name as 'cat_name', genres.name as 'genre_name' FROM `cat_genre`
INNER JOIN categories ON categories.id = cat_genre.cat_id
INNER JOIN genres ON genres.id = cat_genre.genre_id
ORDER BY categories.name, genres.name



-- put all checkboxes into cat_genre table





























-- OLD OLD OLD OLD
-- Joins board row and payer to show only results with ccatura
SELECT *
FROM board_row
INNER JOIN payer
ON board_row.payer_id = payer.user_name
WHERE board_row.payer_id = 'ccatura'

-- Joins all tables on board #1 - it may be messed up a little, but for the most part, it works
SELECT *
FROM board_row
INNER JOIN payer
ON board_row.payer_id = payer.user_name
INNER JOIN board
ON board.payer_id = payer.user_name
INNER JOIN payee
ON payee.id = board_row.payee_id
WHERE board.id = 1


-- with all the months
SELECT 	board.name,
		payer.user_name,
		payee.name,
		board_row.january,
        board_row.february,
        board_row.march,
        board_row.april,
        board_row.may,
        board_row.june,
        board_row.july,
        board_row.august,
        board_row.september,
        board_row.october,
        board_row.november,
        board_row.december
FROM board_row
INNER JOIN payer
ON board_row.payer_id = payer.user_name
INNER JOIN board
ON board.payer_id = payer.user_name
INNER JOIN payee
ON payee.id = board_row.payee_id
WHERE board.id = 1


=======




SELECT  board_row.id as 'board_row_id',
		payee.id as 'payee_id',
		payee.name as 'payee_name',
		board.name as 'board_name',
		board_row.board_id as 'board_row_board_id',
	    payer.user_name,
        board_row.january,
        board_row.february,
        board_row.march,
        board_row.april,
        board_row.may,
        board_row.june,
        board_row.july,
        board_row.august,
        board_row.september,
        board_row.october,
        board_row.november,
        board_row.december
FROM payer
INNER JOIN board ON board.payer_id = payer.user_name
INNER JOIN board_row on board_row.board_id = board.id
INNER JOIN payee on payee.id = board_row.payee_id
WHERE board.id = 1;