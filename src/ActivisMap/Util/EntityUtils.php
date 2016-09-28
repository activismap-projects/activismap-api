<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 21/06/16
 * Time: 15:41
 */

namespace ActivisMap\Util;


class EntityUtils
{

    /**
     * @return int
     */
    public static function millis() {
        return (int) round(microtime(true) * 1000);
    }
}