<?php

use Prophecy\Argument;

/**
 * CalculatorTest
 *
 * @author Dominik
 */
class CalculatorTest extends AbstractTest {
    
     /**
     *
     * @var \Prophecy\Prophet  
     */
    private $prophet;
    /**
     *
     * @var Calculator 
     */
    private $calculator;
    
    
    public function testDivide() {
        // constricts multiply() method usage to 0
        $this->calculator->multiply()->shouldNotBeCalled();
        // constricts divide() method usage to 1 (should be called EXACTLY 1 time)
        // remember that arguments are also checked, so if they won't match, checkPredictions() method throws an exception
        $this->calculator->divide(4,2)->shouldBeCalled(1);
        // checks only argument types, not values, so if you had changed 'int' to 'string' test will fail, because arguments are 4 and 2 
        $this->calculator->divide(Argument::type('int'), Argument::type('int'))->shouldBeCalled(1);
        $calc = $this->calculator->reveal();
        $this->assertTrue( $calc->divide(4,2) === 2 );
    }
    
    public function testDivideFailed() {
        $ok = false;
        try {
            $calc = $this->calculator->reveal();
            $calc->divide(4,0);
        } catch(InvalidArgumentException $e){
            $ok = true;
        } catch(Exception $e){
            
        }
        $this->assertTrue($ok, "InvalidArgumentException wasn't thrown!");
    }
    
    protected function setup() {
        $this->prophet = new \Prophecy\Prophet;
        $this->calculator = $this->prophet->prophesize('Calculator')->willBeConstructedWith(array(new ResultType(1)));
        $this->calculator->divide(4,2)->willReturn(2);
        $this->calculator->divide(4,0)->willThrow(new InvalidArgumentException());
        
    }
    
    protected function tearDown(){
        $this->prophet->checkPredictions();
    }
}
