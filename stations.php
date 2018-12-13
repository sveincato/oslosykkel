<?php	
	
	$method = $_SERVER['REQUEST_METHOD'];
	$parameter = $_SERVER['QUERY_STRING'];
	$identifier =$_GET['Identifier'];
	$res = array();
	
	switch($method) {
	
	case 'GET':
		
		
		$stations = shell_exec('curl -H "Client-Identifier: '.$identifier.'" https://oslobysykkel.no/api/v1/stations');
		$availability = shell_exec('curl -H "Client-Identifier: '.$identifier.'" https://oslobysykkel.no/api/v1/stations/availability');
			
		$titel = json_decode($stations, true);
		$avail = json_decode($availability, true);
		
		foreach ($titel['stations'] as $s){
		
			foreach ($avail['stations'] as $a){
				if ($s['id'] == $a['id'] ){
					$obj = array($s['title'],$s['id'],$a['availability']['bikes'],$a['availability']['locks']);
					$res[] = $obj;
				}
			}
		
		}
				
		echo  json_encode($res);
		
		break;
		
	default:
		var_dump('Invalid Method');
		break;
	}


?>