
## Short URL generator

For generating the _short_ url you should use ***/api/short*** URL with ***original_url*** parameter where you will provide the URL that should be processed.
Url will be saved to the memory (currently we use a Sessions for testing inside browser) 

Example:

```sh
http://localhost:8000/api/short?original_url=http://google.com
```

When you open the _short_ url this will redirect you to correct "URL" 

### run php server 

Run command in the terminal:

```sh
php -S localhost:8000 server.php
```