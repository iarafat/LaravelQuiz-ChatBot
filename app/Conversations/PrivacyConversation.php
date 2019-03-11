<?php

namespace App\Conversations;

use App\Highscore;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class PrivacyConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askAboutDataDeletion();
    }

    private function askAboutDataDeletion()
    {
        $user = Highscore::where('chat_id', $this->bot->getUser()->getId())->first();

        if (!$user)
        {
            return $this->say('We have not stored any data of you.');
        }

        $this->say('We have stored your name and chat ID for showing you in the highscore.');
        $this->askIfDelete();
    }

    private function askIfDelete()
    {
        $question = Question::create('Do you want to get deleted?')
            ->addButtons([
                Button::create('Sure')->value('yes'),
                Button::create('Not now')->value('no'),
            ]);

        $this->ask($question, function (Answer $answer){
            switch ($answer->getValue()){
                case 'yes':
                    Highscore::deleteUser($this->bot->getUser()->getId());
                    $this->say("Done! Your data has been deleted.");
                    return $this->bot->startConversation(new HighscoreConversation());
                case 'no':
                    return $this->say('Great to keep you 👍');
                default:
                    return $this->repeat('Sorry, I did not get that. Please use the buttons.');

            }
        });
    }
}
