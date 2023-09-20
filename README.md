
# Livewire Plugin

Integrate Laravel Livewire components inside October CMS themes, app and plugins, with templates provided by Twig, Blade or PHP.

## Requirements

- October CMS v3.3.9 or above

### Installation

To install with Composer, run this from your project root.

```bash
composer require rainlab/livewire-plugin
```

## Rendering Livewire Components

Use the `livewire` CMS component to activate Livewire in your CMS theme page or layout. For example, your page may look like this.

```twig
url = "/test"
layout = "default"

[livewire]
==
<div class="container">
    {% livewire 'counter' %}
</div>
```

Next, render a Livewire component using the `{% livewire %}` Twig tag.

```twig
{% livewire 'counter' %}
```

You may pass variables to the component using an equal sign (`=`).

```twig
{% livewire 'counter' count=3 %}
```

> **Note**: For proper operation, your CMS layout should include the `{% styles %}` and `{% scripts %}` placeholder tags, as described in the [placeholder documentation](https://docs.octobercms.com/3.x/markup/tag/placeholder.html#scripts).

## File Locations

By default, classes are stored in the **app/Livewire** directory. However, you can register custom classes within plugins (see below).

Views are stored in the in **app/views/livewire** directory by default. The following template syntaxes are supported in the views directory, determined by their file extension.

Extension | Template Engine
--------- | --------------
**.htm** | October Twig
**.blade.php** | Laravel Blade
**.php** | PHP Template

## Plugin Registration

To register Livewire components in your plugins using the `registerLivewireComponents` override method. The method should return a class name as the key and the component alias as the value.

```php
public function registerLivewireComponents()
{
    return [
        \October\Demo\Livewire\Todo::class => 'demoTodo'
    ];
}
```

In the above example, the `October\Demo\Livewire\Todo` class refers to the following file locations:

- Class file: **plugins/october/demo/livewire/Todo.php**
- View file: **plugins/october/demo/views/livewire/todo.htm**.

The class should return its view path by overriding the `render` method, and returns [a View instance](https://docs.octobercms.com/3.x/extend/services/response-view.html) relative to the plugin.

```php
namespace October\Demo\Livewire;

use RainLab\Livewire\Classes\LivewireBase;

class Todo extends LivewireBase
{
    public function render()
    {
        return \View::make('october.demo::livewire.todo');
    }
}
```

The component can be rendered anywhere using the `demoTodo` alias.

```twig
{% livewire 'demoTodo' %}
```

### Usage in CMS Components

You may implement Livewire in your [CMS components](https://docs.octobercms.com/3.x/extend/cms-components.html) using the `RainLab\Livewire\Behaviors\LivewireComponent` behavior. This implementation will ensure that the necessary dependencies are registered when the component is used.

```php
class MyComponent extends \Cms\Classes\ComponentBase
{
    public $implement = [
        \RainLab\Livewire\Behaviors\LivewireComponent::class
    ];
}
```

Then render the component using the `{% livewire %}` tag.

```twig
{% livewire 'counter' %}
```

Alternatively, you can render the component in PHP using the `renderLivewire` method.

```php
$this->renderLivewire('counter');
```

### Usage in Backend Controllers

You may implement Livewire in your [backend controllers](https://docs.octobercms.com/3.x/extend/system/controllers.html) using the `RainLab\Livewire\Behaviors\LivewireController` behavior. This implementation will ensure that the necessary dependencies are registered with the controller.

```php
class MyController extends \Backend\Classes\Controller
{
    public $implement = [
        \RainLab\Livewire\Behaviors\LivewireController::class
    ];
}
```

Then render the component using the `makeLivewire` method.

```php
<?= $this->makeLivewire('counter') ?>
```

## Usage Example

Here we will create a component in the **app** directory and render it on a CMS page freestanding. First, create a file called **app/views/livewire/counter.htm** with the following content.

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

use RainLab\Livewire\Classes\LivewireBase;

class Counter extends LivewireBase
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

[livewire]
==
<div class="container">
    {% livewire 'counter' %}
</div>
```

### See Also

- [Laravel Livewire](https://laravel-livewire.com/)

### License

This plugin is an official extension of the October CMS platform and is free to use if you have a platform license. See [EULA license](LICENSE.md) for more details.
