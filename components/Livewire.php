<?php namespace Rainlab\Livewire\Components;

use Cms\Classes\ComponentBase;

/**
 * Livewire Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class Livewire extends ComponentBase
{
    /**
     * @var array implement
     */
    public $implement = [
        \RainLab\Livewire\Behaviors\LivewireComponent::class
    ];

    /**
     * componentDetails
     */
    public function componentDetails()
    {
        return [
            'name' => 'Livewire Component',
            'description' => 'A generic component that adds Livewire integration to a page.'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [
            'injectAssets' => [
                'title' => 'Inject Livewire Assets',
                'type' => 'checkbox',
            ],
        ];
    }
}
