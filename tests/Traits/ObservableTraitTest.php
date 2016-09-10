<?php

namespace Tests\Traits;

use Tests\BaseTest;
use Tests\Stubs\ObservableTraitStub;
use Tests\Stubs\ObserverTraitStub;

class ObservableTraitTest extends BaseTest
{
    /** @var ObservableTraitStub */
    private $observableTraitStub;

    public function setUp()
    {
        parent::setUp();
        $this->observableTraitStub = new ObservableTraitStub();
    }

    public function testAttachWithSingular()
    {
        $this->observableTraitStub->attach('myevent', new ObserverTraitStub())->attach('myevent2', new ObserverTraitStub());

        $observers = $this->getProperty($this->observableTraitStub, 'observers');
        $this->assertInternalType('array', $observers);
        $this->assertCount(2, $observers);
        $this->assertArrayHasKey('myevent', $observers);
        $this->assertArrayHasKey('myevent2', $observers);
        $this->assertArrayHasKey('Tests\Stubs\ObserverTraitStub', $observers['myevent']);
        $this->assertArrayHasKey('Tests\Stubs\ObserverTraitStub', $observers['myevent2']);
    }

    public function testAttachWithArray()
    {
        $this->observableTraitStub->attach('myevent', [new ObserverTraitStub(), new ObserverTraitStub()]);

        $observers = $this->getProperty($this->observableTraitStub, 'observers');
        $this->assertInternalType('array', $observers);
        $this->assertCount(1, $observers);
        $this->assertArrayHasKey('myevent', $observers);
        $this->assertArrayHasKey('Tests\Stubs\ObserverTraitStub', $observers['myevent']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAttachWithInvalidType()
    {
        $this->observableTraitStub->attach('myevent', new \stdClass());
    }

    public function testDetachWithSingular()
    {
        $this->setProperty($this->observableTraitStub, 'observers', [
            'myevent' => [
                'Tests\Stubs\ObserverTraitStub' => 'test'
            ]
        ]);

        $this->observableTraitStub->detach('myevent', new ObserverTraitStub());

        $observers = $this->getProperty($this->observableTraitStub, 'observers');
        $this->assertInternalType('array', $observers);
        $this->assertCount(0, $observers);
    }

    public function testDetachWithSingularDoesntExist()
    {
        $this->setProperty($this->observableTraitStub, 'observers', [
            'myevent' => [
                'Tests\Stubs\TestStub' => 'test'
            ]
        ]);

        $this->observableTraitStub->detach('myevent', new ObserverTraitStub());

        $observers = $this->getProperty($this->observableTraitStub, 'observers');
        $this->assertInternalType('array', $observers);
        $this->assertCount(1, $observers);
    }

    public function testDetachWithArray()
    {
        $this->setProperty($this->observableTraitStub, 'observers', [
            'myevent' => [
                'Tests\Stubs\ObserverTraitStub' => 'test'
            ]
        ]);

        $this->observableTraitStub->detach('myevent', [new ObserverTraitStub(), new ObserverTraitStub()]);

        $observers = $this->getProperty($this->observableTraitStub, 'observers');
        $this->assertInternalType('array', $observers);
        $this->assertCount(0, $observers);
    }

    public function testNotify()
    {
        $stub = $this->createMock(ObserverTraitStub::class);
        $stub->expects($this->once())->method('update');

        $stub2 = $this->createMock(ObserverTraitStub::class);
        $stub2->expects($this->once())->method('update');

        $stub3 = $this->createMock(ObserverTraitStub::class);
        $stub3->expects($this->never())->method('update');

        $this->setProperty($this->observableTraitStub, 'observers', [
            'myevent' => [
                'Tests\Stubs\ObserverTraitStub' => $stub,
                'Tests\Stubs\ObserverTraitStub2' => $stub2,
            ],
            'myevent2' => [
                'Tests\Stubs\ObserverTraitStub' => $stub3,
            ]
        ]);

        $this->observableTraitStub->notify('myevent');
    }
}