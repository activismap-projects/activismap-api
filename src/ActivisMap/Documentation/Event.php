<?php
include('BaseDocumentation.php');

/**
 * @api {post} /v1/event/ CreateEvent
 * @apiVersion 1.0.0
 * @apiGroup Event
 * @apiName CreateEvent
 * @apiDescription Crear un evento
 * @apiParam {String} title Título del evento
 * @apiParam {String} description Descripción del evento
 * @apiParam {Number} start_date Fecha de inicio del evento representada en milisegundos
 * @apiParam {Number} start_date Fecha de finalización del representada en milisegundos
 * @apiParam {Number} lat Latitud donde se ubicará el evento
 * @apiParam {Number} lon Longitud donde se ubicará el evento
 * @apiParam {String} categories Categorías del evento separadas por coma
 * @apiParam {String} type Tipo del evento.
 * @apiParam {Number} company_id Id de la compñía a cargo dle evento
 * @apiParam {File-String} [image] Imagen promocional del evento, o en su defecto una URL.
 * @apiParam {String} [image64] Imagen promocional del evento en base64
 * @apiParam {String} [image_name] Nombre de la imagen promocional del evento. Obligatorio si se especifica el parámetro <code>image64</code>
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse EventResponseParams
 * @apiUse EventResponse
 * @apiUse USER_NOT_FOUND
 * @apiUse PARAM_REQUIRED
 * @apiUse COMPANY_NOT_FOUND
 * @apiUse PUBLISHER_REQUIRED
 */

/**
 * @api {post} /v1/event/:id UpdateEvent
 * @apiVersion 1.0.0
 * @apiGroup Event
 * @apiName UpdateEvent
 * @apiDescription Modificar un evento
 * @apiParam {String} [title] Título del evento
 * @apiParam {String} [description] Descripción del evento
 * @apiParam {Number} [start_date] Fecha de inicio del evento representada en milisegundos
 * @apiParam {Number} [start_date] Fecha de finalización del representada en milisegundos
 * @apiParam {Number} [lat] Latitud donde se ubicará el evento
 * @apiParam {Number} [lon] Longitud donde se ubicará el evento
 * @apiParam {String} [categories] Categorías del evento separadas por coma
 * @apiParam {String} [type] Tipo del evento.
 * @apiParam {File-String} [image] Imagen promocional del evento, o en su defecto una URL.
 * @apiParam {String} [image64] Imagen promocional del evento en base64
 * @apiParam {String} [image_name] Nombre de la imagen promocional del evento. Obligatorio si se especifica el parámetro <code>image64</code>
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse EventResponseParams
 * @apiUse EventResponse
 * @apiUse USER_NOT_FOUND
 * @apiUse PARAM_REQUIRED
 * @apiUse PUBLISHER_REQUIRED
 */

/**
 * @api {delete} /v1/event/:id DeleteEvent
 * @apiVersion 1.0.0
 * @apiGroup Event
 * @apiName DeleteEvent
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiDescription Modificar un evento
 * @apiUse DeleteResponse
 * @apiUse USER_NOT_FOUND
 * @apiUse PARAM_REQUIRED
 * @apiUse PUBLISHER_REQUIRED
 */

/**
 * @api {post} /v1/event/:id/addComment AddComment
 * @apiVersion 1.0.0
 * @apiGroup Event
 * @apiName AddComment
 * @apiParam {String} comment Texto del comentario a añadir.
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiDescription Añadir un comentario a un evento
 * @apiUse BaseResponseParams
 * @apiUse CommentResponseParams
 * @apiUse CommentResponse
 * @apiUse USER_NOT_FOUND
 * @apiUse PARAM_REQUIRED
 * @apiUse PUBLISHER_REQUIRED
 */