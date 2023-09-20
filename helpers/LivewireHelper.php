<?php namespace RainLab\Livewire\Helpers;

use Url;
use Livewire\Livewire;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;

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
        if (method_exists('\Livewire\LivewireManager', 'styles')) {
            // Livewire v2
            return Livewire::styles($options);
        }
        // Livewire v3
        return FrontendAssets::styles($options);
    }

    /**
     * renderScripts adds turbo router support, along with the baseline scripts
     */
    public static function renderScripts($options = [])
    {
        if (method_exists('\Livewire\LivewireManager', 'scripts')) {
            // Livewire v2
            if (!isset($options['asset_url'])) {
                $options['asset_url'] = Url::asset('');
            }

            $scriptStr = Livewire::scripts($options);
        } else {
            // Livewire v3
            $scriptStr = FrontendAssets::scripts($options);
        }

        $turboScript = Url::asset('plugins/rainlab/livewire/assets/js/livewire-turbo.js');

        $scriptStr = str_replace('data-turbolinks-eval="false"', '', $scriptStr);

        $scriptStr .= "<script> addEventListener('page:loaded', function() { if (window.oc && oc.useTurbo && oc.useTurbo() && !window.Livewire) window.location.reload(); }, { once: true }); </script>";

        $scriptStr .= '<script src="' . $turboScript . '" data-turbo-eval="false"></script>';

        return $scriptStr;
    }

    /**
     * renderLivewire
     */
    public static function renderLivewire($component, $params = [])
    {
        if (class_exists('\Livewire\LifecycleManager')) {
            // Livewire v2
            return Livewire::mount($component, $params)->html();
        }
        // Livewire v3
        return Livewire::mount($component, $params);
    }
}
