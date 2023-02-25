# encode-and-decode-php8
simple example of how to encode and decode files in PHP 8 using the built-in Sodium extension.

simple example of how to encode and decode files in PHP 8 using the built-in Sodium extension.

Encoding a file:

php
Copy code
// Read file contents into a string
$fileContents = file_get_contents('path/to/file.txt');

// Generate a random key and nonce
$key = sodium_crypto_secretbox_keygen();
$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

// Encrypt the file contents with the key and nonce
$encryptedContents = sodium_crypto_secretbox($fileContents, $nonce, $key);

// Write the encrypted contents to a file
file_put_contents('path/to/encrypted-file.bin', $nonce . $encryptedContents . $key);
In this example, we use the file_get_contents function to read the contents of a file into a string. We then generate a random key and nonce using the sodium_crypto_secretbox_keygen and random_bytes functions, respectively. We encrypt the file contents using the sodium_crypto_secretbox function, which takes the file contents, nonce, and key as parameters. Finally, we concatenate the nonce, encrypted contents, and key into a single binary string and write the result to a new file using the file_put_contents function.

Decoding a file:

php
Copy code
// Read the encrypted contents from the file
$encryptedData = file_get_contents('path/to/encrypted-file.bin');

// Extract the nonce, ciphertext, and key from the binary string
$nonce = substr($encryptedData, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
$ciphertext = substr($encryptedData, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, -SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
$key = substr($encryptedData, -SODIUM_CRYPTO_SECRETBOX_KEYBYTES);

// Decrypt the ciphertext using the nonce and key
$decryptedContents = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);

// Write the decrypted contents to a file
file_put_contents('path/to/decrypted-file.txt', $decryptedContents);
In this example, we use the file_get_contents function to read the encrypted file contents into a binary string. We then extract the nonce, ciphertext, and key from the binary string using the substr function. We decrypt the ciphertext using the sodium_crypto_secretbox_open function, which takes the ciphertext, nonce, and key as parameters. Finally, we write the decrypted file contents to a new file using the file_put_contents function.

Note that the Sodium extension requires PHP 7.2 or higher and must be enabled in your PHP configuration. Additionally, you should store the encryption key and nonce securely and not include them in the encrypted file, as this could compromise the security of the encryption. In practice, you may want to use a more robust encryption scheme and take additional measures to ensure the security of your encrypted files.
