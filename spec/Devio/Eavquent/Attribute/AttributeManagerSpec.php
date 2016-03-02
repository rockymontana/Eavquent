<?php

namespace spec\Devio\Eavquent\Attribute;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Illuminate\Support\Collection;
use Devio\Eavquent\Contracts\AttributeCache;
use Devio\Eavquent\Attribute\AttributeRepository;

class AttributeManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Devio\Eavquent\Attribute\AttributeManager');
    }

    function let(AttributeCache $cache, AttributeRepository $repository)
    {
        $this->beConstructedWith($cache, $repository);
    }

    function it_should_get_attributes(AttributeCache $cache, AttributeRepository $repository)
    {
        $cache->exists()->shouldBeCalled()->willReturn(true);
        $cache->get()->shouldBeCalled();
        $this->get();
    }

    function it_should_refresh_attributes_cache(AttributeCache $cache, AttributeRepository $repository)
    {
        $collection = new Collection();

        $repository->all()->shouldBeCalled()->willReturn($collection);
        $cache->set($collection)->shouldBeCalled();

        $this->refresh();
    }
}
