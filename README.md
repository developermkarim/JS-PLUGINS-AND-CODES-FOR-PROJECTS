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

#