<?php

namespace MichaelKing0\Observers\Interfaces;

interface ObserverInterface
{
    public function update($event, ObservableInterface $observable);
}