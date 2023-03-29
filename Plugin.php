<?php namespace RainLab\Livewire;

use App;
use View;
use Config;
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
        // Ensure path is registered
        View::addLocation(app_path('views'));

        Config::set('livewire.manifest_path', App::cachePath('framework/livewire-components.php'));

        Config::set('livewire.class_namespace', 'App\Livewire');
    }

    /**
     * registerMarkupTags
     */
    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'livewireStyles' => [Livewire::class, 'styles'],
                'livewireScripts' => [Livewire::class, 'scripts'],
            ],
            'tokens' => [
                new LivewireTokenParser
            ]
        ];
    }
}
