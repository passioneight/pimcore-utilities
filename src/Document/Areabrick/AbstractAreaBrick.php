<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Document\Areabrick;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\NamespaceUtility;
use Passioneight\Bundle\PimcoreUtilitiesBundle\Traits\TranslatorTrait;
use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Model\Document\Editable\Area\Info;

abstract class AbstractAreaBrick extends AbstractTemplateAreabrick
{
    use TranslatorTrait;

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
    public function getHtmlTagOpen(Info $info)
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getHtmlTagClose(Info $info)
    {
        return '';
    }
}
