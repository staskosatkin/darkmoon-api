# Test framework

## Requires

  Docker

## Installation environment

`docker-compose up -d`

## Build project

`docker run --rm -v $(pwd):/app composer install`

## Run Tests

`docker run --rm -v $(pwd):/app composer run-script test`
