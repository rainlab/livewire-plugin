<?php namespace RainLab\Livewire\Classes;

use View;
use Livewire\Component as LivewireComponent;

/**
 * LivewireBase class for components
 */
class LivewireBase extends LivewireComponent
{
    /**
     * render component
     */
    public function render()
    {
        return View::make("livewire.{$this->getName()}");
    }
}
