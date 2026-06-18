<?php

declare(strict_types=1);

namespace Demo\Rector;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Return_;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class WrapJsonResponseRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Wrap array literals returned from controllers in json_encode()',
            [new CodeSample('return [\'ok\' => true];', 'return json_encode([\'ok\' => true]);')]
        );
    }

    public function getNodeTypes(): array
    {
        return [Return_::class];
    }

    public function refactor(Node $node): ?Node
    {
        if (! $node instanceof Return_ || ! $node->expr instanceof Array_) {
            return null;
        }

        $node->expr = new FuncCall(new Name('json_encode'), [new Node\Arg($node->expr)]);

        return $node;
    }
}
