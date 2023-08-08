# JS-PLUGINS-AND-CODES-FOR-PROJECTS

## Validation of Form

* To Validate black form , use the following file.It check the inputs on keyup event.It is totally live validation.MoreOver , The form name attribute must define in validate object like the following system.In the Form , Id must be called like id="myForm".
```bash
  validate.min.js // to connect from local
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script> //  CDN to connect via online

  Example Code of Validation 

  $(document).ready(function (){
      $('#myForm').validate({
          rules: {
              title: {
                  required : true,
              }, 
              thumbnail_name: {
                  required : true,
              }, 
             
          },

          messages :{

              title: {
                  required : 'Please Enter Product Name',
              },
        thumbnail_name: {
                  required : 'Please Enter Product Image',
              }
          }
          errorElement : 'span', 
          errorPlacement: function (error,element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
          },
          highlight : function(element, errorClass, validClass){
              $(element).addClass('is-invalid');
          },
          unhighlight : function(element, errorClass, validClass){
              $(element).removeClass('is-invalid');
          },
      });
  });

  ```

  ## Editor Of TextArea input

  To edit and write message with various format, use the CDN and Code.It is the best suitable editor of js plugins.In the Textarea tag, Id must be defined like id="mytextarea"
  ```bash
  tinymce.min.js // for local store

  <script src='https://cdn.tiny.cloud/1/vdqx2klew412up5bcbpwivg1th6nrh3murc6maz8bukgos4v/tinymce/5/tinymce.min.js' referrerpolicy="origin"> // CDN from online

  Example Code

  tinymce.init({
          selector: '#mytextarea'
        });
  ```

  ## Single or Multiple Image live show after Upload

  In Single Image , the code Format

  ```bash

  Html Code

    <input type="file" class="form-control" id="thumbnail_name" name="thumbnail_name" placeholder="Product Title" onChange="thunmbnail_Url(this)" >

    <img src="" id="mainThmb" />

  js Code

  function thunmbnail_Url(input){
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      $('#mainThmb').attr('src',e.target.result).width(80).height(80);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

To SHow Multiple Image

Html Code 
<input type="file" multiple class="form-control" id="product_gallery_images" name="product_gallery_images[]" placeholder="Product Title">

    <div class="row" id="preview_img"></div>

    Js Codes

$(document).ready(function(){
 $('#product_gallery_images').on('change', function(){ //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {
        var data = $(this)[0].files; //this file data
         
        $.each(data, function(index, file){ //loop though each file
            if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                var fRead = new FileReader(); //new filereader
                fRead.onload = (function(file){ //trigger function on successful read
                return function(e) {
                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                .height(80); //create image element 
                    $('#preview_img').append(img); //append image to output element
                };
                })(file);
                fRead.readAsDataURL(file); //URL representing the file's data.
            }
        });
         
    }else{
        alert("Your browser doesn't support File API!"); //if File API is absent
    }
 });
});

  ```

  ## DataTable Plugin
  To Format the table data with pagination ,search and Sorting, Use THe Datatable plugin.Id must be called in table tag like id="example". Following

  The CDN and code
  ```bash

dataTables.bootstrap5.min.css // for local
jquery.datatables.min.js // for local

https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css

https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js

https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js


  Code Example of Table data



  $(document).ready(function() {
			$('#example').DataTable();
} );
  ```

  ## Sweet-Alert for Notification with Confirm
  To Approve, Delete or Update that means anything actions, This plugin make sure what you want to do by warning
```bash

sweetalert2@10.js // for local
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> // CDN From Online

Example Code of Sweetalert

$(function(){


$(document).on('click','#ApproveBtn',function(e){
      e.preventDefault();
      var link = $(this).attr("href");


                Swal.fire({
                  title: 'Are you sure?',
                  text: "Approve This Data?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Approve it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = link
                    Swal.fire(
                      'Approved!',
                      'Your file has been Approved.',
                      'success'
                    )
                  }
                }) 

  });
});

```
## Notice Show after Action DELETE,APPROVE,UPDATE
to show notification after triggering any action 
```bash
 toasts.min.js // for local use
  toasts.min.css // for local use
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
 
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> // CDN

Example Code of This plugin 

 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 

```

## Search Or Any Tag with Highlight

To Search or any product tag are used by filling in the input box.
To Highliht the tags ,we can use The tagsInput jquery plugin

```bash
tagsinput.css // css local file
tagsinput.js // js local file

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" /> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>


Sample of Html Tag with data-role

<input type="text" name="product_color" class="form-control visually-hidden" data-role="tagsinput" value="Red,Blue,Black">

Here Red,Blue , Black these values will be highlighted tag. try it with using locally

```

## JSCOLOR Plugin
jscolor.js is a web color picker with opacity (alpha channel) and customizable palette.

Single file of plain JS with no dependencies
Supports CSS colors such as rgba() and hex, including #rrggbbaa notation.
Download includes minified jscolor.min.js
Mobile friendly

```bash
// Local file

<script scr="jscolor.js"></script> // it is stored here

// online CDN

<script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.5.1/jscolor.min.js" integrity="sha512-/e+XGe8oSD9M1t0NKNCrUlRsiyeFTiZw4+pmf0g8wTbc8IfiLwJsjTODc/pq3hKhKAdsehJs7STPvX7SkFSpOQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <input type="text" name="theme_color_1" class="form-control jscolor" value="AFD340" autocomplete="off" style="background-image: none; background-color: rgb(175, 211, 64); color: rgb(0, 0, 0);">
  ```

# Laravel Section
---
Here all Laravel codes will be liked/uploaded by file.

### Crud With Storage File,Multiple Image and DRY Codes
  ---
Here  The crud Describes with File Uploading ,Updating and Deleting The Previous File with LARAVEL Storage Class.To See The Controller File ,Please Click the FOllowing Link.

[Crud With Storage File](LARAVEL-CODES/crud-storage-with-multi-file.php)

### Full Crud With Public_path() File by move()
---

This Crud describes Email,Name and Password Validating and Optimizing and Image File Uploading ,Updating and Deleting The Previous File with LARAVEL move(public_path()) function.

[Crud With Storage File](LARAVEL-CODES/crud-with-file.php)

### Image Used by Image Intervention Package
Image Intervention will optimize Image and resize Image with many features available here
Original Code Here.

```bash
        if($request->file('category_image')){

           #$img = Image::make($request->file('category_image'))->resize(320, 240)->insert(str_replace(array(' ','_'),'-',$request->category_name). "-" . rand(500,999) . "." . $mainImg->getClientOriginalExtension());
          # $save_url = "http://localhost:8000/upload/category/" . $imgOriginal; 

            $mainImg = $request->file('category_image');
            $imageStr = str_replace(array(' ','_'),'-',$request->category_name);
            $imgOriginal = $imageStr . "-" . rand(500,999) . "." . $mainImg->getClientOriginalExtension();
            Image::make($mainImg)->resize(320, 240)->save('upload/category/' . $imgOriginal);

            $save_url = "http://localhost:8000/upload/category/" . $imgOriginal; 
           
        }

        $category = Category::insert([
            'category_name' => $request->category_name,
            'category_image' => $save_url,
        ]);
```

### Migration File 
---
Laravel Migration is an essential feature in Laravel that allows you to create a table in your database. It allows you to modify and share the application's database schema. You can modify the table by adding a new column or deleting an existing column.

[Database all Datatypes and using the system in migration file](LARAVEL-CODES/migration-example.php)


### One TO Many Relation With Model
---
The File below describes the connection the Relationship with Child Model and Parent model.(BelongsTo() and hasMany()).

[Database all Datatypes and using the system in migration file](LARAVEL-CODES/migration-example.php)


## Mail Sending laravel 8 and 9 version
---
Step on how to send email or mail from localhost using laravel 9/8 apps.
[See The Steps to Configure the Mail Sending](LARAVEL-CODES/mail-sending-php.md)


## Password-eye Show Hide by Toggle Click

You can create a password show/hide functionality using an eye icon and a toggle button in HTML by combining HTML, CSS, and JavaScript. Here's a step-by-step guide on how to achieve this:

1. **HTML Structure**: Set up the HTML structure for your password input field, toggle button, and eye icon.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Password Show/Hide</title>

       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>
    <div class="password-container">
        <input type="password" id="password-input" placeholder="Password">
        <button id="toggle-button">
            <span id="eye-icon" class="fa fa-eye"></span>
        </button>
    </div>
    <script src="script.js"></script>
    # Or The script src in the Own File. 
</body>
</html>
```

2. **CSS Styling**: Style your elements using CSS. You can use Font Awesome icons for the eye icon. Include these styles in a `styles.css` file.

```css
.password-container {
    position: relative;
    display: flex;
    align-items: center;
    margin: 20px;
}

#password-input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
}

#toggle-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
}

.fa {
    font-size: 18px;
}

#eye-icon {
    color: #777;
}
```

3. **JavaScript Functionality**: Add JavaScript to toggle the visibility of the password field when the button is clicked. Include these scripts in a `script.js` file.

```javascript

const passwordInput = document.getElementById('password-input');
const eyeIcon = document.getElementById('eye-icon');
const toggleButton = document.getElementById('toggle-button');

toggleButton.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});

```

OR 

```bash
# HTML Code
---
<input type="password" name="password" autocomplete="current-password" required="" id="id_password">
  <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>

  # JS Code 
  ---
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');

  togglePassword.addEventListener('click', function (e) {
    # toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    # toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
```

4. **Linking Everything**: Make sure to include the Font Awesome CSS and your own styles and scripts in your HTML file. You can get the Font Awesome CSS link from their website.

Now, when you open your HTML file in a browser, you'll see a password input field with an eye icon toggle button. Clicking the button will toggle the visibility of the password text.

## Select Dropdown Combobox / categry wise subcategory
It is used in any kind of combo box of select option wise data show without page reload.
```bash
$(document).on('change','#category_id',function(){
    var category_id = $(this).val();
    $.ajax({
        url : "{{ url('/subcategory/ajax') }}/"+category_id,
        type:'GET',
        data:{category_id:category_id},
        dataType:"json",
        success:(response)=>{
            let option = `<option>Select Category</option>`;
            $.each(response, function(key,value){
                option+= `<option value="${value.id}">${value.subcategory_name}</option>`
            })
            $('#subcategory_id').html(option);
        }
    })
  })

  #OR

$(document).ready(function(){
            $('select[name="category_id"]').on('change', function(){
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ url('/subcategory/ajax') }}/"+category_id,
                        type: "GET",  
                        dataType: "json", 
                        success:function(data){
                            $('select[name="subcategory_id"]').html('');
                            var d =$('select[name="subcategory_id"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="subcategory_id"]').append('<option value="'+ value.id +'"> ' + value.subcategory_name + '</option>');
                            });
                        },
                    });
                }
                 else{
                    alert('danger');
                }
            });
        });

```

### Carbon and Normal Format Date 
---

```bash
 @php
                                                          
   $today = Carbon\Carbon::create($news->created_at);
    echo  $today->format('j F Y, h:i A'); # output 8 September 2022, 09:31 PM

@endphp 

      $carbonDate = Carbon\Carbon::create(date('Y-m-d'));

      # Format the date as desired
      $todayDate = $carbonDate->format('l, jS F Y'); 
      echo $todayDate # output Saturday, 5th August 2023

      # Normal Date Format
      date('m-d-Y',strtotime($post->created_at)) # Output 04-08-2023

      # IN Laravel , most used following format.

      {{ {{ $news->created_at->format('l M d Y') }} }}
```

### Latest , Popular by views and Related Post in Laravel
```bash
    $news = NewsPost::findOrFail($id);


        $cat_id = $news->category_id;
        $relatedNews = NewsPost::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(6)->get();

        $newsKey = 'blog' . $news->id;
        if (!Session::has($newsKey)) {
           $news->increment('view_count');
           Session::put($newsKey,1);
        }

        $newnewspost = NewsPost::orderBy('id','DESC')->limit(8)->get();
        $newspopular = NewsPost::orderBy('view_count','DESC')
        ->limit(8)->get();


 #Notes : This apply in any type of articles , products to show the latest , popular by user traffic and related things.
```

### Multiple Language Setup in Laravel App
---
Steps to Configure the Multi Language in App.

1 . Install The Package.
```bash
composer require stichoza/google-translate-php
```
2 . add The Provider in config\app.php
```bash
in this aliases array
'aliases' => Facade::defaultAliases()->merge([
        'GoogleTranslate' => Stichoza\GoogleTranslate\GoogleTranslate::class,
    ])->toArray(),

];

```

3 . add the desired languages in the select option of blade file / header file.
```bash
      <select class="form-select changeLang">
                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English
                        </option>

                        <option value="bn" {{ session()->get('locale') == 'bn' ? 'selected' : '' }}>Bangla
                        </option>

                        <option value="hi" {{ session()->get('locale') == 'hi' ? 'selected' : '' }}>Hindi
                        </option>

                        <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>French
                        </option>
                    </select>

```

4 .  Then make a method in controller file
```bash
 public function ChangeLanguage(Request $request){

        App::setLocale($request->lang);
        session()->put('locale',$request->lang);

        return redirect()->back();

    } # End Method
```
5 .  make a middleware file in naming convention.
```bash
php artisan make:middleware LanguageManager 

```

and add this in handle method of the middleware.

```bash

  if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        return $next($request);
```
6 . then add the middle  file in app/Http/Kernel.php
```bash
 \App\Http\Middleware\LanguageManager::class,

 in the protected middlewaregroup because it\'s effect on  the whole app. It is The application\'s route middleware groups.

  'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            # this middlewware

            \App\Http\Middleware\LanguageManager::class,
        ],
```

7 .First Of All , Jquery CDN mentioned below, add the top of the blade file.
add script code in master file to relaod while changing language

```bash
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">

    var url = "{{ route('changeLang') }}";
    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+$(this).val();
    });

</script>
```

8. make a route url
```bash
Route::get('/lang/change', [IndexController::class, 'Change'])->name('changeLang');
```

9 . to change the dynamic nav menu like category or subcategory add the cateogory, subcategory name with google translate like the following
```bash
 <a href="{{ url("news/category/$category->id/$category->category_slug") }}">

    {{ GoogleTranslate::trans($category->category_name,app()->getLocal())  }}
</a>

     # and subcategory sub menu

<a href="{{ url("news/subcategory/$item->id/$item->subcategory_slug") }}">

    {{ GoogleTranslate::trans($item->subcategory_name,app()->getLocal()) }}
</a>

```

10 . the url or anchor tag <a> <a/> which is not change language as usual. add the Google translate like the following
```bash
 <h1 class="sec-one-title">
<a href="{{ url('news/details/' . $slider->id . '/' . $slider->news_title_slug) }}">
    {{ GoogleTranslate::trans($slider->news_title, app()->getLocale()) }}
</a>
</h1>

# or any kind of url that is not change by the langauge option change . because normal texts are only changed by the option chang.
so add the following in the all anchor urls

 @foreach ($newnewspost as $item)
<div class="tab-image tab-border">
    <a href="{{ url('news/details/' . $item->id . '/' . $item->news_title_slug) }}"><img
            class="lazyload" src="{{ asset($item->image) }}"></a>
    <a href=" " class="tab-icon"><i class="la la-play"></i></a>
    <h4 class="tab_hadding"><a
            href="{{ url('news/details/' . $item->id . '/' . $item->news_title_slug) }}">{{ GoogleTranslate::trans($item->news_title, app()->getLocale()) }}
        </a></h4>
</div>
@endforeach
```

### Foreign id set with table in laravel
---
The code must be write with unsignedBigInteger('user_id')->unsigned() . like the following
```bash
          $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('news_id')->unsigned();
            $table->text('comment');
           
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('news_id')->references('id')->on('news_posts')->onDelete('cascade');
            $table->enum('status',[1,0])->default(0);
            $table->timestamps();
```

### manage a crud of a comment with database in laravel using ajax
---

Managing a CRUD (Create, Read, Update, Delete) system for comments in Laravel using Ajax involves setting up routes, controllers, models, and JavaScript code to handle the interactions. Below, I'll provide you with a step-by-step guide and example code snippets to achieve this. Please note that this is a high-level overview, and you might need to adjust the code according to your project's specific needs.

**Step 1: Set up the database**

Create a migration for the comments table:

```bash
php artisan make:migration create_comments_table
```

Edit the migration file to define the structure of the comments table:

```php
// database/migrations/xxxx_xx_xx_create_comments_table.php

public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('post_id');
        $table->text('body');
        $table->timestamps();
    });
}
```

Run the migration to create the comments table:

```bash
php artisan migrate
```

**Step 2: Create the Comment model**

Generate a Comment model:

```bash
php artisan make:model Comment
```

Define the relationships in the Comment model:

```php
// app/Models/Comment.php

class Comment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```

**Step 3: Set up routes**

Define routes for CRUD operations in the `routes/web.php` file:

```php
Route::resource('comments', CommentController::class)->middleware('auth');
```

**Step 4: Create the CommentController**

Generate a CommentController:

```bash
php artisan make:controller CommentController
```

Implement the CRUD operations in the controller:

```php
// app/Http/Controllers/CommentController.php

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validation

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'body' => $request->body,
        ]);

        return response()->json($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        // Validation

        $comment->update(['body' => $request->body]);

        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }
}
```

**Step 5: Create the Blade view**

Create a Blade view to display comments and handle Ajax interactions:

```html
<!-- resources/views/posts/show.blade.php -->

<div id="comments">
    <!-- Display existing comments here -->
</div>

<form id="comment-form">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <textarea name="body" placeholder="Add a comment"></textarea>
    <button type="submit">Submit</button>
</form>

<script>
    // Use JavaScript to handle AJAX requests and update the UI
</script>
```

**Step 6: Implement JavaScript for AJAX**

In your JavaScript code, you can use libraries like Axios or jQuery to send AJAX requests to the server for creating, updating, and deleting comments. Update the `script` tag in the Blade view to include your AJAX logic.

Here's a simplified example using Axios:

```html
<!-- resources/views/posts/show.blade.php -->

<!-- ... existing HTML ... -->

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const commentForm = document.getElementById('comment-form');
    const commentsContainer = document.getElementById('comments');

    commentForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(commentForm);
        const response = await axios.post('/comments', formData);

        // Update the UI with the new comment
        const newComment = response.data;
        const commentElement = document.createElement('div');
        commentElement.innerHTML = `<p>${newComment.body}</p>`;
        commentsContainer.appendChild(commentElement);

        commentForm.reset();
    });

    // Implement similar logic for updating and deleting comments using AJAX
</script>
```

Remember that this is just a basic example. You can enhance and optimize the JavaScript code based on your project's needs.

Please note that this example assumes you have already set up user authentication using Laravel's built-in authentication system or a package like Laravel Sanctum. Also, ensure you have proper security measures in place, like input validation and authorization checks, to prevent unauthorized access and potential vulnerabilities.