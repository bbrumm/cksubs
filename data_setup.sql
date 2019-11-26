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
  last_updated DATETIME,
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

CREATE TABLE tag_bk (
  tag_id int(10) DEFAULT NULL,
  tag_name varchar(200) DEFAULT NULL,
  tag_map_id int(1) DEFAULT NULL,
  last_updated datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (452865, 'Start General',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (609574, 'Start DSA Sales 02',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (446786, 'Start DSA Sales 01',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (980720, 'Start Content 11',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (980720, 'Start Content 10',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (823846, 'Start Content 09',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (715082, 'Start Content 08',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (659105, 'Start Content 07',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (514580, 'Start Content 06',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (508869, 'Start Content 05',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (502794, 'Start Content 04',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (502787, 'Start Content 03',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (435165, 'Start Content 02',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (390939, 'Start Content 01',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (609575, 'Done DSA Sales 02',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (446787, 'Done DSA Sales 01',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (980723, 'Done Content 11',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (980723, 'Done Content 10',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (823848, 'Done Content 09',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (715084, 'Done Content 08',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (659106, 'Done Content 07',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (514581, 'Done Content 06',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (508870, 'Done Content 05',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (502795, 'Done Content 04',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (502788, 'Done Content 03',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (964507, 'Done Content 02',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (429090, 'Done Content 01',1, '2019-01-01');
INSERT INTO tag (tag_id, tag_name, tag_map_id, last_updated) VALUES (435103, 'DONESEQ Engagement DB Normalisation',2, '2019-01-01');

INSERT INTO subsciber (subscriber_id, first_name, email_address) VALUES (1, 'Test', 'test@test.com');
INSERT INTO subsciber (subscriber_id, first_name, email_address) VALUES (2, 'More', 'more@test.com');
