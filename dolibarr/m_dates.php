<?php 
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
?>