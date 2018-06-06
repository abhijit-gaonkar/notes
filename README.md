# Notes Api
## Setup:
git clone the repo<br>
Run composer install<br>
$composer install<br>

To setup the environment you need docker.<br>
Create .env file from .env.example file with proper environment variable values<br>
Run below commands..<br>
$docker-compose build //build base container<br>
$docker-compose up -d //build the  stack in detached mode<br>
$docker-compose logs -f //monitor logs<br>

To create database and table run sql queries in sql/init.sql

You should have your notes api now accessible at http://localhost:8089/notes

For accessing any api you need basic authentication. You can use the example user credentials...<br>
test@test.com/test

See below example Curl requests...

### Create Note

curl -X POST \
  http://localhost:8089/notes \
  -H 'authorization: Basic dGVzdEB0ZXN0LmNvbTp0ZXN0' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -d '{
	"title": "title",
	"content": "1234"
}'

### Retrieve a Note

curl -X GET \
  http://localhost:8089/notes/11 \
  -H 'authorization: Basic dGVzdEB0ZXN0LmNvbTp0ZXN0' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json'

### Update a Note

curl -X PUT \
  http://localhost:8089/notes/11 \
  -H 'authorization: Basic dGVzdEB0ZXN0LmNvbTp0ZXN0' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -d '{
	"title": "title",
	"content": "123124"
}'

### Delete a Note

curl -X DELETE \
  http://localhost:8089/notes/10 \
  -H 'authorization: Basic dGVzdEB0ZXN0LmNvbTp0ZXN0' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json'
