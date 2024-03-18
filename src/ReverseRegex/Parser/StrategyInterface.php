<?php
namespace ReverseRegex\Parser;

use ReverseRegex\Generator\Scope;
use ReverseRegex\Generator\LiteralScope;
use ReverseRegex\Lexer;

/**
  *  Interface for all parser strategy object
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 0.0.1
  */
interface StrategyInterface
{
    
    /**
      *  Parse the current token and return a new head
      *
      *  @access public
      *  @return Scope a new head
      *  @param LiteralScope $head
      *  @param Scope $set
      *  @param Lexer $lexer
      */
    public function parse(LiteralScope $head, Scope $set, Lexer $lexer);
    
    
}
/* End of File */