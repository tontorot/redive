use redive;
DROP TABLE IF EXISTS item_info;
CREATE TABLE item_info(
 item_id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 item_name varchar(100) NOT NULL,
 material_id1 int(10) DEFAULT NULL,
 require_num1 int(10) DEFAULT '0',
 material_id2 int(10) DEFAULT NULL,
 require_num2 int(10) DEFAULT '0',
 material_id3 int(10) DEFAULT NULL,
 require_num3 int(10) DEFAULT '0'
);
