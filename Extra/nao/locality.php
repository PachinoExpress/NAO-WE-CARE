<?php
require_once 'config.php';
require_once 'database.php';
if(isset($_REQUEST['s'])){

	$sQuery = "	SELECT l.name, l.keyurl, sa.name AS sa_name, sa.number_plate, sa.keyurl AS sa_keyurl, a.keyurl AS a_keyurl,  CONCAT(l.name, ' (', sa.number_plate, ')') AS label
				FROM locality AS l
				JOIN sub_administrative_area AS sa
                    ON sa.keyurl = l.fk_subadministrative_area
				JOIN administrative_area AS a
                    ON a.keyurl = sa.fk_administrative_area
				WHERE `l`.`name` LIKE '". $_REQUEST['s'] ."%'
				ORDER BY `l`.`name`
				LIMIT 12;";

    echo json_encode(Database::instance()->fetchAllRows($sQuery, true));
	
}else die('{}');
