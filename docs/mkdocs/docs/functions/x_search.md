# PHP Functions: Search


Use search-related functions by including `/_framework/functions/x_search.php`.


!!! warning "Dependencies"
	- PHP 7.1-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Modules"
	- `mbstring`: Required for preg_match functions.
	- `mysqli`: Required for `x_class_mysql` class object.
	
!!! warning "PHP-Classes"
	- `x_class_mysql`: Required for `$mysql` parameter.


| **Section**                       | **Description**                                                                                                           |
|-----------------------------------|---------------------------------------------------------------------------------------------------------------------------|
| **Function Signature**            | `function x_search($mysql, $table, $search_fields = array(), $get_fields = array(), $search_string = "", $uniqueref = "id")` |
| **Purpose**                       | Searches a database table based on a search string, scores the results, and returns them sorted by relevance.             |
| **Parameters**                    | - `$mysql`: Database connection object. <br> - `$table`: Name of the table to search. <br> - `$search_fields`: Fields to search within. <br> - `$get_fields`: Fields to return in the results. <br> - `$search_string`: The search term or terms. <br> - `$uniqueref`: Unique identifier field for sorting. |
| **Abort Condition**               | Checks if the search string is empty or null. If true, returns `false`.                                                   |
| **Trim Search String**            | Removes extra whitespace from the search string.                                                                         |
| **Split Search String**           | Splits the search string into an array of terms if it contains spaces; otherwise, treats it as a single term.               |
| **Initialize Query and Bind Array**| Prepares the SQL query and binds array for parameterized queries.                                                            |
| **Build Query**                   | Constructs the SQL query with conditions for each search term. <br> - For the first term, includes specific fields. <br> - For subsequent terms, adds conditions for additional search fields. |
| **Prepare Bind Array**            | Adds each search term to the binding array for the SQL query.                                                                |
| **Execute Query**                 | Executes the SQL query using the `$mysql` object and retrieves the results.                                                 |
| **Score Calculation**             | Calculates a relevance score for each result based on term frequency and weight.                                             |
| **Sort Results**                  | Sorts the results by the calculated score in descending order using `array_multisort()`.                                      |
| **Return Results**                | Constructs and returns an array of results sorted by relevance.                                                              |
| **Fallback**                      | Returns an empty array if no results are found or if the scoring array is empty.                                            |