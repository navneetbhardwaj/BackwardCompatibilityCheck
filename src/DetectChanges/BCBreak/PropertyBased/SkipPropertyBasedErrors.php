<?php

declare(strict_types=1);

namespace Roave\BackwardCompatibility\DetectChanges\BCBreak\PropertyBased;

use Roave\BackwardCompatibility\Change;
use Roave\BackwardCompatibility\Changes;
use Roave\BetterReflection\Reflection\ReflectionProperty;
use Throwable;

final class SkipPropertyBasedErrors implements PropertyBased
{
    /** @var PropertyBased */
    private $next;

    public function __construct(PropertyBased $next)
    {
        $this->next = $next;
    }

    public function __invoke(ReflectionProperty $fromProperty, ReflectionProperty $toProperty) : Changes
    {
        try {
            return $this->next->__invoke($fromProperty, $toProperty);
        } catch (Throwable $failure) {
            return Changes::fromList(Change::skippedDueToFailure($failure));
        }
    }
}
