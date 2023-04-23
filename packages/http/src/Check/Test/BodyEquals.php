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

namespace de\codenamephp\deploymentchecks\http\Check\Test;

use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;
use de\codenamephp\deploymentchecks\http\Check\Test\Result\HttpTestResult;
use Psr\Http\Message\ResponseInterface;

final class BodyEquals implements TestInterface {

  public function __construct(public readonly string $expectedResponseText) {}

  public function test(ResponseInterface $response) : ResultInterface {
    return new HttpTestResult((string) $response->getBody() === $this->expectedResponseText, sprintf("Expected response text '%s' got '%s'", $this->expectedResponseText, $response->getBody()));
  }
}