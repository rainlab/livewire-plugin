<?php namespace RainLab\Livewire\Twig;

use Twig\Node\Node as TwigNode;
use Twig\Compiler as TwigCompiler;

/**
 * LivewireNode represents a "livewire" node
 *
 * @package rainlab\livewire
 * @author Alexey Bobkov, Samuel Georges
 */
class LivewireNode extends TwigNode
{
    /**
     * __construct
     */
    public function __construct(TwigNode $nodes, $options, $lineno, $tag = 'livewire')
    {
        $nodes = ['nodes' => $nodes];

        parent::__construct($nodes, ['options' => $options], $lineno, $tag);
    }

    /**
     * compile the node to PHP.
     */
    public function compile(TwigCompiler $compiler)
    {
        $options = $this->getAttribute('options');

        $compiler->addDebugInfo($this);

        $compiler->write("\$livewireParams = [];\n");

        for ($i = 1; $i < count($this->getNode('nodes')); $i++) {
            $attrName = $options['paramNames'][$i-1];
            $compiler->write("\$livewireParams['".$attrName."'] = ");
            $compiler->subcompile($this->getNode('nodes')->getNode($i));
            $compiler->write(";\n");
        }

        $compiler
            ->write("echo \RainLab\Livewire\Helpers\LivewireHelper::renderLivewire(")
            ->subcompile($this->getNode('nodes')->getNode(0))
        ;

        if ($options['hasOnly']) {
            $compiler->write(", array_merge(['__cms_livewire_params' => \$livewireParams], \$livewireParams)");
        }
        else {
            $compiler->write(", array_merge(\$context, ['__cms_livewire_params' => \$livewireParams], \$livewireParams)");
        }

        $compiler
            ->write(");\n")
        ;
    }
}
