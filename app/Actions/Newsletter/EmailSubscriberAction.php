<?php

namespace App\Actions\NewsLetter;

use App\Models\Subscriber;

class EmailSubscriberAction{

    public function __invoke(array $formdata)
    {
        $this->getOrCreateSubscriberEmail($formdata);
    }

    private function getOrCreateSubscriberEmail(array $formdata) : Subscriber{

        return Subscriber::firstorCreate($formdata);
    }
}