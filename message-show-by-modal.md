## MESSAGE SHOW BY MODAL
---
### Step-1 : Request from jquery like this
```js
$('.add-to-wishlist').click(function(e){
        e.preventDefault()
        var product_id = $(this).attr('data-id');
        $.ajax({
            url:'php_files/user_action.php',
            type:"POST",
            data:{wishlist_id:product_id},
            dataType: 'json', // Specify the data type as JSON
            success: function(response) {
                if (response.hasOwnProperty('success')) {
                    var message = response.success;
                    var wishlistCount = response.wishlist_count;

                    // Display success message and update wishlist count
                    displaySuccessAlert(message);
                    $('.wishlist-count').addClass('cart-wishlist');
                    updateWishlistCount(wishlistCount);
                } else if(response.hasOwnProperty('error')) {
                    var errorMessage = response.error;

                    // Display error message
                    displayErrorAlert(errorMessage);
                    
                }

                else if(response.hasOwnProperty('showModal')){
                       
              $('#loginMessageText').html(`<span>Please Please login before add to Wishlist</span> <a href="#" data-toggle="modal" class="btn btn-outline-primary" data-dismiss="modal" data-target="#user_login_form">Login</a>`);
                    $('#loginMessageModal').modal('show');
                }

            },

            error: function(xhr, textStatus, errorThrown) {
                displayErrorAlert('An error occurred: ' + errorThrown);
            }
        });
    });

    function displaySuccessAlert(message) {
        $('#messageText').text(message);
            $('#messageModal').modal('show');
    }

    function displayErrorAlert(message) {
        $('#ErrorMessageText').text(message);
        $('#ErrorMessageModal').modal('show');
    }

    function updateWishlistCount(count) {
        $('.wishlist-count').text(count);
        
    }

```

### Step-2 : Add Css Class Dynamically
---
Added the `$('.wishlist-count').addClass('cart-wishlist')` to jquery response logic block for
 ` <li><a href="#"><i class="fa fa-heart"></i> <span class="wishlist-count"></span></a></li>` tag where cart Item shown in html page/php page of html codes.`(index.html to index.php)`
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
 if(!session_id()){
    session_start();

if (!isset($_SESSION['user_id'])) {

    $response = array(
        "message" => "Request was successful",
        "showModal" => true  // This could be a flag to indicate whether to show the modal
    );
    echo json_encode($response);
    exit;
}
else {

/* Wishlist server code Here */
 if(isset($_POST['wishlist_id'])) {
    $db = new Database;

    $p_id = $_POST['wishlist_id'];
    if(isset($_COOKIE['user_wishlist-'.$p_id])){
        echo json_encode(['error'=>'Already Added this product to wishlist']);exit;
        $user_wishlist = json_decode($_COOKIE['user_wishlist-'.$p_id]);
    }else{
        $user_wishlist = [];
    }
    if(!in_array($p_id,$user_wishlist)){
        array_push($user_wishlist,$p_id);
    }


    $wishlist_count = count($user_wishlist);
    $u_wishlist = json_encode($user_wishlist);

    if(setcookie("user_wishlist-$p_id",$u_wishlist,time() + (180),'/','','',TRUE)){
        setcookie('wishlist_count',$wishlist_count,time() + (180),'/','','',TRUE);
        echo json_encode(['success'=>'added to wishlist successfully','wishlist_count'=>$wishlist_count]);
    }else{
        echo json_encode(['error'=>'cookie set successfully']);
    }
  };

}

};
```