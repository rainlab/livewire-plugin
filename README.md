
# Livewire Plugin

Integrate Laravel Livewire components inside October CMS themes.

## Installation Instructions

To install with Composer, run this from your project root.

```bash
composer require rainlab/livewire-plugin
```

## Rendering Livewire Components

Use the `livewireStyles` and `livewireScripts` Twig functions to activate Livewire in your CMS theme layout. For example:

```twig
<html>
    <head>
        {{ livewireStyles() }}
    </head>
    <body>
        {% page %}

        {{ livewireScripts() }}
    </body>
</html>
```

Next, simply include a Livewire component using the `{% livewire %}` Twig tag inside your page or partials.

```twig
{% livewire 'counter' %}
```

Pass variables to the component using an equal sign (`=`).

```twig
{% livewire 'counter' count=3 %}
```

## Usage Example

In the **app/views/livewire** directory, create **counter.htm** as a view file.

```twig
<div class="input-group py-3 w-25">
    <button wire:click="add" class="btn btn-outline-secondary">
        Add
    </button>
    <div class="form-control">
        {{ count }}
    </div>
    <button wire:click="subtract" class="btn btn-outline-secondary">
        Subtract
    </button>
</div>
```

In the **app/livewire** directory, create **Counter.php** as a `App\Livewire\Counter` Livewire component class.

```php
namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 1;

    public function add()
    {
        $this->count++;
    }

    public function subtract()
    {
        $this->count--;
    }
}
```

This component now be rendered as **counter** in your CMS templates. The component name is derived from the class name.

```twig
{% livewire 'counter' %}
```

### See Also

- [Laravel Livewire](https://laravel-livewire.com/)

### License

This plugin is an official extension of the October CMS platform and is free to use if you have a platform license. See [EULA license](LICENSE.md) for more details.
