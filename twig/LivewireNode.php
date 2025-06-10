<?php namespace RainLab\Livewire\Twig;

use Twig\Node\Node as TwigNode;
use Twig\Compiler as TwigCompiler;

/**
 * LivewireNode represents a "livewire" node
 *
 * @package rainlab\livewire
 * @author Alexey Bobkov, Samuel Georges
 */
#[\Twig\Attribute\YieldReady]
class LivewireNode extends TwigNode
{
    /**
     * __construct
     */
    public function __construct(array $nodes, array $options, int $lineno, string $tag = 'livewire')
    {
        parent::__construct($nodes, ['options' => $options], $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     */
    public function compile(TwigCompiler $compiler)
    {
        $paramNames = $this->getAttribute('options')['paramNames'];
        $hasOnly = $this->getAttribute('options')['hasOnly'];

        $compiler->addDebugInfo($this);

        $compiler->write("\$livewireParams = [];\n");

        foreach ($paramNames as $paramName) {
            if ($this->hasNode($paramName)) {
                $compiler
                    ->write("\$livewireParams['$paramName'] = ")
                    ->subcompile($this->getNode($paramName))
                    ->write(";\n");
            }
        }

        $compiler
            ->write("yield \\RainLab\\Livewire\\Helpers\\LivewireHelper::renderLivewire(")
            ->subcompile($this->getNode('name'));

        if ($hasOnly) {
            $compiler->write(", array_merge(['__cms_livewire_params' => \$livewireParams], \$livewireParams)");
        } else {
            $compiler->write(", array_merge(\$context, ['__cms_livewire_params' => \$livewireParams], \$livewireParams)");
        }

        $compiler->write(");\n");
    }
}
