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

namespace de\codenamephp\deploymentchecks\base\Check\Result;

/**
 * Interface for results of deployment checks
 *
 * @psalm-api
 */
interface ResultInterface {

  /**
   * indicates a successful check. Ture if successful, false otherwise
   *
   * Basically a shortcut for getting the status from the exit code
   *
   * @return bool
   */
  public function successful() : bool;
}