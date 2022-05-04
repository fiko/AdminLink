<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Api\Data;

interface NotificationInterface
{
    public const KEY = 'key';
    public const DESTINATION = 'destination';
    public const CREATED_AT = 'created_at';

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey();

    /**
     * Set key.
     *
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key);

    /**
     * Get destination.
     *
     * @return string
     */
    public function getDestination();

    /**
     * Set destination.
     *
     * @param string $destination
     *
     * @return $this
     */
    public function setDestination($destination);

    /**
     * Get created at.
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set created at.
     *
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
