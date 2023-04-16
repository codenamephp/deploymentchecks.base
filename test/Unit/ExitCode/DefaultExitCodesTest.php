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

namespace de\codenamephp\deploymentchecks\base\test\Unit\ExitCode;

use de\codenamephp\deploymentchecks\base\ExitCode\DefaultExitCodes;
use PHPUnit\Framework\TestCase;

final class DefaultExitCodesTest extends TestCase {

  public function testError() : void {
    self::assertTrue(DefaultExitCodes::ERROR->error());
    self::assertFalse(DefaultExitCodes::SUCCESSFUL->error());
  }

  public function testErrorCodes() : void {
    self::assertSame([DefaultExitCodes::ERROR->value], DefaultExitCodes::ERROR->errorCodes());
  }

  public function testCode() : void {
    self::assertSame(DefaultExitCodes::SUCCESSFUL->value, DefaultExitCodes::SUCCESSFUL->code());
    self::assertSame(DefaultExitCodes::ERROR->value, DefaultExitCodes::ERROR->code());
  }

  public function testSuccessfulCodes() : void {
    self::assertSame([DefaultExitCodes::SUCCESSFUL->value], DefaultExitCodes::SUCCESSFUL->successfulCodes());
  }

  public function testSuccessful() : void {
    self::assertTrue(DefaultExitCodes::SUCCESSFUL->successful());
    self::assertFalse(DefaultExitCodes::ERROR->successful());
  }
}
