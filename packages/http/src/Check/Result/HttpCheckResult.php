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

namespace de\codenamephp\deploymentchecks\http\Check\Result;

use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollectionInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\WithNameInterface;

final readonly class HttpCheckResult implements ResultCollectionInterface, WithNameInterface {

  public ResultCollectionInterface $testResults;

  public function __construct(public string $name, ResultInterface ...$testResults) {
    $this->testResults = new ResultCollection(...$testResults);
  }

  public function add(ResultInterface $result) : self {
    $this->testResults->add($result);
    return $this;
  }

  public function successful() : bool {
    return $this->testResults->successful();
  }

  public function name() : string {
    return $this->name;
  }
}