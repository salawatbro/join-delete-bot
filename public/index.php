<?php

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;

try {
    $bot = new Nutgram(token: $_ENV['BOT_TOKEN']);
    $bot->setRunningMode(Webhook::class);
    $bot->onNewChatMembers(function (Nutgram $bot) {
        $bot->deleteMessage(
            chat_id: $bot->chatId(),
            message_id: $bot->messageId(),
        );
    });
    $bot->onLeftChatMember(function (Nutgram $bot) {
        $bot->deleteMessage(
            chat_id: $bot->chatId(),
            message_id: $bot->messageId(),
        );
    });
    $bot->onCommand('start', function (Nutgram $bot) {
        if ($bot->message()->chat->type === 'private') {
            $bot->sendMessage('Hello! I am a bot!');
        }
    });
    $bot->run();
} catch (NotFoundExceptionInterface $e) {
    echo 'Bot token not found';
} catch (ContainerExceptionInterface $e) {
    echo $e->getMessage();
}