<?php

namespace Application\AppBundle\Slack\Command;

use Slack\Channel;
use Slack\User;

class PingCommand extends AbstractCommand
{
    public function configure()
    {
        $this->setRegex('/ping/');
    }

    public function execute(string $message, User $user, Channel $channel)
    {
        $this->client->send('@' . $user->getUsername() . ' pong!', $channel);

        return true;
    }
}