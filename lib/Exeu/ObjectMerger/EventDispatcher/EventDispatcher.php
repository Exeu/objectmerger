<?php
/*
 * Copyright 2014 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Exeu\ObjectMerger\EventDispatcher;

/**
 * Class EventDispatcher
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class EventDispatcher
{
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * Adds a listener.
     *
     * @param string   $eventName
     * @param callable $listener
     */
    public function addListener($eventName, $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    /**
     * Dispatches an event if there are any listeners.
     *
     * @param string $eventName
     * @param mixed  $event
     */
    public function dispatch($eventName, $event)
    {
        if (!$this->hasListener($eventName)) {
            return;
        }

        foreach ($this->listeners[$eventName] as $listener) {
            call_user_func($listener, $event);
        }
    }

    /**
     * Checks if there are listeners registered for this event.
     *
     * @param string $eventName
     *
     * @return bool
     */
    public function hasListener($eventName)
    {
        return isset($this->listeners[$eventName]);
    }
}
