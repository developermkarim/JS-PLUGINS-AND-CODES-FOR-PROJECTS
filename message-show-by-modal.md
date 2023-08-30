## MESSAGE SHOW BY MODAL
---
### Step-1 : Request from jquery like this
```js
$('.add-to-wishlist').click(function(e){
        e.preventDefault();
        var product_id = $(this).attr('data-id');
        $.ajax({
            url:'php_files/user_action.php',
            type:"POST",
            data:{product_id:product_id},
            dataType: 'json', // Specify the data type as JSON
            success: function(response) {
                if (response.hasOwnProperty('success')) {
                    var message = response.success;
                    var wishlistCount = response.wishlist_count;

                    // Display success message and update wishlist count
                    $('.wishlist-count').addClass('cart-wishlist');
                    displaySuccessAlert(message);
                    updateWishlistCount(wishlistCount);
                } else if (response.hasOwnProperty('error')) {
                    var errorMessage = response.error;

                    // Display error message
                    displayErrorAlert(errorMessage);
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
        $('#messageText').text(message);
        $('#messageModal').modal('show');
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
```

### Step-4: Response From PHP Server
---
```php
 if(isset($_POST['product_id'])) {
    $db = new Database;

    $p_id = $_POST['product_id'];
    if(isset($_COOKIE['user_wishlist'])){
        $user_wishlist = json_decode($_COOKIE['user_wishlist']);
    }else{
        $user_wishlist = [];
    }
    if(!in_array($p_id,$user_wishlist)){
        array_push($user_wishlist,$p_id);
    }

    $wishlist_count = count($user_wishlist);
    $u_wishlist = json_encode($user_wishlist);

    if(setcookie('user_wishlist',$u_wishlist,time() + (180),'/','','',TRUE)){
        setcookie('wishlist_count',$wishlist_count,time() + (180),'/','','',TRUE);
        echo json_encode(['success'=>'cookie set successfully','wishlist_count'=>$wishlist_count]);
    }else{
        echo json_encode(['error'=>'cookie set successfully']);
    }
  };
```