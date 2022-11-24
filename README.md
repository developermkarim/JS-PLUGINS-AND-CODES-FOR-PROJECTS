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

  