<?php

declare(strict_types=1);

namespace Roave\ApiCompare\Comparator\BackwardsCompatibility\ClassBased;

use Assert\Assert;
use Roave\ApiCompare\Change;
use Roave\ApiCompare\Changes;
use Roave\BetterReflection\Reflection\ReflectionClass;
use function sprintf;

/**
 * A class cannot become a trait without introducing an explicit BC break, since
 * all child classes or implementors need to be changed from `extends` to `use`,
 * and all instantiations start failing
 */
final class ClassBecameTrait implements ClassBased
{
    public function compare(ReflectionClass $fromClass, ReflectionClass $toClass) : Changes
    {
        Assert::that($fromClass->getName())->same($toClass->getName());

        if ($fromClass->isTrait() || ! $toClass->isTrait()) {
            return Changes::new();
        }

        return Changes::fromArray([Change::changed(
            sprintf('Class %s became a trait', $fromClass->getName()),
            true
        ),
        ]);
    }
}
