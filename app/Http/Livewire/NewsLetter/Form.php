<?php

namespace App\Http\Livewire\Newsletter;

use App\Actions\Newsletter\EmailSubscriberAction;
use App\Mail\SubscriberMailable;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Newsletter;

class Form extends Component
{
    public string $name = '';
    public string $email = '';

    protected $rules = [
        'name'      => ['required'],
        'email'     => ['required', 'email', 'unique:subscribers'],
    ];

    public function formSubmit()
    {
        $this->validate();

        $token = bcrypt($this->email);

        $data = array(
            'name'      => $this->name,
            'email'     => $this->email,
        );

        (new EmailSubscriberAction)([
            'name'  => $this->name,
            'email' => $this->email,
            'token' => $token,
        ]);

        if (!Newsletter::isSubscribed($this->email)) {
            Newsletter::subscribe($this->email, ['NAME' => $this->name, 'TOKEN' => $token]);
        }

        Mail::to($this->email)
            ->bcc('your@email.com', 'Your Name')
            ->send(new SubscriberMailable($data));

        session()->flash('success', 'You are subscribed!');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.newsletter.form');
    }

    // public Subscriber $subsciber;

    // public function unSubscriber(){
    //     if(Newsletter::isSubscribed($this->subsciber->email)){
    //         Newsletter::deletePermanently($this->subsciber->email);
    //     }

    //     return redirect()->route('newsletter.success');
    // }
}
