# Function Framework
	This is a set of functions to use when building a webpage.
## xfp_library
|Runtime Variable|Description|
|--|--|
|\_XFP_MAIN_SEOVAR\_| Htaccess URL Get Variable |
| \_XFP_ADMIN_NAME\_ | Administrator Name for Meta |
| \_XFP_ADMIN_MAIL\_| Administrator Mail for Meta |
| \_XFP_LANG\_ | Language for Website (en, de) for Meta |
| \_XFP_META_TITLE_PRE\_ | Before Meta Title |
| \_XFP_META_TITLE_POST\_ | After Meta Title|
| \_XFP_META_DESC_PRE\_ | Before Meta Title |
| \_XFP_META_DESC_POST\_ | After Meta Title|
| \_XFP_THEME\_ | Current Theme Name|
| \_XFP_COOKIES\_ | Cookies Prefix |
| \_XFP_PATH\_ | Path to File Document Root Folder |
| \_XFP_THEMESPIN\_ | Random Themespin (yes/no) |
-------------------------
|Meta Function Name|Description|
|--|--|
|xfp_meta_error($object = false, $code = 404, $image = false, $cssarray = false, $setcode = true, $ext = "", $docstart = true)| Print Meta Error|
|xfp_meta_prep($val, $maxlength = 350)| Prepare Text for Meta |
| xfp_meta($object, $title, $description, $keywords = false, $robots = false, $cssarray = false, $img = false, $formexpire =  false, $fallbackimage = false, $nocache = true, $canonical = false, $docstart = true, $ext = "", $favicon = false)| Write Meta Content |
-------------------------
|Message Function Name|Description|
|--|--|
|xfp_etb_ok($text)| Event Box |
|xfp_etb_warning($text) (warn possitble)|Event Box Function|
|xfp_etb_error($text)|Event Box Function |
|xfp_etb_info($text)|Event Box Function |
-------------------------
|Build Function Name|Description|
|--|--|
|xfp_footer($text) | Build Footer |
|xfp_entry($var, $x, $level = 0) | Check Location for Case in Index |
|xfp_headline($title, $titlesec) | Build Headline |
| xfp_top_button($cssclasses = "") | Build Top Button below Headline |
|xfp_return_button($cssclasses = "") | Build Top Back Button below Headline|
| xfp_top_button_print($url, $cssclasses = "") | Print Button on Top|
|xfp_theme()| Get Current Theme Name|
-------------------------
|Navigation Function Name|Description|
|--|--|
|xfp_navi_end() |End of Navigation |
|xfp_navi_start($searchpage = false", $searchparam_sc = "", $navi_image = false)|Start of Navigation |
|xfp_navi_item($navname, $url, $titlealt, $level = 0, $isonempty = false) | Spawn Navigation Item |
|xfp_navi_location_seo($param = \_XFP_MAIN_SEOVAR\_) | Get Location |
-------------------------
|Website Function Name|Description|
|--|--|
|xfp_website_create_table($mysql, $tablename, $query)| Create Table if not Exists|
|xfp_website_init($title, $meta_ext, $section)| Get Object for use in settings.php of xfp-template|
