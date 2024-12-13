<?php

namespace Municipio\PostObject\Decorators;

use AllowDynamicProperties;
use Municipio\PostObject\PostObjectInterface;

/**
 * Backwards compatible PostObject.
 *
 * This class is used to make sure that the PostObjectInterface is backwards compatible with the old PostObject class.
 */
#[AllowDynamicProperties]
class BackwardsCompatiblePostObject extends AbstractPostObjectDecorator implements PostObjectInterface
{
    /**
     * Constructor.
     */
    public function __construct(PostObjectInterface $postObject, object $legacyPost)
    {
        $this->postObject = $postObject;

        foreach ($legacyPost as $key => $value) {
            if (!isset($this->{$key})) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->postObject->getId();
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->postObject->getTitle();
    }

    /**
     * @inheritDoc
     */
    public function getPermalink(): string
    {
        return $this->postObject->getPermalink();
    }

    /**
     * @inheritDoc
     */
    public function getCommentCount(): int
    {
        return $this->postObject->getCommentCount();
    }

    /**
     * @inheritDoc
     */
    public function getTermIcons(): array
    {
        return $this->postObject->getTermIcons();
    }
}
