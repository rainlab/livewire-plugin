<?php namespace RainLab\Livewire;

use Url;
use View;
use Route;
use Config;
use System\Classes\PluginManager;
use RainLab\Livewire\Helpers\LivewireHelper;
use RainLab\Livewire\Twig\LivewireTokenParser;
use System\Classes\PluginBase;
use Livewire\Livewire;

/**
 * Plugin for Livewire integration
 *
 * @package rainlab\livewire
 * @author Alexey Bobkov, Samuel Georges
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'October Livewire',
            'description' => 'Integrate Laravel Livewire components inside October CMS themes.',
            'author' => 'Alexey Bobkov, Samuel Georges',
            'icon' => 'icon-plug',
            'homepage' => 'https://github.com/rainlab/livewire-plugin',
        ];
    }

    /**
     * register method
     */
    public function register()
    {
        // Package missing
        if (!class_exists(Livewire::class)) {
            return;
        }

        // Ensure path is registered
        View::addLocation(app_path('views'));

        Config::set('livewire.view_path', app_path('views/livewire'));

        Config::set('livewire.manifest_path', cache_path('framework/livewire-components.php'));

        Config::set('livewire.class_namespace', \App\Livewire::class);
    }

    /**
     * boot
     */
    public function boot()
    {
        // Package missing
        if (!class_exists(Livewire::class)) {
            return;
        }

        // Register route for main script
        if (LivewireHelper::isVersion3()) {
            Livewire::setScriptRoute(function ($handle) {
                return config('app.debug')
                    ? Route::get(Url::asset('/livewire/livewire.js'), $handle)
                    : Route::get(Url::asset('/livewire/livewire.min.js'), $handle);
            });
        }

        $this->registerLivewireFromPlugins();
    }

    /**
     * registerComponents
     */
    public function registerComponents()
    {
        return [
            \Rainlab\Livewire\Components\Livewire::class => 'livewire',
        ];
    }

    /**
     * registerMarkupTags
     */
    public function registerMarkupTags()
    {
        // Package missing
        if (!class_exists(Livewire::class)) {
            return;
        }

        return [
            'functions' => [
                'livewireStyles' => [LivewireHelper::class, 'renderStyles'],
                'livewireScripts' => [LivewireHelper::class, 'renderScripts'],
                'livewireScriptConfig' => [LivewireHelper::class, 'renderScriptConfig'],
            ],
            'tokens' => [
                new LivewireTokenParser
            ]
        ];
    }

    /**
     * registerLivewireFromPlugins
     */
    protected function registerLivewireFromPlugins()
    {
        $pluginDetails = PluginManager::instance()->getRegistrationMethodValues('registerLivewireComponents');
        foreach ($pluginDetails as $livewireComponents) {
            foreach ($livewireComponents as $className => $classAlias) {
                LivewireHelper::registerComponent($className, $classAlias);
            }
        }
    }
}
