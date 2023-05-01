DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `increment_views`(IN `id` INT)
BEGIN
    UPDATE post
    SET views = views + 1
    WHERE post_id = id;
END$$
DELIMITER ;