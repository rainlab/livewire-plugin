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
     * renderScripts adds turbo router support, along with the baseline scripts
     */
    public static function renderScripts()
    {
        $turboScript = Url::asset('plugins/rainlab/livewire/assets/js/livewire-turbo.js');

        return Livewire::scripts() .
            '<script src="' . $turboScript . '" data-turbo-eval="false"></script>';
    }
}
