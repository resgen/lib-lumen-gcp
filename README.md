# Lumen GCP Service Account Provider

GCP Service Account authentication provider powered by ENV vars. Base64 decodes Json service account from ENV and puts it down as a usable service account file. Works with multiple GCP service accounts in the ENV aswell.

## Requirements

- Lumen 5.8+
- ENV var APP_GCP_SERVICE_ACCOUNT with base64 encoded GCP Service Account JSON

## Why base64 Json?

Env vars with JSON values are more system universal when they are base64 encoded values. Some systems work fine with json values in ENV vars, some do not. 

## Kubernetes

If you are using kubernetes secrets, be sure to double base64 encode the value. This will ensure that the env var will still be base64 encoded inside your pod's ENV.

## Basic Example

Env:

```bash
# base64 service account json text. example is encoded {'foo':'bar'}
APP_GCP_SERVICE_ACCOUNT=e2ZvbzpiYXJ9
```

Example Code:

```php
use Google\Cloud\Storage\StorageClient;
use Resgen\Common\Gcp\GoogleServiceAccountProvider;
use Resgen\Common\Gcp\GoogleServiceAccount;

// omitting Lumen app init...follow their examples

// Register service account in your app
$app->register(GoogleServiceAccountProvider::class);

// Example GCP Storage client usage
$gcpStorageClient = new StorageClient([
    'keyFilePath' => app(GoogleServiceAccount::class)->getFilePath()
]);

```


## Multiple Service Accounts Example

Env:

```bash
APP_GCP_ACCOUNTS=APP_GCP_SERVICE_ACCOUNT_ONE,APP_GCP_SERVICE_ACCOUNT_TWO,APP_GCP_SERVICE_ACCOUNT_THREE

# base64 service account json text. example is encoded {'foo':'bar'}
GCP_ACCOUNT_ONE=e2ZvbzpiYXJ9
GCP_ACCOUNT_TWO=e2ZvbzpiYXJ9
GCP_ACCOUNT_THREE=e2ZvbzpiYXJ9
```

Example Code:

```php
use Google\Cloud\Storage\StorageClient;
use Resgen\Common\Gcp\GoogleServiceAccountProvider;
use Resgen\Common\Gcp\GoogleServiceAccountBundle;

// omitting Lumen app init...follow their examples

// Register service account in your app
$app->register(GoogleServiceAccountProvider::class);

$gcpAccountBundle = app(GoogleServiceAccountBundle::class);

// Example GCP Storage client usage
$storageAccountOne = new StorageClient([
    'keyFilePath' => $gcpAccountBundle->get('GCP_ACCOUNT_ONE')->getFilePath()
]);

$storageAccountTwo = new StorageClient([
    'keyFilePath' => $gcpAccountBundle->get('GCP_ACCOUNT_TWO')->getFilePath()
]);

$storageAccountThree = new StorageClient([
    'keyFilePath' => $gcpAccountBundle->get('GCP_ACCOUNT_THREE')->getFilePath()
]);

```