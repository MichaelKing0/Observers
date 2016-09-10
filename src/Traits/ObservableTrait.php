<?php

namespace MichaelKing0\Observers\Traits;

use MichaelKing0\Observers\Interfaces\ObserverInterface;

trait ObservableTrait
{
    protected $observers = [];

    /**
     * Attach an array of ObserverInterface implementations, or an individual ObserverInterface implementations
     *
     * @param array|ObserverInterface $observer
     * @return $this
     */
    public function attach($event, $observer)
    {
        if (is_array($observer)) {
            $this->attachObserverArray($event, $observer);
            return $this;
        }

        if (!($observer instanceof ObserverInterface)) {
            throw new \InvalidArgumentException('The observer must implement the ObserverInterface.');
        }

        $this->observers[$event][get_class($observer)] = $observer;

        return $this;
    }

    /**
     * Used internally to attach an array of ObserverInterface implementations
     *
     * @param array $observers
     * @return $this
     */
    private function attachObserverArray($event, array $observers)
    {
        foreach ($observers as $observer) {
            $this->attach($event, $observer);
        }

        return $this;
    }

    /**
     * Detach an array of ObserverInterface implementations, or an individual ObserverInterface implementations
     *
     * @param $observer
     * @return $this
     */
    public function detach($event, $observer)
    {
        if (is_array($observer)) {
            $this->detachObserverArray($event, $observer);
            return $this;
        }

        if (array_key_exists($event, $this->observers)) {
            unset($this->observers[$event][get_class($observer)]);
            if (count($this->observers[$event]) === 0) {
                unset($this->observers[$event]);
            }
        }

        return $this;
    }

    /**
     * Used internally to detach an array of observers
     *
     * @param array $observers
     * @return $this
     */
    private function detachObserverArray($event, array $observers)
    {
        foreach ($observers as $observer) {
            $this->detach($event, $observer);
        }

        return $this;
    }

    /**
     * Notify all observers for the specified event
     *
     * @param $event
     */
    public function notify($event)
    {
        if (array_key_exists($event, $this->observers)) {
            foreach ($this->observers[$event] as $observer) {
                $observer->update($event, $this);
            }
        }
    }
}
