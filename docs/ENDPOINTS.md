# Roomve

### Your endpoints
```
Add Money 
http://localhost:8000/api/add-money
method = post
request body
{
    "userId": 101,
    "amount": 2002.32
}
----------------------------------------------
Get Balance
http://localhost:8000/api/get-balance
method = post
request body
{
    "userId": 101
}
--------------------------------------------------------
### Testing

-   `docker-compose exec php bin/phpunit`
