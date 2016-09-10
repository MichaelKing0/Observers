<?php

namespace MichaelKing0\Observers\Interfaces;

interface ObservableInterface
{
    public function attach($event, $observer);
    public function detach($event, $observer);
    public function notify($event);
}
