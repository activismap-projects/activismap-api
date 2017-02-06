<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 27/08/16
 * Time: 17:49
 */

namespace ActivisMap\Error;


interface ApiError {

    //REQUEST
    const PARAM_REQUIRED = array('error' => 'PARAM_REQUIRED', 'httpCode' => 400);
    const FILE_REQUIRED = array('error' => 'FILE_REQUIRED', 'httpCode' => 400);
    const INVALID_FILE = array('error' => 'INVALID_FILE', 'httpCode' => 400);

    //REGISTER
    const REGISTERED_USERNAME = array('error' => 'REGISTERED_USERNAME', 'httpCode' => 400);
    const REGISTERED_EMAIL = array('error' => 'REGISTERED_EMAIL', 'httpCode' => 400);

    //ENTITY
    const ENTITY_EXIST = array('error' => 'ENTITY_EXIST', 'httpCode' => 400);
    const USER_NOT_FOUND = array('error' => 'USER_NOT_FOUND', 'httpCode' => 404);
    const EVENT_NOT_FOUND = array('error' => 'EVENT_NOT_FOUND', 'httpCode' => 404);
    const COMPANY_NOT_FOUND = array('error' => 'COMPANY_NOT_FOUND', 'httpCode' => 404);
    const COMMENT_NOT_FOUND = array('error' => 'COMMENT_NOT_FOUND', 'httpCode' => 404);

    //USER
    const INVALID_PASSWORD = array('error' => 'INVALID_PASSWORD', 'httpCode' => 401);
    const INVALID_VERIFICATION = array('error' => 'INVALID_VERIFICATION', 'httpCode' => 400);

    //PERMISSIONS
    const PERMISSIONS_NOT_FOUND = array('error' => 'PERMISSIONS_NOT_FOUND', 'httpCode' => 401);
    const PUBLISHER_REQUIRED = array('error' => 'PUBLISHER_REQUIRED', 'httpCode' => 403);
    const ADMIN_REQUIRED = array('error' => 'ADMIN_REQUIRED', 'httpCode' => 403);
    const SUPER_ADMIN_REQUIRED = array('error' => 'SUPER_ADMIN_REQUIRED', 'httpCode' => 403);
    const INVALID_REQUEST_PERMISSIONS = array('error' => 'INVALID_REQUEST_PERMISSIONS', 'httpCode' => 400);

    //CREDENTIALS
    const INVALID_CREDENTIALS = array('error' => 'INVALID_CREDENTIALS', 'httpCode' => 401);
    const INVALID_CLIENT = array('error' => 'INVALID_CLIENT', 'httpCode' => 401);
    const INVALID_LOGIN = array('error' => 'INVALID_LOGIN', 'httpCode' => 401);
    const INVALID_GRANT_TYPE = array('error' => 'INVALID_GRANT_TYPE', 'httpCode' => 400);
    const INVALID_REFRESH_TOKEN = array('error' => 'INVALID_REFRESH_TOKEN', 'httpCode' => 401);

    //UNKNOWN
    const UNKNOWN_ERROR = array('error' => 'UNKNOWN_ERROR', 'httpCode' => 419);

    /**
     * @return string
     */
    function getError();

    /**
     * @return string|array
     */
    function getData();

    /**
     * @return int
     */
    function getHttpCode();
}