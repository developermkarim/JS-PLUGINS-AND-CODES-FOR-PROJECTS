## MESSAGE SHOW BY MODAL
---
### Step-1 : Request from jquery like this
```js
/* Add To Cart Option Here cart-count*/

    $('.add-to-cart').click(function(e){
        e.preventDefault();
        var product_id = $(this).attr('data-product-id');
        var product_price = $(this).attr('data-product-price');
        $.ajax({
            url:'php_files/user_action.php',
            type:'POST',
            data:{cart_product_id:product_id,product_price:product_price},
            dataType:'json',
            success:function(response){
                console.log(response);

                if(response.hasOwnProperty('success')){
                    var successMessage = response.success;
                    var cart_count = response.cart_count;

                    // Display success message and update wishlist count
                    displaySuccessAlert(successMessage);
                    $('.cart-count').addClass('cart-wishlist');
                    $('.cart-count').text(cart_count);

                }else if(response.hasOwnProperty('error')){

                    var errorMessage = response.error;
                    displayErrorAlert(errorMessage);

                }

                else if(response.hasOwnProperty('showModal')){

                   $('#loginMessageText').html(`<span>${response.message}</span> <a href="#" data-toggle="modal" class="btn btn-outline-primary" data-dismiss="modal" data-target="#user_login_form">Login</a>`);
                    $('#loginMessageModal').modal('show');

                }

            },
            error:function(xhr, textStatus, errorThrown){
                displayErrorAlert('an Error Occured : ' + errorThrown);
            }
        })
    })


```

### Step-2 : Add Css Class cart count(if exist , will be from database) Dynamically .
---
Added the `$('.wishlist-count').addClass('cart-wishlist')` 
to jquery response logic block
```js
$db->select('cart',"COUNT(id) AS cart_count",null,"user_id={$_SESSION['user_id']}",null,null);

$exist = $db->getResult();

 <li>
 <a href="#">
 <i class="fa fa-shopping-bag"></i> 
 <span class="cart-count <?= $exist[0]['cart_count'] == 0 ? '':'cart-wishlist';?>">

 <?= $exist[0]['cart_count']==0 ? '':$exist[0]['cart_count'];?>
 </span>
 </a>
 </li>` 
 tag where cart Item shown in html page/php page of html codes.`(index.html to index.php)

 ```

```css
    <style>
        .cart-wishlist{
            background: #7fad39;
        }
    </style>>
```


### Step-3: Html Modal DOMS of Bootstrap
---
```html

# Success / Normal Message Modal

<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    <p id="messageText" class="mb-0"></p>
                </div>
            </div>
        </div>
    </div>
</div>



# Error Message Modal 

<div class="modal fade" id="ErrorMessageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger align-items-center text-white">
                <h5 class="modal-title" id="messageModalLabel"> Sorry! </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <p id="ErrorMessageText" class="mb-0"></p>
                </div>
            </div>
        </div>
    </div>
</div>


# Login redirect Message Modal 

<div class="modal fade" id="loginMessageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger align-items-center text-white">
                <h5 class="modal-title" id="messageModalLabel"> Warning </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <p id="loginMessageText" class="mb-0"></p>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Step-4: Response From PHP Server
---
```php
if (!session_id()){
    session_start();

}
/* add to cart  */
 if (isset($_POST['cart_product_id'])) {

    if (!isset($_SESSION['user_id'])) {
        $response = [
            'message'=>"Please Login before add to cart",
            "showModal"=>true,
        ];
        echo json_encode($response);exit;
      }

    $db = new Database;
    $product_id = $db->escapeString($_POST['cart_product_id']);
    $product_price = $db->escapeString($_POST['product_price']);
    $user_id = $_SESSION['user_id'];

    $cart_params = [
        'product_id'=>$product_id,
        'price'=>$product_price,
        'user_id'=>$user_id,
        'quantity'=>1,
    ];

    $db->select('cart',"product_id,user_id,id",null,"product_id={$product_id} AND user_id={$user_id}",null,null);

    $exist = $db->getResult();
  /*   $addedCart = $exist[0]['id']; */
    if (!empty($exist)) {

        echo json_encode(['error'=>"Product is already added to cart.Please Choose Another Cart"]);

    }else {
        
        $db->insert('cart',$cart_params);
         $isInserted = $db->getResult();
         

         if(!empty($isInserted)){

            /* Cart count Here */
            $carts = $db->select('cart','id',null,"user_id={$user_id}");
             $cartResult = $db->getResult();
            // $cartCount = $cartResult
            echo json_encode(['success'=>'Add To cart Successfully','cart_count'=>count($cartResult)]);

         }else{

            echo json_encode(['error'=>"Product is not added to cart,Please Try it again"]);

         }

    }


  };
```
