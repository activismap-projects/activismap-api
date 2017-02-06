<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 4/11/16
 * Time: 16:48
 */

namespace ActivisMap\Error;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface {

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException',
            KernelEvents::RESPONSE => 'onResponse',
        );
    }

    public function onKernelException(GetResponseForExceptionEvent $event) {

        $e = $event->getException();
        if (!$e instanceof ApiException) {
            return;
        }

        $response = new JsonResponse($e->getData(), $e->getHttpCode());

        $event->setResponse($response);
    }

    public function onResponse(FilterResponseEvent $event) {
        $e = $event->getResponse();
        $content = $e->getContent();
        $content = json_decode($content, true);

        if (array_key_exists('error_description', $content)) {
            $desc = strtolower($content['error_description']);
            if (strpos($desc, 'invalid username and password') !== false) {
                throw new ApiException(ApiError::INVALID_LOGIN, 'Invalid username or password.', 401);
            } else if (strpos($desc, 'access token provided is invalid') !== false) {
                throw new ApiException(ApiError::INVALID_CREDENTIALS, 'Invalid AccessToken.', 401);
            } else if (strpos($desc, 'access token provided has expired') !== false) {
                throw new ApiException(ApiError::INVALID_CREDENTIALS, 'Invalid AccessToken.', 401);
            } else if (strpos($desc, 'client credentials are invalid') !== false) {
                throw new ApiException(ApiError::INVALID_CLIENT, 'Client not authorized.', 401);
            } else if (strpos($desc, 'client id was not found') !== false) {
                throw new ApiException(ApiError::INVALID_CLIENT, 'Client not authorized.', 401);
            } else if (strpos($desc, 'invalid grant_type parameter') !== false) {
                throw new ApiException(ApiError::INVALID_GRANT_TYPE, 'Invalid grant_type parameter.');
            } else if (strpos($desc, 'refresh token has expired') !== false) {
                throw new ApiException(ApiError::INVALID_REFRESH_TOKEN, 'RefreshToken is expired or invalid.');
            } else if (strpos($desc, 'invalid refresh token') !== false) {
                throw new ApiException(ApiError::INVALID_REFRESH_TOKEN, 'RefreshToken is expired or invalid.');
            }
        }
    }

}