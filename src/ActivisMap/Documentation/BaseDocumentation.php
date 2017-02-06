<?php

/**
 * @apiDefine INVALID_CLIENT
 * @apiError (Errores) INVALID_CLIENT El cliente no existe o no tiene permisos para obtener el tipo de credencial requerido.
 * @apiErrorExample {json} Error INVALID_CLIENT
 *      {
 *          "error":"INVALID_CLIENT",
 *          "message":"Client not authorized."
 *      }
 */

/**
 * @apiDefine INVALID_CREDENTIALS
 * @apiError (Errores) INVALID_CREDENTIALS No se encontró el AccessToken o está expirado para acceder al recurso
 * @apiErrorExample {json} Error INVALID_CREDENTIALS
 *      {
 *          "error":"INVALID_CREDENTIALS",
 *          "message":"Invalid AccessToken."
 *      }
 */

/**
 * @apiDefine INVALID_LOGIN
 * @apiError (Errores) INVALID_LOGIN El usuario o contraseña proporcionados no son válidos
 * @apiErrorExample {json} Error INVALID_LOGIN
 *      {
 *          "error":"INVALID_LOGIN",
 *          "message":"Invalid username or password."
 *      }
 */

/**
 * @apiDefine INVALID_GRANT_TYPE
 * @apiError (Errores) INVALID_GRANT_TYPE El tipo de accesso requerido no existe o es inválido para el cliente proporcionado.
 * @apiErrorExample {json} Error INVALID_GRANT_TYPE
 *      {
 *          "error":"INVALID_GRANT_TYPE",
 *          "message":"Invalid grant_type parameter."
 *      }
 */

/**
 * @apiDefine INVALID_REFRESH_TOKEN
 * @apiError (Errores) INVALID_REFRESH_TOKEN El refresh token proporcionado no existe o ha expirado. Se deberá pedir acceso con <code>username</code> y <code>password</code>.
 * @apiErrorExample {json} Error INVALID_REFRESH_TOKEN
 *      {
 *          "error":"INVALID_REFRESH_TOKEN",
 *          "message":"RefreshToken is expired or invalid."
 *      }
 */

/**
 * @apiDefine PARAM_REQUIRED
 * @apiError (Errores) PARAM_REQUIRED No se ha proporcionado un párametro obligatorio
 * @apiErrorExample {json} Error PARAM_REQUIRED
 *      {
 *          "error":"PARAM_REQUIRED",
 *          "message":"Param x is required."
 *      }
 */

/**
 * @apiDefine FILE_REQUIRED
 * @apiError (Errores) FILE_REQUIRED No se ha detectado ningún archivo en la llamada
 * @apiErrorExample {json} Error FILE_REQUIRED
 *      {
 *          "error":"FILE_REQUIRED",
 *          "message":"File not provided."
 *      }
 */

/**
 * @apiDefine REGISTERED_USERNAME
 * @apiError (Errores) REGISTERED_USERNAME El valor del parámetro <code>username</code> ya existe
 * @apiErrorExample {json} Error REGISTERED_USERNAME
 *      {
 *          "error":"REGISTERED_USERNAME",
 *          "message":"Username already exist"
 *      }
 */

/**
 * @apiDefine REGISTERED_EMAIL
 * @apiError (Errores) REGISTERED_EMAIL El valor del parámetro <code>email</code> ya existe
 * @apiErrorExample {json} Error REGISTERED_EMAIL
 *      {
 *          "error":"REGISTERED_EMAIL",
 *          "message":"Email already exist"
 *      }
 */


/**
 * @apiDefine COMPANY_NOT_FOUND
 * @apiError (Errores) COMPANY_NOT_FOUND La compañia no existe en la base de datos.
 * @apiErrorExample {json} Error COMPANY_NOT_FOUND
 *      {
 *          "error":"COMPANY_NOT_FOUND",
 *          "message":"COMPANY_NOT_FOUND"
 *      }
 */

/**
 * @apiDefine EVENT_NOT_FOUND
 * @apiError (Errores) EVENT_NOT_FOUND El evento no existe en la base de datos.
 * @apiErrorExample {json} Error EVENT_NOT_FOUND
 *      {
 *          "error":"EVENT_NOT_FOUND",
 *          "message":"EVENT_NOT_FOUND"
 *      }
 */

/**
 * @apiDefine COMMENT_NOT_FOUND
 * @apiError (Errores) COMMENT_NOT_FOUND El comentario no existe en la base de datos.
 * @apiErrorExample {json} COMMENT_NOT_FOUND EVENT_NOT_FOUND
 *      {
 *          "error":"COMMENT_NOT_FOUND",
 *          "message":"COMMENT_NOT_FOUND"
 *      }
 */

/**
 * @apiDefine USER_DISTINCT_CREATOR_REQUIRED
 * @apiError (Errores) USER_DISTINCT_CREATOR_REQUIRED El usuario a asignar no puede ser el creador del caso.
 * @apiErrorExample {json} Error USER_DISTINCT_CREATOR_REQUIRED
 *      {
 *          "error":"USER_DISTINCT_CREATOR_REQUIRED",
 *          "message":"You are the sender of this thread."
 *      }
 */

/**
 * @apiDefine INVALID_PASSWORD
 * @apiError (Errores) INVALID_PASSWORD Se ha proporcionado una contraseña que no coincide con la cuenta a la que se intenta acceder
 * @apiErrorExample {json} Error INVALID_PASSWORD
 *      {
 *          "error":"INVALID_PASSWORD",
 *          "message":"Invalid old password"
 *      }
 */

/**
 * @apiDefine PUBLISHER_REQUIRED
 * @apiError (Errores) PUBLISHER_REQUIRED El usuario a asignar debe ser PUBLISHER de uno de las compañías que publicá el evento
 * @apiErrorExample {json} Error PUBLISHER_REQUIRED
 *      {
 *          "error":"PUBLISHER_REQUIRED",
 *          "message":"The assigned user should be a employee of the groups that published the case."
 *      }
 */

/**
 * @apiDefine ADMIN_REQUIRED
 * @apiError (Errores) ADMIN_REQUIRED El usuario debe ser ADMIN de la compañía a la que se intenta acceder
 * @apiErrorExample {json} Error ADMIN_REQUIRED
 *      {
 *          "error":"ADMIN_REQUIRED",
 *          "message":"You do not have necessary permissions to access on this group."
 *      }
 */

/**
 * @apiDefine SUPER_ADMIN_REQUIRED
 * @apiError (Errores) SUPER_ADMIN_REQUIRED El usuario debe ser SUPER_ADMIN de la compañía a la que se intenta acceder
 * @apiErrorExample {json} Error SUPER_ADMIN_REQUIRED
 *      {
 *          "error":"SUPER_ADMIN_REQUIRED",
 *          "message":"You do not have necessary permissions to access on this group."
 *      }
 */

/**
 * @apiDefine AccessTokenResponseParams
 * @apiSuccess {String} access_token Token de accesso con el que se realizarán las llamadas que requieran autorización.
 * @apiSuccess {Number} expires_in Tiempo de expiración del Token de acceso en segundos.
 * @apiSuccess {Number} token_type Tipo de token obtenido.
 * @apiSuccess {String="null"} scope Ámbito de uso del token.
 * @apiSuccess {String} refresh_token Token de refresco a usar para obtener un nuevo Token de accesso cuando este expire.
 */

/**
 * @apiDefine BaseResponseParams
 * @apiSuccess {Number} id ID del nuevo caso creado
 * @apiSuccess {Number} created Fecha de creación en milisegundos
 * @apiSuccess {Number} updated Fecha de ultima modificación en milisegundos
 * @apiSuccess {String} identifier Identificador único
 */

/**
 * @apiDefine UserResponseParams
 * @apiSuccess {String} username Nombre de usuario
 * @apiSuccess {String} email Dirección de correo electrónico
 * @apiSuccess {String} avatar URL del avatar del usuario
 */

/**
 * @apiDefine CompanyResponseParams
 * @apiSuccess {String} name Nombre de la Company
 * @apiSuccess {String} email Dirección de correo electrónico
 * @apiSuccess {String} logo URL del logo de la compañía
 */

/**
 * @apiDefine EventResponseParams
 * @apiSuccess {String} title Título del evento
 * @apiSuccess {String} description Descripción del evento
 * @apiSuccess {String} image URL de la imagenpromocional del evento
 * @apiSuccess {String} status Estado del evento
 * @apiSuccess {Number} latitude Latitud donde se ubica el evento
 * @apiSuccess {Number} longitude Longitud donde se ubica el evento
 * @apiSuccess {Number} start_date Fecha de inicio del evento representada en millisegundos
 * @apiSuccess {Number} end_date Fecha de finalización del evento representada en millisegundos
 * @apiSuccess {String} categories Categorías a las que pertenece el evento
 * @apiSuccess {String} type Tipo del evento
 * @apiSuccess {Number} participants Número aproximado de personas que podrían asistir al evento
 * @apiSuccess {Number} likes Número de personas a las que les gusta el evento
 * @apiSuccess {Number} dislikes Número de personas a las que no les gusta el evento
 * @apiSuccess {JSON} creator Datos del usuario que ha creado el evento
 * @apiSuccess {JSON} company Datos de la compañía a cargo del evento
 */

/**
 * @apiDefine CommentResponseParams
 * @apiSuccess {String} comment Comentario realizado
 * @apiSuccess {JSON} event Datos del evento donde se ha comentado
 * @apiSuccess {JSON} [user] Datos del usuario que ha comentado
 */

/**
 * @apiDefine AccessTokenResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "access_token": "ZTVlODNjZDY4ZDU2Y2QyNDQ2ZGM1YjdjZGZlZWFmNWFhNjk4OTBjOWVlMWJmYTdlN2RjZjRmYjY2NjQzY2YwOQ",
 *          "expires_in": 86400,
 *          "token_type": "bearer",
 *          "scope": null,
 *          "refresh_token": "MjA2YzJiMjg4OGJjMWM2MWYxYTYzOWNiZTFmZTFmMTE3Yjc1OGEwYjEzMzJlZTc2OTBmNDAyZDA0MmMyMzdkOQ"
 *      }
 *
 */

/**
 * @apiDefine UserResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 86,
 *          "created": 1478615766041,
 *          "last_update": 1478615766046,
 *          "identifier": "U5821e2d609ec5",
 *          "username": "User5821e2d5909c8",
 *          "email": "User5821e2d5909c8@activismap.net",
 *          "avatar": "https://localhost:8000/avatar_m.png",
 *      }
 */

/**
 * @apiDefine EventResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 9,
 *          "created": 1486404622300,
 *          "last_update": 1486404622301,
 *          "identifier": "E5898bc0e494d0",
 *          "title": "ActivisMap is comming!",
 *          "description": "ActivisMap app is creating by Entropy Facotry in Les Coves de Vinromá",
 *          "image": "https://localhost:8000/files/5898bc0e49560.png",
 *          "status": "WORKING",
 *          "latitude": 49.5595482,
 *          "longitude": -0.2155455,
 *          "start_date": 1486404082000,
 *          "end_date": 1486836082000,
 *          "categories": "LEARNING",
 *          "type": "ASSEMBLY",
 *          "creator": { . . . },
 *          "company": { . . . }
 *      }
 */

/**
 * @apiDefine EventResponseList
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *              "id": 9,
 *              "created": 1486404622300,
 *              "last_update": 1486404622301,
 *              "identifier": "E5898bc0e494d0",
 *              "title": "ActivisMap is comming!",
 *              "description": "ActivisMap app is creating by Entropy Facotry in Les Coves de Vinromá",
 *              "image": "https://localhost:8000/files/5898bc0e49560.png",
 *              "status": "WORKING",
 *              "latitude": 49.5595482,
 *              "longitude": -0.2155455,
 *              "start_date": 1486404082000,
 *              "end_date": 1486836082000,
 *              "categories": "LEARNING",
 *              "type": "ASSEMBLY",
 *              "creator": { . . . },
 *              "company": { . . . }
 *          },
 *          { . . . },
 *      ]
 */

/**
 * @apiDefine CommentResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 85,
 *          "identifier": "R58211a730d939",
 *          "created": 1478559844462,
 *          "last_update": 1478559844462,
 *          "contentType": "comment",
 *          "event": { . . . },
 *          "user": { . . . }
 *       }
 */

/**
 * @apiDefine CommentResponseList
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *              "id": 85,
 *              "identifier": "R58211a730d939",
 *              "created": 1478559844462,
 *              "last_update": 1478559844462,
 *              "contentType": "comment",
 *              "event": { . . . },
 *              "user": { . . . }
 *          },
 *          { . . . },
 *      ]
 */


/**
 * @apiDefine CompanyResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 11,
 *          "created": 1468510803672,
 *          "last_update": 1468510803672,
 *          "identifier": "C5787b253a423c",
 *          "name": "ActivisMap",
 *          "email": "info@activismap.net"
 *          "logo": "https://localhost:8000/files/5898bc0e49560.png"
 *      }
 */

/**
 * @apiDefine CompanyResponseList
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *              "id": 11,
 *              "created": 1468510803672,
 *              "last_update": 1468510803672,
 *              "identifier": "C5787b253a423c",
 *              "name": "ActivisMap",
 *              "email": "info@activismap.net"
 *              "logo": "https://localhost:8000/files/5898bc0e49560.png"
 *          },
 *          { . . .},
 *      ]
 */