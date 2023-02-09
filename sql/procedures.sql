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
	IN cintact_no varchar(15),
    IN nic varchar(12),
    IN role varchar(20)
)
BEGIN
	INSERT INTO user (name,email,password_hash,address,contact_no,type)
    VALUES (name,email,password_hash,address,contact_no,'Staff');
    SET @id = LAST_INSERT_ID();
    INSERT INTO staff VALUES(@id,'working',nic,role);
END$$
DELIMITER ;