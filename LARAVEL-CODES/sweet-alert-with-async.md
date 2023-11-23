## Sweet Alert with Ajax Request and Laravel Response
---
Certainly! Below is a complete example of how you can use jQuery AJAX with Laravel to delete data and respond with SweetAlert messages. In this example, I'll assume you have a model named `MultiImage` for handling multi-image data.

1. **Web.php (Routes):**

   ```php
   Route::get('/multi-images', 'YourController@index')->name('multi-images.index');
   Route::delete('/delete/each-multi-image/{id}', 'YourController@deleteMultiImage')->name('delete.each.multi.image');
   ```

2. **YourController.php:**
   ```php
   use App\Models\MultiImage;
   use App\Helpers\ImageHelper; // Adjust the namespace based on your actual helper class

   public function index()
   {
       // Your code to retrieve multi-images and pass them to the view
   }

   public function deleteMultiImage($id)
   {
       $multiImage = MultiImage::find($id);

       if (!$multiImage) {
           return response()->json("Multi Image Not Found", 404);
       }

       ImageHelper::DeleteImage(null, $multiImage->photo_name);

       if ($multiImage->delete()) {
           return response()->json("Multi Image Deleted Successfully", 200);
       } else {
           return response()->json("Sorry! Multi Image not Deleted", 500);
       }
   }
   ```

3. **Blade View (multi-images.blade.php):**
   ```html
   <!-- Include SweetAlert and jQuery -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   <!-- Your multi-image display loop -->
   @foreach ($multiImages as $image)
       <div>
           <!-- Display image and other information -->

           <!-- Delete button -->
           <a data-id="{{ $image->id }}" href="javascript:void(0)" class="btn btn-inverse-danger delete-multi-image">Delete</a>
       </div>
   @endforeach

   <!-- Your existing HTML structure -->

   <!-- jQuery script -->
   <script>
    $(document).on('click', '.delete-multi-image', function(e){
        e.preventDefault();
        var id_tag = $(this);
        var delete_id = $(this).data('id'); // Use data() method
        console.log(delete_id);

        // var url = "{{ url('/delete/each-multi-image') }}" + '/' + delete_id;

        var url = "{{ route('delete.each.multi.image', ['id' => ':id']) }}";
        url = url.replace(':id', delete_id);

        console.log(url);

        Swal.fire({
            title: 'Are you sure?',
            text: 'Delete This Data?',
            icon: 'warning',
            color:'#000000',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response){
                        console.log(response);
                        Swal.fire({
                        icon: "success",
                        title:"Deleted",
                        text: response.success,
                       color:'#000000',
                        showConfirmButton: false,
                        timer: 2000});
                        id_tag.parent().parent('tr').remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the file.',
                            'error'
                        );
                    }
                });
            }
        });
    });
  </script>
   ```

   **Blade File of Master Template**
The Following Css design is for forcing the style sheet of sweet alert.
   ```php
   @stack('css-style')
   ```
  * in Child Template 

  ```php
    @push('css-style')
    <style>
    .swal2-html-container{
        font-size: 1.105rem !important;
        color: #191c21 !important;

    }
    .swal2-title{
        color: #0040bf !important;
    }
    .swal2-popup {
        width: 26em !important;
        background: #e6e3e3 !important;

    }
    </style>

    @endpush

    ```

This example assumes you have a controller method to fetch and pass `multiImages` to the view. Adjust the code based on your actual application structure. Also, make sure your routes and controller methods are named correctly. 


### **Auto Close Start**
This can be used in asynchronous data getting

```js
let timerInterval;
Swal.fire({
  title: "Auto close alert!",
  html: "I will close in <b></b> milliseconds.",
  timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading();
    const timer = Swal.getPopup().querySelector("b");
    timerInterval = setInterval(() => {
      timer.textContent = `${Swal.getTimerLeft()}`;
    }, 100);
  },
  willClose: () => {
    clearInterval(timerInterval);
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log("I was closed by the timer");
  }
});
```

### **Sweet Alert for Toast Message**
```js
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});
Toast.fire({
  icon: "success",
  title: "Signed in successfully"
});
```

### **Animated alert message**

```js
Swal.fire({
  title: "Custom animation with Animate.css",
  showClass: {
    popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `
  },
  hideClass: {
    popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `
  }
});
```

### **Sweet Alert To Show Image**
```js
Swal.fire({
  imageUrl: "https://placeholder.pics/svg/300x1500",
  imageHeight: 1500,
  imageAlt: "A tall image"
});

/* OR */
Swal.fire({
  title: "Sweet!",
  text: "Modal with a custom image.",
  imageUrl: "https://unsplash.it/400/200",
  imageWidth: 400,
  imageHeight: 200,
  imageAlt: "Custom image"
});
```
### **Just Simple Show Message**
```js
Swal.fire({
  title: "Good job!",
  text: "You clicked the button!",
  icon: "success"
});
```

### **Upload Image with popup input**
```js
const { value: file } = await Swal.fire({
  title: "Select image",
  input: "file",
  inputAttributes: {
    "accept": "image/*",
    "aria-label": "Upload your profile picture"
  }
});
if (file) {
  const reader = new FileReader();
  reader.onload = (e) => {
    Swal.fire({
      title: "Your uploaded picture",
      imageUrl: e.target.result,
      imageAlt: "The uploaded picture"
    });
  };
  reader.readAsDataURL(file);
}
```