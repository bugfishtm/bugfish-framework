# PHP Functions: Search

Use search-related function by including `/_framework/functions/x_search.php`.

!!! warning "Dependencies"
	- PHP 7.0-7.4
	- PHP 8.0-8.4
	
!!! warning "PHP-Classes"
	- `x_class_mysql`: For database operations.


## Introduction

The `x_search` function provides a flexible, scoring-based full-text search capability for a MySQL table. It uses prepared statements for security, allows multi-word search queries, supports weighted search across multiple fields, and returns results sorted by relevance score.

This function is designed to be used with a MySQL wrapper class that supports prepared statements and binding parameter arrays, such as the provided `x_class_mysql`.

***

## Function Signature

```php
function x_search(
    $mysql,               // MySQL database wrapper instance (object)
    string $table,        // Table name to search (string)
    array $search_fields = [], // Array of fields and weights to search - format: [ ["field", weight], ... ]
    array $get_fields = [],    // Array of fields to retrieve from records
    string $search_string = "",// The search input query string
    string $uniqueref = "id"   // Unique identifier column name for records
) : array|false
```

***

## Parameters

- **$mysql**  
  The database access object instance that provides a `select` method supporting prepared statements with binding parameters. This object is used to execute the constructed SQL query securely.

- **$table**  
  The name of the database table to search in. The table should contain fields corresponding to those in `$search_fields`.

- **$search_fields**  
  An optional array defining which fields to search and how to weight matches in those fields for scoring.  
  Format:  
  ```php
  [
    ["field_name1", weight1],
    ["field_name2", weight2],
    ...
  ]
  ```
  If empty, defaults to searching the fields:  
  - `title` with weight 3  
  - `text` with weight 1  
  - `category` with weight 2  
  - `sec_category` with weight 2

- **$get_fields**  
  An optional array of fields to be retrieved in the search results. If empty, defaults to the list of searchable fields only. The unique identifier field `$uniqueref` is automatically included in results.

- **$search_string**  
  The search query text. Can be a single word or multiple words separated by spaces. The function treats each word individually and combines search clauses with AND logic, meaning all terms must appear.

- **$uniqueref**  
  The unique identifier column for records, typically a primary key like `id`. This field is always returned for each record.

***

## Return Value

- Returns an **array** of associative arrays representing database rows matching the search.  
  Each record contains the requested fields in `$get_fields` plus an additional `score` field indicating relevance.  
- Returns **false** if the search input string is empty or only whitespace.

***

## Behavior and Algorithm

1. **Input Validation**  
   The function immediately returns false if the search string is empty or whitespace only.

2. **Search Term Processing**  
   Splits the `$search_string` into individual search terms based on spaces after normalizing multiple spaces to single spaces.

3. **Query Preparation**  
   For each search term, constructs SQL `LIKE ?` conditions on each field specified in `$search_fields`. Multiple fields combined by `OR`, multiple terms combined by `AND`.

4. **Binding Parameters**  
   Prepares a binding array for each search term per field with proper wildcarding (`%term%`) to protect against SQL injection.

5. **Field Selection**  
   Builds the select clause based on requested `$get_fields`, ensuring the unique identifier field is included.

6. **Query Execution**  
   The filtered records from the constructed query are fetched, or returns an empty array if no matches.

7. **Scoring**  
   For each result row, counts the number of occurrences of each search term in each of the weighted fields (case-insensitive).  
   The counts are multiplied by respective weights and summed up to compute a relevance `score`.

8. **Sorting**  
   The resulting array is sorted in descending order by the computed `score` to rank most relevant results first.

***

## Usage Example

```php
// Assume $mysql is an instance of x_class_mysql or compatible

$search_fields = [
    ["title", 5],
    ["description", 3],
    ["tags", 1],
];

$get_fields = ["id", "title", "description", "tags"];

$search_string = "open ai integration";

$results = x_search($mysql, "projects", $search_fields, $get_fields, $search_string, "id");

if ($results === false) {
    echo "Empty search query.";
} elseif (empty($results)) {
    echo "No results found.";
} else {
    foreach ($results as $row) {
        echo "Project: {$row['title']} (Score: {$row['score']})\n";
    }
}
```

***

## Notes and Recommendations

- The function expects the `$mysql->select` method to accept a query string, a flag for multiple records, and an array of binding arrays where each binding array has `'type'` (e.g. `"s"`) and `'value'` keys for prepared statement parameters.

- The function assumes all field names provided are valid and sanitized to prevent SQL injection via field names. These should ideally be controlled or validated before usage.

- The scoring algorithm uses `substr_count` for simple substring occurrence count per field which performs well but may not account for advanced linguistic relevance.

- The function performs a case-insensitive search and scoring by normalizing strings with `mb_strtolower`.

- When customizing, adjust weights to reflect domain-specific significance of fields in relevance ranking.

- For very large tables consider adding full-text indexes or more advanced search solutions for performance.