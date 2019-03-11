<?php

use App\Conversations\HighscoreConversation;
use App\Conversations\PrivacyConversation;
use App\Conversations\QuizConversation;
use App\Conversations\WelcomeConversation;
use App\Http\Controllers\BotManController;
use BotMan\BotMan\BotMan;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('/start|GET_STARTED|start', function (BotMan $bot) {
    $bot->startConversation(new WelcomeConversation());
})->stopsConversation();

$botman->hears('/startquiz|startquiz', function (BotMan $bot) {
    $bot->startConversation(new QuizConversation());
});

$botman->hears('/highscore|highscore', function (BotMan $bot) {
    $bot->startConversation(new HighscoreConversation());
})->stopsConversation();

$botman->hears('/deletedata|deletedata', function (BotMan $bot) {
    $bot->startConversation(new PrivacyConversation());
})->stopsConversation();

$botman->hears('/about|about', function (BotMan $bot) {
    $bot->reply('LaravelQuiz is a project by MD Iyasin Arafat. Find out more about it on https://github.com/iarafat/LaravelQuiz-ChatBot');
})->stopsConversation();
