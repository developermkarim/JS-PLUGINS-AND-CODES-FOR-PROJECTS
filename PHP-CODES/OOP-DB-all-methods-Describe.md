# OOP DB of PHP
---
```php
<?php

class Database{
		private $db_host = "localhost";  // Change as required
		private $db_user = "root";       // Change as required
		private $db_pass = "";   // Change as required
		private $db_name = "shopping_db";   // Change as required
		private $result = array(); // Any results from a query will be stored here
		private $mysqli = ""; // This will be our mysqli object
		private $myQuery = "";// used for debugging process with SQL return
		private $conn = false;
		public function __construct(){
			if(!$this->conn){

				$this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
				// Check connection
				if ($this->mysqli->connect_errno > 0){
				  array_push($this->result,$this->mysqli->connect_error);
	              return false; // Problem selecting database return FALSE
				}
			}
			else{
				return true;
			}
		}


		// Function to insert into the database
    public function insert($table,$params=array()){
    	// Check to see if the table exists
    	 if($this->tableExists($table)){

    	 	$table_columns = implode(', ',array_keys($params));
    	 	$table_value =implode("', '", $params); /* '$name',"iamge" */
    	 	// echo $arr_value; exit;

			$sql="INSERT INTO $table ($table_columns) VALUES ('$table_value')";

    	 	$this->myQuery = $sql; // Pass back the SQL
          // Make the query to insert to the database
          if($this->mysqli->query($sql)){
          	array_push($this->result,$this->mysqli->insert_id);
              //return true; // The data has been inserted
          }else{
          	array_push($this->result,$this->mysqli->error);
              return false; // The data has not been inserted
          }

        }

		else{
        	return false; // Table does not exist
        }

    }

    // Function to update row in database
    public function update($table,$params=array(),$where = null){
    	// Check to see if table exists
    	if($this->tableExists($table)){
    		// Create Array to hold all the columns to update
	        $args=array();
					foreach($params as $key=>$value){
						// Seperate each column out with it's corresponding value
						// $args[]=$key.'="'.$value.'"'; name="$name" , email='$email'
						$args[]="$key='$value'";
					}
					// print_r($params);
					// print_r($args);
					// Create the query update user set name='$name', email='$email where $where id = 1'
					//$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
					$sql="UPDATE $table SET " . implode(',',$args);
					if($where != null){
		        $sql .= " WHERE $where";
					}
					$this->myQuery = $sql; // Pass back the sql
			 // Make query to database
          if($query = $this->mysqli->query($sql)){
          	array_push($this->result,$this->mysqli->affected_rows); // 1 // 2// 3 return 5
          	return true; // Update has been successful
          }else{
          	array_push($this->result,$this->mysqli->error);
              return false; // Update has not been successful
          }
        }
		else{
            return false; // The table does not exist
        }
    }

		//Function to delete table or row(s) from database
    public function delete($table,$where = null){
    	// Check to see if table exists
    	 if($this->tableExists($table)){
    	 	// The table exists check to see if we are deleting rows or table
    	 	
          $sql = "DELETE FROM $table"; // Create query to delete rows
         	if($where != null){
	        	$sql .= " WHERE $where";
					}
          // Submit query to database
          if($this->mysqli->query($sql)){
          	array_push($this->result,$this->mysqli->affected_rows);
              //$this->myQuery = $delete; // Pass back the SQL
              return true; // The query exectued correctly
          }else{
          	array_push($this->result,$this->mysqli->error);
             	return false; // The query did not execute correctly
          }
        }
		else{
            return false; // The table does not exist
        }
    }

  // Function to SELECT from the database
	public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){
		// Check to see if the table exists
    if($this->tableExists($table)){ 
			// Create query from the variables passed to the function
			$sql = "SELECT $rows FROM  $table ";
			if($join != null){
				$sql .= ' JOIN '.$join;
			}
	    if($where != null){
	    	$sql .= ' WHERE '.$where;
			}
	    if($order != null){
	        $sql .= ' ORDER BY '.$order;
			}
	    if($limit != null){

	    	  if(isset($_GET["page"])){
			    	$page = $_GET["page"]; //5
					}
					else{
					  $page = 1;
					}

					$start = ($page-1) * $limit; // 3 

	        $sql .= ' LIMIT '.$start.','.$limit;
	    } 
			
	    	$this->myQuery = $sql; // Pass back the SQL 
	    	// The table exists, run the query
	    	$query = $this->mysqli->query($sql);   

				if($query){
					$this->result = $query->fetch_all(MYSQLI_ASSOC);
					return true; // Query was successful
				}else{
					array_push($this->result,$this->mysqli->connect_error);
					return false; // No rows where returned
				}
    }
	else{
    	return false; // Table does not exist
  	}
  }

   // FUNCTION to show pagination
  public function pagination($table, $join = null, $where = null, $limit){
  	// Check to see if table exists
  	if($this->tableExists($table)){
  		//If no limit is set then no pagination is available
  		if( $limit != null){
  			// select count() query for pagination
        $sql = "SELECT COUNT(*) FROM $table";
        if($where != null){
      		$sql .= " WHERE $where";
				}
				if($join != null){
					$sql .= ' JOIN '.$join;
				}
				// echo $sql; exit;
        $query = $this->mysqli->query($sql);
        
        $total_record = $query->fetch_array();
        $total_record = $total_record[0];
 
        $total_page = ceil( $total_record / $limit);

        $url = basename($_SERVER['PHP_SELF']);

	        if(isset($_GET["page"])){
			    	$page = $_GET["page"];
					}
					else{
					  $page = 1;
					}

        // show pagination
        $output =   "<ul class='pagination'>";
        if($page>1){
            $output .="<li><a href='$url?page=".($page-1)."' class='page-link'>Prev</a></li>";
        }
        if($total_record > $limit){
          for ($i=1; $i<=$total_page ; $i++) {
            if($i == $page){
               $cls = "class='active'";
            }else{
               $cls = '';
            }
          	$output .="<li $cls><a class='page-link' href='$url?page=$i'>$i</a></li>";
          }
        }
        if($total_page>$page){
          $output .="<li> <a class='page-link' href='$url?page=".($page+1)."'>Next</a></li>";
        }
        $output .= "</ul>";

        return $output;
  		}

  	}else{
    	return false; // Table does not exist
  	}
  }
 
	public function sql($sql){
		$this->myQuery = $sql; // Pass back the SQL
		$query = $this->mysqli->query($sql);

		if($query){
      $sql_array = explode(' ',$sql);
      switch ($sql_array[0]) {
        case "INSERT":
          array_push($this->result,$this->mysqli->insert_id);
          break;
        case "UPDATE":
          array_push($this->result,$this->mysqli->affected_rows);
          break;
        case "DELETE":
          array_push($this->result,$this->mysqli->affected_rows);
          break;
        case "SELECT":
          array_push($this->result,$query->fetch_all(MYSQLI_ASSOC));
          break;
      }
			// $this->result = $query->fetch_all(MYSQLI_ASSOC);
			return true; // Query was successful
		}else{
			array_push($this->result,$this->mysqli->error);
			return false; // No rows where returned
		}
	}

	// Private function to check if table exists for use with queries
	private function tableExists($table){
		$tablesInDb = $this->mysqli->query("SHOW TABLES FROM $this->db_name LIKE '$table'");
        if($tablesInDb){
        	if($tablesInDb->num_rows == 1){
                return true; // The table exists
            }else{
            	array_push($this->result,$table." does not exist in this database");
                return false; // The table does not exist
            }
        }
    }
	   
    // Public function to return the data to the user
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    //Pass the SQL back for debugging
    public function getSql(){
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    // Escape your string
    public function escapeString($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $this->mysqli->real_escape_string($data);
    }

  
  public function uploadFile($fileInputName, $targetDirectory, $rename = true, $allowedFileTypes = array(), $deletePrevious = true) {
    if (!isset($_FILES[$fileInputName])) {
        return false; // File input does not exist
    }

    $file = $_FILES[$fileInputName];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false; // File upload error
    }

    // Get file information
    $fileName = $file['name'];
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];

    // Check file type (if allowedFileTypes is provided)
    if (!empty($allowedFileTypes) && !in_array($fileType, $allowedFileTypes)) {
        return false; // Invalid file type
    }

    // Generate a unique filename (if rename is enabled)
    if ($rename) {
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueName = uniqid() . '.' . $fileExtension;
        $targetPath = $targetDirectory . $uniqueName;
    } else {
        $targetPath = $targetDirectory . $fileName;
    }

    // Delete the previous file (if deletePrevious is enabled)
    if ($deletePrevious && file_exists($targetPath)) {
        unlink($targetPath);
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($fileTmpPath, $targetPath)) {
        return $targetPath; // Return the path to the uploaded file
    } else {
        return false; // Failed to move the file
    }
}


  // Implement methods for starting and committing transactions. This allows you to group multiple queries into a single transaction and ensures data consistency. Here's an example:


   public function beginTransaction() {
       return $this->mysqli->begin_transaction();
   }

   public function commit() {
       return $this->mysqli->commit();
   }

   public function rollback() {
       return $this->mysqli->rollback();
   }



 //  Enhance error handling by logging or displaying detailed error messages when queries fail. You can create a method to retrieve the last error message.


   public function getLastErrorMessage() {
       return $this->mysqli->error;
   }
  



  // Create a method to log SQL queries for debugging purposes. This can be especially useful during development and troubleshooting.


   public function logQuery($query) {
       // Implement your logging mechanism here
   }
  



  // Add a method that allows users to execute custom SQL queries. Ensure proper security measures are taken to prevent SQL injection.

   
   public function executeCustomQuery($query) {
       return $this->mysqli->query($query);
   }
   

// **Session Management**:

 //  Implement methods for session initialization, management, and termination. You may want to use PHP's built-in session handling functions.


   public function startSession() {
       session_start();
   }

   public function setSession($key, $value) {
       $_SESSION[$key] = $value;
   }

   public function getSession($key) {
       return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
   }

   public function endSession() {
       session_unset();
       session_destroy();
   }
   

// **Data Validation and Sanitization**:

 //  Implement methods for data validation and sanitization to ensure safe user inputs:


   public function validateInput($input) {
       // Implement your validation rules here
       return /* true or false */;
   }

   public function sanitizeInput($input) {
       return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
   }
  

// **Caching**:

  // You can use caching libraries like Memcached or Redis for more advanced caching. Here's a simplified example using PHP's built-in caching mechanism:

 
   public function getFromCache($key) {
       // Implement caching logic here
   }

   public function addToCache($key, $value, $expiry) {
       // Implement caching logic here
   }


// User Authentication and Authorization

   // Create methods for user authentication and authorization. These methods should handle user login, role checks, and access control.


   public function login($username, $password) {
       // Implement user login logic here
   }

   public function isLoggedIn() {
       // Check if the user is logged in
   }

   public function hasPermission($permission) {
       // Check if the user has a specific permission
   }
   


    // close connection
		public function __destruct(){
			if($this->conn){
				if($this->mysqli->close()){
					$this->conn = false;
					return true;
				}else{
					return false;
				}
			}
		}


	}


?>
```
## Full Details of The Class Database
---
The `Database` class in your PHP code is designed to handle database operations such as inserting, updating, deleting, and selecting data from a MySQL database. Below, I'll describe all the properties and methods of the `Database` class along with code examples for each.

#### Properties:

1. `$db_host`, `$db_user`, `$db_pass`, `$db_name`: These properties store the database connection information, including the host, username, password, and database name.

2. `$result`: An array used to store results or error messages from database operations.

3. `$mysqli`: An instance of the MySQLi class, which is used for connecting to the database and executing queries.

4. `$myQuery`: A property used to store the last executed SQL query for debugging purposes.

5. `$conn`: A boolean flag indicating whether a database connection has been established.

#### Constructor:

The constructor (`__construct`) is responsible for initializing the database connection when an instance of the `Database` class is created. It checks if a connection already exists and, if not, creates a new MySQLi object and establishes a database connection.

```php
public function __construct(){
    if(!$this->conn){
        $this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
        // Check connection
        if ($this->mysqli->connect_errno > 0){
            array_push($this->result, $this->mysqli->connect_error);
            return false; // Problem connecting to the database, return FALSE
        }
    }
    else{
        return true;
    }
}
```

#### Methods:

1. `insert($table, $params)`: Inserts data into a specified table.

   Example:
   ```php
   $database = new Database();
   $data = array("name" => "John", "email" => "john@example.com");
   $database->insert("users", $data);
   ```

2. `update($table, $params, $where)`: Updates rows in a table based on a given condition.

   Example:
   ```php
   $database = new Database();
   $data = array("name" => "Updated Name", "email" => "updated@example.com");
   $where = "id = 1";
   $database->update("users", $data, $where);
   ```

3. `delete($table, $where)`: Deletes rows from a table based on a given condition.

   Example:
   ```php
   $database = new Database();
   $where = "id = 1";
   $database->delete("users", $where);
   ```

4. `select($table, $rows, $join, $where, $order, $limit)`: Retrieves data from a table with optional filtering, joining, ordering, and pagination.

   Example:
   ```php
   $database = new Database();
   $result = $database->select("products", "*", "categories ON products.category_id = categories.id", "price < 50", "name ASC", 10);
   ```

5. `pagination($table, $join, $where, $limit)`: Generates a pagination menu for a result set.

   Example:
   ```php
   $database = new Database();
   $pagination = $database->pagination("products", null, "category_id = 1", 10);
   ```

6. `sql($sql)`: Executes a custom SQL query and handles different types of queries (INSERT, UPDATE, DELETE, SELECT).

   Example:
   ```php
   $database = new Database();
   $sql = "SELECT * FROM users WHERE age > 30";
   $result = $database->sql($sql);
   ```

7. `getResult()`: Returns the results or error messages from the last query and resets the result array.

   Example:
   ```php
   $database = new Database();
   $result = $database->getResult();
   ```

8. `getSql()`: Returns the last executed SQL query for debugging.

   Example:
   ```php
   $database = new Database();
   $sql = $database->getSql();
   ```

9. `escapeString($data)`: Escapes a string to prevent SQL injection.

   Example:
   ```php
   $database = new Database();
   $input = "John's Data";
   $escapedInput = $database->escapeString($input);
   ```

10. `__destruct()`: Closes the database connection when the object is destroyed.

   Example:
   ```php
   $database = new Database();
   unset($database); // The connection will be closed automatically.
   ```

These methods allow you to perform various database operations in your PHP application using the `Database` class.


## Described by ChatGPT-02
---
Here are examples of how to use each of the methods in your `Database` class:

1. **Construct Method (`__construct`)**:

   This method establishes a database connection when you create an instance of the `Database` class. You don't need to call it explicitly; it's automatically called when you create an object of the class.

   ```php
   $db = new Database(); // Automatically establishes a database connection
   ```

2. **Insert Method (`insert`)**:

   Use this method to insert data into a table. Provide the table name and an associative array of column names and their values.

   ```php
   $data = [
       'name' => 'John Doe',
       'email' => 'john@example.com',
   ];

   if ($db->insert('users', $data)) {
       echo 'Data inserted successfully. Last insert ID: ' . $db->getLastInsertId();
   } else {
       echo 'Failed to insert data. Error: ' . $db->getResult()[0];
   }
   ```

3. **Update Method (`update`)**:

   Use this method to update data in a table. Provide the table name, an associative array of column names and their new values, and an optional `WHERE` clause.

   ```php
   $data = [
       'email' => 'newemail@example.com',
   ];

   if ($db->update('users', $data, 'id = 1')) {
       echo 'Data updated successfully. Affected rows: ' . $db->getAffectedRows();
   } else {
       echo 'Failed to update data. Error: ' . $db->getResult()[0];
   }
   ```

4. **Delete Method (`delete`)**:

   Use this method to delete data from a table. Provide the table name and an optional `WHERE` clause.

   ```php
   if ($db->delete('users', 'id = 1')) {
       echo 'Data deleted successfully. Affected rows: ' . $db->getAffectedRows();
   } else {
       echo 'Failed to delete data. Error: ' . $db->getResult()[0];
   }
   ```

5. **Select Method (`select`)**:

   Use this method to retrieve data from a table. Provide the table name, columns to select (default is all), optional `JOIN`, `WHERE`, `ORDER BY`, and `LIMIT` clauses.

   ```php
   $result = $db->select('users', 'id, name, email', null, 'id > 10', 'id DESC', 10);

   if ($result) {
       foreach ($db->getResult() as $row) {
           echo 'ID: ' . $row['id'] . ', Name: ' . $row['name'] . ', Email: ' . $row['email'] . '<br>';
       }
   } else {
       echo 'Failed to retrieve data. Error: ' . $db->getResult()[0];
   }
   ```

6. **SQL Method (`sql`)**:

   This method allows you to run custom SQL queries. It returns the result of the query, and you can use it for various SQL operations.

   ```php
   $sql = "SELECT * FROM users WHERE id = 1";
   if ($db->sql($sql)) {
       $result = $db->getResult();
       // Process the result as needed
   } else {
       echo 'Failed to execute SQL query. Error: ' . $db->getResult()[0];
   }
   ```

7. **Pagination Method (`pagination`)**:

   Use this method to generate pagination for your query results. Provide the table name, optional `JOIN`, `WHERE`, and `LIMIT` clauses.

   ```php
   $pagination = $db->pagination('users', null, 'active = 1', 10);

   if ($pagination) {
       echo $pagination; // Output the pagination links
   } else {
       echo 'Pagination not available.';
   }
   ```

8. **Form Validation Method (`validateForm`)**:

   Use this method to validate form input data against specified validation rules. Provide the form data as an associative array and a set of validation rules.

   ```php
   $formData = [
       'name' => 'John Doe',
       'email' => 'invalidemail',
   ];

   $validationRules = [
       'name' => ['required'],
       'email' => ['required', 'email'],
   ];

   $validationErrors = $db->validateForm($formData, $validationRules);

   if (empty($validationErrors)) {
       // Form data is valid, proceed with further actions
   } else {
       // Validation errors occurred, handle them (e.g., display error messages)
       print_r($validationErrors);
   }
   ```

9. **Destruct Method (`__destruct`)**:

   This method is called automatically when the object goes out of scope (e.g., at the end of your script). It closes the database connection.

   ```php
   // No need to call this method explicitly; it's handled automatically
   ```

10. **Close Connection Method (`closeConnection`)**:

    You can use this method to explicitly close the database connection before the script ends.

    ```php
    if ($db->closeConnection()) {
        echo 'Database connection closed successfully.';
    } else {
        echo 'Failed to close the database connection.';
    }
    ```

Certainly! Here are the remaining methods from your `Database` class with examples:

11. **Escape String Method (`escapeString`)**:

    Use this method to safely escape a string to prevent SQL injection. It takes a string as input and returns the escaped string.

    ```php
    $input = "John's book";
    $escapedInput = $db->escapeString($input);
    echo $escapedInput; // Output: John\'s book
    ```

12. **Get SQL Method (`getSql`)**:

    This method retrieves the last executed SQL query.

    ```php
    $sql = "SELECT * FROM users WHERE id = 1";
    $db->sql($sql);
    $lastQuery = $db->getSql();
    echo $lastQuery; // Output: SELECT * FROM users WHERE id = 1
    ```

13. **Get Result Method (`getResult`)**:

    Use this method to retrieve the result of the last executed query.

    ```php
    $sql = "SELECT * FROM users WHERE id = 1";
    $db->sql($sql);
    $result = $db->getResult();
    print_r($result); // Output: Array containing query results
    ```

14. **Validation Rules for Phone, Username, and Address**:

    You can use the `validateForm` method to add validation rules for phone numbers, usernames, and addresses. Here's an example:

    ```php
    $formData = [
        'phone' => '1234567890',
        'username' => 'user123',
        'address' => '',
    ];

    $validationRules = [
        'phone' => ['required', 'phone'],
        'username' => ['required', 'username'],
        'address' => ['required'],
    ];

    $validationErrors = $db->validateForm($formData, $validationRules);

    if (empty($validationErrors)) {
        // Form data is valid, proceed with further actions
    } else {
        // Validation errors occurred, handle them (e.g., display error messages)
        print_r($validationErrors);
    }
    ```

15. **Pagination Without `JOIN` and `WHERE`**:

    You can use the `pagination` method without specifying `JOIN` and `WHERE` clauses for simple pagination.

    ```php
    $pagination = $db->pagination('products', null, null, 10);

    if ($pagination) {
        echo $pagination; // Output pagination links
    } else {
        echo 'Pagination not available.';
    }
    ```

16. **Close Connection Explicitly**:

    You can explicitly close the database connection using the `closeConnection` method.

    ```php
    if ($db->closeConnection()) {
        echo 'Database connection closed successfully.';
    } else {
        echo 'Failed to close the database connection.';
    }
    ```

These examples demonstrate how to use the methods provided by your `Database` class for various database operations and form validation. You can adapt and expand upon these examples to suit your specific project needs.

### Validation methods added and Example with it

```php

/* this Function is for Input Validattion */
  // Function to validate a form
  public function validateForm($formData, $validationRules) {
    $errors = array();

    foreach ($validationRules as $fieldName => $rules) {
        foreach ($rules as $rule) {
            switch ($rule) {
                case 'required':
                    if (empty($formData[$fieldName])) {
                        $errors[$fieldName] = ucfirst($fieldName) . ' is required.';
                    }
                    break;
                case 'email':
                    if (!empty($formData[$fieldName]) && !filter_var($formData[$fieldName], FILTER_VALIDATE_EMAIL)) {
                        $errors[$fieldName] = 'Invalid ' . ucfirst($fieldName) . ' format.';
                    }
                    break;
                case 'phone':
                    if (!empty($formData[$fieldName]) && !preg_match('/^\d{10}$/', $formData[$fieldName])) {
                        $errors[$fieldName] = 'Invalid ' . ucfirst($fieldName) . ' format.';
                    }
                    break;
                case 'username':
                    if (!empty($formData[$fieldName]) && strlen($formData[$fieldName]) < 6) {
                        $errors[$fieldName] = 'Username must be at least 6 characters.';
                    }
                    break;
                // Add more validation rules as needed
            }
        }
    }

    return $errors;
}



// Assuming you have an instance of your Database class, e.g., $db

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive form data via POST
    $formData = $_POST;

    // Define validation rules for the form fields
    $validationRules = [
        'f_name' => ['required'],
        'l_name' => ['required'],
        'email' => ['required','email'],
        'username' => ['required', 'username'],
        'password' => ['required'],
        'mobile' => ['required', 'phone'],
        'address' => ['required'],
        'city' => ['required'],
    ];

    // Validate the form data
    $validationErrors = $db->validateForm($formData, $validationRules);

    if (empty($validationErrors)) {
        // No validation errors, proceed with further actions like database insertion
        // Insert code here
        // Send a success response if needed
        echo json_encode(['success' => true]);
    } else {
        // Validation errors, send a JSON response with error messages
        echo json_encode(['errors' => $validationErrors]);
    }
}

```

### File Uploading Methods Dynamically Using Here and examples
---
Certainly! Here's a real-life example using the `uploadFile` method to handle file uploads and store file paths in a database table. In this example, we'll assume you have a database connection available through your `Database` class:


```php

public function uploadFile($fileInputName, $targetDirectory, $rename = true, $allowedFileTypes = array(), $deletePrevious = true) {
    if (!isset($_FILES[$fileInputName])) {
        return false; // File input does not exist
    }

    $file = $_FILES[$fileInputName];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false; // File upload error
    }

    // Get file information
    $fileName = $file['name'];
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];

    // Check file type (if allowedFileTypes is provided)
    if (!empty($allowedFileTypes) && !in_array($fileType, $allowedFileTypes)) {
        return false; // Invalid file type
    }

    // Generate a unique filename (if rename is enabled)
    if ($rename) {
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueName = uniqid() . '.' . $fileExtension;
        $targetPath = $targetDirectory . $uniqueName;
    } else {
        $targetPath = $targetDirectory . $fileName;
    }

    // Delete the previous file (if deletePrevious is enabled)
    if ($deletePrevious && file_exists($targetPath)) {
        unlink($targetPath);
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($fileTmpPath, $targetPath)) {
        return $targetPath; // Return the path to the uploaded file
    } else {
        return false; // Failed to move the file
    }
}

```


```php
// Include your Database class here and establish a database connection

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the target directory where uploaded files will be stored
    $targetDirectory = "uploads/";

    // Define allowed file types (optional)
    $allowedFileTypes = ["image/jpeg", "image/png", "image/gif"];

    // Check if a file was uploaded
    if (isset($_FILES["file"])) {
        // Use the uploadFile method to handle the file upload
        $database = new Database();

        $fileInputName = "file";
        $rename = true; // Rename the file to a unique name
        $deletePrevious = false; // Do not delete previous files
        $uploadedFilePath = $database->uploadFile($fileInputName, $targetDirectory, $rename, $allowedFileTypes, $deletePrevious);

        if ($uploadedFilePath) {
            // File was successfully uploaded, now you can store the file path in your database table
            $sql = "INSERT INTO files (file_path) VALUES ('$uploadedFilePath')";
            if ($database->sql($sql)) {
                echo "File uploaded and stored in the database successfully.";
            } else {
                echo "File uploaded but failed to store in the database.";
            }
        } else {
            echo "File upload failed. Please check the file type and try again.";
        }
    }
}
```

In this example:

1. We check if the form was submitted.

2. We define the target directory where uploaded files will be stored. You can change this directory to match your project's structure.

3. We define the allowed file types, which is optional. If you want to restrict file types, you can specify them in the `$allowedFileTypes` array.

4. We check if a file was uploaded using the `$_FILES` superglobal.

5. We use the `uploadFile` method to handle the file upload, and if successful, we store the file path in a database table called "files."

6. If the file upload and database insertion are successful, a success message is displayed. Otherwise, an error message is shown.

Make sure to adjust the code to match your database configuration and table structure.


### Session Management Methods
---
```php
   public function startSession() {
       session_start();
   }

   public function setSession($key, $value) {
       $_SESSION[$key] = $value;
   }

   public function getSession($key) {
       return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
   }

   public function endSession() {
       session_unset();
       session_destroy();
   }

```

Certainly! Here's a real-life example of how to use the provided session management methods in a PHP application:

```php
// Include your Database class here and establish a database connection
// Assuming your Database class has the session management methods

// Start a session
$database = new Database();
$database->startSession();

// Set session variables
$database->setSession("user_id", 123);
$database->setSession("username", "john_doe");

// Get session variables
$userID = $database->getSession("user_id");
$username = $database->getSession("username");

if ($userID !== null && $username !== null) {
    echo "User ID: " . $userID . "<br>";
    echo "Username: " . $username . "<br>";
} else {
    echo "Session variables not set.<br>";
}

// End the session
$database->endSession();
```

In this example:

1. We start a session using the `startSession` method.

2. We set session variables using the `setSession` method. These could be user-related data like user ID and username.

3. We retrieve session variables using the `getSession` method and display them if they exist.

4. Finally, we end the session using the `endSession` method to unset and destroy the session data.

Make sure to include your `Database` class and adapt the code to your specific use case. The session management methods help you maintain user-specific data across multiple pages in your PHP application.


### Validate INput and sanitize Methods
---

Methods :

```php
 public function validateInput($input) {
       // Implement your validation rules here
       return /* true or false */;
   }

   public function sanitizeInput($input) {
       return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
   }
```
```php

// Include your Database class here and establish a database connection

// Initialize the Database class
$database = new Database();

// Define a user input (e.g., from a form submission)
$userInput = "<script>alert('This is a malicious script');</script>";

// Validate the user input
$isInputValid = $database->validateInput($userInput);

if ($isInputValid) {
    echo "Input is valid.<br>";
} else {
    echo "Input is not valid.<br>";
}

// Sanitize the user input
$sanitizedInput = $database->sanitizeInput($userInput);

echo "Sanitized Input: " . $sanitizedInput;

```

### Difference between ValidateForm and validate Input and sanitize
---
The `validateForm` method and the `validateInput` method serve different purposes in a class like `Database`:

1. **validateForm**:
   - Purpose: The `validateForm` method is designed to validate an entire form, which typically consists of multiple input fields.
   - Usage: It takes an array of form data and a set of validation rules and checks each input field against those rules. It can be used to ensure that all the form data meets specific criteria before processing it further, such as before inserting or updating records in a database.
   - Example: You would use `validateForm` when you have a form submission containing multiple fields (e.g., registration form) and you want to validate all the inputs collectively.

2. **validateInput**:
   - Purpose: The `validateInput` method, on the other hand, is more focused on validating a single input or a piece of data. It's a more general-purpose validation method.
   - Usage: You can use `validateInput` when you have individual input data that you want to validate independently. For example, if you receive user input from various sources or need to validate data before performing certain operations, you can use this method.
   - Example: You might use `validateInput` when you receive user input from an API call, a query parameter, or any other source and want to ensure it meets specific criteria before processing it.

In summary, `validateForm` is specifically tailored for form validation, which typically involves multiple fields with different validation rules, while `validateInput` is a more generic validation method that can be used for single pieces of data. Depending on your use case, you may choose to use one or both of these methods in your application.


### **METHODS :** beginTransaction ,rollback and commit, getLastErrorMessage,  logQuery,  executeCustomQuery
---

Certainly, I'll provide you with examples of how to use these methods in a real-life scenario. Let's assume you have a simple web application for managing products in an online store.

```php
class Database {
    // ... (Other class properties and methods)

    // Begin a transaction
    public function beginTransaction() {
        return $this->mysqli->begin_transaction();
    }

    // Commit a transaction
    public function commit() {
        return $this->mysqli->commit();
    }

    // Rollback a transaction
    public function rollback() {
        return $this->mysqli->rollback();
    }

    // Get the last error message
    public function getLastErrorMessage() {
        return $this->mysqli->error;
    }

    // Log a SQL query
    public function logQuery($query) {
        // You can implement a logging mechanism here, such as writing to a log file
        $logFileName = 'query_log.txt';
        $logMessage = date('Y-m-d H:i:s') . ' - ' . $query . PHP_EOL;
        file_put_contents($logFileName, $logMessage, FILE_APPEND);
    }

    // Execute a custom SQL query
    public function executeCustomQuery($query) {
        return $this->mysqli->query($query);
    }
}
```

Now, let's see how these methods can be used in a real-life scenario:

**1. Begin and Commit a Transaction:**
Transactions are crucial for ensuring data integrity, especially when you need to perform multiple related database operations. Here's an example of how you can use these methods to insert a new product and update its stock in a transaction:

```php
// Create a new Database instance
$db = new Database();

// Begin a transaction
$db->beginTransaction();

// Insert a new product
$insertQuery = "INSERT INTO products (name, price) VALUES ('New Product', 29.99)";
if ($db->executeCustomQuery($insertQuery)) {
    // Update product stock
    $updateQuery = "UPDATE product_stock SET quantity = quantity + 10 WHERE product_id = LAST_INSERT_ID()";
    if ($db->executeCustomQuery($updateQuery)) {
        // Commit the transaction if both queries succeed
        $db->commit();
        echo "Product added successfully.";
    } else {
        // Rollback the transaction if the second query fails
        $db->rollback();
        echo "Failed to update product stock.";
    }
} else {
    // Rollback the transaction if the first query fails
    $db->rollback();
    echo "Failed to insert a new product.";
}
```

**2. Get the Last Error Message:**
You can use this method to retrieve detailed error messages when a query fails. For example:

```php
if (!$db->executeCustomQuery("INSERT INTO products (name, price) VALUES ('Invalid Product', 'abc')")) {
    $errorMessage = $db->getLastErrorMessage();
    echo "Query failed with error: $errorMessage";
}
```

**3. Log SQL Queries:**
Logging queries can be helpful for debugging and auditing. Here's how you can log a query:

```php
// Example query
$query = "SELECT * FROM products WHERE category_id = 1";

// Log the query
$db->logQuery($query);

// Execute the query
$result = $db->executeCustomQuery($query);

// Process the result (omitted for brevity)
```

**4. Execute a Custom SQL Query:**
This method allows you to execute custom SQL queries safely. For example:

```php
// Execute a SELECT query
$selectQuery = "SELECT * FROM products WHERE category_id = 1";
$result = $db->executeCustomQuery($selectQuery);

// Execute an UPDATE query
$updateQuery = "UPDATE products SET price = 19.99 WHERE id = 1";
if ($db->executeCustomQuery($updateQuery)) {
    echo "Product price updated successfully.";
} else {
    echo "Failed to update product price.";
}
```

These examples demonstrate how the provided methods can be used in a real-life application to manage database transactions, handle errors, log queries, and execute custom SQL statements.