<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
class LastDay extends FunctionNode
{
    public $date;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        return 'LAST_DAY(' . $sqlWalker->walkArithmeticPrimary($this->date) . ')';
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}