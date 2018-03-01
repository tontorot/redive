use redive;
DROP TABLE IF EXISTS chara_name;
CREATE TABLE chara_name(
 chara_id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 chara_name varchar(100) NOT NULL
);
