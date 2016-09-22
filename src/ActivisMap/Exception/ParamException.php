<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 1/08/16
 * Time: 20:23
 */

namespace ActivisMap\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ParamException extends HttpException {

    /**
     * @param array $handled
     * @param array $needed
     */
    public function __construct(array $handled, array $needed) {
        $h = implode(', ', $handled);
        $n = implode(', ', $needed);
        parent::__construct(404, 'Params found ' . $h . ', needed ' . $n);
    }
}