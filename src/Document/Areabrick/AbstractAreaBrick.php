<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Document\Areabrick;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\NamespaceUtility;
use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;

abstract class AbstractAreaBrick extends AbstractTemplateAreabrick
{
    /**
     * @inheritDoc
     * @return string the name based on the class.
     */
    public function getName()
    {
        return NamespaceUtility::getClassNameFromNamespace(get_called_class());
    }

    /**
     * @inheritDoc
     */
    public function getTemplateLocation()
    {
        return self::TEMPLATE_LOCATION_GLOBAL;
    }

    /**
     * @inheritDoc
     */
    public function getTemplateSuffix()
    {
        return self::TEMPLATE_SUFFIX_TWIG;
    }
}
