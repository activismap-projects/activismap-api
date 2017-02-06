<?
include('BaseDocumentation.php');

/**
 * @api {post} /api/v1/public/app/register RegisterUser
 * @apiVersion 1.0.0
 * @apiGroup Public
 * @apiName RegisterUser
 * @apiDescription Crear un nuevo Usuario
 * @apiParam {String} password Contraseña de la cuenta
 * @apiParam {String="password"} repassword Comprobación de la contraseña de la cuenta
 * @apiParam {String} [username="RandomUsername"] Nombre de usuario para la cuenta
 * @apiParam {String} [person_name="username"] Nombre personal del usuario
 * @apiParam {String} [public_key="RandomRSAPublicKey"] Clave pública del usuario
 * @apiParam {String} [private_key="RandomRSAPrivateKey"] Clave privada del usuario
 * @apiUse BaseResponseParams
 * @apiUse UserResponseParams
 * @apiUse PARAM_REQUIRED
 * @apiUse PASS_NOT_MATCH
 * @apiUse USERNAME_EXIST
 * @apiUse UserResponse
 */

/**
 * @api {get} /api/v1/public/app/:id/groups OrganizationGroups
 * @apiVersion 1.0.0
 * @apiGroup Public
 * @apiName OrganizationGroups
 * @apiDescription Lista de grupos con <code>accesibility="PUBLIC"</code> de una organización
 * @apiUse BaseResponseParams
 * @apiUse GroupResponseParams
 * @apiUse ORG_NOT_FOUND
 * @apiUse GroupResponseList
 */

/**
 * @api {get} /api/v1/public/app/search OrganizationSearch
 * @apiVersion 1.0.0
 * @apiGroup Public
 * @apiName OrganizationSearch
 * @apiParam {String} [search="''"] Cadena de texto a coincidir con el nombre de las organizaciones
 * @apiParam {Number} [offset=1] Indice de la búsqueda limitado por el valor <code>limit</code>
 * @apiParam {Number} [limit=20] Límite de elementos a devolver
 * @apiParam {Number} [lat] Latitud de buúsqueda de los resultados
 * @apiParam {Number} [lon] Longitud de buúsqueda de los resultados
 * @apiParam {Number} [ratio] Radio de distacia en metros para realizar la búsqueda. Si <code>lat</code> o <code>lon</code> no son proporcionados, <code>ratio</code> será ignorado.
 * @apiDescription Busca organizaciones que incluyan el valor de <code>search</code> en su nombre y filtrada por los demás parámetros
 * @apiSuccess {JSONArray} data Resultados de la búsqueda
 * @apiSuccess {Number} count Número de resultados devueltos
 * @apiSuccess {Number} limit Número límite de resultados
 * @apiSuccess {Number} offset Indice de la búsqueda
 * @apiSuccessExample  {json} Success-Response
 *      HTTP/1.1 200 OK
 *      {
 *          "data": [
 *              {
 *                  "id": 87,
 *                  "created": 1478624453922,
 *                  "updated": 1478624453973,
 *                  "identifier": "Org582204c5e10ac",
 *                  "name": "BitExchange.tk",
 *                  "status": "WORKING",
 *                  "latitude": "0.005",
 *                  "longitude": "0.255",
 *                  "icon": "https://localhost:8000/files/582204c5e111a.png",
 *                  "application": { . . . },
 *                  "managers": { . . . },
 *                  "groups": { . . . },
 *                  "rating": {
 *                      "score": 5,
 *                      "total": 2,
 *                      "rating": 2.5,
 *                  }
 *              },
 *              { . . . }
 *          ],
 *          "count":1
 *          "limit":20
 *          "offset":1
 *      }
 */