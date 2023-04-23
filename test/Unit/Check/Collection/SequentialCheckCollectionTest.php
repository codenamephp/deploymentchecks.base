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

namespace de\codenamephp\deploymentchecks\base\test\Unit\Check\Collection;

use de\codenamephp\deploymentchecks\base\Check\CheckInterface;
use de\codenamephp\deploymentchecks\base\Check\Collection\SequentialCheckCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollection;
use de\codenamephp\deploymentchecks\base\Check\Result\Collection\ResultCollectionInterface;
use de\codenamephp\deploymentchecks\base\Check\Result\ResultInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class SequentialCheckCollectionTest extends TestCase {

  use MockeryPHPUnitIntegration;

  public function test__construct() : void {
    $check1 = $this->createMock(CheckInterface::class);
    $check2 = $this->createMock(CheckInterface::class);
    $check3 = $this->createMock(CheckInterface::class);

    $collection = new SequentialCheckCollection($check1, $check2, $check3);

    self::assertSame([$check1, $check2, $check3], $collection->checks);
    self::assertInstanceOf(ResultCollection::class, $collection->resultCollection);
  }

  public function testRun() : void {
    $result1 = $this->createMock(ResultInterface::class);
    $check1 = $this->createMock(CheckInterface::class);
    $check1->expects(self::once())->method('run')->willReturn($result1);

    $result2 = $this->createMock(ResultInterface::class);
    $check2 = $this->createMock(CheckInterface::class);
    $check2->expects(self::once())->method('run')->willReturn($result2);

    $result3 = $this->createMock(ResultInterface::class);
    $check3 = $this->createMock(CheckInterface::class);
    $check3->expects(self::once())->method('run')->willReturn($result3);

    $resultCollection = Mockery::mock(ResultCollectionInterface::class);
    $resultCollection->expects('add')->once()->with($result1);
    $resultCollection->expects('add')->once()->with($result2);
    $resultCollection->expects('add')->once()->with($result3);

    $collection = new SequentialCheckCollection($check1, $check2, $check3);
    $collection->resultCollection = $resultCollection;

    self::assertSame($resultCollection, $collection->run());
  }
}
