<?php namespace RainLab\Livewire\Behaviors;

use Block;
use Livewire\Livewire;
use Backend\Classes\ControllerBehavior;
use RainLab\Livewire\Helpers\LivewireHelper;

/**
 * LivewireController
 */
class LivewireController extends ControllerBehavior
{
    /**
     * beforeDisplay fires before the page is displayed and AJAX is executed.
     */
    public function beforeDisplay()
    {
        if ($this->controller->vars['livewireInjected'] ?? false) {
            return;
        }

        Block::append('head', LivewireHelper::renderStyles());
        Block::append('footer', LivewireHelper::renderScripts());

        $this->controller->vars['livewireInjected'] = true;
    }

    /**
     * makeLivewire
     */
    public function makeLivewire($component, $params = [])
    {
        return Livewire::mount($component, $params)->html();
    }
}
