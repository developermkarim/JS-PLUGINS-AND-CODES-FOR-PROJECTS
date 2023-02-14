## Mail Sending laravel 8 and 9 version
---
Step on how to send email or mail from localhost using laravel 9 apps:

Step 1 – Install Laravel 9 App
Step 2 – Configuration SMTP in .env
Step 3 – Create Mailable Class
Step 4 – Add Email Send Route
Step 5 – Create Directory And Blade View
Step 6 – Create Email Controller
Step 7 – Run Development Server

Step 2 :
In first step, you have to add send mail configuration with mail driver, mail host, mail port, mail username, mail password so laravel 8/9 will use those sender configuration for sending email. So you can simply add as like following.
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=mygoogle@gmail.com
MAIL_PASSWORD=rrnnucvnqlbsl
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=mygoogle@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```
Step 3 : 
```bash
php artisan make:mail Mail/NotifyMail
```
Open the file and update the code below.
```bash
<?php

namespace App\Mail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class Websitemail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject,$body,$pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_subject,$mail_body,$mail_pdf)
    {
       $this->subject = $mail_subject;
       $this->body = $mail_body;
       $this->pdf = $mail_pdf;
    }


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
  
    public function build()
    {
       return $this->view('mail.mail')->with([
        'subject'=>$this->subject // this is for dynamic subject in  calling the class
       ]);

       or 
       return $this->subject('Test Email')->view('email.email'); // no dynamic Subject

       or 
        return $this->view('mail.invoiceEmail')->attachData($this->pdf, 'customer-invoice.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
```
Note : By whatever name you will create an email template. That you want to send. Do not forget to add an email template name in build class of the above created notifymail class.

Step 4:
In next step, we will create email template named mail.blade.php inside resources/views/emails directory. That’s why we have added view name email

Step 4 – Add Send Email Route
```bash
Route::get('send-email', [SendEmailController::class, 'index']);
```
Step 5 – Create Directory And Blade View
```bash
<!DOCTYPE html>
<html>
<head>
 <title>Laravel 9 Send Email Example</title>
</head>
<body>
 
 <h1>This is test mail from Tutsmake.com</h1>
 <p>Laravel 9 send email example</p>
 
</body>
</html> 
```
Step 6
Use The mail in Controller.for example like following. Or With PDF , use the following.
```bash
use Barryvdh\DomPDF\Facade\Pdf;
$pdf = Pdf::loadView('pdf.invoice', compact('billingName', 'date', 'orderId', 'selectedProducts', 'totalPrice'));

//*MAIL SEND
 Mail::to(auth()->user()->email)->send(new Websitemail($subject,$message, $pdf->output())); // if the pdf needs to send.

 // this error handling for if failed while mailing

  if (Mail::failures()) {
           return response()->Fail('Sorry! Please try again latter');
      }else{
           return response()->success('Great! Successfully send in your mail');
         }
```