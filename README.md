
####  Simple Example of How to Encode and Decode Files in PHP 8 Using the Built-in Sodium Extension

This guide provides examples of how to encrypt and decrypt files using PHP's Sodium extension, which offers modern cryptographic functions.

## Prerequisites

- PHP 8 or higher
- Sodium extension enabled (ext-sodium)

## Table of Contents

- [Encoding a File](#encoding-a-file)
  - [Example: Basic Encoding](#example-basic-encoding)
  - [Example: Encoding with Secure Key Storage](#example-encoding-with-secure-key-storage)
- [Decoding a File](#decoding-a-file)
  - [Example: Basic Decoding](#example-basic-decoding)
  - [Example: Decoding with Secure Key Retrieval](#example-decoding-with-secure-key-retrieval)
- [Best Practices](#best-practices)
- [Credits](#credits)

## Encoding a File

### Example: Basic Encoding

```php
// Read file contents into a string
$fileContents = file_get_contents('path/to/file.txt');

// Generate a random key and nonce
$key = sodium_crypto_secretbox_keygen();
$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

// Encrypt the file contents with the key and nonce
$encryptedContents = sodium_crypto_secretbox($fileContents, $nonce, $key);

// Write the encrypted contents to a file
file_put_contents('path/to/encrypted-file.bin', $nonce . $encryptedContents . $key);
```

In this example, we use the file_get_contents function to read the contents of a file into a string. We then generate a random key and nonce using the sodium_crypto_secretbox_keygen and random_bytes functions, respectively. We encrypt the file contents using the sodium_crypto_secretbox function, which takes the file contents, nonce, and key as parameters. Finally, we concatenate the nonce, encrypted contents, and key into a single binary string and write the result to a new file using the file_put_contents function.

### Example: Encoding with Secure Key Storage

In practice, you should store the encryption key separately from the encrypted data to enhance security. Here's how you can modify the basic encoding example to store the key securely.

```php
// Read file contents into a string
$fileContents = file_get_contents('path/to/file.txt');

// Generate a random key and nonce
$key = sodium_crypto_secretbox_keygen();
$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

// Encrypt the file contents with the key and nonce
$encryptedContents = sodium_crypto_secretbox($fileContents, $nonce, $key);

// Write the encrypted contents and nonce to a file
file_put_contents('path/to/encrypted-file.bin', $nonce . $encryptedContents);

// Store the key securely, e.g., in a file with restricted permissions
file_put_contents('path/to/keyfile.key', $key);
chmod('path/to/keyfile.key', 0600);
```

## Decoding a File

### Example: Basic Decoding

```php
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
```

In this example, we use the file_get_contents function to read the encrypted file contents into a binary string. We then extract the nonce, ciphertext, and key from the binary string using the substr function. We decrypt the ciphertext using the sodium_crypto_secretbox_open function, which takes the ciphertext, nonce, and key as parameters. Finally, we write the decrypted file contents to a new file using the file_put_contents function.

### Example: Decoding with Secure Key Retrieval

```php
// Read the encrypted contents from the file
$encryptedData = file_get_contents('path/to/encrypted-file.bin');

// Extract the nonce and ciphertext from the binary string
$nonce = substr($encryptedData, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
$ciphertext = substr($encryptedData, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

// Retrieve the key from a secure location
$key = file_get_contents('path/to/keyfile.key');

// Decrypt the ciphertext using the nonce and key
$decryptedContents = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);

// Write the decrypted contents to a file
file_put_contents('path/to/decrypted-file.txt', $decryptedContents);
```

## Best Practices

- **Secure Key Management**: Always store encryption keys securely. Do not include them in the same file as the encrypted data.
- **Use Strong Randomness**: Use `random_bytes` for generating nonces to ensure they are cryptographically secure.
- **Keep Software Updated**: Ensure PHP and the Sodium extension are kept up-to-date to benefit from security patches and improvements.
- **Handle Errors Gracefully**: Implement proper error handling to manage potential issues during encryption and decryption processes.

## Credits

S. V
