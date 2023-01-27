<?php
	/*	__________ ____ ___  ___________________.___  _________ ___ ___  
		\______   \    |   \/  _____/\_   _____/|   |/   _____//   |   \ 
		 |    |  _/    |   /   \  ___ |    __)  |   |\_____  \/    ~    \
		 |    |   \    |  /\    \_\  \|     \   |   |/        \    Y    /
		 |______  /______/  \______  /\___  /   |___/_______  /\___|_  / 
				\/                 \/     \/                \/       \/ XPF Function Set	*/
	//////////////////////////////////////////////
	// Meta Elements
	//////////////////////////////////////////////	
	function xfp_meta_prep($val) {
		$val = strip_tags($val, '<br>');
		$val = htmlspecialchars($val);
		$val = str_replace("&nbsp;" ," ", $val);
		$val = str_replace(array('\n', '\r', '\t') ," ", $val);
		$val = preg_replace('!\s+!', ' ', $val);
		$val = str_replace("\\" ,"\\\\", $val);
		$val = str_replace("\"" ,"&qout;", $val);
		$val = substr($val, 0, 350);
		return $val;
	}	
	function xfp_meta_error($code = 404) {
		switch($code) {
			case "404": $description = "This page or content has not been found!"; $code = "Error 404"; break;
			case "403": $description = "Forbidden Page!"; $code = "Error 403"; break;
			case "401": $description = "Unauthorized!"; $code = "Error 401"; break;
			case "402": $description = "Payment Required!"; $code = "Error 402"; break;
			case "405": $description = "Method not allowed!"; $code = "Error 405"; break;
			case "500": $description = "Internal Server Error!"; $code = "Error 500"; break;
			case "db": $description = "Database Error!"; $code = "Database Error!"; break;
			default : $description = "Unknown error on Page!"; $code = "Error Unknown"; 
		}
		echo "<title>"._XFP_META_TITLE_PRE_.$code._XFP_META_TITLE_POST_."</title>";		
		echo '<meta property="og:title" content="'._XFP_META_TITLE_PRE_.$code._XFP_META_TITLE_POST_.'" />';
		echo '<meta name="description" content="'._XFP_META_DESC_PRE_.$description._XFP_META_DESC_POST_.'" />';	
		echo '<meta property="og:description" content="'._XFP_META_DESC_PRE_.$description._XFP_META_DESC_POST_.'" />';			
		if(defined("_XFP_LANG_")) { echo '<meta property="og:image" content="'._XFP_META_ERROR_IMAGE_.'" />';}		
		echo '<meta name="robots" content="noindex, nofollow" />';
		echo '<meta name="keywords" content="'." error ".$code.'" />';
		echo '<meta http-equiv="Pragma" content="no-cache" />';
		echo '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />';
		echo '<meta http-equiv="content-Type" content="text/html; utf-8" />';
		if(defined("_XFP_LANG_")) { echo '<meta http-equiv="content-Language" content="'._XFP_LANG_.'" />'; }
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		if(defined("_XFP_ADMIN_NAME_")) { echo '<meta name="author" content="'._XFP_ADMIN_NAME_.'" />'; 
					echo '<meta name="publisher" content="'._XFP_ADMIN_NAME_.'" />'; 
					echo '<meta name="copyright" content="'._XFP_ADMIN_NAME_.'" />'; } 
		if(defined("_XFP_ADMIN_MAIL_")) { echo '<meta http-equiv="Reply-to" content="'._XFP_ADMIN_MAIL_.'" />';	}
	}
	function xfp_meta($mysql, $title, $description, $keywords = false, $robots = false, $cssarray = false, $img = false, $formexpire =  false, $fallbackimage = false, $nocache = true, $canonical = false) {		
		$description =  _XFP_META_DESC_PRE_.xfp_meta_prep($description)._XFP_META_DESC_POST_;
		$title       = 	_XFP_META_TITLE_PRE_.xfp_meta_prep($title)._XFP_META_TITLE_POST_;	
		echo "<title>".$title."</title>";	
		echo '<meta property="og:title" content=\''.$title.'\'" />';
		echo '<meta name="description" content=\''.$description.'\' />';
		echo '<meta property="og:description" content=\''.$description.'\' />';
		if(is_array($cssarray)) { foreach($cssarray as $key => $val) { echo '<link rel="stylesheet" type="text/css" href="'.$val.'" />';  }
		} elseif($cssarray != false) { echo '<link rel="stylesheet" type="text/css" href="'.trim($cssarray).'" />';	 }			
		if($img == false) {
			if($fallbackimage == false) {
				if(defined("_XFP_META_FB_IMAGE_")) { echo '<meta property="og:image" content="'._XFP_META_FB_IMAGE_.'" />'; }
			} else {
				echo '<meta property="og:image" content="'.$fallbackimage.'" />';
			}
		} else {
			if(x_imgValid($img)) {
				echo '<meta property="og:image" content="'.$img.'" />';
			} else {
				if($fallbackimage == false) {
				 if(defined("_XFP_META_FB_IMAGE_")) {	echo '<meta property="og:image" content="'._XFP_META_FB_IMAGE_.'" />';}
				} else {
					echo '<meta property="og:image" content="'.$fallbackimage.'" />';
				}
			}
		}
		if($formexpire != false) { echo '<meta name="expires" content="'.$formexpire.'" />'; }	
		if($nocache != false) { echo '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />'; echo '<meta http-equiv="Pragma" content="no-cache" />'; }	
		if($canonical != false) { echo "<link rel='canonical' href='".$canonical."' />"; }
		if($robots != false) { echo '<meta name="robots" content="'.trim($robots).'" />'; }	
		if($keywords != false) { echo '<meta name="keywords" content="'.trim(htmlspecialchars($keywords)).'" />';	}
		echo '<meta name="audience" content="all" />';
		echo '<meta http-equiv="content-Type" content="text/html; utf-8" />';
		if(defined("_XFP_LANG_")) { echo '<meta http-equiv="content-Language" content="'._XFP_LANG_.'" />'; }
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';	
		if(defined("_XFP_ADMIN_NAME_")) {echo '<meta name="author" content="'._XFP_ADMIN_NAME_.'" />'; 
											echo '<meta name="publisher" content="'._XFP_ADMIN_NAME_.'" />'; 
											echo '<meta name="copyright" content="'._XFP_ADMIN_NAME_.'" />'; }
		if(defined("_XFP_ADMIN_MAIL_"))  { echo '<meta http-equiv="Reply-to" content="'._XFP_ADMIN_MAIL_.'" />'; }			
	}
	
	//////////////////////////////////////////////
	// Build Elements
	//////////////////////////////////////////////	
	function xfp_footer($text) { echo '</div><div id="xfp_footer">'.$text.'</body></html>'; }	
	function xfp_entry($var, $x, $level = 1) {if(@$x[0] == @$var AND count(@$x) < ($level+1)) { return true; }return false;}
	function xfp_headline($a, $b) { return '<div id="xfp_headline"><h1>'.htmlspecialchars($a).'</h1><font id="xfp_headline_extender"><h2 id="xfp_headline_h2">'.htmlspecialchars($b).'</h2></font></div>';}
	function xfp_top_button() { echo '<div id="xfp_top_but_1"><a title="Back" alt="Back"  href="#xfp_content"> ^Top </a></div>'; return; }
	function xfp_top_button_sec() { echo '<div id="xfp_top_but_1" class="xfpe_nomargintop"><a title="Back" alt="Back"  href="#content"> ^Top </a></div>'; return; }
	function xfp_return_button() {
		$tmploc	=	xfp_navi_location_seo();
		if(x_isset(@$tmploc[1])) {
			$return_url	=	'/'.x_hsc(@$tmploc[0]);
			if(x_isset(@$tmploc[2]) AND !x_isset(@$tmploc[3])) { $return_url = '/'.x_hsc(@$tmploc[0]).'/'.x_hsc(@$tmploc[1]); }
			if(x_isset(@$tmploc[3]) AND !x_isset(@$tmploc[4])) { $return_url = '/'.x_hsc(@$tmploc[0]).'/'.x_hsc(@$tmploc[1]).'/'.x_hsc(@$tmploc[2]); }
			if(x_isset(@$tmploc[4]) AND !x_isset(@$tmploc[5])) { $return_url = '/'.x_hsc(@$tmploc[0]).'/'.x_hsc(@$tmploc[1]).'/'.x_hsc(@$tmploc[2]).'/'.x_hsc(@$tmploc[3]); }
			if(x_isset(@$tmploc[5])) { $return_url = '/'.x_hsc(@$tmploc[1]).'/'.x_hsc(@$tmploc[2]).'/'.x_hsc(@$tmploc[3]).'/'.x_hsc(@$tmploc[4]); }
			echo '<div id="xfp_top_but_2"><a title="Back" alt="Back"  href=\''.$return_url.'\'><< Back </a></div>'; return;
		}
	}
	function xfp_return_button_sec() {
		$tmploc	=	xfp_navi_location_seo();
		if(x_isset(@$tmploc[1])) {
			$return_url	=	'/'.x_hsc(@$tmploc[0]);
			if(x_isset(@$tmploc[2]) AND !x_isset(@$tmploc[3])) { $return_url = '/'.x_hsc(@$tmploc[0]).'/'.x_hsc(@$tmploc[1]); }
			if(x_isset(@$tmploc[3]) AND !x_isset(@$tmploc[4])) { $return_url = '/'.x_hsc(@$tmploc[0]).'/'.x_hsc(@$tmploc[1]).'/'.x_hsc(@$tmploc[2]); }
			if(x_isset(@$tmploc[4]) AND !x_isset(@$tmploc[5])) { $return_url = '/'.x_hsc(@$tmploc[0]).'/'.x_hsc(@$tmploc[1]).'/'.x_hsc(@$tmploc[2]).'/'.x_hsc(@$tmploc[3]); }
			if(x_isset(@$tmploc[5])) { $return_url = '/'.x_hsc(@$tmploc[1]).'/'.x_hsc(@$tmploc[2]).'/'.x_hsc(@$tmploc[3]).'/'.x_hsc(@$tmploc[4]); }
			echo '<div id="xfp_top_but_2" class="xfpe_nomargintop"><a title="Back" alt="Back"  href=\''.$return_url.'\'><< Back </a></div>'; return;
		}
	}
	function xfp_top_button_print($url) {
		echo '<div id="btm_top_but_3"><a title="Print" alt="Print"  '; 
		echo "  onclick=\"MyWindow=window.open('".$url."','Print Item','width=600,height=300'); return false;\" "; 
		echo ' >Print</a></div>'; 
		return;}	
	function xfp_top_button_print_sec($url) {
		echo '<div id="btm_top_but_3" class="xfpe_nomargintop"><a title="Print" alt="Print"  '; 
		echo "  onclick=\"MyWindow=window.open('".$url."','Print Item','width=600,height=300'); return false;\" "; 
		echo ' >Print</a></div>'; 
		return;}	
	function xfp_theme(){
		$themevar = @$_SESSION[_XFP_COOKIES_."xfp_theme"];
		if(_XFP_THEMESPIN_ == "yes" AND !isset($themevar)) { 
			@$randomfortheme = @mt_rand(0, count(_XFP_THEMEARRAY_));
			@$tmparrayfortheme	=	_XFP_THEMEARRAY_;
			$_SESSION[_XFP_COOKIES_."xfp_theme"] = @$tmparrayfortheme[$randomfortheme];
		}			
		$themevar = @$_SESSION[_XFP_COOKIES_."xfp_theme"];
		if(!isset($themevar)) { $_SESSION[_XFP_COOKIES_."xfp_theme"] = _XFP_THEME_; return _XFP_THEME_; }
		$themevar = @$_SESSION[_XFP_COOKIES_."xfp_theme"];
		if(!in_array($_SESSION[_XFP_COOKIES_."xfp_theme"], _XFP_THEMEARRAY_)) { $_SESSION[_XFP_COOKIES_."xfp_theme"] = _XFP_THEME_; return _XFP_THEME_; }
		if(@$_SESSION[_XFP_COOKIES_."xfp_theme"] == NULL OR @$_SESSION[_XFP_COOKIES_."xfp_theme"] == "") {return _XFP_THEME_;}
		else {return htmlspecialchars($_SESSION[_XFP_COOKIES_."xfp_theme"]);}
	}
		
	//////////////////////////////////////////////
	// Navigation Elements
	//////////////////////////////////////////////
	function xfp_navi_end() { echo '</div></div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div><div id="xfp_navwrapper"></div>';}
	function xfp_navi_start($searchpage = "/search", $searchparam_sc = "", $navi_image = "", $search = true) {
		// Display the TopBar
		echo '<div id="xfp_menutopbar">';
		echo '<img alt="Mobile-Menu" src="'.$navi_image.'" width="50" height="50" id="xfp_cenetermenueimg">';
		echo '<div id="xfp_navigation">';
		if($search) { echo '<form method="get" action="'.$searchpage.'">';
			$curloc = xfp_navi_location_seo();
			if($searchparam_sc != false)  { echo '<input type="hidden" name="sc" value="'.$searchparam_sc.'">'; }
		echo '<input type="text" name="tag" placeholder="Search Content" id="xfp_searchboxtop" maxlength="256">';
		echo '</form>';  }
		echo '<div id="xfp_scrollnavi">'; }
	function xfp_navi_item($navname, $url, $titlealt, $level = 0, $isonempty = false) { 
		$curloc = xfp_navi_location_seo();$curlocx = explode("/", @$url); if(strpos("/", $url) >= 0 && $level == 0) { $curlocx[$level+1] = $url; }
		if(@$curloc[$level] == @$curlocx[$level+1] OR (empty(@$curloc[$level]) AND $isonempty)) { $active = "id='xfp_navactive'"; } else { $active = ""; } 
		if($level == 0) {$cc = "xfp_navlink";} elseif($level == 1) {$cc = "xfp_navlinksec";} else {$cc = "xfp_navlinksecsec";}
		if($level == 0 AND substr($url, 0, 1) != "/") {$url = "/".$url;}
		return '<a title="'.$titlealt.'" href="'.$url.'" '.$active.'><div class="'.$cc.'">'.$navname.'</div></a>';}	
	function xfp_navi_location_seo($param = false) { if(!$param) { return explode("/", @$_GET[_XFP_MAIN_SEOVAR_]); } else { return explode("/", @$_GET[$param]); } }

	//////////////////////////////////////////////
	// Message Elements
	//////////////////////////////////////////////	
	function xfp_msg_box_error($title, $text) {  echo "<div class='xfp_content_box_text xfpe_nopadding xfp_content_box_text_error'><div class='xfp_content_box_text_title'>".$title."</div><div class='xfp_content_box_text xfpe_nopaddingbottom xfpe_nomarginbottom'>"; echo $text; echo "</div></div>"; }
	function xfp_msg_box_warning($title, $text) {  echo "<div class='xfp_content_box_text xfpe_nopadding xfp_content_box_text_warning'><div class='xfp_content_box_text_title'>".$title."</div><div class='xfp_content_box_text xfpe_nopaddingbottom xfpe_nomarginbottom'>"; echo $text; echo "</div></div>"; }
	function xfp_msg_box_notify($title, $text) {  echo "<div class='xfp_content_box_text xfpe_nopadding xfp_content_box_text_notify'><div class='xfp_content_box_text_title'>".$title."</div><div class='xfp_content_box_text xfpe_nopaddingbottom xfpe_nomarginbottom'>"; echo $text; echo "</div></div>"; }
	function xfp_msg_box_ok($title, $text) {  echo "<div class='xfp_content_box_text xfpe_nopadding xfp_content_box_text_ok'><div class='xfp_content_box_text_title'>".$title."</div><div class='xfp_content_box_text xfpe_nopaddingbottom xfpe_nomarginbottom'>"; echo $text; echo "</div></div>"; }
	function xfp_msg_box($title, $text) {  echo "<div class='xfp_content_box_text xfpe_nopadding'><div class='xfp_content_box_text_title'>".$title."</div><div class='xfp_content_box_text xfpe_nopaddingbottom xfpe_nomarginbottom'>"; echo $text; echo "</div></div>"; }
	function xfp_msg_boxnt_error($text) {  echo "<div class='xfp_content_box_text xfp_content_box_text_error'>"; echo $text; echo "</div>"; }
	function xfp_msg_boxnt_warning($text) {  echo "<div class='xfp_content_box_text xfp_content_box_text_warning'>"; echo $text; echo "</div>"; }
	function xfp_msg_boxnt_notify($text) {  echo "<div class='xfp_content_box_text xfp_content_box_text_notify'>"; echo $text; echo "</div>"; }
	function xfp_msg_boxnt_ok($text) {  echo "<div class='xfp_content_box_text xfp_content_box_text_ok'>"; echo $text; echo "</div>"; }
	function xfp_msg_boxnt($text) {  echo "<div class='xfp_content_box_text'>"; echo $text; echo "</div>"; }
	function xfp_msg_notify_ok($cookie, $text)      {  return x_eventBoxPrep($text, "ok", $cookie); }
	function xfp_msg_notify_warning($cookie, $text) {  return x_eventBoxPrep($text, "warn", $cookie); }
	function xfp_msg_notify_error($cookie, $text)   {  return x_eventBoxPrep($text, "error", $cookie); }
?>