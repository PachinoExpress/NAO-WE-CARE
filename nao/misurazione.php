<?php
require_once 'config.php';
require_once 'database.php';


if(isset($_REQUEST['cmd'])){
	switch($_REQUEST['cmd']){

		case 'inserisci-misurazione':

			$sQuery = "INSERT INTO `misurazione` (`id_paziente`, `data`, `tipo`, `valore`)
                                    VALUES ('{$_REQUEST['id_paziente']}',
                                            CURRENT_DATETIME,
                                            '{$_REQUEST['tipo']}',
                                            '{$_REQUEST['valore']}');";

			$bSuccess = Database::instance()->doQuery($sQuery);

			echo json_encode(array('success' => $bSuccess));

			break;

		case 'ultima-misurazione':

    $myfile = fopen("nao.txt", "w") or die("Unable to open file!");
    fwrite($myfile,print_r($_REQUEST, true));
    fclose($myfile);

			$sQuery = "	SELECT `misurazioni`.*, `pazienti`.`nome`, `pazienti`.`cognome`
						FROM `misurazioni`
						JOIN `pazienti`
							ON `misurazioni`.`id_paziente` = `pazienti`.`id`
						WHERE `misurazioni`.`id_paziente` = '{$_REQUEST['id_paziente']}'
						ORDER BY `misurazioni`.`data` DESC
						LIMIT 1;";

			$aMisurazione = Database::instance()->fetchOneRow($sQuery);
			$aMisurazione['success'] = true;

			echo json_encode($aMisurazione);

			break;

		case 'delete':

		break;



	return;
  }
}

?>
