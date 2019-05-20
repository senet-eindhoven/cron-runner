# Senet Cron

This module allows you to run both recurring as one time jobs from you application.

## Install

```bash
composer require senet-eindhoven/cron-runner
```

Update your server cron to invoke the library every minute

## Usage

Inject a valid repository that implements the libary `RepositoryInterface` together with a
compatible `PSR\Logger` like `monolog`.

```php
$repository = new Repository();
$logger = new MyPsrLogger();
$cronService = new CronService($repository, $logger);
$cronService->execute();
```

The execute method will determine if a job needs to be executed or not and will trigger a new process for it.

## Development

Run below scripts to verify code quality. On each commit these steps are also executed via `GrumPHP`

```bash
# Startup
make up
# PHPCS
make phpcs
# PHPUnit
make test
```
