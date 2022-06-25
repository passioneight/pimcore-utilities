# Usage
Depending on your needs, the usage varies. See the examples below to find out how to use the various utilities and features.

### Constants
Based on the [Php Utilities Bundle](https://github.com/passioneight/php-utilities), an additional class is provided,
which helps uniformly creating translation-keys for constants: `TranslatableConstant`. This class provides the
`toTranslationKey` method, which can be called, once the `getTranslationKeyPrefix` method was implemented.

As an example, consider the *availability* of a product:

```php
<?php

namespace App\Constant;

use Passioneight\Bundle\PimcoreUtilitiesBundle\Constant\TranslatableConstant;

class Availability extends TranslatableConstant
{
    const IN_STOCK = "in-stock";
    const OUT_OF_STOCK = "out-of-stock";

    /**
     * @inheritdoc
     */
    public static function getTranslationKeyPrefix(): string
    {
        return "availability.";
    }
}
```

> This way, you can always create the same translation key for the same constant and have a single point of change.

When calling `Availability::toTranslationKey(Availability::IN_STOCK);` the value `availability.in-stock` is returned. This
value can then be passed to the application's translator.

> Note that it is considered best practice to create all translation keys in the same format. Where the format should be
> **lowercase only**, using **dashes** to delimit words for readability, and having as little _context_ as possible. Where
> _context_ is any part **before a dot**.

### Areabricks
Eventually, area bricks need to be created to increase flexibility in terms of customizing documents within Pimcore. Especially,
the setup of such area bricks becomes relatively repetitive. Thus, the `AbstractAreaBrick` class is provided. Simply, extend
from this class when creating area bricks to provide basic functionality to the bricks.

> See Pimcore's documentation for details on the configuration.

Note that the name is automatically computed based on the brick's class name. You may override the `getName` if a different
behaviour is needed. It's also note-worthy that Pimcore automatically creates translation-keys for the area brick names.

> The default implementation creates the name of an area brick in camel-case format. This is not considered best practice,
> when it comes to the translation-key format. We are still looking into a proper solution for this.

### Traits
The following traits were added to decrease maintenance and implementation effort.

> Have a look at [PHP's documentation](https://www.php.net/manual/en/language.oop5.traits.php) to read more about traits.

##### TranslatorTrait
Whenever a translation key is used, a translator is needed as well. While the translator is provided by Pimcore, chances are
that the developer chooses dependency injection to access the translator. 

> Note that it is considered best practice to use dependency injection whenever the service is accessed conditionally or
> optionally (e.g., in a service class or area brick).

Here's an example on how to `use` the `TranslatorTrait`:

```php
<?php

namespace App\Document\Areabrick;

use Passioneight\Bundle\PimcoreUtilitiesBundle\Traits\TranslatorTrait;

class Wysiwyg extends Passioneight\Bundle\PimcoreUtilitiesBundle\Document\Areabrick\AbstractAreaBrick implements EditableDialogBoxInterface
{
    use TranslatorTrait;
    
    /**
     * @inheritDoc
     */
    public function getEditableDialogBoxConfiguration(Document\Editable $area, ?Info $info): EditableDialogBoxConfiguration
    {
        $config = new EditableDialogBoxConfiguration();
        $config->addItem([
            'type' => 'relation',
            'label' => $this->translator->trans('element', [], 'editmode'),
            'name' => 'element'
        ]);   
    }
}
```

##### AutoSaveTrait
As of Pimcore X, an auto-save functionality (aka. _draft_) was introduced. While the feature itself is great, it has one
_potentially_ unexpected behaviour: it triggers Pimcore's element-related events. This means that any, e.g., save-subscriber in your project
might be triggered by the auto-save functionality. This can cause unwanted side effects.

Here's an example on to prevent the event subscriber executing any code in case of an auto-save:

```php
<?php

namespace App\EventSubscriber\Index;

use App\Traits\Pimcore\AntiDraftEventTrait;
use Pimcore\Event\DataObjectEvents;
use Pimcore\Event\Model\DataObjectEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductSaveSubscriber implements EventSubscriberInterface
{
    use AutoSaveTrait;

    /**
     * @inheridoc
     */
    public static function getSubscribedEvents()
    {
        return [
            DataObjectEvents::POST_UPDATE => 'onPostUpdate'
        ];
    }

    /**
     * @param DataObjectEvent $event
     */
    public function onPostUpdate(DataObjectEvent $event)
    {
        if ($this->isAutoSaveEvent($event)) {
            return;
        }

        // Omitted for brevity
    }
}
```

> Obviously, you can also invert the `if`-statement to only listen to auto-save events.

> This trait is only useful if you don't want to turn off the auto-save functionality.

### Commands
Creating a command is fairly simple, however, most commands will share the same basic implementation. Thus, the
`AbstractCommand` was implemented. It specifically focuses on adding the well-known `--dry-run` option to any command
that extends from this class.

> Note use `$this->isDryRun()` to check if the command was started with the `--dry-run` option, so, the option is actually
> considered in your code.

An additional call to `$this->enableDryRun()` is required in the `initialize` method. If this call is skipped, the command
will abort with a `LogicException`. As a best practice, always implement the dry-run logic first, then
call `$this->enableDryRun()`.

> This behaviour is by design, to avoid accidentally adding the `--dry-run` option without actually implementing the dry-run
> functionality. It will decrease the chance of another team member thinking they are executing the command in dry-run mode
> when it is not implemented.

### [Back to Overview](/README.md)