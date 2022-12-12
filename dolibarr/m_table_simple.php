<?php
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
?>