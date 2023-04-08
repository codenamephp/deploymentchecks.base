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

namespace de\codenamephp\deploymentchecks\base\ExitCode;

/**
 * Simple enum with to codes: 0 for success and 1 for error
 *
 * @psalm-api
 */
enum DefaultExitCodes: int implements ExitCodeInterface, WithErrorCodesInterface {

  case SUCCESSFUL = 0;
  case ERROR = 1;

  public function code() : int {
    return $this->value;
  }

  public function successful() : bool {
    return match ($this) {
      self::SUCCESSFUL => true,
      default => false
    };
  }

  public function successfulCodes() : array {
    return [self::SUCCESSFUL->value];
  }

  public function error() : bool {
    return !$this->successful();
  }

  public function errorCodes() : array {
    return [self::ERROR->value];
  }
}