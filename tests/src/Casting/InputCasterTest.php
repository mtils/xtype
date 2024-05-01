<?php
/**
 *
 * Created by mtils on 01.05.2024 at 09:19.
 **/

namespace XType\Test\Casting;


use PHPUnit\Framework\TestCase;
use XType\Casting\InputCaster;

class InputCasterTest extends TestCase
{
    protected function setUp(): void
    {
        $this->caster = new InputCaster([
                                            'remove_whitespace' => function (
                                                $input
                                            ) {
                                                return array_map(
                                                    function ($item) {
                                                        return trim($item);
                                                    },
                                                    $input
                                                );
                                            },
                                            'cast_numbers' => function ($input
                                            ) {
                                                return array_map(
                                                    function ($item) {
                                                        return is_numeric(
                                                            $item
                                                        ) ? (float)$item : $item;
                                                    },
                                                    $input
                                                );
                                            },
                                            'capitalize' => function ($input) {
                                                return array_map(
                                                    function ($item) {
                                                        return ucwords($item);
                                                    },
                                                    $input
                                                );
                                            }
                                        ]);
    }

    public function testSetChainAndCastInput()
    {
        $input = [' name ' => '  john ', 'age' => ' 30 '];
        $this->caster->setChain('remove_whitespace|cast_numbers');

        $result = $this->caster->castInput($input);

        $this->assertEquals([' name ' => 'john', 'age' => 30.0], $result);
    }

    public function testWithMethodReturnsNewInstance()
    {
        $newCaster = $this->caster->with('capitalize');

        $this->assertNotSame($this->caster, $newCaster);
        $this->assertEquals(['capitalize'], $newCaster->chain());
    }

    public function testChainModification()
    {
        $originalChain = ['remove_whitespace', 'cast_numbers'];
        $this->caster->setChain($originalChain);
        $newCaster = $this->caster->with('capitalize');

        $expectedChain = ['remove_whitespace', 'cast_numbers', 'capitalize'];
        $this->assertEquals($expectedChain, $newCaster->chain());
    }

    public function testRemoveCasterFromChain()
    {
        $this->caster->setChain('remove_whitespace|cast_numbers|capitalize');
        $newCaster = $this->caster->with('!capitalize');

        $expectedChain = ['remove_whitespace', 'cast_numbers'];
        $this->assertEquals($expectedChain, $newCaster->chain());
    }

    public function testAddCaster()
    {
        $lowercase = function ($input) {
            return array_map('strtolower', $input);
        };
        $this->caster->add('lowercase', $lowercase);

        $this->caster->setChain(['lowercase']);
        $result = $this->caster->castInput(['TEST' => 'DATA']);

        $this->assertEquals(['TEST' => 'data'], $result);
    }

    public function testEmptyChainResultsInOriginalInput()
    {
        $this->caster->setChain([]);
        $input = ['test' => ' unchanged'];
        $result = $this->caster->castInput($input);

        $this->assertEquals($input, $result);
    }
}
