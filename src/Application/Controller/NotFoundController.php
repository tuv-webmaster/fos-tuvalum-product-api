<?php
declare(strict_types=1);

namespace App\Application\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * An action which always returns HTTP 404 Not Found. Useful for disabling an operation.
 */
final class NotFoundController
{
    public function __invoke()
    {
        throw new NotFoundHttpException();
    }
}
