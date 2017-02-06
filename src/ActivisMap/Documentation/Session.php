<?php
include('BaseDocumentation.php');

/**
 * @api {post} /oauth/v2/token Login
 * @apiVersion 1.0.0
 * @apiGroup Session
 * @apiName Login
 * @apiDescription Pedir accessToken para un usuario
 * @apiParam {String="password"} grant_type Tipo de accesso para obtener las credenciales.
 * @apiParam {String} client_id Identificador del cliente proporcionado por el Administrador de la API.
 * @apiParam {String} client_secret Credencial de acceso del cliente por el Administrador de la API.
 * @apiParam {String} password Contraseña de la cuenta.
 * @apiParam {String} username Nombre de usuario de la cuenta.
 * @apiUse AccessTokenResponseParams
 * @apiUse INVALID_GRANT_TYPE
 * @apiUse INVALID_CLIENT
 * @apiUse INVALID_LOGIN
 * @apiUse AccessTokenResponse
 */

/**
 * @api {post} /oauth/v2/token Login Refresh
 * @apiVersion 1.0.0
 * @apiGroup Session
 * @apiName LoginRefresh
 * @apiDescription Refrescar accessToken para un usuario
 * @apiParam {String="refresh_token"} grant_type Tipo de accesso para obtener las credenciales.
 * @apiParam {String} client_id Identificador del cliente proporcionado por el Administrador de la API.
 * @apiParam {String} client_secret Credencial de acceso del cliente por el Administrador de la API.
 * @apiParam {String} refresh_token RefreshToken obtenido al hacer Login o al refrescar el accessToken.
 * @apiUse AccessTokenResponseParams
 * @apiUse INVALID_GRANT_TYPE
 * @apiUse INVALID_REFRESH_TOKEN
 * @apiUse INVALID_CLIENT
 * @apiUse AccessTokenResponse
 */