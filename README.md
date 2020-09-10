# Laravel API helper for CLio
Does nothing more than helping you setup the oAuth connection for the [Clio API](https://app.clio.com/api/v4/documentation) and giving you a few simple wrappers to make life a bit easier.

## Installation
```
composer require webparking/laravel-clio
```

## Usage
Note that Clio has a hard (domain based) separation of EU customers which is not always documented so API endpoints and urls that go to https://app.clio.com should be read as https://eu.app.clio.com for EU customers. 

### Preparations
1. Create the [developer app](https://app.clio.com/nc/#/settings?path=settings%2Fdeveloper_applications) (for EU users [use this URL](https://eu.app.clio.com/nc/#/settings?path=settings%2Fdeveloper_applications)).
2. Store the `app key` and `app secret` in your ENV (see clio.php config file)
3. xxx 

### 1. Making redirect url for initial consent
    use \Webparking\LaravelClio\APIClient;

    /** @var APIClient $apiClient */
    $apiClient = app()->make(APIClient::class)->connect();
    return redirect()->away($apiClient->getAuthorizationUrl());
    
### 2. Use the received token to generate an access token
    use \Webparking\LaravelClio\APIClient;

    /** @var APIClient $apiClient */
    $apiClient = app()->make(APIClient::class)->connect();

    /** @var AccessTokenInterface $tokens */
    $tokens = $apiClient->getAccessToken('__authorization_code__');
    // __authorization_code__ received through request
    
    // Store for future requests
    $accessToken = $tokens->getToken();
    $expiresAt = $tokens->getExpires();
    $refreshToken = $tokens->getRefreshToken();
        
#### Basic requests preparation
    use \Webparking\LaravelClio\APIClient;
        
    /** @var APIClient $client */
    $apiClient = app()->make(APIClient::class)->connect($accessToken);
        
#### Refresh access token
    /** @var AccessTokenInterface $tokens */
    $tokens = $apiClient->refreshAccessToken('__refresh_token__');
    // Store tokens for future requests
    
### Example request: Bills index
Please note that you have to provide the fields you want Clio to return. The notation for related entities is shown using the `client` property.

    use Webparking\LaravelClio\Entities\Bill;

    $clioBill = new Bill($apiClient);
    $bills = $clioBill->index(
        ['created_since' => now()->toIso8601String()],
        ['id', 'number', 'due_at', 'client{name,id}']
    );
    
### Example request: Get preview (html) for bill
    use Webparking\LaravelClio\Entities\Bill;

    $clioBill = new Bill($apiClient);
    $htmlPreview = $clioBill->preview('__bill_id__');

### Example request: Update bill
Please note that at this moment the field `state` looks like it could be updated (returns 200 OK) but it does not work. Clio is notified and said they would fix this.
    use Webparking\LaravelClio\Entities\Bill;

    $clioBill = new Bill($apiClient);
    $htmlPreview = $clioBill->update(
        '__bill_id__'
        [
            'memo' => 'Foo',
            'subject' => 'Bar',
    );
    
### Notes
This is a bare minimal helper for the Clio API that just covers what we needed. Feel free to improve it. 

## Licence and Postcardware

This software is open source and licensed under the [MIT license](/LICENSE.md).

If you use this software in your daily development we would appreciate to receive a postcard of your hometown.

Please send it to: Webparking BV, Cypresbaan 31a, 2908 LT Capelle aan den IJssel, The Netherlands
