<?php
declare(strict_types=1);


namespace App\Shared\Infrastructure\Adapter;

use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\StampInterface;

interface MessageBusInterface
{
    /**
     * Dispatches the given message.
     *
     * @param object $message The message object
     * @param bool $getResponse
     */
    public function dispatch($message, bool $getResponse = false);

}
