<?php

namespace spec\Happyr\DoctrineSpecification\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Expression;
use Happyr\DoctrineSpecification\Logic\Not;
use Happyr\DoctrineSpecification\Spec;
use Happyr\DoctrineSpecification\Specification;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Not
 */
class NotSpec extends ObjectBehavior
{
    function let(Expression $filterExpr)
    {
        $this->beConstructedWith($filterExpr, null);
    }

    /**
     * calls parent
     */
    function it_calls_parent_match(QueryBuilder $qb, Expr $expr, Expression $filterExpr)
    {
        $dqlAlias = 'a';
        $expression = 'expression';
        $parentExpression = 'foobar';

        $qb->expr()->willReturn($expr);
        $filterExpr->getExpression($qb, $dqlAlias)->willReturn($parentExpression);

        $expr->not($parentExpression)->willReturn($expression);

        $this->getExpression($qb, $dqlAlias)->shouldReturn($expression);
    }

    /**
     * modifies parent query
     */
    function it_modifies_parent_query(QueryBuilder $qb, Specification $spec)
    {
        $this->beConstructedWith($spec, null);

        $spec->modify($qb, 'a')->shouldBeCalled();
        $this->modify($qb, 'a');
    }

    function it_does_not_modify_parent_query(QueryBuilder $qb)
    {
        $this->modify($qb, 'a');
    }
}
