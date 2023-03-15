DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `putAnnouncement`(
	IN tit varchar(1000),
    IN cont text,
 	IN cat varchar(255),
    IN shod varchar(1000),
    IN auth varchar(255)
)
BEGIN
	INSERT INTO post(title,content,date,views,visible_flag,visible_start_date,type) VALUES
    (tit,cont,CURRENT_DATE,0,1,CURRENT_DATE,'announcement');
    SET @id = LAST_INSERT_ID();
    INSERT INTO announcement 
    VALUES(@id,cat,shod,auth);
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addStaff`(
	IN name varchar(255),
	IN email varchar(255),
	IN password_hash varchar(255),
	IN address varchar(255),
	IN contact_no varchar(15),
    IN nic varchar(12),
    IN role int,
    IN adder_id int
)
BEGIN
	INSERT INTO users (email,user_type,state_id,name,contact_no,address,password_hash)
    VALUES (email,1,1,name,contact_no,address,password_hash);
    SET @id = LAST_INSERT_ID();
    INSERT INTO staff(user_id,nic,staff_type,added_by) VALUES(@id,nic,role,adder_id);
END$$
DELIMITER ;