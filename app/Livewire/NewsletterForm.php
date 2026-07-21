<?php

namespace App\Livewire;

use App\Services\Newsletter\NewsletterManager;
use App\Services\Newsletter\NewsletterSubscriptionException;
use Livewire\Component;

class NewsletterForm extends Component
{
    public string $email = '';

    public bool $subscribed = false;

    public ?string $error = null;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function subscribe(NewsletterManager $newsletter): void
    {
        $this->error = null;
        $this->validate();

        try {
            $newsletter->subscribe($this->email);
            $this->subscribed = true;
            $this->email = '';
        } catch (NewsletterSubscriptionException $e) {
            $this->error = 'Something went wrong — please try again in a moment.';
            report($e);
        }
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
