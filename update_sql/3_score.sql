CREATE TABLE score (
    `s_id` int(4) NOT NULL auto_increment,
    q_id   int(4) ,
	a_id   int(4) ,
	user_id int(4), 
	like_item int(4),
  PRIMARY KEY (s_id)
);
