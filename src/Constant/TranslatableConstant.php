<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Constant;

use Passioneight\Bundle\PhpUtilitiesBundle\Constant\Constant;

abstract class TranslatableConstant extends Constant
{
    /**
     * @param string $value
     * @return string the translation key.
     */
    public static function toTranslationKey(string $value)
    {
        /** @var Constant $class */
        $class = get_called_class();
        return $class::getTranslationKeyPrefix() . $value;
    }

    /**
     * @return string the prefix for the translation key.
     */
    abstract public static function getTranslationKeyPrefix();
}
