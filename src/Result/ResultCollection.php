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

namespace de\codenamephp\deploymentchecks\base\Result;

/**
 * A collection of results. Can be used to aggregate results from multiple checks, e.g. run multiple http checks and treat them as a group
 *
 * @psalm-api
 */
final class ResultCollection implements ResultInterface {

  /**
   * @var array<ResultInterface> The results that are aggregated in this collection
   */
  public array $results;

  /**
   * @param array<ResultInterface> $results
   */
  public function __construct(ResultInterface ...$results) { $this->results = $results; }

  public function successful() : bool {
    foreach($this->results as $result) {
      if(!$result->successful()) return false;
    }
    return true;
  }
}