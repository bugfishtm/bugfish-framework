	<Files "FILEPATHTOSUBSTITUTE">    
		RequestHeader unset Accept-Encoding  
		AddOutputFilterByType SUBSTITUTE text/html  
		AddOutputFilterByType SUBSTITUTE text/css  
		AddOutputFilterByType SUBSTITUTE text/javascript  
		AddOutputFilterByType SUBSTITUTE text/plain  
		AddOutputFilterByType SUBSTITUTE text/xml  
		Substitute "s/REPLACE/WITHTHISSTRING/ni"  
	</Files>  