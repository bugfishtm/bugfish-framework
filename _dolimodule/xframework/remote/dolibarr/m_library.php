<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/ Dolibarr Set	*/
	// Check if a Var is Set
	function m_isset($var){if(!empty($var) AND $var != NULL AND trim($var) != "") {return true;}return false;}
	
	// Get the current rowID of logged in User, if error than false
	function m_login_id($db){ $result = m_db_row($db, 'SELECT * FROM ' . MAIN_DB_PREFIX . 'user WHERE login = "' . @$_SESSION["dol_login"] . '"'); if(!$result) {return false;}return $result["rowid"];}	
	// Get the current name of User by UserID, if error than false
	function m_login_name_from_id($db, $userid){ $result = m_db_row($db, 'SELECT * FROM ' . MAIN_DB_PREFIX . 'user WHERE rowid = "' . $userid . '"'); if(!$result) {return false;} return $result["login"];}

	// Add a Default Button Linked to another Page
	function m_button_link($name, $url, $break = false, $style = "", $reacttourl = true){ if($reacttourl AND strpos($url."&", $_SERVER["REQUEST_URI"]."&") > -1) {$style .= ";background: grey !important;";} print "<a href='".$url."' class='butAction' style='".$style."'>".$name."</a>"; if($break) {echo "<br />";}}
		
	// Add a Button Able to Execute a Simple SQL Function
	function m_button_sql($db, $name, $url, $query, $get, $msgerr = "Fehler!", $msgok = "Erfolgreich!", $break = false, $style = ""){
		if(strpos(trim($url), "?") > 2) { $xurl = trim($url)."&".$get."=x"; } else {$xurl = trim($url)."?".$get."=x";}
		print "<a href='".$xurl."' class='butAction' style='".$style."'>".$name."</a>";if($break) {echo "<br />";}
		if(@$_GET[$get] == "x") {
			if($db->query($query)) { setEventMessage($msgok, "mesgs"); } else { setEventMessage($msgerr, "mesgs"); } 
			$url = str_replace("?".$get."=x&", "?", $url); $url = str_replace("&".$get."=x", "", $url); 
			print '<meta http-equiv="refresh" content="0; url='.$url.'">';exit();}}	
			
	// Get a Multiple Array with $array[COUNT]["fieldname"] = $value back.
	function m_db_rows($db, $query){ $sql_res = $db->query($query); if ($sql_res) { if ($db->num_rows($sql_res) > 0) { $count = $db->num_rows($sql_res); $row = array(); for ($i=0; $i<$count; $i++){$tmpnow = get_object_vars($db->fetch_object($sql_res)); $row[$i] = $tmpnow;} return $row; } else { return false; }} else { return false; }}	
	// Get a Single Array with $array["fieldname"] = $value back.
	function m_db_row($db, $query){ $sql_res = $db->query($query); if ($sql_res) { if ($db->num_rows($sql_res) > 0) { $tmpnow = get_object_vars($db->fetch_object($sql_res));  $row = $tmpnow; return $row; } else { return false; }} else { return false; }}		
	// Insert into a Database with array ["fieldname"] = $value;
	function m_db_row_insert($db, $table, $array, $filter = true){ if(!is_array($array)) {return false;} $build_first	=	""; $build_second	=	""; $firstrun = true; foreach( $array as $key => $value ){ if(!$firstrun) {$build_first .= ", ";} if(!$firstrun) {$build_second .= ", ";} $build_first .= $key; $valuex = $value; if($filter) {$valuex = str_replace("\\", "\\\\", htmlspecialchars($valuex));} else {$valuex = str_replace("\\", "\\\\", $valuex);} $valuex = str_replace("'", "\\'", $valuex); $build_second .= "'".$valuex."'"; $firstrun = false;} $db->query('INSERT INTO '.$table.'('.$build_first.') VALUES('.$build_second.');');}
	/* Get Array by provising a finished result */
	function m_db_rowsbycleanresult($db, $sql_res){ if ($sql_res) { if ($db->num_rows($sql_res) > 0) { $count = $db->num_rows($sql_res); $row = array(); for ($i=0; $i<$count; $i++){$tmpnow = get_object_vars($db->fetch_object($sql_res)); $row[$i] = $tmpnow;} return $row; } else { return false; }} else { return false; }}

	function m_month_num_to_name($number) {
		if($number == 1) { return "Januar";}
		if($number == 2) { return "Februar";}
		if($number == 3) { return "März";}
		if($number == 4) { return "April";}
		if($number == 5) { return "Mai";}
		if($number == 6) { return "Juni";}
		if($number == 7) { return "Juli";}
		if($number == 8) { return "August";}
		if($number == 9) { return "September";}
		if($number == 10) { return "Oktober";}
		if($number == 11) { return "November";}
		if($number == 12) { return "Dezember";}
		return "Error !";
	};
	
	// Print a Simple Table
	function m_table_simple($title, $array, $titlelist, $tableid = "", $alignarray = false, $imgeforlist = 'generic'){
		$colspan	=	count($titlelist);
		print_barre_liste($title, NULL, $_SERVER["PHP_SELF"], NULL, NULL, NULL, NULL, NULL, NULL, $imgeforlist);
		print '<table class="tagtable liste" id="mtsimple_'.$tableid.'"><tr class="liste_titre">';
		$t_r_count	=	0;
		foreach( $titlelist as $key => $value ){
				if($t_r_count == 0) {	if(!$alignarray) { $t_align	=	"left"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				elseif($t_r_count == count($titlelist)-1) {	if(!$alignarray) { $t_align	=	"right"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				else {	if(!$alignarray) { $t_align	=	"center"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				//print '<th class="liste_titre" style="text-align: '.$t_align.';">'.$value.'</th>';
				print_liste_field_titre($value, $_SERVER["PHP_SELF"], NULL, NULL, NULL, "style='text-align: ".$t_align.";'");
				$t_r_count	=	$t_r_count	+ 1;}
		print '</tr>';
		if(empty($array)) {print '<tr class="oddeven"><td colspan="'.$colspan.'" style="text-align: center"><i>Keine Daten vorhanden...</i></td></tr>';} else {
			foreach( $array as $key => $value ){
				print '<tr class="oddeven">';
				$t_r_count	=	0;
				foreach( $array[$key] as $key1 => $value1 ){
				if($t_r_count == 0) {	if(!$alignarray) { $t_align	=	"left"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				elseif($t_r_count == count($titlelist)-1) {	if(!$alignarray) { $t_align	=	"right"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				else {	if(!$alignarray) { $t_align	=	"center"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				print '<td style="text-align: '.$t_align.';">'.$value1.'</td>';
				$t_r_count	=	$t_r_count	+ 1;}				
			print '</tr>';}}
		print '</table>';}
		
		
	// Table with Search Function
	function m_table_complex($title, $array, $titlelist, $formid = "", $alignarray = false, $imgeforlist = "generic"){
		$colspan	=	count($titlelist);
		print '<form method="post"  id="mtcomplex_'.$formid.'"><input type="submit" style="display:none;">';
		print_barre_liste($title, NULL, $_SERVER["PHP_SELF"], NULL, NULL, NULL, NULL, NULL, NULL, $imgeforlist);
		print '<table class="tagtable liste">';
			if(!empty($array)) {
				print '<tr class="liste_titre">';$tcount	=	0;
				foreach( $array[0] as $key => $value ){
					$tmp_placeholder = $titlelist[$tcount];$tcount = $tcount + 1;
					$tmp_value = @htmlspecialchars($_POST['mtc_'.$key]);
					print '<th><input type="text" name="mtc_'.$key.'" value="'.@$tmp_value.'" placeholder="'.$tmp_placeholder.'">';
						if(!empty($tmp_value)) { echo '<br />Active Search:<br /><font size="-1">'.$tmp_value.'</font>'; }
						print '</th>';					
					}
				print '</tr>';}
						print '<tr class="liste_titre">';$t_r_count	= 0 ;
			foreach( $titlelist as $key => $value ){
				if($t_r_count == 0) {	if(!$alignarray) { $t_align	=	"left"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				elseif($t_r_count == count($titlelist)-1) {	if(!$alignarray) { $t_align	=	"right"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				else {	if(!$alignarray) { $t_align	=	"center"; } else {$t_align	=	$alignarray[$t_r_count]; }}
				//print '<th class="liste_titre" style="text-align: '.$t_align.';">'.$value.'</th>';
				print_liste_field_titre($value, $_SERVER["PHP_SELF"], NULL, NULL, NULL, "style='text-align: ".$t_align.";'");
				$t_r_count	=	$t_r_count	+ 1;}print '</tr>';
		if(empty($array)) {print '<tr class="oddeven"><td colspan="'.$colspan.'" style="text-align: center"><i>Keine Daten vorhanden...</i></td></tr>'; } else {
			$didfound = false;
			foreach( $array as $key => $value ){
					$search_relevant	=	true;
					foreach( $array[$key] as $key1 => $value1 ){
						if(isset($_POST["mtc_".$key1]) AND @trim($_POST["mtc_".$key1]) != "") {if(strpos($value1, $_POST["mtc_".$key1]) <= -1) {$search_relevant	=	false;}}}							
				if($search_relevant) {
					print '<tr class="oddeven">';
					$t_r_count	=	0;
					foreach( $array[$key] as $key1 => $value1 ){
						if($t_r_count == 0) {	if(!$alignarray) { $t_align	=	"left"; } else {$t_align	=	$alignarray[$t_r_count]; }}
						elseif($t_r_count == count($titlelist)-1) {	if(!$alignarray) { $t_align	=	"right"; } else {$t_align	=	$alignarray[$t_r_count]; }}
						else {	if(!$alignarray) { $t_align	=	"center"; } else {$t_align	=	$alignarray[$t_r_count]; }}
						print '<td style="text-align: '.$t_align.';">'.$value1.'</td>';
						$t_r_count	=	$t_r_count	+ 1;$didfound = true;}print '</tr>';}}
			if(!$didfound) {print '<tr class="oddeven"><td colspan="'.$colspan.'" style="text-align: center"><i>Keine Daten vorhanden...</i></td></tr>';}}
		print '</table></form>';}	
?>