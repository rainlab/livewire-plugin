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
        if (static::isVersion2()) {
            return Livewire::styles($options);
        }

        return FrontendAssets::styles($options);
    }

    /**
     * renderScripts adds turbo router support, along with the baseline scripts
     */
    public static function renderScripts($options = [])
    {
        if (static::isVersion2()) {
            if (!isset($options['asset_url'])) {
                $options['asset_url'] = Url::asset('');
            }

            $scriptStr = Livewire::scripts($options);
        }
        else {
            $scriptStr = FrontendAssets::scripts($options);
        }

        $turboScript = Url::asset('plugins/rainlab/livewire/assets/js/livewire-turbo.js');

        $scriptStr = str_replace('data-turbolinks-eval="false"', '', $scriptStr);

        $scriptStr .= "<script> addEventListener('page:loaded', function() { if (window.oc && oc.useTurbo && oc.useTurbo() && !window.Livewire) window.location.reload(); }, { once: true }); </script>";

        $scriptStr .= '<script src="' . $turboScript . '" data-turbo-eval="false"></script>';

        return $scriptStr;
    }

    /**
     * renderScriptConfig renders the script configuration
     */
    public static function renderScriptConfig($options = [])
    {
        if (static::isVersion3()) {
            return FrontendAssets::scriptConfig($options);
        }
    }

    /**
     * renderLivewire component after mounting it
     */
    public static function renderLivewire($component, $params = [])
    {
        if (static::isVersion2()) {
            return Livewire::mount($component, $params)->html();
        }

        return Livewire::mount($component, $params);
    }

    /**
     * isVersion2 returns true if Livewire v2 was found
     */
    public static function isVersion2()
    {
        return class_exists(\Livewire\LifecycleManager::class);
    }

    /**
     * isVersion2 returns true if Livewire v3 was found
     */
    public static function isVersion3()
    {
        return !class_exists(\Livewire\LifecycleManager::class);
    }
}
