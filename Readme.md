
## Short URL generator

For generating short url you should use "/apis/short" URL with "original_url" parameter where you provide URL that should be conderted.
Url will be  saved to the memory (currently we use a Sessions for testing inside browser) 

Example:

```sh
http://localhost:8000/api/short?original_url=http://google.com
```

When you open short url this will redirect you to correct "URL" that 

### run php server 

Run commant in the termianal:

```sh
php -S localhost:8000 server.php
```