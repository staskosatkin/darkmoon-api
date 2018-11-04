# Test framework

## Installation

`docker-compose up -d`

## Build project

`docker run --rm -v $(pwd):/app composer install`

## Run Unit Tests

`docker run --rm -v $(pwd):/app composer run-script test`
