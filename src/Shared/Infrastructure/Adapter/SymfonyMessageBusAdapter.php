<?php
declare(strict_types=1);


namespace App\Shared\Infrastructure\Adapter;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Messenger\MessageBusInterface as SymfMessageBusInterface;

class SymfonyMessageBusAdapter implements MessageBusInterface
{
    private ?Envelope $lastEnvelope;
    private SymfMessageBusInterface $messageBus;

    public function __construct(SymfMessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * Dispatches the given message.
     *
     * @param object|Envelope $message The message or the message pre-wrapped in an envelope
     * @param bool $getResponse
     *
     * @return void
     */
    public function dispatch($message, bool $getResponse = false)
    {
        $envelope = $this->messageBus->dispatch($message);
        if(true === $getResponse) {
            return $this->getResponse($envelope);
        }
    }

    private function getResponse(Envelope $envelope)
    {
        /**
         * @var StampInterface
         */
        $handledStamp = $envelope->last(HandledStamp::class);
        $result = $handledStamp->getResult();

        return $result;
    }
}
