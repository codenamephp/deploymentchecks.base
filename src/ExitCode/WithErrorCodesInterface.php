<?php
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
 * Interface for exit codes that define errors with the ability to check the error status and get a list of possible error codes.
 *
 * @psalm-api
 */
interface WithErrorCodesInterface {

  /**
   * @return bool Indicates that the current exit code is an error code
   */
  public function error() : bool;

  /**
   * Gets a list of all the error codes
   *
   * @return array<int>
   */
  public function errorCodes(): array;
}