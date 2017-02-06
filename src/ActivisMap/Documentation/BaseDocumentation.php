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
 * @apiDefine PASS_NOT_MATCH
 * @apiError (Errores) PASS_NOT_MATCH Las contraseñas enviadas no coinciden
 * @apiErrorExample {json} Error PASS_NOT_MATCH
 *      {
 *          "error":"PASS_NOT_MATCH",
 *          "message":"Passwords not match"
 *      }
 */

/**
 * @apiDefine USERNAME_EXIST
 * @apiError (Errores) USERNAME_EXIST El valor del parámetro <code>username</code> ya existe
 * @apiErrorExample {json} Error USERNAME_EXIST
 *      {
 *          "error":"USERNAME_EXIST",
 *          "message":"Username already exist"
 *      }
 */

/**
 * @apiDefine FILE_NOT_DETECTED
 * @apiError (Errores) FILE_NOT_DETECTED No se ha detectado ningún archivo en la llamada
 * @apiErrorExample {json} Error FILE_NOT_DETECTED
 *      {
 *          "error":"FILE_NOT_DETECTED",
 *          "message":"No file detected"
 *      }
 */


/**
 * @apiDefine USER_NOT_INTERACT
 * @apiError (Errores) USER_CANNOT_INTERACT El usuario no puede interactuar con el caso
 * @apiErrorExample {json} Error USER_NOT_INTERACT
 *      {
 *          "error":"USER_CANNOT_INTERACT",
 *          "message":"You do not have necessary permission to interact with this thread."
 *      }
 */

/**
 * @apiDefine FOREIGN_OWNER
 * @apiError (Errores) FOREIGN_OWNER El elemento pertenece a otro usuario y es privado
 * @apiErrorExample {json} Error FOREIGN_OWNER
 *      {
 *          "error":"FOREIGN_OWNER",
 *          "message":"You do not have necessary permissions to change this element."
 *      }
 */

/**
 * @apiDefine UNMODIFIABLE_OFFER
 * @apiError (Errores) UNMODIFIABLE_OFFER El cliente ya eligió abogado y no se puede modificar/admitir ofertas
 * @apiErrorExample {json} Error UNMODIFIABLE_OFFER
 *      {
 *          "error":"UNMODIFIABLE_OFFER",
 *          "message":"You do not have necessary permissions to change this element."
 *      }
 */

/**
 * @apiDefine NEOUSER_NOT_FOUND
 * @apiError (Errores) NEOUSER_NOT_FOUND El Usuario que intenta hacer la llamada o el id del usuario proporcionado no existe en la base de datos de Neo4j
 * @apiErrorExample {json} Error NEOUSER_NOT_FOUND
 *      {
 *          "error":"NEOUSER_NOT_FOUND",
 *          "message":"NEOUSER_NOT_FOUND"
 *      }
 */

/**
 * @apiDefine NEOFILE_NOT_FOUND
 * @apiError (Errores) NEOFILE_NOT_FOUND El archivo que intenta obtener no existe
 * @apiErrorExample {json} Error NEOFILE_NOT_FOUND
 *      {
 *          "error":"NEOFILE_NOT_FOUND",
 *          "message":"NEOFILE_NOT_FOUND"
 *      }
 */

/**
 * @apiDefine MESSAGE_PERMISSION_DENIED
 * @apiError (Errores) MESSAGE_PERMISSION_DENIED El usuario no tiene permisos para enviar mensajes/archivos en el caso especificado
 * @apiErrorExample {json} Error 401 MESSAGE_PERMISSION_DENIED
 *      {
 *          "error":"MESSAGE_PERMISSION_DENIED",
 *          "message":"You do not have necessary permissions to send message on this thread."
 *      }
 */

/**
 * @apiDefine INVALID_RATING
 * @apiError (Errores) INVALID_RATING La valoración proporcionada para el caso es inválida
 * @apiErrorExample {json} Error 401 INVALID_RATING
 *      {
 *          "error":"INVALID_RATING",
 *          "message":"Invalid rating value: '7'. Accepted [0, 1, 2, 3, 4, 5].'"
 *      }
 */

/**
 * @apiDefine THREAD_NOT_FOUND
 * @apiError (Errores) THREAD_NOT_FOUND El caso no existe en la base de datos de Neo4j
 * @apiErrorExample {json} Error THREAD_NOT_FOUND
 *      {
 *          "error":"THREAD_NOT_FOUND",
 *          "message":"THREAD_NOT_FOUND"
 *      }
 */

/**
 * @apiDefine GROUP_NOT_FOUND
 * @apiError (Errores) GROUP_NOT_FOUND El grupo no existe en la base de datos de Neo4j
 * @apiErrorExample {json} Error GROUP_NOT_FOUND
 *      {
 *          "error":"GROUP_NOT_FOUND",
 *          "message":"GROUP_NOT_FOUND"
 *      }
 */

/**
 * @apiDefine ORG_NOT_FOUND
 * @apiError (Errores) ORG_NOT_FOUND La organización no existe en la base de datos de Neo4j
 * @apiErrorExample {json} Error ORG_NOT_FOUND
 *      {
 *          "error":"ORG_NOT_FOUND",
 *          "message":"ORG_NOT_FOUND"
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
 * @apiDefine INVALID_THREAD_STATUS
 * @apiError (Errores) INVALID_THREAD_STATUS El caso no permite un cambio de estado
 * @apiErrorExample {json} Error INVALID_THREAD_STATUS
 *      {
 *          "error":"INVALID_THREAD_STATUS",
 *          "message":"Thread is in 'ASSIGNED' status."
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
 * @apiDefine EMPLOYEE_GROUP_REQUIRED
 * @apiError (Errores) EMPLOYEE_PUBLISHED_GROUP_REQUIRED El usuario a asignar debe ser EMPLOYEE de uno de los grupos donde se publico el caso
 * @apiErrorExample {json} Error EMPLOYEE_PUBLISHED_GROUP_REQUIRED
 *      {
 *          "error":"EMPLOYEE_PUBLISHED_GROUP_REQUIRED",
 *          "message":"The assigned user should be a employee of the groups that published the case."
 *      }
 */

/**
 * @apiDefine EMPLOYEE_REQUIRED
 * @apiError (Errores) EMPLOYEE_REQUIRED El usuario debe ser EMPLOYEE del grupo donde se publicó el caso al que se intenta acceder
 * @apiErrorExample {json} Error EMPLOYEE_REQUIRED
 *      {
 *          "error":"EMPLOYEE_REQUIRED",
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
 * @apiSuccess {String} personName Nombre personal del usuario
 * @apiSuccess {String} email Dirección de correo electrónico
 * @apiSuccess {String} avatar URL del avatar del usuario
 * @apiSuccess {String} public_key Clave pública de la cuenta del usuario
 * @apiSuccess {String} [private_key] Clave privada de la cuenta del usuario
 * @apiSuccess {String} [password] Contraseña cifrada de la cuenta dle usuario
 * @apiSuccess {String} [salt] Datos extras usados para cifrar la contraseña
 * @apiSuccess {JSON} [rating] Calificación del usuario
 * @apiSuccess {JSONArray} [closed_threads] Lista de casos cerrados
 * @apiSuccess {JSON} [statistics] Estadísticas de la cuenta del usuario
 */

/**
 * @apiDefine OrgResponseParams
 * @apiSuccess {String} name Nombre de la organización
 * @apiSuccess {String="UNVERIFIED","WORKING","SUSPENDED"} status Estado actual de la organización
 * @apiSuccess {Number} latitude Latitud donde se encuentra la organización
 * @apiSuccess {Number} longitude Longitud donde se encuentra la organización
 * @apiSuccess {String} icon URL del icono de la organización
 * @apiSuccess {JSON} [application] Aplicación donde se encuentra registrada la organización
 * @apiSuccess {JSONArray} [managers] Lista de usuarios con permisos de Administración sobre la organización
 * @apiSuccess {JSON} [rating] Calificación del usuario
 * @apiSuccess {JSONArray} [closed_threads] Lista de casos cerrados
 * @apiSuccess {JSON} [statistics] Estadísticas de la cuenta del usuario
 * @apiSuccess {JSONArray} [groups] Lista de grupos de la organización
 */

/**
 * @apiDefine ThreadResponseParams
 * @apiSuccess {String} threadCode Lista de categorías del caso separadas por coma
 * @apiSuccess {String} subject Asunto descriptivo del caso
 * @apiSuccess {String="NEW","ASSIGNED","CLOSED","FORWARDED","CANCELED"} status Estado del caso
 * @apiSuccess {Number} limit_price Precio límite a pujar por el caso
 * @apiSuccess {String="EUR","BTC"} currency Moneda del valor de <code>limit_price</code>
 * @apiSuccess {Number{0-5}} rating Calificación del cliente sobre la labor del abogado en el caso.
 * @apiSuccess {JSON} sender Datos del creador del caso
 * @apiSuccess {JSONArray} destiny_groups Datos de los grupos donde se publicó el caso
 * @apiSuccess {String} [comment] Cometario calificativo del cliente sobre la labor del abogado en el caso.
 * @apiSuccess {Number} [closed_date] Fecha en la que se cerró el caso representada en millisegundos
 * @apiSuccess {JSON} [assignedUser] Datos del abogado elegido por el cliente
 * @apiSuccess {JSONArray} [offers] Datos de las pujas enviadas a este grupo
 */

/**
 * @apiDefine OfferResponseParams
 * @apiSuccess {String="SENT","PARTIAL_PAYMENT","TOTAL_PAYMENT","PAID_TO_LAWYER","DENIED"} status Estado de la puja
 * @apiSuccess {Number} lawyer_amount Honorarios del abogado representada en la unidad más baja de la moneda
 * @apiSuccess {Number} signal_amount Cantidad a pagar como señal de pago representado en la unidad más baja de la moneda
 * @apiSuccess {Number} rest_amount Cantidad restante a pagar después de la realizar el pago de la señal representada en la unidad más baja de la moneda
 * @apiSuccess {Number} total_amount Cantidad total que pagará el usuario representada en la unidad más baja de la moneda
 * @apiSuccess {Number{0-1}} bail Porcentaje de la señal de pago
 * @apiSuccess {String="EUR","BTC","FAIR","USD"} currency Moneda en la que se representan las cantidades
 * @apiSuccess {String="Bitcoin address","IBAN"} address Cuenta de cobro donde se le ingresarán al abogado sus honorarios
 * @apiSuccess {JSON} thread Datos del caso donde se envió la puja
 * @apiSuccess {JSON} bidder Datos del del usuario que creo la puja
 * @apiSuccess {String} [bic_swift] Código BIC o SWIFT del banco donde se ingresarán los honoroarios del abogado. Sólo necesario si se proporciona en <code>address</code> una cuenta tipo <code>IBAN</code>
 * @apiSuccess {String} [beneficiary] Nombre del beneficiary de la cuenta a recibir los honorarios
 */

/**
 * @apiDefine MessageResponseParams
 * @apiSuccess {Number} thread_id ID del caso donde se enviará el mensaje
 * @apiSuccess {String} senderMessage Versión del mensaje para emisor
 * @apiSuccess {String} middleMessage Versión del mensaje para el caso
 * @apiSuccess {String} destinyMessage Versión del mensaje para el receptor
 * @apiSuccess {String} contentType MIMEType del contenido del mensaje
 * @apiSuccess {String} messageHash Hash SHA256 del mensaje
 * @apiSuccess {JSON} sender Datos del emisor
 * @apiSuccess {JSON} thread Datos del caso donde se envió el mensaje
 */

/**
 * @apiDefine GroupResponseParams
 * @apiSuccess {String} name Nombre del grupo
 * @apiSuccess {String="PUBLIC","PRIVATE","INTERNAL"} accessibility Accesibilidad del grupo
 * @apiSuccess {String="CITIZEN","EMPLOYEE","MANAGER"} [role] Permisos del usuario sobre el grupo
 * @apiSuccess {JSON} [fatherGroup] Datos del grupo padre
 * @apiSuccess {JSON} [organization] Datos de la organización a la que pertenece el grupo
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
 *          "updated": 1478615766046,
 *          "identifier": "Usr5821e2d609ec5",
 *          "username": "User5821e2d5909c8",
 *          "personName": "User5821e2d5909c8",
 *          "email": "User5821e2d5909c8@soldier.lawyer",
 *          "avatar": "https://localhost:8000/avatar_m.png",
 *          "publicKey": "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsp7SEsyl . . .",
 *          "privateKey": "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC . . .",
 *          "password": "en6",
 *          "salt": "4ozzjckhprmsk0ggko0w8w8okk8s8og"
 *          "rating": {
 *              "score": 5,
 *              "total": 2,
 *              "rating": 2.5,
 *           }
 *      }
 */

/**
 * @apiDefine ThreadResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 83,
 *          "created": 1478559051423,
 *          "updated": 1478559051622,
 *          "identifier": "Thr5821054b675bd",
 *          "threadCode": "PAGOS, BANCO, TPV",
 *          "subject": "Prueba pagos",
 *          "status": "NEW",
 *          "currency": "EUR",
 *          "rating": 0,
 *          "longitude": -0.3753877,
 *          "latitude": 43.454545,
 *          "sender": { . . . },
 *          "assignedUser": { . . . },
 *          "destiny_groups": [
 *              { . . . },
 *          ],
 *          "offers": [
 *              { . . . },
 *          ]
 *      }
 */

/**
 * @apiDefine ThreadResponseList
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *             "id": 83,
 *              "created": 1478559051423,
 *              "updated": 1478559051622,
 *              "identifier": "Thr5821054b675bd",
 *              "threadCode": "PAGOS, BANCO, TPV",
 *              "subject": "Prueba pagos",
 *              "status": "NEW",
 *              "currency": "EUR",
 *              "rating": 0,
 *              "longitude": -0.3753877,
 *              "latitude": 43.454545,
 *              "sender": { . . . },
 *              "assignedUser": { . . . },
 *              "destiny_groups": [
 *                  { . . . },
 *              ],
 *              "offers": [
 *                  { . . . },
 *              ]
 *          },
 *          { . . . },
 *      ]
 */

/**
 * @apiDefine ThreadAssignedResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 83,
 *          "created": 1478559051423,
 *          "updated": 1478559051622,
 *          "identifier": "Thr5821054b675bd",
 *          "threadCode": "PAGOS, BANCO, TPV",
 *          "subject": "Prueba pagos",
 *          "status": "ASSIGNED",
 *          "currency": "EUR",
 *          "rating": 0,
 *          "longitude": -0.3753877,
 *          "latitude": 43.454545,
 *          "sender": { . . . }
 *          "assignedUser": { . . . }
 *          "destiny_groups": [
 *              { . . . }
 *          ]
 *      }
 */

/**
 * @apiDefine OfferResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 84,
 *          "identifier": "Off5821086470e74",
 *          "created": 1478559844462,
 *          "updated": 1478559844462,
 *          "status": "SENT",
 *          "lawyer_amount": "100",
 *          "signal_amount": 41,
 *          "rest_amount": 64,
 *          "total_amount": 105,
 *          "bail": "0.36",
 *          "currency": "EUR",
 *          "address": "ES58 2038 6318 2130 0071 0472",
 *          "thread": { . . . }
 *          "bidder": { . . . }
 *       }
 */

/**
 * @apiDefine OfferResponseList
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      [
 *        {
 *              "id": 84,
 *              "identifier": "Off5821086470e74",
 *              "created": 1478559844462,
 *              "updated": 1478559844462,
 *              "status": "SENT",
 *              "lawyer_amount": "100",
 *              "signal_amount": 41,
 *              "rest_amount": 64,
 *              "total_amount": 105,
 *              "bail": "0.36",
 *              "currency": "EUR",
 *              "address": "ES58 2038 6318 2130 0071 0472",
 *              "thread": { . . . }
 *              "bidder": { . . . }
 *           },
 *          {
 *              . . .
 *          }
 *      ]
 */

/**
 * @apiDefine MessageResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 85,
 *          "identifier": "Msg58211a730d939",
 *          "created": 1478559844462,
 *          "updated": 1478559844462,
 *          "contentType": "text/plain",
 *          "senderMessage": "Como está",
 *          "middleMessage": "Como está",
 *          "destinyMessage": "Como está",
 *          "messageHash": "6258565A5B56E6F266D89",
 *          "sender": { . . . }
 *          "thread": { . . . }
 *       }
 */

/**
 * @apiDefine MessageResponseList
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *              "id": 85,
 *              "identifier": "Msg58211a730d939",
 *              "created": 1478559844462,
 *              "updated": 1478559844462,
 *              "contentType": "text/plain",
 *              "senderMessage": "Como está",
 *              "middleMessage": "Como está",
 *              "destinyMessage": "Como está",
 *              "messageHash": "6258565A5B56E6F266D89",
 *              "sender": { . . . }
 *              "thread": { . . . }
 *          },
 *          { . . . },
 *      ]
 */

/**
 * @apiDefine FileResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 85,
 *          "identifier": "Msg58211a730d939",
 *          "created": 1478559844462,
 *          "updated": 1478559844462,
 *          "contentType": "text/plain",
 *          "senderMessage": "archive.txt:4:5",
 *          "middleMessage": "archive.txt:4:5",
 *          "destinyMessage": "archive.txt:4:5",
 *          "messageHash": "6258565A5B56E6F266D89",
 *          "sender": { . . . }
 *          "thread": { . . . }
 *       }
 */

/**
 * @apiDefine GroupResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 11,
 *          "created": 1468510803672,
 *          "updated": 1468510803672,
 *          "identifier": "Grp5787b253a423c",
 *          "name": "Spain Directive",
 *          "accessibility": "PUBLIC",
 *          "fatherGroup": { . . . }
 *          "organization": { . . . }
 *      }
 */

/**
 * @apiDefine GroupResponseList
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      [
 *          {
 *              "id": 11,
 *              "created": 1468510803672,
 *              "updated": 1468510803672,
 *              "identifier": "Grp5787b253a423c",
 *              "name": "Spain Directive",
 *              "accessibility": "PUBLIC",
 *              "fatherGroup": { . . . }
 *              "organization": { . . . }
 *          },
 *          { . . .},
 *      ]
 */

/**
 * @apiDefine OrgResponse
 * @apiSuccessExample {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "id": 87,
 *          "created": 1478624453922,
 *          "updated": 1478624453973,
 *          "identifier": "Org582204c5e10ac",
 *          "name": "BitExchange.tk",
 *          "status": "WORKING",
 *          "latitude": "0.005",
 *          "longitude": "0.255",
 *          "icon": "https://localhost:8000/files/582204c5e111a.png",
 *          "application": { . . . },
 *          "managers": [
 *              { . . . }
 *          ],
 *          "closed_threads": [
 *              { . . . }
 *          ],
 *          "statistics": {
 *              "average_price_eur": 0,
 *              "average_price_btc": 0,
 *              "total_offers": 0,
 *              "closed_threads": 0,
 *              "open_threads": 0
 *          },
 *          "rating": {
 *              "score": 0,
 *              "total": 0,
 *              "rating": 0
 *          }
 *      },
 */