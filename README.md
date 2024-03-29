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

  ## Single or Multiple Image live show pic and file name after Upload

  In Single Image , the code Format

  ```bash

 #  Html Code
 <label for="featured_img">Featured Image</label>
    <input type="file" class="form-control" id="featured_img" name="thumbnail_name" placeholder="Product Title" onChange="thunmbnail_Url(this)" >

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

# Image Name Show in inpute itself
function displayFileName(input) {
  if (input.files && input.files.length > 0) {
    // Get the selected file name
    const fileName = input.files[0].name;

    // Update the value attribute of the input to display the file name
    input.setAttribute('value', fileName);
  }
}


# To SHow Multiple Image

            <div class="form-group">
            <label for="product_gallery_images">Gallery Image</label>
                <input type="file" multiple class="form-control product_gallery_images" id="product_gallery_images" name="product_gallery_images[]">

                <div class="row" id="preview_img"></div>
            </div>>


# Js Codes

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

  ### Image Name Show Here
  ---
  ```js
  /* Multiple Image select Names */
const inputElement = document.getElementById('product_gallery_images');
  const labelElement = document.querySelector('label[for="product_gallery_images"]');

  inputElement.addEventListener('change', function () {
    const files = inputElement.files;
    if (files.length > 0) {
      let fileNames = Array.from(files).map(file => file.name).join(', ');
      labelElement.textContent = 'Gallery Images: ' + fileNames;
    } else {
      labelElement.textContent = 'Gallery Image';
    }
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

### Image Used in php build in system



```php



# in Update/store

$top_ad_data = TopAdvertisement::where('id',1)->first();
 if($request->hasFile('top_ad')) {
            $request->validate([
                'top_ad' => 'image|mimes:jpg,jpeg,png,gif'
            ]);

            unlink(public_path('upload/advertisements/'.$top_ad_data->top_ad));

            $ext = $request->file('top_ad')->extension();
            $final_name = 'top_ad'.'.'.$ext;
            $request->file('top_ad')->move(public_path('upload/advertisements/'),$final_name);

            $top_ad_data->top_ad = $final_name;

        }

        # in Delete 

         $sidebar_ad_data = SidebarAdvertisement::where('id',$id)->first();

        unlink(public_path('upload/advertisements/'.$sidebar_ad_data->sidebar_ad));
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
### CRUD system for comments in Laravel using
---

Managing a CRUD (Create, Read, Update, Delete) system for comments in Laravel using AJAX involves several components, including routes, controllers, models, views, and JavaScript. Below, I'll provide you with a step-by-step guide along with code examples for each component.

Assuming you have a model named `Comment` to represent the comments and a table named `comments` in your database.

1. **Routes (routes/web.php):**

```php
Route::get('/comments', 'CommentController@index'); // To fetch all comments
Route::post('/comments', 'CommentController@store'); // To create a new comment
Route::put('/comments/{id}', 'CommentController@update'); // To update a comment
Route::delete('/comments/{id}', 'CommentController@destroy'); // To delete a comment
```

2. **Controller (app/Http/Controllers/CommentController.php):**

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->save();
        
        return response()->json($comment);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }
}
```

3. **Blade View (resources/views/comments.blade.php):**

```html
<!DOCTYPE html>
<html>
<head>
    <title>Comments</title>
</head>
<body>
    <div>
        <h1>Comments</h1>
        <form id="addCommentForm">
            <input type="text" id="commentContent" placeholder="Add a comment">
            <button type="submit">Add Comment</button>
        </form>
    </div>
    <ul id="commentList">
        <!-- Comments will be displayed here dynamically -->
    </ul>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Fetch and display comments
            function fetchComments() {
                $.ajax({
                    url: '/comments',
                    type: 'GET',
                    success: function (data) {
                        var commentsHtml = '';
                        data.forEach(function (comment) {
                            commentsHtml += '<li>' + comment.content +
                                            ' <button class="deleteBtn" data-id="' + comment.id + '">Delete</button></li>';
                        });
                        $('#commentList').html(commentsHtml);
                    }
                });
            }

            fetchComments(); // Initial fetch

            // Add a new comment
            $('#addCommentForm').submit(function (e) {
                e.preventDefault();
                var content = $('#commentContent').val();

                $.ajax({
                    url: '/comments',
                    type: 'POST',
                    data: { content: content },
                    success: function () {
                        $('#commentContent').val('');
                        fetchComments(); // Fetch and update the list
                    }
                });
            });

            // Delete a comment
            $(document).on('click', '.deleteBtn', function () {
                var id = $(this).data('id');
                
                $.ajax({
                    url: '/comments/' + id,
                    type: 'DELETE',
                    success: function () {
                        fetchComments(); // Fetch and update the list
                    }
                });
            });
        });
    </script>
</body>
</html>
```

This example provides you with a basic implementation of a comment CRUD system in Laravel using AJAX. The provided code assumes that you have already set up the necessary database migrations, models, and have included jQuery for AJAX functionality. Remember that this is a simplified example, and in a real-world scenario, you might want to implement additional validation, error handling, and security measures.


### Laravel Set Notification with Read Unread Methods

Setting up user review notifications and implementing read and unread notifications functionality in the admin dashboard of a Laravel application involves several steps. I'll guide you through the process and provide code examples along the way.

**Step 1: Create Notification**

First, let's create a notification for user reviews. Run the following command to generate a new notification:

```bash
php artisan make:notification UserReviewNotification
```

This will create a new notification class at `app/Notifications/UserReviewNotification.php`.

In this notification class, you can customize the content of the notification message. For example:

```php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserReviewNotification extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A new review has been posted.')
            ->action('View Review', url('/reviews/' . $this->reviewId))
            ->line('Thank you for using our service!');
    }
}
```

**Step 2: Trigger Notification**

When a new review is posted, you'll need to trigger the notification. This might be done in your review controller or wherever reviews are stored. For instance:

```php
use App\Notifications\UserReviewNotification;

// After saving a new review
$user->notify(new UserReviewNotification($reviewId));
```

**Step 3: Admin Dashboard**

Now, let's set up the admin dashboard to display both read and unread notifications.

Assuming you have a route and a controller method for your admin dashboard, you can fetch the notifications like this:

```php
use Illuminate\Support\Facades\Auth;

public function adminDashboard()
{
    $user = Auth::user(); // Assuming the admin is logged in
    $unreadNotifications = $user->unreadNotifications;
    $readNotifications = $user->readNotifications;

    return view('admin.dashboard', compact('unreadNotifications', 'readNotifications'));
}
```

**Step 4: Display Notifications in the View**

In your admin dashboard view, you can iterate through the notifications to display them:

```html
<!-- Unread notifications -->
@foreach ($unreadNotifications as $notification)
    <div class="notification unread">
        {!! $notification->data['message'] !!}
        <a href="{{ route('mark.notification.read', ['id' => $notification->id]) }}">Mark as Read</a>
    </div>
@endforeach

<!-- Read notifications -->
@foreach ($readNotifications as $notification)
    <div class="notification read">
        {!! $notification->data['message'] !!}
    </div>
@endforeach
```

**Step 5: Mark Notification as Read**

Create a route and controller method to mark a notification as read:

```php
public function markNotificationAsRead($id)
{
    $notification = auth()->user()->notifications()->where('id', $id)->first();
    
    if ($notification) {
        $notification->markAsRead();
    }

    return redirect()->back();
}
```

**Step 6: Styling and AJAX (Optional)**

You can enhance the user experience by using AJAX to mark notifications as read without refreshing the page and by styling the notifications to fit your application's design.

Remember that this is a high-level guide, and you might need to adapt the code to fit your specific application structure and requirements.

### Mail and Databse Notification sent togather
---

```bash
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppraisalGoalPublish extends Notification implements ShouldQueue
{
    use Queueable;

    private $sender;
    private $reviewPeriod;
    private $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, $reviewPeriod)
    {
        $this->sender = $sender;
        $this->reviewPeriod = $reviewPeriod;
        $this->name = $this->sender->first_name.' '.$this->sender->last_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view(
            'your.view.path', ['name' => $this->name, 'reviewPeriod' => $this->reviewPeriod]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'sender' => $this->sender->id,
            'receiver' => $notifiable->id,
            'message' => 'The employee with the code $userCode and name ' . $this->name . ' has published his/her goals for the review Period '. $this->reviewPeriod .' for your approval. Thanks'
        ];
    }
}
```

* in controller file your can handle by following
```bash
$details = [

    'full_name' => $FirstName. ' ' . $LastName
];

$user->notify(new \App\Notifications\AppraisalGoalPublish($details));

# OR
 $user = User::where('role','admin')->get(); // to send to admin dashboard only.

Notification::send($user,new NewCommentNotification($details));

// Here , Custom Notification objects wil be enclosed of how many arguments is declared in the constructor   __construct($sender, $reviewPeriod);

```

* Send The data in Blade file via the following method
```bash
    public function toArray($notifiable)  //  this mehod can be **toDatabase($notifiable)**
    {
        return [
            'message'=>"New Comment added on the News",
            // 'reviewText'=>$this->ReviewInfo,
        ];
    }
```

* Use in Blade file 
```bash
# unReadNotifcation

     @php
$reviewcount = Auth::user()->unreadNotifications()->count()
     @endphp

# all UnReadNotification will  be looped here untill click or Read them.

but if want to delete from notice box after read of click the notification , must use the loop like this 

   @forelse ($user->unreadNotifications as $item)
        @php
            $item->markAsRead();
        @endphp 

@php
$user = Auth::user();
@endphp
         
         # all notification will  be looped here.

    @forelse($user->notifications as $notifiaction)
        <!-- item-->
        <a href="{{ route('pending.review') }}" class="dropdown-item notify-item">
            <div class="notify-icon bg-secondary">
                <i class="mdi mdi-heart"></i>
            </div>
            <p class="notify-details">{{ $notifiaction->data['message'] }}
                <b>Admin</b>
                <small class="text-muted"> {{ Carbon\Carbon::parse($notifiaction->created_at)->diffForHumans() }} </small>
            </p>
        </a>
     @empty

    @endforelse

    </div>
  
 **Note** :  {{ $notifiaction->data['message'] }} 

  above, data is column name of notification table and message of json text of data column field that means the message key of this return mentioned avobe in custom totification class method.
    return [
            'message'=>"New Comment added on the News",
            // 'reviewText'=>$this->ReviewInfo,
        ];
```

### all blade directives in laravel using with example

Blade is the templating engine used in Laravel, a popular PHP framework. Blade provides an elegant syntax for creating views and templates in Laravel applications. Here are some commonly used Blade directives with examples:

1. **{{ }}**: The double curly braces are used to escape and output content as HTML entities. This prevents cross-site scripting (XSS) attacks.

   Example:
   ```blade
   <p>Hello, {{ $name }}</p>
   ```

2. **{!! !!}**: The double curly braces with an exclamation mark allow you to output content as raw HTML. Use this directive with caution, as it doesn't automatically escape the content and may expose your application to XSS attacks.

   Example:
   ```blade
   <p>{!! $rawHtml !!}</p>
   ```

3. **@if, @else, @elseif, @endif**: These directives are used for conditional statements in Blade templates.

   Example:
   ```blade
   @if($isAdmin)
       <p>Welcome, Admin!</p>
   @else
       <p>Welcome, Guest!</p>
   @endif
   ```

4. **@unless**: This directive is used to perform the opposite of an `@if` condition. It executes the enclosed code block unless the condition is true.

   Example:
   ```blade
   @unless($loggedIn)
       <p>Please log in to continue.</p>
   @endunless
   ```

5. **@for, @foreach, @while**: These directives are used for looping through data.

   Example using `@foreach`:
   ```blade
   <ul>
       @foreach($items as $item)
           <li>{{ $item }}</li>
       @endforeach
   </ul>
   ```

6. **@forelse, @empty**: The `@forelse` directive works like `@foreach`, but it has a special `@empty` directive block that is executed if the loop is empty.

   Example:
   ```blade
   <ul>
       @forelse($items as $item)
           <li>{{ $item }}</li>
       @empty
           <li>No items available.</li>
       @endforelse
   </ul>
   ```

7. **@include**: This directive is used to include subviews or partials within your main views.

   Example:
   ```blade
   @include('partials.header')
   ```

8. **@yield, @section, @show, @extends**: These directives are used for creating and extending layouts.

   Example using `@yield` and `@section`:
   ```blade
   <!-- layout.blade.php -->
   <html>
       <head>
           <title>@yield('title')</title>
       </head>
       <body>
           @yield('content')
       </body>
   </html>

   <!-- page.blade.php -->
   @extends('layouts.layout')

   @section('title', 'Page Title')

   @section('content')
       <p>This is the page content.</p>
   @endsection
   ```

9. **@push, @stack**: These directives are used to push content onto a stack within a layout, allowing you to insert scripts or stylesheets at specific points.

   Example using `@push` and `@stack`:
   ```blade
   <!-- layout.blade.php -->
   <html>
       <head>
           @stack('styles')
       </head>
       <body>
           @yield('content')
           @stack('scripts')
       </body>
   </html>

   <!-- page.blade.php -->
   @extends('layouts.layout')

   @push('styles')
       <link rel="stylesheet" href="styles.css">
   @endpush

   @push('scripts')
       <script src="script.js"></script>
   @endpush
   ```

10. **@guest and @auth** Blade contains authentication directives that could be used to determine if the current user is authenticated or not.

```bash
@guest
    // The user is not authenticated...
@endguest
@auth
    // The user is authenticated...
@endauth
```

These are some of the most commonly used Blade directives in Laravel. They allow you to build dynamic and interactive views for your application.

11. **@forelse**The forelse directive is a special kind of loop. It is a foreach directive combined with the empty directive. Take a look at the following example:

```bash
@if ($blogs->count())
  @foreach ($blogs as $blog)
    <li>{{ $blog->title }}</li>
  @endforeach
@else
  <p>There are no blogs.</p>
@endif
```
12.**@inject**, The @inject directive is one of my faviourite directive and used on most places in my applications. The @inject directive used to retrieve a service from the Laravel’s Service Container and inject into your view.

The first argument passed to this directive is a variable name the service will be placed into, while the second argument is the class or interface of the service you want to inject.

```bash
@inject('menu', 'App\Services\MenuService')

// then in your view

{!! $menu->render() !!}

```

### Custom Blade Directive with Making Service Provider

Sure, I can provide you with an example of how to create a custom service provider to register custom Blade directives and then use those directives in a Blade template.

Step 1: Create the Custom Service Provider
Let's create a custom service provider called `CustomBladeDirectivesServiceProvider` where we'll define our custom Blade directives.

1. Create the service provider:
Run the following command to create a new service provider:
```sh
php artisan make:provider CustomBladeDirectivesServiceProvider
```

2. Open the generated `CustomBladeDirectivesServiceProvider.php` file located in the `app/Providers` directory. Inside the `boot` method, you can define your custom Blade directives:
```php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CustomBladeDirectivesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('datetime', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->format('Y-m-d H:i:s'); ?>";
        });

    
        Blade::directive('uppercase', function ($expression) {
            return "<?php echo strtoupper($expression); ?>";
        });


# @ifenv: Conditional check based on the environment.
        Blade::directive('ifenv', function ($expression) {
    return "<?php if(app()->environment($expression)): ?>";
});

Blade::directive('endifenv', function () {
    return "<?php endif; ?>";
});

# @ifenv: Conditional check based on the environment. End


# @repeat: Repeats the content within the directive a certain number of times.
Blade::directive('repeat', function ($expression) {
    list($count, $content) = explode(',', $expression, 2);
    return "<?php echo str_repeat($content, $count); ?>";
});

# @datetime is alternative of carbon datetitme 
 Blade::directive('datetime', function ($expression) {
        return "<?php echo with($expression)->format('Y-m-d H:i:s'); ?>";
    });

# @isadmin directive Start
    Blade::directive('isadmin', function () {
        return "<?php if(auth()->user() && auth()->user()->isAdmin()): ?>";
    });

    Blade::directive('endisadmin', function () {
        return "<?php endif; ?>";
    });

    # @isadmin directive Start

    }

    public function register()
    {
        //
    }
}
```

Step 2: Register the Service Provider
Add your custom service provider to the `providers` array in the `config/app.php` configuration file:
```php
'providers' => [
    // ...
    App\Providers\CustomBladeDirectivesServiceProvider::class,
],
```

Step 3: Using the Custom Blade Directives in a View
Now you can use the custom Blade directives in your Blade templates.

Create a new Blade view file, for example, `custom.blade.php`, and add the following content:
```blade

@extends('layouts.app')

@section('content')
    <p>Current date and time: @datetime(now())</p>
    <p>Uppercase text: @uppercase('hello world')</p>
@endsection

# @ifenv: Conditional check based on the environment.
@ifenv('local')
    <p>This is a local environment.</p>
@endifenv


# @repeat: Repeats the content within the directive a certain number of times.
@repeat(3, '<p>Repeated content</p>')


<p>Current date and time: @datetime(now())</p>

@isadmin
    <p>You are an admin user.</p>
@endisadmin

```

In this example, the `@datetime` directive formats the current date and time, and the `@uppercase` directive converts the provided text to uppercase.

Remember to adjust the layout and include the `@yield('content')` directive in your layout file (`layouts/app.blade.php` in this example).

After creating the view and layout, you can visit the route associated with the view to see the custom Blade directives in action.

That's it! You've created a custom service provider to register custom Blade directives and used those directives in a Blade template within the Laravel framework.

### Page title setup dynamically

```bash

@yield('title');  # in home Page

@section('title', $news->news_title) # in different Pages

```

### Validation In Laravel

Create Public Method for both of crating and updating data.
in the following the concenated id ($requestForm->id)

```bash
 public function PermissionValidation($requestForm)
    {
      return   $requestForm->validate([
            'name'=>'required|unique:permissions,name,' . $requestForm->id, 
            'group_name'=>'required',
        ],[
            'name.required'=> 'permission name must be filled up',
            'name.unique'=>'The permission Name already Exist, Try with another name'
        ],
    );
    }

    # Or separate ID parameter

     public function PermissionValidation($requestForm, $id == null)
    {
      return   $requestForm->validate([
            'name'=>'required|unique:permissions,name,' . $id, 
            'group_name'=>'required',
        ],[
            'name.required'=> 'permission name must be filled up',
            'name.unique'=>'The permission Name already Exist, Try with another name'
        ],
    );
    }

    #or alternative system. We Know that one column validation rules can be declared in array ['required','email',Rule::unique('users', 'email')->ignore($id),]. like the following.

    $requestForm->validate(
        ['email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            ]
            );
```
In Blade File to show the error

```bash
<div class="form-group col-md-6 mb-3">
                <label for="inputEmail4" class="form-label">Roles Name </label>
                <input type="text" value={{ old('name') }} name="name" class="form-control" id="inputEmail4" placeholder="Add Roles">
                @error('name')
                <div class="alert alert-danger w-100 text-center bg-white m-1">{{ $message }}</div>
            @enderror
            </div>
```

### how to checked related checkbox  by clicking a single checkbox and not checked all by one in foreach loop in laravel.

It seems like you want to achieve a "check all" functionality for the related checkboxes within a specific group, rather than checking all checkboxes across all groups. To implement this, you need to make sure that each group checkbox is responsible for toggling only the checkboxes within its own group. Here's how you can achieve this in Laravel using jQuery:

Assuming you have a foreach loop in your Laravel Blade view that generates group checkboxes and associated permission checkboxes:

```html
@foreach($groups as $group)
    <input type="checkbox" class="group_name" data-group-id="{{ $group->id }}">
    <label>{{ $group->name }}</label>

    @foreach($group->permissions as $permission)
        <input type="checkbox" class="permission_checkbox group_{{ $group->id }}" name="permission[]" value="{{ $permission->id }}">
        <label>{{ $permission->name }}</label>
    @endforeach
@endforeach
```

In the above code, we've added the `data-group-id` attribute to the group checkbox and used a `group_{{ $group->id }}` class for the permission checkboxes associated with each group.

Now, you can update your jQuery script to handle the "check all" functionality within each group:

```javascript
$('.group_name').on('click', function() {
    var groupId = $(this).data('group-id');
    var permissionCheckboxes = $('.permission_checkbox.group_' + groupId);

    permissionCheckboxes.prop('checked', $(this).is(':checked'));
});

# To select all combobox by one click , another example in the following

  $('#customckeck15').click(function(){
            if ($(this).is(':checked')) {
                $('input[type = checkbox]').prop('checked',true);
            }else{
                 $('input[type = checkbox]').prop('checked',false);
            }
         });
```

This script listens for the click event on each `.group_name` checkbox. When a group checkbox is clicked, it extracts the `data-group-id` attribute to determine the associated group's ID. Then, it selects all permission checkboxes with the class `.permission_checkbox` and the specific group class (e.g., `.group_1`, `.group_2`, etc.) and sets their checked status to match the checked status of the group checkbox.

With this setup, when you click a group checkbox, it will toggle the related permission checkboxes within that specific group, without affecting other groups' checkboxes.

### Laravel Database data access from a table and related data based on parent  data.

```bash

Suppose Permissions\'s Group Name and Permission name by Group Name.

      @php
          $idkey = 0;
          $forkey=0;
      @endphp

      @foreach ($role_has_permissions_group as $groupkey =>  $permissions_group_name)
          
      
         <div class="row">
            <div class="col-3">
                <div class="form-check mb-2 form-check-primary">
                    <input class="form-check-input group_name" data-group-id="{{ $groupkey }}" type="checkbox" value="" id="customckeck{{ $idkey++ }}">
                    <label class="form-check-label" for="customckeck{{ $forkey++ }}">
                        {{ $permissions_group_name->group_name }}
                    </label>
                </div>
            </div>

            @php
                $group_wise_permission_name = App\Models\User::GroupByPermissionName($permissions_group_name->group_name);
            @endphp

            <div class="col-9">
                @foreach ($group_wise_permission_name as $key => $permission_name)
                    
               
                <div class="form-check mb-2 form-check-primary">
                    <input class="form-check-input permission_checkbox group_{{ $groupkey }}" name="permission[]" type="checkbox" value="{{ $permission_name->id }}" id="customckeck{{ $permission_name->id }}">
                    <label class="form-check-label" for="customckeck{{ $permission_name->id }}">

                        {{ $permission_name->name }}

                    </label>
                </div>

                @endforeach
                
                <br>

            </div>
            
        </div>

        @endforeach
```
### how to Redirect to role wise dashboard after a different login page and back to their own login page after the session close in the Laravel.

To achieve role-based redirection in Laravel after login and returning to the respective login page after session closure, you can follow these steps:

1. **Set Up Multiple Login Routes and Redirects:**
    In your `routes/web.php` file, define different login routes for each user role. Also, specify the routes to redirect users to after successful login.

```php
Route::group(['middleware' => 'guest'], function () {
    // Admin login route
    Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm');
    Route::post('/admin/login', 'Auth\AdminLoginController@login');
    
    // User login route
    Route::get('/user/login', 'Auth\UserLoginController@showLoginForm');
    Route::post('/user/login', 'Auth\UserLoginController@login');
});
```

2. **Create Custom Login Controllers:**
    Create separate controller classes for each user role. Make sure these controllers extend Laravel's built-in `App\Http\Controllers\Auth\LoginController` and override the `$redirectTo` property.

```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard'; // Redirect after login

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

class UserLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/user/dashboard'; // Redirect after login

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
```

3. **Implement Custom Logout Functionality:**
    Customize the logout functionality to redirect users back to their respective login pages after session closure. You can do this by overriding the `logout` method in your `LoginController`.

```php
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Existing code
    
    public function logout(Request $request)
    {
        $redirectTo = '/'; // Default redirect
        
        if (Auth::guard('admin')->check()) {
            $redirectTo = '/admin/login'; // Admin logout
        } elseif (Auth::guard('web')->check()) {
            $redirectTo = '/user/login'; // User logout
        }
        
        $this->guard()->logout();
        $request->session()->invalidate();
        
        return redirect($redirectTo);
    }
}
```

4. **Update Middleware for Dashboard Access:**
    Use middleware to ensure that only authenticated users with the appropriate roles can access their respective dashboards.

```php
Route::middleware(['auth:admin', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', 'UserController@dashboard');
});
```

5. **Implement Role Middleware:**
    Create a custom middleware to check the user's role and grant or deny access accordingly. You can create a middleware using the `php artisan make:middleware RoleMiddleware` command.

```php
public function handle($request, Closure $next, $role)
{
    if ($role === 'admin' && Auth::guard('admin')->check()) {
        return $next($request);
    } elseif ($role === 'user' && Auth::guard('web')->check()) {
        return $next($request);
    }

    abort(403, 'Unauthorized');
}
```

Remember to adjust namespaces and class names according to your application's structure. This example assumes you have separate guards for admin and user (you might need to define these guards in your `config/auth.php` file). Also, don't forget to implement the actual dashboard controller actions.

Always make sure to test thoroughly to ensure everything works as intended.

### how to Redirect to role wise dashboard after a different login page and back to their own login page after the session close in the Laravel breeze package.

To achieve role-based redirection after a different login page and returning to their own login page after the session closes using the Laravel Breeze package, you can follow these steps:

1. **Set Up Role-based Redirection:**

   In Laravel Breeze, you can customize the redirection logic in the `Authenticate.php` middleware. This middleware handles the redirection after successful login. To redirect users based on their roles, you can modify the `handle` method in `app/Http/Middleware/Authenticate.php`:

   ```php
   public function handle($request, Closure $next, ...$guards)
   {
       $guards = empty($guards) ? [null] : $guards;

       foreach ($guards as $guard) {
           if (Auth::guard($guard)->check()) {
               $user = Auth::guard($guard)->user();
               if ($user->hasRole('admin')) {
                   return redirect('/admin/dashboard'); // Redirect to admin dashboard
               } elseif ($user->hasRole('user')) {
                   return redirect('/user/dashboard'); // Redirect to user dashboard
               }
           }
       }

       return $next($request);
   }
   ```

   This code snippet assumes that you have a `hasRole` method in your User model to check the user's role.

2. **Return to Specific Login Page:**

   To redirect users back to their respective login pages after the session closes, you can customize the login path in the `LoginController.php` of Laravel Breeze:

   ```php
   protected function loggedOut(Request $request)
   {
       return redirect()->route('login'); // Redirect to the general login page
   }
   ```

   In this example, it redirects users to the general login page. You can modify this method to redirect users to different login pages based on their roles.

Remember to adjust the route names, URLs, and role-checking logic to match your application's structure and requirements.

3. **Session Timeout Handling:**

   To handle the session timeout, you might need to customize the behavior in Laravel's built-in authentication system. Specifically, you can modify the `App\Http\Middleware\AuthenticateSession.php` middleware to achieve this.

   ```php
   protected function redirectTo($request)
   {
       if (! $request->expectsJson()) {
           if (Auth::check()) {
               $user = Auth::user();
               if ($user->hasRole('admin')) {
                   return route('admin.login'); // Redirect admin to admin login
               } elseif ($user->hasRole('user')) {
                   return route('user.login'); // Redirect user to user login
               }
           }
       }
   }
   ```

   This code will redirect users to their respective login pages when their session times out.

Please make sure to adjust the code according to your specific routes, roles, and folder structures. It's also important to ensure that your authentication system and role management are properly set up before implementing these changes.

### how to controll admin panel base on role and permission in laravel?

Controlling the admin panel based on roles and permissions in Laravel involves a multi-step process. You can utilize packages like Spatie Laravel Permissions and create middleware to handle role and permission checks. Here's a step-by-step guide:

1. **Install and Configure Spatie Laravel Permissions:**
   Install the package using Composer:
   
   ```bash
   composer require spatie/laravel-permission
   ```

   After installation, run the migration to create the necessary tables:

   ```bash
   php artisan migrate
   ```

   In your `config/auth.php` file, set the user provider to use the `eloquent` provider.

   ```php
   'providers' => [
       'users' => [
           'driver' => 'eloquent',
           'model' => App\Models\User::class,
       ],
   ],
   ```

2. **Define Roles and Permissions:**
   In your `User` model, use the `HasRoles` and `HasPermissions` traits provided by the package:

   ```php
   use Spatie\Permission\Traits\HasRoles;
   use Spatie\Permission\Traits\HasPermissions;

   class User extends Authenticatable
   {
       use HasRoles, HasPermissions;
       
       // ...
   }
   ```

   Define roles and permissions in your application. You can do this in a seeder or directly in a migration:

   ```php
   use Spatie\Permission\Models\Role;
   use Spatie\Permission\Models\Permission;

   // Create roles
   $adminRole = Role::create(['name' => 'admin']);
   $userRole = Role::create(['name' => 'user']);

   // Create permissions
   $manageUsers = Permission::create(['name' => 'manage users']);
   $managePosts = Permission::create(['name' => 'manage posts']);

   // Assign permissions to roles
   $adminRole->givePermissionTo([$manageUsers, $managePosts]);
   ```

3. **Create Middleware for Role and Permission Checks:**
   Create a middleware to check for roles and permissions. This middleware can be used to protect routes and actions that require specific roles or permissions.

   ```bash
   php artisan make:middleware CheckRolePermission
   ```

   In the `handle` method of the middleware, perform the role and permission checks:

   ```php
   public function handle($request, Closure $next, ...$rolesAndPermissions)
   {
       $user = Auth::user();

       if (! $user->hasAnyRole($rolesAndPermissions) && ! $user->hasAnyPermission($rolesAndPermissions)) {
           abort(403, 'Unauthorized action.');
       }

       return $next($request);
   }
   ```

4. **Apply Middleware to Routes:**
   Apply the custom middleware to routes that require specific roles or permissions.

   ```php
   Route::middleware(['auth', 'role-permission:admin,manage users'])->group(function () {
       // Your admin panel routes here
   });
   ```

5. **Use Middleware in Controllers:**
   In your controller methods, use the middleware to protect specific actions:

   ```php
   public function manageUsers()
   {
       // This action is only accessible to users with the "admin" role or the "manage users" permission
   }
   ```

By following these steps, you can control access to your admin panel based on roles and permissions using the Spatie Laravel Permissions package. Remember to adjust the role and permission names, middleware, and routes according to your application's requirements.


### Error Handling In Laravel
---

As of my last knowledge update in September 2021, Laravel 8 was the latest version available. However, I can still provide you with information about error handling and custom error pages in Laravel, although the specifics might change if Laravel 10 is released after my last update.

In Laravel, you can handle various types of errors and create custom error pages to provide a better user experience. Common HTTP errors like 404 (Not Found) and 500 (Internal Server Error) can be customized to display user-friendly messages or views.

Here's how you can handle and customize these errors in Laravel:

1. **Customizing Error Views:**
   Laravel allows you to create custom error views for different HTTP error codes. These views are located in the `resources/views/errors` directory. You can create blade view files for specific error codes, such as `404.blade.php` for the 404 error and `500.blade.php` for the 500 error. Customize these views according to your design and messaging preferences.

2. **Exception Handling:**
   Laravel's `App\Exceptions\Handler` class is responsible for handling exceptions and converting them into HTTP responses. You can customize how exceptions are handled in the `render` method of this class. To handle specific exceptions, you can check the type of exception and return a custom response. For example:

   ```php
   public function render($request, Throwable $exception)
   {
       if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
           return response()->view('errors.404', [], 404);
       }

       // Handle other exceptions...

       return parent::render($request, $exception);
   }
   ```

3. **Registering Custom Error Pages:**
   You can also register custom error pages in your `app/Providers/AppServiceProvider.php` file's `boot` method using the `View::share` method:

   ```php
   public function boot()
   {
       $this->registerErrorViews();

       // Other boot logic...
   }

   protected function registerErrorViews()
   {
       view()->share('errorCode', ''); // Set a default value

       view()->composer('errors.404', function ($view) {
           $view->with('errorCode', 404);
       });

       // Add similar composers for other error views...
   }
   ```


Remember to customize the handling of each exception based on your application's requirements.

4. **Maintenance Mode:**

You can put your application into maintenance mode by running the `php artisan down` command. This will display a maintenance mode view when users access your application.

```bash
php artisan down --message="We're doing some maintenance. Please check back later."
```

5. **Customizing Maintenance Mode Page:**

You can customize the maintenance mode page by modifying the `resources/views/errors/503.blade.php` view.


As of my last knowledge update in September 2021, Laravel 10 had not been released yet. The latest version available at that time was Laravel 8. However, I can provide you with information on how error handling and custom error pages are typically implemented in Laravel. Keep in mind that some details might have changed in newer versions, so it's always a good idea to consult the official Laravel documentation for the most up-to-date information.

In Laravel, you can handle various types of errors and customize error pages using the following steps:

1. **Handling Exceptions:**

Laravel provides a powerful exception handling mechanism through the `App\Exceptions\Handler` class. You can customize this class to handle different types of exceptions. Here's how you can define custom exception handling:

First, create a new exception class if needed:

```bash
php artisan make:exception CustomException
```

Then, open the `app\Exceptions\Handler.php` file and update the `report` and `render` methods to handle your custom exceptions and other built-in exceptions:

```php
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    // ...

    public function render($request, Exception $exception)
    {
        if ($exception instanceof CustomException) {
            return response()->view('errors.custom', [], 500);
        }

        return parent::render($request, $exception);
    }

    // ...


 # OR alternative 


    public function render($request, Exception $exception)
{
    if ($this->isHttpException($exception)) {
        if ($exception->getStatusCode() == 404) {
            return response()->view('errors.' . '404', [], 404);
        }
        if ($exception->getStatusCode() == 500) {
            return response()->view('errors.' . '500', [], 500);
        }
    }
    return parent::render($request, $exception);
}


    # OR alternative 

    public function register(): void
{

   $this->renderable(function (NotFoundHttpException $e, Request $request) {



        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Record not found.'
            ], 404);
        }


    });


}
}
# OR ALTERNATIVE 

public function render($request, Throwable $exception)
{
    if ($exception instanceof NotFoundHttpException) {
        return response()->view('errors.404', [], 404);
    }

    if ($exception instanceof \PDOException) {
        return response()->view('errors.500', [], 500);
    }

    return parent::render($request, $exception);
}


```


Inside the `errors` directory, create Blade view files for different error codes. For example:

- `resources/views/errors/404.blade.php` for the 404 error page.
- `resources/views/errors/500.blade.php` for the 500 error page.

Customize these views as needed, adding your own HTML, CSS, and design elements.

3. **Error Logging:**

Laravel also supports error logging out of the box. You can configure error logging in the `.env` file using the `LOG_CHANNEL` and related settings.

For example, to log errors to the `daily` log channel, add or update the following in your `.env` file:

```env
LOG_CHANNEL=daily
```

4. **Using Route Closures for Error Pages (Optional):**

In some cases, you might want to return custom error pages directly from your routes. You can do this using route closures:

```php
Route::get('/404', function () {
    return view('errors.404');
});

Route::get('/500', function () {
    return view('errors.500');
});
```

5. **HTTP Exceptions (404, 500, etc.):**

Laravel provides the abort() function to throw HTTP exceptions. You can use this function to return a specific HTTP response with a status code and a message.

```BASH

// For a 404 Not Found error
if (!$user) {
    abort(404, 'User not found');
}

// For a 500 Internal Server Error
if ($errorCondition) {
    abort(500, 'Something went wrong');
}

```

### how to get a database html data in laravel with various Format

In this example, strip_tags($post->content) removes all HTML tags from the post's content, and then Str::limit is applied to the stripped content. The use of {!! !!} around the Str::limit output ensures that the HTML is not escaped, allowing it to be rendered as HTML.
```bash
@foreach($posts as $post)
    <div class="post">
        <h2>{{ $post->title }}</h2>
        <p>{!! Str::limit(strip_tags($post->content), 150,'...') !!}</p> // '...' is optional parameter . it can be used like ''
         or
          <p>{!! Str::words(strip_tags($post->content), 150,'') !!}</p>
    </div>
@endforeach

```

### polymorphic relationship  tags in news , video  and photo gallery table in laravel
---

Setting up a polymorphic relationship in Laravel for a news portal project where tags can be associated with news articles, videos, and photo galleries involves a few steps. Polymorphic relationships allow a single relationship to be used for multiple types of models. Here's how you can achieve this:

Let's assume you have three tables/models: `News`, `Video`, and `PhotoGallery`, and you want to associate tags with each of these models.

1. **Database Setup:**

You'll need a table to store tags and a pivot table to manage the relationships. Create the necessary migration files:

```bash
php artisan make:migration create_tags_table
php artisan make:migration create_taggables_table
```

In the `create_tags_table` migration:

```php
public function up()
{
    Schema::create('tags', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}
```

In the `create_taggables_table` migration:

```php
public function up()
{
    Schema::create('taggables', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tag_id');
        $table->unsignedBigInteger('taggable_id');
        $table->string('taggable_type');
        $table->timestamps();
        
        $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
        
        $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
    });

}

 # OR alternative

    public function up()
{
    Schema::create('taggables', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tag_id');
        $table->unsignedBigInteger('taggable_id');
        $table->string('taggable_type');
        $table->timestamps();
    });
}
```

Run the migrations:

```bash
php artisan migrate
```

2. **Models Setup:**

In each of your models (`News`, `Video`, `PhotoGallery`), you'll define the polymorphic relationship with the `Tag` model.

```php
use Illuminate\Database\Eloquent\Model;

# In your Tag model, define the morphedByMany relationship:

class Tag extends Model
{
    // ...

   public function taggable()
{
    return $this->morphTo();
}

# or alternative 

public function news()
{
    return $this->morphedByMany('App\News', 'taggable');
}

public function videos()
{
    return $this->morphedByMany('App\Video', 'taggable');
}

public function photoGalleries()
{
    return $this->morphedByMany('App\PhotoGallery', 'taggable');
}



}


class News extends Model
{
    // ...

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

class Video extends Model
{
    // ...

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

class PhotoGallery extends Model
{
    // ...

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
```

3. **Creating and Retrieving Tags:**

You can now use these relationships to attach and retrieve tags for each model.

```php
$news = News::find(1);
$news->tags()->attach([1, 2, 3]); // Attach tags to the news article

$tags = $news->tags; // Retrieve tags associated with the news article

// Similarly, for Video and PhotoGallery
$video = Video::find(1);
$video->tags()->attach([2, 3, 4]);

$photoGallery = PhotoGallery::find(1);
$photoGallery->tags()->attach([1, 4, 5]);

# or alternative 
// Attaching tags to a model
$news = News::find(1);
$news->tags()->attach($tagIds);

// Retrieving tags for a model
$news = News::find(1);
$tags = $news->tags;

```

4. **Retrieving Models by Tag:**

You can also retrieve models associated with a specific tag.

```php
$tag = Tag::find(1);

$newsWithTag = $tag->news; // Retrieve news articles with this tag
$videosWithTag = $tag->videos; // Retrieve videos with this tag
$photoGalleriesWithTag = $tag->photoGalleries; // Retrieve photo galleries with this tag
```

That's the basic setup for a polymorphic relationship involving tags and multiple types of models in a Laravel news portal project. You can customize and expand upon this foundation to suit your specific project requirements.

### public function tags() **: MorphToMany** why used that type of class with : colon in laravel ?

The : MorphToMany after the method declaration indicates the return type of the method, which is a hint for developers and IDEs to understand the expected return type.

```bash
public function tags() : MorphToMany
{
    return $this->morphToMany(Tag::class,'taggable');
};
```
Regarding the : MorphToMany in the method declaration, it's optional and not strictly necessary for the code to work correctly. It's a type hint that helps you and your IDE understand the expected return type of the method. Laravel will still establish the relationship correctly even if you omit the : MorphToMany type hint. However, including it can improve code readability and help catch potential type-related errors during development.

In Wrap up : The : MorphToMany type hint is optional but can be helpful for code clarity and type safety.

### Using Polymorphic In Blade File (CRUD)

If you want to display the previously associated tags as a comma-separated list in a single input field for editing news, you can follow these steps:

1. Store or Create File.
```php
 public function AllPhotoGallery(){

        $photo = PhotoGallery::latest()->get();
        return view('backend.photo.all_photo',compact('photo'));

    } // End Method 

    # In above blade file set the code like the following
                       <td>
                        @php
                            $allTags = $item->tags->pluck('name')->toArray();
                        @endphp
                        @foreach ($allTags as $tag)
                            <span class="badge fill-round bg-primary">{{ $tag }}</span>
                        @endforeach
                    </td>


public function store(Request $request)
{
 $gallery = PhotoGallery::create([
                    'photo_gallery'=>$save_url,
                    'post_date'=>Carbon::now()->format('D F Y'),
                ]);

    // Attach tags
     // data set in input like international,national,business . it is used if the input tag is 
     <input type="text" name="tags"  class="selectize-close-btn" value="{{ old('tags') }}"> tag name will be store as string.

     if stored input value in  array  name="tags[]" ,
     we get the tags ,

     $tags = $request->tags.

     Otherwise

     $tags = explode(',', $request->input('tags'));

    foreach ($tags as $tagName) {
        $tag = Tag::insertGetId(['name' => $tagName]);
        $gallery ->tags()->attach($tag);
    }

    return redirect()->route('news.index')->with('success', 'News created successfully');
}
```

1. Retrieve the existing tags associated with the news item in your controller:

```php
$news = News::findOrFail($id);
$existingTags = $news->tags->pluck('name')->implode(',');
```

2. Pass the `$existingTags` variable to your Blade view:

```php
return view('news.edit', compact('news', 'existingTags'));
```

3. In your Blade view's edit form, populate the input field with the existing tags:

```html
<form method="POST" action="{{ route('news.update', $news->id) }}">
    <!-- ... other fields ... -->
        <input type="text" name="tags" value="{{ $existingTags }}" class="form-control">
    <!-- ... submit button ... -->
</form>
```

4. In your update method of the controller, you can handle updating the tags as follows:

```php
public function update(Request $request, $id)

{
    $photoGallary = PhotoGallery::findOrFail($id);
    $photoGallary->title = $request->input('title');
    $news->save();

    // Update tags
    $tagsInput = $request->input('tags');
    $tagsArray = explode(',', $tagsInput);

    $tagIds = [];
    foreach ($tagsArray as $tagName) {
        $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
        $tagIds[] = $tag->id;
    }

    $photoGallary->tags()->sync($tagIds);

    // Delete tags with no associations photogallery data.

    Tag::has('photoGallary', '=', 0)->delete(); //     It is not mandatory if want to keep previous tags for just show as record not plucking.

    return redirect()->route('news.index')->with('success', 'News updated successfully');
}


    public function delete($id){

        $photo = PhotoGallery::findOrFail($id);
        $tagIds = $photo->tags->
        pluck('id')->toArray();
        $img = $photo->photo_gallery;
        unlink($img);

        $photo->tags()->detach();

        // dd($tagIds);
        PhotoGallery::findOrFail($id)->delete();

         // Delete tags with no associations
         Tag::whereIn('id',$tagIds)->has('photoGallary','=',0)->delete();

        $notification = array(
            'message' => 'Photo Gallery Deleted Successfully',
            'alert-type' => 'success'

        );
        return redirect()->back()->with($notification); 


    } // End Method 

```

5. o display data from three tables joined together with a polymorphic relationship and filtered by the same tag name in Laravel, you can follow these steps. I'll provide a high-level overview along with code examples:

```php
    /* Tag Wise all News Videos and Photos */
    public function TagNewsVideosPhotos($tagName)
    {
        // $tags = Tag::with('newsPost','videoGallery','photoGallery')->where('name',$tagName)->get();
       
        $tag = Tag::where('name',$tagName)->firstOrFail();
        // dd($tag->photoGallary);
        $tagVideos = $tag->videoGallary()->with('tags')->get();
        $tagPhotos = $tag->photoGallary()->with('tags')->get();
        $tagNews = $tag->newsPost()->with('tags')->get();
        return view('frontend.tag.tag-wise-news-video-photo',compact('tagVideos','tagPhotos','tagNews'));
    }

    # Blade File

    <!-- Display Videos -->
@foreach ($tagVideos as $video)
    <h2>{{ $video->title }}</h2>
    <p>Tags: 
        @foreach ($video->tags as $tag)
            {{ $tag->name }}
        @endforeach
    </p>
@endforeach

<!-- Display Photos -->
@foreach ($tagPhotos as $photo)
    <h2>{{ $photo->title }}</h2>
    <p>Tags: 
        @foreach ($photo->tags as $tag)
            {{ $tag->name }}
        @endforeach
    </p>
@endforeach

```
6 . news or video or photo wise tag show in blade file (single data wise related tag show)

```php
            <div class="singlePage2-tag">
                <span> Tags : </span>
                @if (is_array($news->tags) || is_object($news->tags))
                    
                
                @foreach($news->tags as $tag)
                <a href="{{ url("/news-videos-photos/tags/$tag->name") }}" rel="tag">   {{ $tag->name }}
                </a>
                @endforeach
                @else
                <p>No tags found.</p>
                @endif
            </div>
```
Note : Apologies for any confusion. In the context of `Tag::whereIn('id', $tagIds)->has('news', '=', 0)->delete();`, the `0` is not related to an index. It represents the count of related news articles.

The line of code `->has('news', '=', 0)` is checking for tags that have zero related news articles. It's not referring to an index but rather specifying a condition for filtering tags based on the count of related news articles.

In Laravel's Eloquent ORM, the `has` method is used to filter results based on the existence of related records. In this case, it's being used to filter tags that have no related news articles (i.e., their count is zero).

So, the entire line of code is essentially saying "delete tags that are in the given `$tagIds` array and have no related news articles (count equals 0)." It's part of the process of cleaning up unused tags from the `tags` table.


### Normal RELATIONSHIP OF LARAVEL

In Laravel, a popular PHP web application framework, relationships are used to define how different database tables are related to each other. Laravel provides a convenient and expressive way to define and work with various types of relationships: one-to-one, one-to-many, and many-to-many.

Let's explore each of these relationship types and see how they are implemented in Laravel:

### 1. One-to-One Relationship:

In a one-to-one relationship, each record in one table is associated with exactly one record in another table.

Example: User and UserProfile tables, where each user has one profile.

**Database Structure:**
- users table
  - id
  - name
  - email

- user_profiles table
  - id
  - user_id
  - bio

**Laravel Relationship Definition:**

In the `User` model:
```php
public function profile()
{
    return $this->hasOne(UserProfile::class);
}
```

In the `UserProfile` model:
```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

### 2. One-to-Many Relationship:

In a one-to-many relationship, a record in one table can be associated with multiple records in another table.

Example: Post and Comment tables, where each post has multiple comments.

**Database Structure:**
- posts table
  - id
  - title
  - content

- comments table
  - id
  - post_id
  - text

**Laravel Relationship Definition:**

In the `Post` model:
```php
public function comments()
{
    return $this->hasMany(Comment::class);
}
```

In the `Comment` model:
```php
public function post()
{
    return $this->belongsTo(Post::class);
}
```

### 3. Many-to-Many Relationship:

In a many-to-many relationship, records in both tables can be associated with multiple records in the other table.

Example: User and Role tables, where each user can have multiple roles, and each role can be assigned to multiple users.

**Database Structure:**
- users table
  - id
  - name
  - email

- roles table
  - id
  - name

- role_user table (pivot table)
  - id
  - role_id
  - user_id

**Laravel Relationship Definition:**

In the `User` model:
```php
public function roles()
{
    return $this->belongsToMany(Role::class);
}
```

In the `Role` model:
```php
public function users()
{
    return $this->belongsToMany(User::class);
}
```

These Laravel relationships are defined within the model classes and use eloquent methods provided by Laravel's Eloquent ORM. By defining these relationships, you can easily fetch related data and perform various operations like querying, creating, and updating records based on these relationships. Remember to set up the appropriate database tables and foreign key constraints to ensure data integrity.


### Polymorphic RELATIONSHIP OF LARAVEL


Certainly! Let's dive deeper into polymorphic relationships and how they work with different types of associations (one-to-one, one-to-many, and many-to-many) in Laravel.

**Polymorphic Relationships:**

Polymorphic relationships allow a single model to be related to multiple other models on a single association. This is achieved by using two columns in the related table: one for the ID of the related model and another for the type of the related model. In Laravel, this is implemented using the `morphTo` and `morphMany`/`morphToMany` methods.

Here's how you can use polymorphic relationships for different association types:

**1. Polymorphic One-to-One Relationship:**

Imagine you have a `photos` table that can be associated with various types of content, like `users` and `posts`.

```php
// Photo model
class Photo extends Model {
    public function imageable() {
        return $this->morphTo();
    }
}

// User model
class User extends Model {
    public function photo() {
        return $this->morphOne(Photo::class, 'imageable');
    }
}

// Post model
class Post extends Model {
    public function photo() {
        return $this->morphOne(Photo::class, 'imageable');
    }
}
```

**2. Polymorphic One-to-Many Relationship:**

In this example, a `comments` table can be associated with different models like `posts` and `videos`.

```php
// Comment model
class Comment extends Model {
    public function commentable() {
        return $this->morphTo();
    }
}

// Post model
class Post extends Model {
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

// Video model
class Video extends Model {
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
```

**3. Polymorphic Many-to-Many Relationship:**

Suppose you have a scenario where `tags` can be associated with both `posts` and `videos`.

```php
// Tag model
class Tag extends Model {
    public function posts() {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function videos() {
        return $this->morphedByMany(Video::class, 'taggable');
    }
}

// Post model
class Post extends Model {
    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

// Video model
class Video extends Model {
    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
```

In these examples, the `imageable_type` and `commentable_type` columns in the `photos` and `comments` tables store the class names of the related models. The `imageable_id` and `commentable_id` columns store the IDs of the related records.

The `taggable_type` and `taggable_id` columns in the pivot table for tags handle the many-to-many relationship between `tags` and other models.

By using polymorphic relationships in Laravel, you can achieve flexibility in modeling complex associations between different models and tables in your application.


### GOOGLE MAP API IN LARAVEL IN FREE TRIAL

Integrating the Google Maps API into a Laravel app involves a few steps, including setting up the API key, creating the necessary views, and handling the JavaScript code for map rendering. Here's a step-by-step guide with a full code example:

**Step 1: Create a Google Cloud Project and Enable Maps JavaScript API**

1. Go to the [Google Cloud Console](https://console.cloud.google.com/) and create a new project if you don't have one.
2. Search for "Maps JavaScript API" in the library and enable it for your project.
3. Create an API key by navigating to the "Credentials" section under "APIs & Services."

**Step 2: Install Laravel**

If you haven't already set up a Laravel project, you can use Composer to create a new one:

```bash
composer create-project --prefer-dist laravel/laravel GoogleMapsApp
```

**Step 3: Configure API Key**

Open the `.env` file of your Laravel app and add your Google Maps API key:

```dotenv
GOOGLE_MAPS_API_KEY=your_api_key_here
```

**Step 4: Create a Route and Controller**

Create a new controller that will handle the map view:

```bash
php artisan make:controller MapController
```

Inside the `MapController.php`:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function showMap()
    {
        return view('map');
    }
}
```

**Step 5: Create a Blade View**

Create a new view file named `map.blade.php` in the `resources/views` directory. In this view, you'll add the HTML structure and JavaScript code to render the map:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Example</title>
    <style>
        /* Set the map container size */
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8
            });
        }
    </script>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
</body>
</html>
```

**Step 6: Define Route**

In the `routes/web.php` file, define a route that maps to the `showMap` method in the `MapController`:

```php
use App\Http\Controllers\MapController;

Route::get('/map', [MapController::class, 'showMap']);
```

**Step 7: Run the Application**

Now you can run your Laravel application:

 Remember to replace `'your_api_key_here'` with your actual Google Maps API key. Since you mentioned that you're using a free API without billing, make sure to adhere to the terms of usage and any potential limitations of the free tier of the Google Maps API.


 ### Bangladesh Division wise State raw Query
 ---
 Sure, here's an example of how you could structure the MySQL insert queries for adding divisions and states of Bangladesh. Please note that you'll need to have a suitable schema with the correct table names and columns before running these queries.

Assuming you have a `divisions` table with columns `id` and `name`, and a `states` table with columns `id`, `division_id`, and `name`, here's how you could insert data for all divisions and states of Bangladesh:

**Insert Divisions:**

```sql
INSERT INTO divisions (id, name) VALUES
(1, 'Dhaka'),
(2, 'Chittagong'),
(3, 'Rajshahi'),
(4, 'Khulna'),
(5, 'Barisal'),
(6, 'Sylhet'),
(7, 'Rangpur');
```

**Insert States (Assuming you have division IDs corresponding to the divisions above):**

```sql
-- Dhaka Division States
INSERT INTO states (id, division_id, name) VALUES
(1, 1, 'Dhaka'),
(2, 1, 'Gazipur'),
(3, 1, 'Narayanganj');

-- Chittagong Division States
INSERT INTO states (id, division_id, name) VALUES
(4, 2, 'Chittagong'),
(5, 2, 'Cox''s Bazar'),
(6, 2, 'Comilla');

-- Rajshahi Division States
INSERT INTO states (id, division_id, name) VALUES
(7, 3, 'Rajshahi'),
(8, 3, 'Bogra'),
(9, 3, 'Pabna');

-- Khulna Division States
INSERT INTO states (id, division_id, name) VALUES
(10, 4, 'Khulna'),
(11, 4, 'Jessore'),
(12, 4, 'Satkhira');

-- Barisal Division States
INSERT INTO states (id, division_id, name) VALUES
(13, 5, 'Barisal'),
(14, 5, 'Patuakhali'),
(15, 5, 'Bhola');

-- Sylhet Division States
INSERT INTO states (id, division_id, name) VALUES
(16, 6, 'Sylhet'),
(17, 6, 'Moulvibazar'),
(18, 6, 'Habiganj');

-- Rangpur Division States
INSERT INTO states (id, division_id, name) VALUES
(19, 7, 'Rangpur'),
(20, 7, 'Dinajpur'),
(21, 7, 'Lalmonirhat');

 or another query

 -- Dhaka Division
INSERT INTO districts (id, division_id, name) VALUES
(1, 1, 'Dhaka'),
(2, 1, 'Faridpur'),
-- ... (other districts of Dhaka division)

-- Chittagong Division
INSERT INTO districts (id, division_id, name) VALUES
(8, 2, 'Chittagong'),
(9, 2, 'Cox''s Bazar'),
-- ... (other districts of Chittagong division)

-- Rajshahi Division
INSERT INTO districts (id, division_id, name) VALUES
(18, 3, 'Rajshahi'),
(19, 3, 'Bogra'),
-- ... (other districts of Rajshahi division)

-- Khulna Division
INSERT INTO districts (id, division_id, name) VALUES
(29, 4, 'Khulna'),
(30, 4, 'Bagerhat'),
-- ... (other districts of Khulna division)

-- Barisal Division
INSERT INTO districts (id, division_id, name) VALUES
(38, 5, 'Barisal'),
(39, 5, 'Patuakhali'),
-- ... (other districts of Barisal division)

-- Sylhet Division
INSERT INTO districts (id, division_id, name) VALUES
(46, 6, 'Sylhet'),
(47, 6, 'Moulvibazar'),
-- ... (other districts of Sylhet division)

-- Rangpur Division
INSERT INTO districts (id, division_id, name) VALUES
(53, 7, 'Rangpur'),
(54, 7, 'Lalmonirhat');
-- ... (other districts of Rangpur division)

```

Remember to adapt these queries based on your actual table structure, column names, and division/state data. Also, be cautious when running insert queries directly on your production database, and make sure to have proper backups.

### search Data category id and subcategory id if exist or not.

```php
$newsPosts = NewsPost::with('subcategory')->orderBy('id', 'DESC');

if ($request->text_item != '') {
    $newsPosts = $newsPosts->where('news_title', 'LIKE', '%' . $request->text_item . '%');
}

if ($request->subcategory_id != '') {
    $newsPosts = $newsPosts->where('subcategory_id', $request->subcategory_id);
}

// New logic: Category-wise news
if ($request->category_id != '') {
    $newsPosts = $newsPosts->whereHas('subcategory', function ($query) use ($request) {
        $query->where('category_id', $request->category_id);
    });
}

$newsPosts = $newsPosts->paginate(12);

```



To achieve the functionality of zooming in on photos or videos after clicking them using a jQuery plugin in a Laravel app, you can follow these steps:

1. **Include jQuery and Zoom Plugin:**

First, ensure that you have jQuery included in your Laravel application. You can do this by including it from a CDN or using Laravel Mix if you prefer.

Next, you'll need a jQuery zoom plugin. One popular option is the "elevateZoom" plugin. You can include it in your project by adding the script tag to your layout file:

```html
<!-- In your layout.blade.php or similar file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>
```

2. **HTML Markup:**

In your Blade view, generate the HTML markup for displaying photos or videos. Each photo or video element should have a unique identifier, which will be used to apply the zoom effect.

```html
<!-- Example for photos -->
<img id="photo1" src="{{ asset('path_to_your_photo.jpg') }}" data-zoom-image="{{ asset('path_to_zoomed_photo.jpg') }}" class="zoomable">

<!-- Example for videos (you can use iframe for embedding videos) -->
<iframe id="video1" src="https://www.youtube.com/embed/your_video_id" class="zoomable"></iframe>
```

3. **JavaScript Initialization:**

Add a script block at the bottom of your view or in an external JavaScript file to initialize the zoom effect.

```html
<script>
    $(document).ready(function() {
        $('.zoomable').elevateZoom({
            zoomType: "inner",
            cursor: "crosshair",
            easing: true,
            galleryActiveClass: "active",
        });
    });
</script>
```

4. **Styling:**

You might want to add some styling to enhance the user experience. For example, you can define the size and appearance of the zoomed-in element. You can do this through CSS.

```css
/* Add appropriate styles to control the appearance of the zoomed element */
.zoomContainer {
    width: 400px;
    height: 300px;
    border: 2px solid #ccc;
    overflow: hidden;
}
```

Please note that the above steps are a basic guideline to implement zoom functionality using the "elevateZoom" plugin. Depending on your project structure and requirements, you might need to adjust the code and styles accordingly.

Remember to test thoroughly to ensure that the zoom effect works as expected and integrates well with your Laravel application.

### Facebook like , share and comment senction add
Integrating Facebook's like button, comments section, and share button into a Laravel app involves a few steps. You'll need to use Facebook's Social Plugins, specifically the Like Button, Comments Plugin, and Share Button. Here's a general outline of the process:

1. **Create a Facebook App:**
   To use Facebook's Social Plugins, you need to have a Facebook App. Go to the [Facebook for Developers](https://developers.facebook.com/) website, create a new app, and obtain the App ID.

2. **Include Facebook JavaScript SDK:**
   In your Laravel app's layout or template file, include the Facebook JavaScript SDK. This SDK is required for initializing the Social Plugins.

   ```html
   <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
   ```

3. **Initialize Facebook SDK:**
   Before using any Social Plugins, initialize the Facebook SDK with your App ID. You should do this in your JavaScript code, preferably in a separate JavaScript file.

   ```javascript
   window.fbAsyncInit = function() {
       FB.init({
           appId: 'YOUR_APP_ID',
           autoLogAppEvents: true,
           xfbml: true,
           version: 'v11.0'
       });
   };
   ```

4. **Integrate Like Button:**
   To integrate the Like Button into your Laravel app, place the following HTML code wherever you want the button to appear.

   ```html
   <div class="fb-like" data-href="YOUR_URL" data-width="" data-layout="standard" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
   ```

   Replace `YOUR_URL` with the URL you want users to like.

5. **Integrate Comments Plugin:**
   To integrate the Comments Plugin, place the following HTML code where you want the comments section to appear.

   ```html
   <div class="fb-comments" data-href="YOUR_URL" data-width="" data-numposts="5"></div>
   ```

   Replace `YOUR_URL` with the URL where you want the comments to be associated.

6. **Integrate Share Button:**
   To integrate the Share Button, place the following HTML code where you want the button to appear.

   ```html
   <div class="fb-share-button" data-href="YOUR_URL" data-layout="button_count"></div>
   ```

   Replace `YOUR_URL` with the URL you want users to share.

Remember to adjust the attributes of the HTML elements according to your design preferences and requirements. Also, make sure you have appropriate CSS to style the Facebook plugins to match your app's design.

Always refer to the [official documentation](https://developers.facebook.com/docs/plugins) for the most up-to-date information and customization options regarding Facebook's Social Plugins.

### Cookie PopUp for user visit in Laravel App
---
Sure, I can guide you through the process of creating a cookie popup in a Laravel application. To achieve this, you'll need to follow these steps:

1. **Create a Blade View for the Cookie Popup:**
Create a new Blade view file, let's say `cookie-popup.blade.php`, in the `resources/views` directory. This view will contain the HTML and JavaScript for the cookie popup.

```html
<!-- resources/views/cookie-popup.blade.php -->

<div id="cookie-popup" class="cookie-popup">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p>This website uses cookies to ensure you get the best experience on our website.</p>
            </div>
            <div class="col-md-4 text-center">
                <button id="accept-cookies" class="btn btn-primary">Accept</button>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function() {
    var cookiePopup = document.getElementById("cookie-popup");
    var acceptCookiesBtn = document.getElementById("accept-cookies");

    acceptCookiesBtn.addEventListener("click", function() {
        // Set a cookie to remember user's choice
        document.cookie = "cookies_accepted=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";

        // Hide the popup
        cookiePopup.style.display = "none";
    });

    // Show the popup if the user hasn't accepted cookies yet
    if (!document.cookie.includes("cookies_accepted=true")) {
        cookiePopup.style.display = "block";
    }
});
</script>

<style>
.cookie-popup {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 9999;
}

.cookie-popup p {
    margin: 0;
}

.cookie-popup .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.cookie-popup .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
</style>

```

2. **Include the Cookie Popup View in Your Layout:**
Open your main layout file, usually named `app.blade.php`, which is located in the `resources/views` directory. Include the cookie popup view within the layout.

```html
<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <!-- ... -->
</head>
<body>
    @include('cookie-popup') <!-- Include the cookie popup view -->

    <div class="container">
        @yield('content')
    </div>

    <!-- ... -->
</body>
</html>
```

3. **Route and Controller Logic:**
Define a route in your `routes/web.php` file that corresponds to the home/index page, and in the corresponding controller method, return the main view, which uses the layout including the cookie popup.

```php
// routes/web.php

Route::get('/', 'HomeController@index');
```

```php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index'); // 'home.index' is the name of your main view file
    }
}
```

That's it! With these steps, you've set up a cookie popup that will be displayed on the home/index page of your Laravel website. The popup will be hidden once the user clicks the "Accept" button, and a cookie will be set to remember their choice.

### SIGN UP/LOGIN With GOOGLE , GITHUB And FACEBOOK In LARAVEL
---

Signing up with Google in a Laravel application typically involves integrating Google's OAuth 2.0 authentication system. This allows users to log in using their Google accounts. Here's a step-by-step guide on how to achieve this:
In 

Step 1-google : **In Google Create Accounts and Obtain Credentials:**
---
1. **Create a Google Developer Project:**
   - Go to the Google Developers Console: https://console.developers.google.com/
   - Create a new project and configure its settings.

2. **Enable Google API:**
   - In your project, navigate to the "APIs & Services" > "Library" section.
   - Search for "Google+ API" and enable it. This API is used for basic user profile information.

3. **Create OAuth 2.0 Credentials:**
   - Still in the "APIs & Services" section, navigate to "Credentials."
   - Click on "Create Credentials" and choose "OAuth client ID."
   - Select "Web application" as the application type.
   - Add authorized redirect URIs, which will be URLs that Google will redirect users to after they authenticate. For a local Laravel application, you might use something like `http://localhost:8000/auth/google/callback`.
   - After creating the credentials, you'll get a `Client ID` and `Client Secret`.

Step 1-github : **In Github Create GitHub OAuth Application:**
---
   - Go to your GitHub account settings.
   - Navigate to "Developer settings" > "OAuth Apps."
   - Click on the "New OAuth App" button.
   - Fill in the required information:
     - Application Name: Your Laravel app's name.
     - Homepage URL: Your app's URL.
     - Authorization callback URL: A route in your Laravel app that will handle the GitHub callback after authentication.


Step 1-facebook : **Create a Facebook App:**
---
 **Remeber :** Facebook Auth can't be worked in localhost/http://127.0.0.1:8000/. So Use the Real domain to configure Facebook Auth with your application.

   - Go to the Facebook Developer Console (https://developers.facebook.com/apps/).
   - Create a new app and follow the setup process.
   - Note down the App ID and App Secret, which will be needed for authentication.
   - Go to facebook login from left sidebar menu option like this https://developers.facebook.com/apps/6230725350287436/fb-login/settings/
   - in  `Client OAuth settings` , toggle to yes button of both `Client OAuth login` and 
    `Web OAuth login`.
   - Browse in below and write *Domain Name* in the box label `Valid OAuth Redirect URIs` like this `mahmud.wdpf50.site/inventory-management-system/`-it is subdomain.
   - Browse in below and in `Redirect URI Validator` , write your reidrect url of label `Redirect URI to Check` inpute box like `mahmud.wdpf50.site/inventory-management-system/home` (if home is your redirect url.
   - Click save changes button).
   - go to facebook dashboard https://developers.facebook.com/apps/6230725350287436/dashboard/.
   - Then go to App settings from left sidebar menu option.
   - you will find `App iD` and  `App secret` from Basic of App settings options.
   - Wite your Domain Name in the label of `App domains`. like `mahmud.wdpf50.site`.
   - We will use the App ID to Clinet ID and App secret to Clinet Secrete in .env file.

   - **Notes** if Facebook Auth request sent from localhost, it will redrect with error

    ```js 
    Insecure Login Blocked
    You can not get an access token or login to this app from an insecure page. Try re-loading the page as https://
    ```

Step 2 : **Install Required Packages:**
   In your Laravel project, you'll need to install a package that simplifies OAuth integration. One popular choice is "Socialite." Install it via Composer:

   ```bash
   composer require laravel/socialite
   ```

Step 3 : **Update .env file**

Add the credentials and redirect URLs to your `.env` file:

```php
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT=http://your-app-url/auth/google/callback

FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT=http://your-app-url/auth/facebook/callback

GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT=http://your-app-url/auth/github/redirect

```
Step 4 : **Configure Services:**
   In your `config/services.php` file, add the configurations for each of the social providers. For example:

   ```php
   'google' => [
       'client_id' => env('GOOGLE_CLIENT_ID'),
       'client_secret' => env('GOOGLE_CLIENT_SECRET'),
       'redirect' => env('GOOGLE_REDIRECT'),
   ],

   'github' => [
       'client_id' => env('GITHUB_CLIENT_ID'),
       'client_secret' => env('GITHUB_CLIENT_SECRET'),
       'redirect' => env('GITHUB_REDIRECT'),
   ],

   'facebook' => [
       'client_id' => env('FACEBOOK_APP_ID'),
       'client_secret' => env('FACEBOOK_APP_SECRET'),
       'redirect' => env('FACEBOOK_REDIRECT'),
   ],
   ```

Step 5 : **Controller Class amd Methods**
In the SocialController, you'll need methods to initiate the login and handle the callback. Here's a simplified example:

```php
class SocialiteAuthController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
{

 $user = Socialite::driver('facebook')->user();
        
        // Check if the user exists in your database
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
            return redirect()->intended('/dashboard');
        } else {
            // Create a new user and login
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = bcrypt(Str::random(16)); // Set a random password
            $newUser->save();

            $newUser->assignRole('Editor');

            Auth::login($newUser);
            return redirect()->intended('/editor/dashboard');
             return redirect()->intended('/');
}

}
/*  Auth with Github */

public function redirectToGithub()
{
    return Socialite::driver('github')->redirect();
}

public function handleGithubCallback()
{
$user =  Socialite::driver('github')->user();
// Handle user authentication and data storage
$newUser = User::UpdateOrCreate(
    ['email'=>$user->email],
    [
        'name'=>$user->name,
        'email'=>$user->email,
        'password'=>Hash::make($user->password),
    ]
);

$newUser->assignRole('Editor');

Auth::login($newUser);
return redirect('/');

}

public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}


public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();

    $googleNewUser = User::updateOrCreate(
        [
            'email'=>$user->email,
        ],
        [
            'name'=>$user->name,
            'email'=>$user->email,
            'password'=>Hash::make($user->password),
        ]
    );
    $googleNewUser->assignRole('Subcriber');
    Auth::login($googleNewUser);
    return redirect('/');
}


}
```
Step 6. **Routing**
   Create a route and controller method to initiate the Google OAuth process:

```php

   Route::controller(SocialiteAuthController::class)->group(function(){

   // Redirect to Google for authentication
    Route::get('/login/github/', 'redirectToGithub');
    Route::get('/login/github/callback/','handleGithubCallback');
    // Google callback

    Route::get('/login/google/', 'redirectToGoogle');
    Route::get('/login/google/redirect/','handleGoogleRedirect');
  
  // Repeat similar steps for GitHub and Facebook

    Route::get('/login/facebook/', 'redirectToGFacebook');
    Route::get('/login/facebook/redirect/','handleFacebookRedirect');
});
```


Step 7-A : **Error Solved**
In Laravel\Socialite\Two\InvalidStateException error to Solve, add stateless() parameter.

```php
$user = Socialite::driver('google')->stateless()->user();

replace of $user = Socialite::driver('google')->user();

```

Step 7-B : **Disable CSRF Protection for Callback Route:**
If you suspect that Laravel's CSRF protection might be interfering with the callback request, you can exclude the callback route from CSRF protection by adding it to the $except array in `app/Http/Middleware/VerifyCsrfToken.php`:

```php
protected $except = [
    'login/google/callback', // Replace with your actual callback route
];

```


