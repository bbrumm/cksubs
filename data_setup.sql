USE ck_subscribers;

CREATE TABLE subscriber (
  subscriber_id int(10) DEFAULT NULL,
  first_name varchar(200) DEFAULT NULL,
  email_address varchar(320) DEFAULT NULL,
  subscriber_state varchar(100) DEFAULT NULL,
  subscriber_created_at date DEFAULT NULL,
  KEY idx_sub_id (subscriber_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


