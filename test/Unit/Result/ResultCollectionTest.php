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

namespace de\codenamephp\deploymentchecks\base\test\Unit\Result;

use de\codenamephp\deploymentchecks\base\Result\ResultCollection;
use de\codenamephp\deploymentchecks\base\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

final class ResultCollectionTest extends TestCase {

  public function test__construct() : void {
    $resultCollection = new ResultCollection();

    self::assertSame([], $resultCollection->results);
  }

  public function test__construct_withResults() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result2 = $this->createMock(ResultInterface::class);
    $result3 = $this->createMock(ResultInterface::class);

    $resultCollection = new ResultCollection($result1, $result2, $result3);

    self::assertSame([$result1, $result2, $result3], $resultCollection->results);
  }

  public function testSuccessful() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result1->expects(self::once())->method('successful')->willReturn(true);
    $result2 = $this->createMock(ResultInterface::class);
    $result2->expects(self::once())->method('successful')->willReturn(true);
    $result3 = $this->createMock(ResultInterface::class);
    $result3->expects(self::once())->method('successful')->willReturn(true);

    self::assertTrue((new ResultCollection($result1, $result2, $result3))->successful());
  }

  public function testSuccessful_canReturnFalseOnFirstUnsuccessfulResult() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result1->expects(self::once())->method('successful')->willReturn(true);
    $result2 = $this->createMock(ResultInterface::class);
    $result2->expects(self::once())->method('successful')->willReturn(false);
    $result3 = $this->createMock(ResultInterface::class);
    $result3->expects(self::never())->method('successful');

    self::assertFalse((new ResultCollection($result1, $result2, $result3))->successful());
  }

  public function testAdd() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $result2 = $this->createMock(ResultInterface::class);
    $result3 = $this->createMock(ResultInterface::class);

    $resultCollection = new ResultCollection($result1, $result2);
    $resultCollection->add($result3);

    self::assertSame([$result1, $result2, $result3], $resultCollection->results);
  }
}
