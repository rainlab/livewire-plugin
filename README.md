
# Livewire Plugin

Integrate Laravel Livewire components inside October CMS themes.

## Requirements

- October CMS 3.0 or above

### Installation

To install with Composer, run this from your project root.

```bash
composer require rainlab/livewire-plugin
```

## Rendering Livewire Components

Use the `livewireStyles` and `livewireScripts` Twig functions to activate Livewire in your CMS theme layout. For example, your layout may look like this:

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

Next, include a Livewire component using the `{% livewire %}` Twig tag inside your page or partials.

```twig
{% livewire 'counter' %}
```

Pass variables to the component using an equal sign (`=`).

```twig
{% livewire 'counter' count=3 %}
```

## File Locations

Classes are stored in the **app/Livewire** directory.

Views are stored in the in **app/views/livewire** directory by default. The following template syntaxes are supported in the views directory, determined by their file extension.

Extension | Template Engine
--------- | --------------
**.htm** | October Twig
**.blade.php** | Laravel Blade
**.php** | PHP Template

## Usage Example

Create a file called **app/views/livewire/counter.htm** with the following content.

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

Create a file called **app/Livewire/Counter.php** with the following contents.

```php
<?php namespace App\Livewire;

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

For example, in the demo theme, create a template called **test.htm** with the following content. Then open the `/test` URL.

```twig
url = "/test"
layout = "default"
==
{% put scripts %}{{ livewireScripts() }}{% endput %}
{% put styles %}{{ livewireStyles() }}{% endput %}

<div class="container">
    {% livewire 'counter' %}
</div>
```

### See Also

- [Laravel Livewire](https://laravel-livewire.com/)

### License

This plugin is an official extension of the October CMS platform and is free to use if you have a platform license. See [EULA license](LICENSE.md) for more details.
