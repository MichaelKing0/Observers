<?php

namespace Tests\Stubs;

use MichaelKing0\Observers\Interfaces\ObservableInterface;
use MichaelKing0\Observers\Interfaces\ObserverInterface;

class ObserverTraitStub implements ObserverInterface
{
    public function update($event, ObservableInterface $observable)
    {
        return null;
    }
}