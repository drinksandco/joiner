<?php

namespace Uvinum\Joiner;

use Uvinum\Joiner\Manipulator\ArrayManipulator;
use Uvinum\Joiner\Serializer\ArraySerializer;
use Uvinum\Joiner\Strategy\ToStringStrategy;

class JoinerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Joiner */
    private $joiner;

    private $output;

    public function setUp()
    {
        $this->joiner = new Joiner(new ArraySerializer(new ToStringStrategy()), new ArrayManipulator());
    }

    /** @test */
    public function shouldProvideASimpleSerialization()
    {
        $this->givenAnInputBaseOf([1, 2, 3]);
        $this->whenExecutingJoin();
        $this->thenShouldExpectAnOutputOf([1, 2, 3]);
    }

    /** @test */
    public function shouldProvideAnObjectSerializationJointWithAnArray()
    {
        $this->givenAnInputBaseOf(new FakeObject("Marcos"));
        $this->givenAnAppendOf('pam', [1, 2, 3]);
        $this->whenExecutingJoin();
        $this->thenShouldExpectAnOutputOf(["name" => "Marcos", "pam" => [1, 2, 3]]);
    }

    /** @test */
    public function shouldProvideAnObjectSerializationJointWithAnotherObjectWithProperties()
    {
        $this->givenAnInputBaseOf(new FakeObject("Marcos"));
        $this->givenAnAppendOf('fakeobject', new FakeObjectWithArrayProperty("Dave", ["Spaguetti", "CheeseCake"]));
        $this->whenExecutingJoin();
        $this->thenShouldExpectAnOutputOf(["name" => "Marcos", "fakeobject" => ["name" => "Dave", "foods" => ["Spaguetti", "CheeseCake"]]]);
    }

    /** @test */
    public function shouldProvideAnObjectSerializationJointWithAnotherObjectWithPropertiesFieldInsideTheFirstObject()
    {
        $this->givenAnInputBaseOf(new FakeObjectWithArrayProperty("Marcos", ["Pizza", "Chocolate"]));
        $this->givenAnAppendOf('foods>dave', (new FakeObjectWithArrayProperty("Dave", ["Spaguetti", "CheeseCake"]))->foods());
        $this->whenExecutingJoin();
        $this->thenShouldExpectAnOutputOf(["name" => "Marcos", "foods" => [0 => "Pizza", 1 => "Chocolate", "dave" => ["Spaguetti", "CheeseCake"]]]);
    }

    /** @test */
    public function shouldProvideAnObjectSerializationJoinWithAnotherObjectWithPropertiesButOnePropertyFiltered()
    {
        $this->givenAnInputBaseOf(new FakeObject("Marcos"));
        $this->givenAnAppendOf('fakeobject', new FakeObjectWithArrayProperty("Dave", ["Spaguetti", "CheeseCake"]));
        $this->givenAFilterOf('fakeobject>foods');
        $this->whenExecutingJoin();
        $this->thenShouldExpectAnOutputOf(["name" => "Marcos", "fakeobject" => ["name" => "Dave"]]);
    }

    private function givenAnInputBaseOf($arg)
    {
        $this->joiner = $this->joiner->join($arg);
    }

    private function givenAnAppendOf($key, $arg)
    {
        $this->joiner = $this->joiner->append($key, $arg);
    }

    private function givenAFilterOf($key)
    {
        $this->joiner = $this->joiner->filter($key);
    }

    private function whenExecutingJoin()
    {
        $this->output = $this->joiner->execute();
    }

    private function thenShouldExpectAnOutputOf($array)
    {
        $this->assertArraySubset($array, $this->output);
    }
}
