<?php
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
