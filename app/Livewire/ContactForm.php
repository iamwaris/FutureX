<?php

namespace App\Livewire;

use App\Models\BusinessInquiry;
use App\Notifications\NewBusinessInquiryNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactForm extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $company = '';

    public string $email = '';

    public string $campaign_type = '';

    public string $budget = '';

    public string $timeline = '';

    public string $message = '';

    public $attachment = null;

    /**
     * Honeypot — a field real visitors never see or fill in (hidden via
     * CSS, not just visually offscreen, so screen readers skip it too).
     * Bots that blindly fill every field trip this.
     */
    public string $website = '';

    public bool $submitted = false;

    public float $renderedAt;

    public function mount(): void
    {
        $this->renderedAt = microtime(true);
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'campaign_type' => ['required', 'string', 'max:255'],
            'budget' => ['nullable', 'string', 'max:255'],
            'timeline' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:pdf,png,jpg,jpeg,docx'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        // Silently "succeed" for bots instead of telling them what tripped —
        // filled honeypot or submitting suspiciously fast (under 3s) after
        // the form rendered are both strong bot signals.
        if (filled($this->website) || (microtime(true) - $this->renderedAt) < 3) {
            $this->submitted = true;
            $this->resetForm();

            return;
        }

        $attachmentPath = $this->attachment?->store('inquiry-attachments', 'local');

        $inquiry = BusinessInquiry::create([
            'name' => $this->name,
            'company' => $this->company ?: null,
            'email' => $this->email,
            'campaign_type' => $this->campaign_type,
            'budget' => $this->budget ?: null,
            'timeline' => $this->timeline ?: null,
            'message' => $this->message,
            'attachment_path' => $attachmentPath,
        ]);

        Notification::route('mail', config('mail.from.address'))
            ->notify(new NewBusinessInquiryNotification($inquiry));

        $this->submitted = true;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['name', 'company', 'email', 'campaign_type', 'budget', 'timeline', 'message', 'attachment', 'website']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
