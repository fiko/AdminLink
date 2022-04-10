<?php

/**
 * Copyright © Fiko Borizqy. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fiko\AdminUrl\Api\Data;

interface NotificationInterface
{
    const KEY = 'key';
    const DESTINATION = 'destination';
    const CREATED_AT = 'created_at';

    /**
     * get key.
     *
     * @return string
     */
    public function getKey();

    /**
     * set key.
     *
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key);

    /**
     * get destination.
     *
     * @return string
     */
    public function getDestination();

    /**
     * set destination.
     *
     * @param string $destination
     *
     * @return $this
     */
    public function setDestination($destination);

    /**
     * get created at.
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * set created at.
     *
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
