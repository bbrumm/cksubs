USE ck_subscribers;

CREATE TABLE subscriber (
  subscriber_id int(10) DEFAULT NULL,
  first_name varchar(200) DEFAULT NULL,
  email_address varchar(320) DEFAULT NULL,
  subscriber_state varchar(100) DEFAULT NULL,
  subscriber_created_at date DEFAULT NULL,
  KEY idx_sub_id (subscriber_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE tag_map (
  tag_map_id INT(2) PRIMARY KEY,
  map_value VARCHAR(50),
  KEY idx_tag_map_id (tag_map_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO tag_map (tag_map_id, map_value) VALUES (1, 'Match'),(2, 'Ignore');

CREATE TABLE tag (
  tag_id int(10) DEFAULT NULL,
  tag_name varchar(200) DEFAULT NULL,
  tag_map_id INT(1),
  KEY idx_tag_id (tag_id),
  FOREIGN KEY fk_tag_map (tag_map_id)
  REFERENCES tag_map(tag_map_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE subscriber_bk (
  subscriber_id int(10) DEFAULT NULL,
  first_name varchar(200) DEFAULT NULL,
  email_address varchar(320) DEFAULT NULL,
  subscriber_state varchar(100) DEFAULT NULL,
  subscriber_created_at date DEFAULT NULL,
  KEY idx_sub_id (subscriber_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;