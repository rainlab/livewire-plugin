<?php namespace RainLab\Livewire\Twig;

use Twig\Node\Node as TwigNode;
use Twig\Token as TwigToken;
use Twig\TokenParser\AbstractTokenParser as TwigTokenParser;
use Twig\Error\SyntaxError as TwigErrorSyntax;

/**
 * LivewireTokenParser for the `{% livewire %}` Twig tag.
 *
 *     {% livewire "sidebar" %}
 *
 *     {% livewire "sidebar" name='John' %}
 *
 *     {% livewire "sidebar" name='John' year=2013 %}
 *
 * @package rainlab\livewire
 * @author Alexey Bobkov, Samuel Georges
 */
class LivewireTokenParser extends TwigTokenParser
{
    /**
     * Parses a token and returns a node.
     */
    public function parse(TwigToken $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $nodes = [];
        $paramNames = [];
        $hasOnly = false;

        // First expression is the Livewire component name
        $nodes['name'] = $this->parser->getExpressionParser()->parseExpression();

        // Parse parameters and flags
        while (!$stream->test(TwigToken::BLOCK_END_TYPE)) {
            $current = $stream->next();

            if ($current->test(TwigToken::NAME_TYPE, 'only') && !$stream->test(TwigToken::OPERATOR_TYPE, '=')) {
                $hasOnly = true;
                continue;
            }

            if ($current->getType() === TwigToken::NAME_TYPE) {
                $paramName = $current->getValue();
                $stream->expect(TwigToken::OPERATOR_TYPE, '=');
                $nodes[$paramName] = $this->parser->getExpressionParser()->parseExpression();
                $paramNames[] = $paramName;
            } else {
                throw new TwigErrorSyntax(
                    sprintf('Invalid syntax in the livewire tag. Line %s', $lineno),
                    $stream->getCurrent()->getLine(),
                    $stream->getSourceContext()
                );
            }
        }

        $stream->expect(TwigToken::BLOCK_END_TYPE);

        $options = [
            'paramNames' => $paramNames,
            'hasOnly' => $hasOnly,
        ];

        return new LivewireNode($nodes, $options, $lineno, $this->getTag());
    }

    /**
     * getTag name associated with this token parser
     */
    public function getTag()
    {
        return 'livewire';
    }
}
