<?php
/**
 * Created by PhpStorm.
 * User: novikor
 * Date: 17.06.18
 * Time: 17:01
 */

namespace SQLC;

final class EventManager
{
    private $eventObservers = [];

    public function dispatchEvent(string $eventCode, ...$params)
    {
        $observers = $this->eventObservers[$eventCode] ?? [];

        /** @var callable $observer */
        foreach ($observers as $observer) {
            $observer($params);
        }
    }

    public function attachObserver(callable $observer, string $event)
    {
        $this->eventObservers[$event][] = $observer;
    }
}