<?php

include('BaseDocumentation.php');

/**
 * @api {post} /api/v1/messaging/addThread AddThread
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName AddThread
 * @apiDescription Crear un nuevo caso
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {String} subject Explicación breve del caso
 * @apiParam {String} thread_code Cadena de texto con las categorías o tags para clasificar el caso separadas por coma
 * @apiParam {Number} latitude Latitud donde se encuentra el caso
 * @apiParam {Number} longitude Longitud donde se encuentra el caso
 * @apiParam {String[]} [destiny_group_id="ALL"] Identificadores de los grupos donde se va a publicar el caso
 * @apiParam {Number} [limit_price="0"] Precio límite para pujar por este caso
 * @apiParam {String="EUR","BTC"} [currency="EUR"] Moneda del precio límite
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse PARAM_REQUIRED
 * @apiUse ThreadResponse
 */

/**
 * @api {post} /api/v1/messaging/addOffer AddOffer
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName AddOffer
 * @apiDescription Enviar una pujar para un caso específico
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} thread_id ID del caso donde se va a pujar
 * @apiParam {Number} amount Cantidad de dinero que se va a pujar representada en la unidad más baja de la moneda
 * @apiParam {String="EUR","BTC","FAIR","USD"} currency Moneda usada para representar el <code>amount</code> y para realizar los pagos
 * @apiParam {Number{0-1}} bail Porcentaje que se debe de cobrar como señal de pago
 * @apiParam {String="Bitcoin address","IBAN"} address Cuenta de cobro donde se le ingresarán al abogado sus honorarios
 * @apiParam {String} [bic_swift] Código BIC o SWIFT del banco donde se ingresarán los honoroarios del abogado. Sólo necesario si se proporciona en <code>address</code> una cuenta tipo <code>IBAN</code>
 * @apiParam {String} [beneficiary] Nombre del beneficiary de la cuenta a recibir los honorarios
 * @apiUse BaseResponseParams
 * @apiUse OfferResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse PARAM_REQUIRED
 * @apiUse USER_NOT_INTERACT
 * @apiUse THREAD_NOT_FOUND
 * @apiUse OfferResponse
 */

/**
 * @api {get} /api/v1/messaging/getOffers/:id GetThreadOffers
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetThreadOffers
 * @apiDescription Consultar las pujas de un caso en concreto
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse OfferResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse THREAD_NOT_FOUND
 * @apiUse OfferResponseList
 */

/**
 * @api {post} /api/v1/messaging/modifyOffer/:id ModifyOffer
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName ModifyOffer
 * @apiDescription Modificar valores de una puja
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} [amount] Cantidad de dinero que se va a pujar representada en la unidad más baja de la moneda
 * @apiParam {String="EUR","BTC","FAIR","USD"} [currency] Moneda usada para representar el <code>amount</code> y para realizar los pagos
 * @apiParam {Number{0-1}} [bail] Porcentaje que se debe de cobrar como señal de pago
 * @apiParam {String="Bitcoin address","IBAN"} [address] Cuenta de cobro donde se le ingresarán al abogado sus honorarios
 * @apiParam {String} [bic_swift] Código BIC o SWIFT del banco donde se ingresarán los honoroarios del abogado. Sólo necesario si se proporciona en <code>address</code> una cuenta tipo <code>IBAN</code>
 * @apiParam {String} [beneficiary] Nombre del beneficiary de la cuenta a recibir los honorarios
 * @apiUse BaseResponseParams
 * @apiSuccess {String="SENT","PARTIAL_PAYMENT","TOTAL_PAYMENT","PAID_TO_LAWYER","DENIED"} status Estado de la puja
 * @apiSuccess {Number} lawyer_amount Honorarios del abogado representada en la unidad más baja de la moneda
 * @apiSuccess {Number} signal_amount Cantidad a pagar como señal de pago representado en la unidad más baja de la moneda
 * @apiSuccess {Number} rest_amount Cantidad restante a pagar después de la realizar el pago de la señal representada en la unidad más baja de la moneda
 * @apiSuccess {Number} total_amount Cantidad total que pagará el usuario representada en la unidad más baja de la moneda
 * @apiSuccess {Number{0-1}} bail Porcentaje de la señal de pago
 * @apiSuccess {String="EUR","BTC","FAIR","USD"} currency Moneda en la que se representan las cantidades
 * @apiSuccess {String="Bitcoin address","IBAN"} address Cuenta de cobro donde se le ingresarán al abogado sus honorarios
 * @apiSuccess {String} [bic_swift] Código BIC o SWIFT del banco donde se ingresarán los honoroarios del abogado. Sólo necesario si se proporciona en <code>address</code> una cuenta tipo <code>IBAN</code>
 * @apiSuccess {String} [beneficiary] Nombre del beneficiary de la cuenta a recibir los honorarios
 * @apiUse INVALID_CREDENTIALS
 * @apiUse FOREIGN_OWNER
 * @apiUse UNMODIFIABLE_OFFER
 * @apiUse OfferResponse
 */

/**
 * @api {post} /api/v1/messaging/addMessage AddMessage
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName AddMessage
 * @apiDescription Enviar un mensaje
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} thread_id ID del caso donde se enviará el mensaje
 * @apiParam {String} sender_message Versión del mensaje para emisor
 * @apiParam {String} middle_message Versión del mensaje para el caso
 * @apiParam {String} destiny_message Versión del mensaje para el receptor
 * @apiParam {String} content_type MIMEType del contenido del mensaje
 * @apiParam {String} message_hash Hash SHA256 del mensaje
 * @apiUse BaseResponseParams
 * @apiUse MessageResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse PARAM_REQUIRED
 * @apiUse MESSAGE_PERMISSION_DENIED
 * @apiUse USER_NOT_INTERACT
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse THREAD_NOT_FOUND
 * @apiUse MessageResponse
 */

/**
 * @api {post} /api/v1/messaging/addFile AddFile
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName AddFile
 * @apiDescription Enviar un archivo
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} thread_id ID del caso donde se enviará el archivo
 * @apiParam {String} file_hash Hash SHA512 del archivo
 * @apiParam {File{..10000}} [file] Archivo a enviar. Parámetro obligatorio si <code>file64</code> no se especifica.
 * @apiParam {Base64{..10000}} [file64] Archivo a enviar. Parámetro obligatorio si <code>file</code> no se especifica.
 * @apiParam {String} [file_name] Parámetro obligatorio si se especifica <code>file64</code>.
 * @apiUse BaseResponseParams
 * @apiSuccess {Number} thread_id ID del caso donde se enviará el archivo
 * @apiSuccess {String} senderMessage Versión del archivo para emisor
 * @apiSuccess {String} middleMessage Versión del archivo para el caso
 * @apiSuccess {String} destinyMessage Versión del archivo para el receptor
 * @apiSuccess {String} contentType MIMEType del contenido del archivo
 * @apiSuccess {String} messageHash Hash SHA512 del archivo
 * @apiSuccess {JSON} sender Datos del emisor
 * @apiSuccess {JSON} thread Datos del caso donde se envió el mensaje
 * @apiUse INVALID_CREDENTIALS
 * @apiUse PARAM_REQUIRED
 * @apiUse FILE_NOT_DETECTED
 * @apiUse MESSAGE_PERMISSION_DENIED
 * @apiUse USER_NOT_INTERACT
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse THREAD_NOT_FOUND
 * @apiUse FileResponse
 */

/**
 * @api {post} /api/v1/messaging/assignThread AssignThread
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName AssignThread
 * @apiDescription Asignar un abogado a un caso
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} thread_id ID del caso donde se va a asignar el abogado
 * @apiParam {Number} assign_user_id ID del abogado que se asignará al caso
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse INVALID_THREAD_STATUS
 * @apiUse EMPLOYEE_GROUP_REQUIRED
 * @apiUse ThreadAssignedResponse
 */

/**
 * @api {post} /api/v1/messaging/cancelThread CancelThread
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName CancelThread
 * @apiDescription Cancelar un caso
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} thread_id ID del caso donde se enviará el archivo
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse PARAM_REQUIRED
 * @apiUse FOREIGN_OWNER
 * @apiUse USER_NOT_INTERACT
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse THREAD_NOT_FOUND
 * @apiUse ThreadResponse
 */

/**
 * @api {post} /api/v1/messaging/closeThread CloseThread
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName CloseThread
 * @apiDescription Cerrar un caso
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} thread_id ID del caso donde se enviará el archivo
 * @apiParam {Number{0-5}} rating Calificación del usuario sobre la labor del anogado en este caso
 * @apiParam {String} comment Comentario del usuario sobre la labor del abogado en este caso
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse PARAM_REQUIRED
 * @apiUse FOREIGN_OWNER
 * @apiUse USER_NOT_INTERACT
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse THREAD_NOT_FOUND
 * @apiUse ThreadResponse
 */

/**
 * @api {get} /api/v1/messaging/getThreadInfo/:id GetThreadInfo
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetThreadInfo
 * @apiDescription Consultar datos completos de un caso
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse THREAD_NOT_FOUND
 * @apiUse USER_NOT_INTERACT
 * @apiUse ThreadResponse
 */

/**
 * @api {get} /api/v1/messaging/getCreatedUserThreads GetUserCreatedThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetUserCreatedThreads
 * @apiDescription Consultar la lista de casos creados por el usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getAssignedUserThreads GetUserAssignedThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetUserAssignedThreads
 * @apiDescription Consultar la lista de casos que se le han asignado al usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getOpenUserThreads GetUserOpenThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetUserOpenThreads
 * @apiDescription Consultar la lista de casos en curso publicados por un usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getClosedUserThreads GetUserClosedThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetUserClosedThreads
 * @apiDescription Consultar la lista de casos cerrados publicados de un usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getAllGroupsPendingThreads GetAllGroupsPendingThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetAllGroupsPendingThreads
 * @apiDescription Consultar la lista de casos pendientes de todos los grupos donde el usuario tiene acceso.
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getPendingThreads/:id GetGroupPendingThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetGroupPendingThreads
 * @apiDescription Consultar la lista de casos pendientes de un grupo en concreto
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse GROUP_NOT_FOUND
 * @apiUse EMPLOYEE_REQUIRED
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getAllUserThreads GetAllUserThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetAllUserThreads
 * @apiDescription Consultar la lista de todos los casos donde el usuario tiene algún tipo de relación
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getAllGroupThreads GetAllGroupThreads
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetAllGroupThreads
 * @apiDescription Consultar la lista de todos los casos donde el usuario tiene acceso
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse ThreadResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse ThreadResponseList
 */

/**
 * @api {get} /api/v1/messaging/getThreadMessages/:id GetThreadMessages
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetThreadMessages
 * @apiDescription Consultar los mensajes de un caso en concreto
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse MessageResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse THREAD_NOT_FOUND
 * @apiUse USER_NOT_INTERACT
 * @apiUse MessageResponseList
 */

/**
 * @api {get} /api/v1/messaging/getOffers GetOffers
 * @apiVersion 1.0.0
 * @apiGroup Messaging
 * @apiName GetOffers
 * @apiDescription Consultar la lista de todos las pujas enviadas y recibidas de un usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse OfferResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse OfferResponseList
 */