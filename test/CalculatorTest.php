<?php

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
    
    
    public function testMinus() {
        $calc = $this->calculator->reveal();
        $this->assertTrue( $calc->divide(4,2) === 2 );
    }
    
    public function testMinusFailed() {
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
        //$this->prophet->checkPredictions();
    }
}
