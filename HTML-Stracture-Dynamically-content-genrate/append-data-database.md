## Generated Data appended to html tbody
---
```php
<tr class="delete_add_more_item" id="delete_add_more_item">
    <input type="hidden" name="date[]" value="2023-09-30">
    <input type="hidden" name="purchase_no[]" value="TY56FT45">
    <input type="hidden" name="supplier_id[]" value="10">

<td>
    <input type="hidden" name="category_id[]" value="4">
    Groceries
</td>

 <td>
    input
    <input type="hidden" name="product_id[]" value="12">
    <input type="hidden" name="product_name" value="Mashur Dal">
    Mashur Dal
</td>

 <td>
    <input type="number" min="1" class="form-control buying_qty text-right" name="buying_qty[]" value=""> 
</td>

<td>
    <input type="number" class="form-control unit_price text-right" name="unit_price[]" value=""> 
</td>

<td>
    <input type="text" class="form-control" name="description[]"> 
</td>

 <td>
    <input type="number" class="form-control buying_price text-right" name="buying_price[]" value="0" readonly=""> 
</td>

 <td>
    <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore" aria-hidden="true"></i>
</td>

</tr>
```

## the data compilatino and insert to database
---

<tr class="delete_add_more_item" id="delete_add_more_item">
            <input type="hidden" name="date[]" value="2023-10-01">
            <input type="hidden" name="purchase_no[]" value="78dfg">
            <input type="hidden" name="supplier_id[]" value="3">
    
        <td>
            <input type="hidden" name="category_id[]" value="4">
            Groceries
        </td>
    
         <td>
            input
            <input type="hidden" name="product_id[]" value="8">
            <input type="hidden" name="product_name" value="Danu Milk">
            Danu Milk
        </td>
    
         <td>
            <input type="number" min="1" class="form-control buying_qty text-right" name="buying_qty[]" value=""> 
        </td>
    
        <td>
            <input type="number" class="form-control unit_price text-right" name="unit_price[]" value=""> 
        </td>
    
         <td>
            <input type="text" class="form-control" name="description[]"> 
        </td>
    
         <td>
            <input type="number" class="form-control buying_price text-right" name="buying_price[]" value="0" readonly=""> 
        </td>
    
         <td>
            <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore" aria-hidden="true"></i>
        </td>
    
        </tr>

        To insert the appended data into a PHP MySQL database, you would typically need to do the following steps:

1. **Create a Database Table**: You should have a MySQL database table that matches the structure of the data you want to insert. In this case, it appears you want to insert purchase-related data, so you might have a table with columns like `date`, `purchase_no`, `supplier_id`, `category_id`, `product_id`, `product_name`, `buying_qty`, `unit_price`, `description`, and `buying_price`.

2 A. **PHP Backend**: Create a PHP script that will handle the insertion of data into the database. Here's an example of how you can do it:

```php
<?php
// Connect to your MySQL database (replace with your database credentials)
$host = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Iterate through the data and insert each row into the database
foreach ($_POST['date'] as $key => $date) {
    $purchase_no = $_POST['purchase_no'][$key];
    $supplier_id = $_POST['supplier_id'][$key];
    $category_id = $_POST['category_id'][$key];
    $product_id = $_POST['product_id'][$key];
    $product_name = $_POST['product_name'][$key];
    $buying_qty = $_POST['buying_qty'][$key];
    $unit_price = $_POST['unit_price'][$key];
    $description = $_POST['description'][$key];
    $buying_price = $_POST['buying_price'][$key];

    $sql = "INSERT INTO purchases (date, purchase_no, supplier_id, category_id, product_id, product_name, buying_qty, unit_price, description, buying_price)
            VALUES ('$date', '$purchase_no', '$supplier_id', '$category_id', '$product_id', '$product_name', '$buying_qty', '$unit_price', '$description', '$buying_price')";

    if (mysqli_query($conn, $sql)) {
        echo "Record inserted successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
```

In this PHP script:

- It connects to the MySQL database using your credentials.
- It loops through the data arrays you posted (assuming you have posted the form data to this PHP script).
- For each set of data, it constructs an SQL `INSERT` query and executes it to insert a new row into the database table.

2 B. **LARAVEL BACKEND**
```PHP
    public function purchaseStore(Request $request)
    {
        if($request->category_id == null){

            $errorNotice = array(
                'message'=>'Sorry, You Do not select any item',
                'alert-type'=>'error',
            );
            return redirect()->back()->with($errorNotice);
        }
        else{
            $count_category = count($request->category_id);
            for ($i=0; $i < $count_category; $i++) {
                $purchase = new Purchase();
                $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->category_id = $request->category_id[$i];

                $purchase->product_id = $request->product_id[$i];
                $purchase->buying_qty = $request->buying_qty[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->description = $request->description[$i];
                $purchase->created_by = Auth::user()->id;
                $purchase->status = '0';
                $purchase->save();

            /* To send Notification in admin notice board after purchase */
            $user = User::where('username','admin')->get();
            Notification::send($user,new PurchaseComplete($request->product_name));

            }
            $notification = array(
                'message' => 'Data Save Successfully',
                'alert-type' => 'success'
            );

           
            return redirect()->route('purchase.all')->with($notification);
        }
    }
```

3. **Submit Data from HTML Form**: Ensure that the appended data is part of an HTML form and that you submit the form to the PHP script above. For example, you might have a form wrapping the appended data with a submit button.

4. **Database Configuration**: Make sure to replace the database connection credentials (`$host`, `$username`, `$password`, `$database`) with your actual database information.

5. **Sanitization and Validation**: Depending on your application, you might need to perform input validation and data sanitization to ensure the security and integrity of your database.

6. **Error Handling**: Implement error handling to manage any database connection or insertion errors.

Please adapt the code to your specific database structure and application requirements. Additionally, consider using prepared statements to prevent SQL injection attacks.
        