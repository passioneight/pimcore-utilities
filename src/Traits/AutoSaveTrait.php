<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Traits;

use Pimcore\Event\Model\ElementEventInterface;

trait AutoSaveTrait
{
    protected function isAutoSaveEvent(ElementEventInterface $event): bool
    {
        return $event->hasArgument('isAutoSave') && $event->getArgument('isAutoSave');
    }
}
