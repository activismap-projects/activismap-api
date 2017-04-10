<?php
include('BaseDocumentation.php');

/**
 * @api {post} /v1/company CreateCompany
 * @apiVersion 1.0.0
 * @apiGroup Company
 * @apiName CreateCompany
 * @apiDescription Crear una compañía
 * @apiParam {String} name Nombre de la compáñia
 * @apiParam {String} email Dirección de emaild e la compañía
 * @apiParam {File-String} [logo] Imagen promocional del evento, o en su defecto una URL.
 * @apiParam {String} [logo64] Imagen promocional del evento en base64
 * @apiParam {String} [logo_name] Nombre de la imagen de la compañía. Obligatorio si se especifica el parámetro <code>logo64</code>
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse CompanyResponseParams
 * @apiUse CompanyResponse
 * @apiUse USER_NOT_FOUND
 * @apiUse PARAM_REQUIRED
 * @apiUse REGISTERED_EMAIL
 */

/**
 * @api {post} /v1/company/:id UpdateCompany
 * @apiVersion 1.0.0
 * @apiGroup Company
 * @apiName UpdateCompany
 * @apiDescription Modificar una compañía
 * @apiParam {String} [name] Nombre de la compáñia
 * @apiParam {String} [email] Dirección de emaild e la compañía
 * @apiParam {File-String} [logo] Imagen promocional del evento, o en su defecto una URL.
 * @apiParam {String} [logo64] Imagen promocional del evento en base64
 * @apiParam {String} [logo_name] Nombre de la imagen de la compañía. Obligatorio si se especifica el parámetro <code>logo64</code>
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse CompanyResponseParams
 * @apiUse CompanyResponse
 * @apiUse USER_NOT_FOUND
 * @apiUse COMPANY_NOT_FOUND
 * @apiUse PARAM_REQUIRED
 * @apiUse SUPER_ADMIN_REQUIRED
 */

/**
 * @api {delete} /v1/company/:id DeleteCompany
 * @apiVersion 1.0.0
 * @apiGroup Company
 * @apiName DeleteCompany
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiDescription Eliminar una compñía
 * @apiUse DeleteResponse
 * @apiUse USER_NOT_FOUND
 * @apiUse COMPANY_NOT_FOUND
 * @apiUse PARAM_REQUIRED
 * @apiUse SUPER_ADMIN_REQUIRED
 */

/**
 * @api {get} /v1/company/:id/events CompanyEvents
 * @apiVersion 1.0.0
 * @apiGroup Company
 * @apiName CompanyEvents
 * @apiParam {Number} [limit="20"] Número límite de evnetos a devolver.
 * @apiParam {Number} [offset="0"] Índice del primer evento a devolver.
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiDescription Lista de eventos gestionados por una compañía
 * @apiUse BaseResponseParams
 * @apiUse EventResponseParams
 * @apiUse EventResponseList
 * @apiUse COMPANY_NOT_FOUND
 */

/**
 * @api {get} /v1/company/:id/events CompanyUsers
 * @apiVersion 1.0.0
 * @apiGroup Company
 * @apiName CompanyUsers
 * @apiParam {Number} [limit="20"] Número límite de usuarios a devolver.
 * @apiParam {Number} [offset="0"] Índice del primer usuarios a devolver.
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiDescription Lista de usuarios relacionadps con una compañía
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse UserResponseList
 * @apiUse COMPANY_NOT_FOUND
 */