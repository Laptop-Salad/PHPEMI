# PHPEMI
Equivalence Modulo Input (EMI) testing for finding bugs in the PHP Interpreter.

## PHP Optimization

https://www.siteground.co.uk/tutorials/php-mysql/zend-optimizer/ 

> After PHP 5.3 Zend Optimizer is included in the standard PHP distribution and there are no additional installations needed 
> for it to work.


## Mutation Strategies

### Pruning Unexecuted Segments
The PHP interpreter will still have to perform all its analysis and optimzations
for the unexecuted segments of code. Producing a program that removes those segments
could produce vastly different control flow and data.

### Replacing Constants
One optimization used is to take constant values such as booleans and replacing the variable with the actual value. Producing a program that appears to have a constant value that gets changed further down the line or after complex functions have taken place could result in a broken program. 
