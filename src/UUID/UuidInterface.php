<?php

namespace benemohamed\analytics\UUID;

/**
 * Mian UUID
 */
interface UuidInterface
{

    /**
     * random UUID (version 4)
     *
     * @return string
     */
    public static function v4();
}
