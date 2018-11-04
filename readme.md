# Test framework

## Requires

  Docker

## Installation environment

`docker-compose up -d`

## Build project

`docker run --rm -v $(pwd):/app composer install`

## Init Database

`docker-compose exec app php artisan migrate --seed`

## Run Tests

`docker run --rm -v $(pwd):/app composer run-script test`

## Usage

### Register
```
POST /api/register HTTP/1.1
Host: localhost:8080
Accept: application/json
Content-Type: application/json
{
	"name": "John",
	"email": "test@test.com",
	"password": "strong-pass",
	"password_confirmation": "strong-pass"
}
```

### Login
```
POST /api/login HTTP/1.1
Host: localhost:8080
Accept: application/json
Content-Type: application/json
{
	"email": "test.@test.com",
	"password": "strong-pass"
}
```

### Logout

```
POST /api/logout HTTP/1.1
Host: localhost:8080
Accept: application/json
Content-Type: application/json
```
