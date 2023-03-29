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
     * parse a token and returns a node.
     * @return TwigNode A TwigNode instance
     */
    public function parse(TwigToken $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $name = $this->parser->getExpressionParser()->parseExpression();
        $paramNames = [];
        $nodes = [$name];
        $hasOnly = false;

        $end = false;
        while (!$end) {
            $current = $stream->next();

            if (
                $current->test(TwigToken::NAME_TYPE, 'only') &&
                !$stream->test(TwigToken::OPERATOR_TYPE, '=')
            ) {
                $hasOnly = true;
                $current = $stream->next();
            }

            switch ($current->getType()) {
                case TwigToken::NAME_TYPE:
                    $paramNames[] = $current->getValue();
                    $stream->expect(TwigToken::OPERATOR_TYPE, '=');
                    $nodes[] = $this->parser->getExpressionParser()->parseExpression();
                    break;

                case TwigToken::BLOCK_END_TYPE:
                    $end = true;
                    break;

                default:
                    throw new TwigErrorSyntax(
                        sprintf('Invalid syntax in the livewire tag. Line %s', $lineno),
                        $stream->getCurrent()->getLine(),
                        $stream->getSourceContext()
                    );
                    break;
            }
        }

        $options = [
            'paramNames' => $paramNames,
            'hasOnly' => $hasOnly
        ];

        return new LivewireNode(new TwigNode($nodes), $options, $token->getLine(), $this->getTag());
    }

    /**
     * getTag name associated with this token parser
     */
    public function getTag()
    {
        return 'livewire';
    }
}
