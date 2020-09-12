# Usage
Depending on what part of the bundle you need, the usage varies. See the examples below to find out how to use the
various utilities.

### Constants
Based on the [Php Utilities Bundle](https://github.com/passioneight/php-utilities), an additional class is provided,
which helps uniformly creating translation-keys for constants: `TranslatableConstant`. This class provides the
`toTranslationKey` method, which can be called, once the `getTranslationKeyPrefix` method was implemented.

As an example, consider the *availability* of a product:

```php
<?php

namespace AppBundle\Constant;

use Passioneight\Bundle\PimcoreUtilitiesBundle\Constant\TranslatableConstant;

class Availablility extends TranslatableConstant
{
    const IN_STOCK = "in-stock";
    const OUT_OF_STOCK = "out-of-stock";

    /**
     * @inheritdoc
     */
    public static function getTranslationKeyPrefix()
    {
        return "availability.";
    }
}
```

> This way, you can always create the same translation key for the same constant and have a single point of change.

When calling `Availability::toTranslationKey(Availability::IN_STOCK);` the value `availability.in-stock` is returned.

> Note that it is considered best practice to create all translation keys in the same format. Where the format should be
> **lowercase only**, using **dashes** to delimit words for readability, and having as little _context_ as possible. Where
> _context_ is any part **before a dot**.

### Areabricks
Eventually, area bricks need to be created to increase flexibility in terms of customizing documents within Pimcore. Especially,
the setup of such area bricks becomes relatively repetitive. Thus, the `AbstractAreaBrick` class is provided. Simply, extend
from this class when creating area bricks to provide basic functionality to the bricks.

> See Pimcore's documentation for details on the pre-configuration.

Note that the name is automatically computed based on the brick's class name. You may override the `getName` if a different
behaviour is needed. 