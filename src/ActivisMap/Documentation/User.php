<?php
include('BaseDocumentation.php');

/**
 * @api {get} /api/v1/user ReadUser
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName ReadUser
 * @apiDescription Datos de la cuenta del usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse UserResponse
 */

/**
 * @api {post} /api/v1/user UpdateUser
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
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse INVALID_PASSWORD
 * @apiUse UserResponse
 */

/**
 * @api {get} /api/v1/user/getUser/:id ReadAnotherUser
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName ReadAnotherUser
 * @apiDescription Leer datos de la cuenta de un usuario en concreto
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse UserResponse
 */

/**
 * @api {get} /api/v1/user/organization/:id OrganizationStatistics
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName OrganizationStatistics
 * @apiDescription Obtener datos de una organizacion con sus estadísticas
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse OrgResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse OrgResponse
 */

/**
 * @api {get} /api/v1/user/getManagedOrganizations ManagedOrganizations
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName ManagedOrganizations
 * @apiDescription Datos de las organizaciones administradas por el usuario
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse OrgResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse OrgResponse
 */

/**
 * @api {post} /api/v1/user/setActiveGroup SetActiveGroup
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName SetActiveGroup
 * @apiDescription Cambiar grupo activo
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiParam {Number} group_id ID del grupo que se va a activar
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse EMPLOYEE_REQUIRED
 * @apiUse UserResponse
 */

/**
 * @api {get} /api/v1/user/getGroupOrganizationList GroupList
 * @apiVersion 1.0.0
 * @apiGroup User
 * @apiName GroupList
 * @apiDescription Lista de grupos donde el usuario tiene acceso, separado por organización
 * @apiHeader {String="Bearer access_token"} Authorization The bearer <code>access_token</code>.
 * @apiUse BaseResponseParams
 * @apiUse OrgResponseParams
 * @apiUse INVALID_CREDENTIALS
 * @apiUse NEOUSER_NOT_FOUND
 * @apiUse OrgResponse
 */