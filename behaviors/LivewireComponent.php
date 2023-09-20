<?php namespace RainLab\Livewire\Behaviors;

use Block;
use Config;
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
        if ($this->component->property('injectAssets') !== null) {
            Config::set('livewire.inject_assets', $this->component->property('injectAssets'));
        }

        if (!Config::get('livewire.inject_assets', true)) {
            return;
        }

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
        return LivewireHelper::renderLivewire($component, $params);
    }
}
