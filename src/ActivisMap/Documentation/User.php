<?php
include('BaseDocumentation.php');

/**
 * @api {get} /v1/user ReadUser
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName ReadUser
 * @apiDescription Datos de la cuenta del usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse USER_NOT_FOUND
 * @apiUse UserResponse
 */

/**
 * @api {post} /v1/user UpdateUser
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName UpdateUser
 * @apiDescription Modificar datos de la cuenta del usuario
 * @apiParam {String} [person_name] Nombre personal del usuario
 * @apiParam {String} [old_password] Actual contraseña de la cuenta. Será ignorado si no se proporciona el parámetro <code>new_password</code>.
 * @apiParam {String} [new_password] Nueva contraseña de la cuenta. Será ignorado si no se proporciona el parámetro <code>old_password</code>.
 * @apiParam {Base64{10000}} [avatar64] Imagen en Base64 que se establecerá como avatar de la cuenta.
 * @apiParam {String} [file_name] Nombre del archivo establecido en el parámetro <code>avatar64</code>. Es obligatorio si se establece el parámetro <code>avatar64</code>.
 * @apiParam {String} [description] Descripción breve de las funciones del usuario, logros, y características como abogado.
 * @apiParam {File{10000}} [avatar] Imagen que se establecerá como avatar de la cuenta del usuario.
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse PARAM_REQUIRED
 * @apiUse USER_NOT_FOUND
 * @apiUse INVALID_PASSWORD
 * @apiUse UserResponse
 */

/**
 * @api {get} /v1/user/account/:id ReadAnotherUser
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName ReadAnotherUser
 * @apiDescription Leer datos de la cuenta de un usuario en concreto
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse USER_NOT_FOUND
 * @apiUse UserResponse
 */


/**
 * @api {get} /v1/user/companies UserCompanies
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName UserCompanies
 * @apiDescription Datos de las compañias a las que pertenece el usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse CompanyResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse USER_NOT_FOUND
 * @apiUse CompanyResponseList
 */

/**
 * @api {get} /v1/user/events UserEvents
 * @apiGroup User
 * @apiName UserEvents
 * @apiDescription Datos de los eventos creados por el usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse EventResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse USER_NOT_FOUND
 * @apiUse EventResponseList
 */