To send sensitive data in the query string of a URL in PHP while encrypting it and later decrypting it, you can follow these steps:

1. **Encrypt the Data Before Adding it to the URL**:
   Use a secure encryption method to encrypt the sensitive data before adding it to the query string. You can use PHP's `openssl_encrypt` and `openssl_decrypt` functions for this purpose.

   Here's an example of how you can encrypt and add data to the URL:

   ```php
   // Data to be encrypted
   $total = 3573;
   $subtotal = 3504;

   // Encryption key and method (use a strong key and method in production)
   $encryptionKey = 'YourEncryptionKey';
   $encryptionMethod = 'AES-256-CBC';
         // Generate a random 16-byte IV
      $iv = openssl_random_pseudo_bytes(16);

   // Encrypt the data
   $totalEncrypted = openssl_encrypt($total, $encryptionMethod, $encryptionKey, 0, $iv);
   $subtotalEncrypted = openssl_encrypt($subtotal, $encryptionMethod, $encryptionKey, 0, $iv);

  // Encode the IV as a base64 string for transmission in the URL
   $ivBase64 = base64_encode($iv);
   // Construct the URL with encrypted data
   $url = 'http://localhost/Ecommerce-Shopping-Project/checkout.php?total=' . urlencode($totalEncrypted) . '&subtotal=' . urlencode($subtotalEncrypted) . '&iv=' . urlencode($ivBase64);

   // Redirect to the URL
   header('Location: ' . $url);
   exit;
   ```

2. **Decrypt the Data on the Receiving Page**:
   On the `checkout.php` page, you can retrieve the encrypted values from the URL, decrypt them, and use the decrypted data.

   ```php
   // Encryption key and method (should be the same as used for encryption)
   $encryptionKey = 'YourEncryptionKey';
   $encryptionMethod = 'AES-256-CBC';

   // Retrieve and decrypt the data from the URL
   $totalEncrypted = $_GET['total'];
   $subtotalEncrypted = $_GET['subtotal'];

   $total = openssl_decrypt($totalEncrypted, $encryptionMethod, $encryptionKey, 0, $encryptionKey);
   $subtotal = openssl_decrypt($subtotalEncrypted, $encryptionMethod, $encryptionKey, 0, $encryptionKey);

   // Now, you can use $total and $subtotal as decrypted values
   echo "Total: $total<br>";
   echo "Subtotal: $subtotal";
   ```

Remember to replace `'YourEncryptionKey'` with a strong and secure encryption key. Also, ensure that you are using a secure encryption method and key management practices in a production environment.

This approach encrypts the data before sending it in the query string and decrypts it when it's received on the other page, providing a level of security for sensitive information in transit. However, it's essential to implement additional security measures, such as HTTPS, to protect data further, especially in a production environment.