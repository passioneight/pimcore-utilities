<?php

namespace Passioneight\Bundle\PimcoreUtilitiesBundle\Traits;

use Pimcore\Translation\Translator;

trait TranslatorTrait
{
    protected Translator $translator;

    /**
     * @required
     * @internal
     * @param Translator $translator
     */
    public function setTranslator(Translator $translator): void
    {
        $this->translator = $translator;
    }
}
