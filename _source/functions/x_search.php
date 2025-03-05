<?php
	/* 
		 ____  __  __  ___  ____  ____  ___  _   _ 
		(  _ \(  )(  )/ __)( ___)(_  _)/ __)( )_( )
		 ) _ < )(__)(( (_-. )__)  _)(_ \__ \ ) _ ( 
		(____/(______)\___/(__)  (____)(___/(_) (_) www.bugfish.eu
			  ___                                         _     
			 / __)                                       | |    
			| |__ ____ ____ ____   ____ _ _ _  ___   ____| |  _ 
			|  __) ___) _  |    \ / _  ) | | |/ _ \ / ___) | / )
			| | | |  ( ( | | | | ( (/ /| | | | |_| | |   | |< ( 
			|_| |_|   \_||_|_|_|_|\____)\____|\___/|_|   |_| \_)
		Copyright (C) 2024 Jan Maurice Dahlmanns [Bugfish]

		This program is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 3 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program.  If not, see <https://www.gnu.org/licenses/>.
	*/
	function x_search($mysql, $table, $search_fields = array(), $get_fields = array(), $search_string = "", $uniqueref = "id") {
		// Abort if Search String if not Set
		if(empty($search_string) OR trim(@$search_string ?? '') == "" OR @$search_string == false) { return false; }
		
		// Trim Search String
		$search_string = trim($search_string ?? '');
		
		// Get Current Search Tag Array
		if(strpos($search_string, " ") > -1) { 
			$search_string = preg_replace('/\s+/', ' ', $search_string); 
			$search_array =  explode(" ", $search_string);
		} else {$search_array[0] = trim($search_string ?? '');}
		

		// Prepare Array for Binds for Search Query
		$new_bind_array	=	array();
		$counter = 0; // Search String Counter
		$c_q	=	""; // Serach Query Counter
		$bindcounter = 0;
		
		
		
		// Prepare the Query for Search Results
		while (is_numeric($counter)) {
			if(@$search_array[$counter] != null) {
				if(trim(@$search_array[$counter] ?? '') != "") {
					
					if($counter == 0) {
						if($bindcounter == 0) {
							$c_q = "SELECT * FROM `".$table ."` WHERE (title LIKE CONCAT( '%', ?, '%') OR text LIKE CONCAT( '%', ?, '%') OR category = CONCAT( '%', ?, '%') OR sec_category LIKE CONCAT( '%', ?, '%')) ";
							$bindcounter++;
						} else {
							
						}
							
					} else {
						foreach($search_fields AS $tmpkey => $tmpvalue) {
							$c_q .= " OR ".$tmpvalue[0]." LIKE CONCAT( '%', ?, '%') ";	
						}
					}
					
					
					
					$new_ar["type"]	 =	"s";
					$new_ar["value"] =	$search_array[$counter];
					
					foreach($search_fields AS $tmpkey => $tmpvalue) {
						array_push($new_bind_array, $new_ar);				
					}
				}  $counter	= $counter + 1;
			} else {$counter	= "notset";}
		}
		
		// Query and Sorting Variables
		$cur_ar		=	$mysql->select( $c_q." ORDER BY ".$uniqueref." DESC", true, $new_bind_array);
		$ra		=	null;
		$rad	=	null;
		
		// Scoring for Items
		foreach($cur_ar as $key => $score_r){
			// Set Fields available for Score
			$counter = 0;
			foreach($get_fields AS $tmpkey => $tmpvalue) {
				$ra[$score_r[$uniqueref]][$tmpvalue]  	  = $score_r[$tmpvalue];
			}
			
			$rad[0][$score_r[$uniqueref]]["score"]  = 0;
				
			while (is_numeric($counter)) {
				if(@$search_array[$counter] != null) {
					if(trim(@$search_array[$counter] ?? '') != "") {
						foreach($search_fields AS $tmpkey => $tmpvalue) {
							$rad[0][$score_r[$uniqueref]]["score"] = @$rad[0][$score_r[$uniqueref]][$tmpvalue[0]] + (substr_count(strtolower($score_r[$tmpvalue[0]]), strtolower($search_array[$counter])) * $tmpvalue[1]);
						}	
					} $counter	= $counter + 1;
				} else { $counter	= "notset"; }
			}
			
			// Add Related IF for later Recognizing
			$rad[0][$score_r[$uniqueref]][$uniqueref] = $score_r[$uniqueref];
		}	
		
		if(@$rad[0]) {
			array_multisort($rad[0], SORT_DESC);
			$output = array();
			foreach (@$rad[0] as &$value) {array_push($output, $ra[$value[$uniqueref]]);}	
			return $output;
		} else { return array(); }
	}

