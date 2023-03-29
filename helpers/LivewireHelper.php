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
     * renderScripts injects turbo support along with the baseline scripts
     */
    public static function renderScripts()
    {
        return Livewire::scripts() .
            '<script src="' . Url::asset('plugins/rainlab/livewire/assets/js/livewire-turbo.js') . '" data-turbo-eval="false"></script>';
    }
}