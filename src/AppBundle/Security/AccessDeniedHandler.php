<?php
/**
 * Created by PhpStorm.
 * User: yboucher2018
 * Date: 26/03/2019
 * Time: 10:13
 */

namespace AppBundle\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    /**
     * Handles an access denied failure.
     *
     * @return Response may return null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $message = "<h1 style='color: red'>Désolé, vous n'avez pas accès à cette partie du site</h1>";

        return new Response($message, 403);
    }
}