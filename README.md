# Vetmanager Botman Conversation

![GitHub CI](https://github.com/otis22/vetmanager-botman-converstations/workflows/CI/badge.svg)

## For contributors

Copy .env.example file to .env and past your values to .env file

For run all tests
```shell
make all
```
or connect to terminal
```shell
make exec
```
*Dafault php version is 7.4*. Does not support php v8.
```shell
make all PHP_VERSION=7.3
```

all commands
```shell
# security check
make security
# composer install
make install
# composer install with --no-dev
make install-no-dev
# check code style
make style
# run static analyze tools
make static-analyze
# run unit tests
make unit
```

