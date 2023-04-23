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

use de\codenamephp\deploymentchecks\base\Check\CheckInterface;
use de\codenamephp\deploymentchecks\base\Result\Collection\ResultCollection;
use de\codenamephp\deploymentchecks\base\Result\ResultInterface;
use Spatie\Async\Pool;
use Throwable;

final readonly class AsyncCheckCollection implements CheckInterface {

  /**
   * @var array<CheckInterface>
   */
  public array $checks;

  public function __construct(public Pool $pool, CheckInterface ...$checks) {
    $this->checks = $checks;
  }

  public function run() : ResultInterface {
    $result = new ResultCollection();
    foreach($this->checks as $check) {
      $parallelCheck = new ParallelCheck($check);
      $runnable = $this->pool
        ->add($parallelCheck)
        ->then(static fn(ResultInterface $output) => $parallelCheck->successHandler()->handle($result, $output));
      if($parallelCheck instanceof WithErrorHandlerInterface) $runnable->catch(static fn(Throwable $exception) => $parallelCheck->errorHandler()->handle($result, $exception));
    }
    $this->pool->wait();
    return $result;
  }
}