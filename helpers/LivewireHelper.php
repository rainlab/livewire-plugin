<?php namespace RainLab\Livewire\Helpers;

use Url;
use Livewire\Livewire;

/**
 * LivewireHelper
 *
 * @package rainlab\livewire
 * @author Alexey Bobkov, Samuel Georges
 */
class LivewireHelper
{
    /**
     * registerComponent
     */
    public static function registerComponent($className, $classAlias)
    {
        Livewire::component($classAlias, $className);
    }

    /**
     * renderStyles
     */
    public static function renderStyles($options = [])
    {
        return Livewire::styles($options);
    }

    /**
     * renderScripts adds turbo router support, along with the baseline scripts
     */
    public static function renderScripts($options = [])
    {
        $turboScript = Url::asset('plugins/rainlab/livewire/assets/js/livewire-turbo.js');

        if (!isset($options['asset_url'])) {
            $options['asset_url'] = Url::asset('');
        }

        return Livewire::scripts($options) .
            '<script src="' . $turboScript . '" data-turbo-eval="false"></script>';
    }
}
