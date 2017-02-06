<?
include('BaseDocumentation.php');

/**
 * @api {post} /v1/public/register RegisterUser
 * @apiVersion 1.0.0
 * @apiGroup Public
 * @apiName RegisterUser
 * @apiDescription Registro de un usuario
 * @apiParam {String} password Contraseña de la cuenta
 * @apiParam {String} username Nombre de usuario para la cuenta
 * @apiParam {String} email Dirección de correo electrónico
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse PARAM_REQUIRED
 * @apiUse REGISTERED_USERNAME
 * @apiUse REGISTERED_EMAIL
 * @apiUse UserResponse
 */

/**
 * @api {get} /v1/public/search EventList
 * @apiVersion 1.0.0
 * @apiGroup Public
 * @apiName EventList
 * @apiDescription Búsqueda de eventos
 * @apiParam {String} [type] Tipo de evento a buscar
 * @apiParam {String} [category] Categoría de evento a buscar
 * @apiParam {String} [start_date="CURRENT_DATE"] Fecha de mínima de inicio del evento a buscar representada en milisegundos.
 * @apiParam {String} [end_date="3MONTHS_FORWARD"] Fecha de máxima de fin del evento a buscar representada en milisegundos.
 * @apiParam {Number} [limit="20"] Límite de eventos a devolver.
 * @apiParam {Number} [offset="0"] Indice del primer evento a devolver.
 * @apiParam {String} [area=] Aŕea donde se realizará la busqueda. Formato: <code>latitude,longitude@latitude,longitude</code>.
 * @apiUse BaseResponseParams
 * @apiUse EventResponseParams
 * @apiUse EventResponseList
 */

/**
 * @api {get} /v1/public/event/:id EventAction
 * @apiVersion 1.0.0
 * @apiGroup Public
 * @apiName EventAction
 * @apiParam {String="LIKE", "DISLIKE", "NEUTRAL", "SUBSCRIBE", "UNSUBSCRIBE"} action Tipo de acción a relaizar sobre el evento
 * @apiDescription Actualiza los datos del evento según la acción emitida
 * @apiUse EventResponseParams
 * @apiUse EventResponse
 */

/**
 * @api {post} /v1/public/:id/addComment AnonymousComment
 * @apiVersion 1.0.0
 * @apiGroup Public
 * @apiName AnonymousComment
 * @apiParam {String} comment Texto del comentario a añadir.
 * @apiDescription Añadir un comentario a un evento
 * @apiUse BaseResponseParams
 * @apiUse CommentResponseParams
 * @apiUse CommentResponse
 * @apiUse PARAM_REQUIRED
 * @apiUse PUBLISHER_REQUIRED
 */