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

namespace de\codenamephp\deploymentchecks\base\Check\Collection;

use de\codenamephp\deploymentchecks\base\Check\CheckInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollectionInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;

/**
 * Collects multiple checks and executes them sequentially and adds their results to a result collection
 */
final class SequentialCollection implements CheckInterface {

  public readonly array $checks;

  public ResultCollectionInterface $resultCollection;

  public function __construct(CheckInterface ...$checks) {
    $this->checks = $checks;
    $this->resultCollection = new ResultCollection();
  }

  public function run() : ResultInterface {
    foreach($this->checks as $check) {
      $this->resultCollection->add($check->run());
    }
    return $this->resultCollection;
  }
}