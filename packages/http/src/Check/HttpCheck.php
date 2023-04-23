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

namespace de\codenamephp\deploymentchecks\http\Check;

use de\codenamephp\deploymentchecks\base\Check\CheckInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;
use de\codenamephp\deploymentchecks\base\Check\WithNameInterface;
use de\codenamephp\deploymentchecks\http\Check\Test\TestInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;

final class HttpCheck implements CheckInterface, WithNameInterface {

  /**
   * @var array<TestInterface>
   */
  public array $tests = [];

  public function __construct(
    public readonly RequestInterface $request,
    public readonly string $name,
    TestInterface ...$tests
  ) {
    $this->tests = $tests;
  }

  public function name() : string {
    return $this->name;
  }

  public function run() : ResultInterface {
    $client = new Client();
    $response = $client->send($this->request);
    return new ResultCollection(...array_map(fn(TestInterface $test) => $test->test($response), $this->tests));
  }
}