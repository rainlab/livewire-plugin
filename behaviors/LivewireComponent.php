<?php namespace RainLab\Livewire\Behaviors;

use Block;
use Livewire\Livewire;
use Cms\Classes\ComponentBehavior;
use RainLab\Livewire\Helpers\LivewireHelper;

/**
 * LivewireComponent
 */
class LivewireComponent extends ComponentBehavior
{
    /**
     * beforeDisplay fires before the page is displayed and AJAX is executed.
     */
    public function beforeDisplay()
    {
        if ($this->controller->vars['livewireInjected'] ?? false) {
            return;
        }

        Block::append('styles', LivewireHelper::renderStyles());
        Block::append('scripts', LivewireHelper::renderScripts());

        $this->controller->vars['livewireInjected'] = true;
    }

    /**
     * renderLivewire
     */
    public function renderLivewire($component, $params = [])
    {
        return Livewire::mount($component, $params)->html();
    }
}
