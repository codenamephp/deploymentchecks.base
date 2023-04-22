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

namespace de\codenamephp\deploymentchecks\async;

use Closure;
use de\codenamephp\deploymentchecks\base\Check\CheckInterface;
use de\codenamephp\deploymentchecks\base\Result\ResultCollection;
use de\codenamephp\deploymentchecks\base\Result\ResultInterface;
use Laravel\SerializableClosure\SerializableClosure;
use Throwable;

final class ParallelCheck {

  public readonly SerializableClosure $successCallback;

  public readonly SerializableClosure $errorCallback;

  public function __construct(
    public readonly CheckInterface $check,
    Closure|callable $successCallback = null,
    Closure|callable $errorCallback = null
  ) {
    $this->successCallback = new SerializableClosure($successCallback ?? static fn(ResultCollection $resultCollection, ResultInterface $result) => $resultCollection->add($result));
    $this->errorCallback = new SerializableClosure($errorCallback ?? static fn(ResultCollection $resultCollection, Throwable $exception) => throw $exception);
  }

  public function __invoke() : ResultInterface {
    return $this->check->run();
  }

  public function success(ResultCollection $resultCollection, ResultInterface $result) : mixed {
    return ($this->successCallback)($resultCollection, $result);
  }

  public function error(ResultCollection $resultCollection, Throwable $exception) : mixed {
    return ($this->errorCallback)($resultCollection, $exception);
  }
}