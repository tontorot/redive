use redive;
DROP TABLE IF EXISTS chara_info;
CREATE TABLE chara_info(
 chara_id int(10) NOT NULL,
 rank int(10) NOT NULL,
 item_id1 int(10) DEFAULT NULL,
 item_id2 int(10) DEFAULT NULL,
 item_id3 int(10) DEFAULT NULL,
 item_id4 int(10) DEFAULT NULL,
 item_id5 int(10) DEFAULT NULL,
 item_id6 int(10) DEFAULT NULL,
 UNIQUE(chara_id, rank)
);
