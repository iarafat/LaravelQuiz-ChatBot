<?php

use App\Conversations\HighscoreConversation;
use App\Conversations\QuizConversation;
use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotMan;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('/startquiz|startquiz', function (BotMan $bot) {
    $bot->startConversation(new QuizConversation());
});

$botman->hears('/highscore|highscore', function (BotMan $bot) {
    $bot->startConversation(new HighscoreConversation());
})->stopsConversation();
