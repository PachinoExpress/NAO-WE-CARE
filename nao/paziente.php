<?php
require_once 'config.php';
require_once 'database.php';


if(isset($_POST['cmd'])){
	switch($_POST['cmd']){
		case 'cerca-paziente':

			$sQuery = "	SELECT *
						FROM paziente
						WHERE `id` = '{$_GET['id_paziente']}'
						LIMIT 1;";
				
			echo json_encode(Database::instance()->fetchOneRow($sQuery));

			break;
		

		case 'inserisci-paziente':
			
			unset($_POST['cmd']);
			unset($_POST['secureTicket']);
			
			$sFields = implode('`, `', array_keys($_GET));
			
			foreach($_GET as $sKey => $sValue) $_GET[$sKey] = Database::instance()->escapeString($sValue);
			
			$sQuery = "	INSERT INTO `paziente` (`nome`, `cognome`, `data_nascita`, `luogo_nascita`) 
                                    VALUES ('{$_GET['nome']}', 
                                            '{$_GET['cognome']}', 
                                            '{$_GET['data_nascita']}', 
                                            '{$_GET['luogo_nascita']}');"

			$nIdPaziente = Database::instance()->doInsertIntoQuery($sQuery);

			echo json_encode(array('id' => $nIdPaziente));

			break;
		
		case 'modifca-paziente':
			$sQuery = "	UPDATE `paziente` 
						SET `{$_POST['campo']}` = '". Text::toUtf8($_POST['valore']) ."' 
						WHERE `id` = {$_POST['id']};";

			echo json_encode(array('success' => Database::instance()->doQuery($sQuery)));

			break;
		
		case 'delete':

		break;
	}
	
	return;
}
?>