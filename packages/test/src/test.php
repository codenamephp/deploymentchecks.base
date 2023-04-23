<?php declare(strict_types=1);

/*
 *  Copyright 2023 Bastian Schwarz <bastian@codename-php.de>.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

use de\codenamephp\deploymentchecks\async\Collection\AsyncCheckCollection;
use de\codenamephp\deploymentchecks\http\Check\HttpCheck;
use de\codenamephp\deploymentchecks\http\Check\Test\StatusCode;
use GuzzleHttp\Psr7\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$check1 = new HttpCheck(
  new Request('GET', 'https://www.google.com'),
  'Should be successful',
  new StatusCode(200),
);
$check2 = new HttpCheck(
  new Request('GET', 'https://www.google.com'),
  'Should fail',
  new StatusCode(200),
);
$result = (new AsyncCheckCollection(new \Spatie\Async\Pool(), $check1, $check2))->run();
$successful = $result->successful();
var_dump($successful, $result);