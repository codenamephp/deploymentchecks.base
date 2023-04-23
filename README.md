# deploymentchecks.base

![Packagist Version](https://img.shields.io/packagist/v/codenamephp/deploymentchecks.base)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/codenamephp/deploymentchecks.base)
![Lines of code](https://img.shields.io/tokei/lines/github/codenamephp/deploymentchecks.base)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/codenamephp/deploymentchecks.base)
![CI](https://github.com/codenamephp/deploymentchecks.base/workflows/CI/badge.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/codenamephp/deploymentchecks.base)
![GitHub](https://img.shields.io/github/license/codenamephp/deploymentchecks.base)

This package is the base building block for deployment checks. It provides the interfaces and basic execution logic needed to run checks.
The checks itself will be provided by other specialized packages.

## What are deployment checks?

Deployment checks or Post-Deploy Verification or Post-Release Tests (whatever you want to call them, they are more or less the same concept) are used
to verify that a deployment was successful and the application is running is expected.

These steps are usually performed as part of the CI/CD pipeline and are an important step when automating the deployment/release cycle.

They can either be run on the server itself or on a build/deployment "server" like Github Workflows either before the final rollout or after on the production
resources.
Depending on the outcome you can stop the rollout, perform a rollback ... or just be notified that something may be wrong.

## Installation

Easiest way is via composer. Just run `composer require codenamephp/deploymentchecks.base` in your cli which should
install the latest version for you.

## Usage

### The very basics

The simplest case ist just PHP script that includes the autoloader, builds some checks, executes them and ends the script with an exit
code and leaves the rest to the build system that was running the checks:

```php
<?php declare(strict_types=1);

use de\codenamephp\deploymentchecks\async\Collection\AsyncCheckCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\WithExitCodeInterface;
use de\codenamephp\deploymentchecks\base\ExitCode\DefaultExitCodes;
use de\codenamephp\deploymentchecks\http\Check\HttpCheck;
use de\codenamephp\deploymentchecks\http\Check\Test\StatusCode;
use GuzzleHttp\Psr7\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$result = (new AsyncCheckCollection(new \Spatie\Async\Pool(),
  new HttpCheck(
    new Request('GET', 'https://localhost'),
    'Frontpage should be available',
    new StatusCode(200),
  ),
  new HttpCheck(
    new Request('GET', 'https://localhost/admin'),
    'Admin login page should be available',
    new StatusCode(401),
  )
))->run();

exit($result instanceof WithExitCodeInterface ? $result->exitCode() : ($result->successful() ? DefaultExitCodes::SUCCESSFUL->value : DefaultExitCodes::ERROR->value));
```

This example uses the http package to perform http requests and run tests on them together with the async package to the requests are tested in parallel.
At the end the result is checked. If it is a result with an exit code, the exit code is used. If not, the result is checked for success and
the default exit codes are used.

Since most CI/CD systems will run the script and check the exit code, this should already be enough to get the system to fail if one of the checks fail.