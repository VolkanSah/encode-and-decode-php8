<?php

// Read file contents into a string
$fileContents = file_get_contents('path/to/file.txt');

// Generate a random key and nonce
$key = sodium_crypto_secretbox_keygen();
$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

// Encrypt the file contents with the key and nonce
$encryptedContents = sodium_crypto_secretbox($fileContents, $nonce, $key);

// Write the encrypted contents to a file
file_put_contents('path/to/encrypted-file.bin', $nonce . $encryptedContents . $key);
