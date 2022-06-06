<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Traits;

use Pimcore\Event\Model\DataObjectEvent;

trait AutoSaveTrait
{
    /**
     * @param DataObjectEvent $event
     * @return bool
     */
    protected function isAutoSaveEvent(DataObjectEvent $event): bool
    {
        return $event->hasArgument('isAutoSave') && $event->getArgument('isAutoSave');
    }
}
