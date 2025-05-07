<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Template;
use App\Models\Contact;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Editor extends Component
{
    public $content = '';
    public $subject = ''; // Default subject
    public $showNameModal = false;
    public $showConfirmModal = false;
    public $templateName = '';
    public $existingTemplateId = null;
    public $selectedContactIds = [];

    protected $listeners = [
        'load-template' => 'loadTemplate',
    ];

    protected $tykanieVykanieReplacements = [
        '{pozdrav_zaciatok}' => [
            'tykanie' => 'Ahoj',
            'vykanie' => 'Dobrý deň',
        ],
        '{dakujem}' => [
            'tykanie' => 'Ďakujem ti',
            'vykanie' => 'Ďakujem Vám',
        ],
        '{pozdrav_zaver}' => [
            'tykanie' => 'Pozdravujem',
            'vykanie' => 'S pozdravom',
        ],
        '{Vás/teba}' => [
            'tykanie' => 'teba',
            'vykanie' => 'Vás',
        ],
        '{Vám/ti}' => [
            'tykanie' => 'ti',
            'vykanie' => 'Vám',
        ],
        '{Vami/tebou}' => [
            'tykanie' => 'tebou',
            'vykanie' => 'Vami',
        ],
        '{Vy/ty}' => [
            'tykanie' => 'ty',
            'vykanie' => 'Vy',
        ],
    ];

    public function openNameModal()
    {
        $this->showNameModal = true;
    }

    public function checkTemplate()
    {
        $this->validate([
            'templateName' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $existingTemplate = Template::where('user_id', $user->id)
            ->where('name', $this->templateName)
            ->first();

        if ($existingTemplate) {
            $this->existingTemplateId = $existingTemplate->id;
            $this->showConfirmModal = true;
        } else {
            $this->createTemplate();
        }
    }

    public function overwriteTemplate()
    {
        $template = Template::find($this->existingTemplateId);
        $template->template = $this->content;
        $template->subject = $this->subject; // Save the subject
        $template->save();

        $this->content = $template->template ?? '';
        $this->subject = $template->subject ?? 'Your Template Email'; // Load the saved subject
        $this->showConfirmModal = false;
        $this->showNameModal = false;
        session()->flash('message', 'Template overwritten successfully!');
    }

    public function createTemplate()
    {
        $user = Auth::user();
        $template = Template::create([
            'user_id' => $user->id,
            'name' => $this->templateName,
            'template' => $this->content,
            'subject' => $this->subject, // Save the subject
        ]);

        $this->content = $template->template ?? '';
        $this->subject = $template->subject ?? 'Your Template Email'; // Load the saved subject
        $this->showNameModal = false;
        $this->dispatch('template-saved'); // Udalosť pre refresh tabuľky
        session()->flash('message', 'Template saved successfully!');
    }

    public function loadTemplate($templateId)
    {
        $template = Template::find($templateId);
        if ($template && $template->user_id === auth()->id()) {
            $this->content = $template->template ?? '';
            $this->subject = $template->subject ?? 'Your Template Email'; // Load the saved subject
            session()->flash('message', 'Template loaded successfully!');
        }
    }

    public function sendEmails()
    {
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id)
            ->whereIn('id', $this->selectedContactIds)
            ->get();

        if (empty($this->content)) {
            session()->flash('error', 'Template content is empty!');
            return;
        }

        if (empty($this->subject)) {
            session()->flash('error', 'Email subject is empty!');
            return;
        }

        foreach ($contacts as $contact) {
            // Start with the original template content
            $personalizedContent = $this->content;

            // Replace {oslovenie} with the contact's oslovenie only if use_vykanie is true
            if ($contact->use_vykanie && $contact->oslovenie) {
                $personalizedContent = str_replace('{oslovenie}', $contact->oslovenie, $personalizedContent);
            } elseif (!$contact->use_vykanie && $contact->name) {
                $personalizedContent = str_replace('{oslovenie}', '', $personalizedContent);
            }

            // Replace {meno} with the contact's name
            if ($contact->name) {
                $personalizedContent = str_replace('{meno}', $contact->name, $personalizedContent);
            }

            // Replace tykanie/vykanie keywords based on use_vykanie
            $tone = $contact->use_vykanie ? 'vykanie' : 'tykanie';
            foreach ($this->tykanieVykanieReplacements as $placeholder => $replacements) {
                $personalizedContent = str_replace($placeholder, $replacements[$tone], $personalizedContent);
            }

            // Send the email with the personalized content and custom subject
            try {
                Mail::raw($personalizedContent, function ($message) use ($contact) {
                    $message->to($contact->email, $contact->name)
                        ->subject($this->subject)
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });

                // Log the email in the email_logs table
                EmailLog::create([
                    'user_id' => $user->id,
                    'contact_id' => $contact->id,
                    'subject' => $this->subject,
                    'body' => $personalizedContent,
                    'sent_at' => now(),
                ]);

                Log::info('Email sent to: ' . $contact->email . ' with subject: ' . $this->subject . ' and content: ' . $personalizedContent);
            } catch (\Exception $e) {
                Log::error('Failed to send email to ' . $contact->email . ': ' . $e->getMessage());
                session()->flash('error', 'Failed to send email to ' . $contact->email);
                return;
            }
        }

        $this->selectedContactIds = [];
        session()->flash('message', 'Emails sent successfully to ' . count($contacts) . ' contacts!');
    }

    public function render()
    {
        $contacts = Auth::user()->contacts ?? collect();
        return view('livewire.editor', compact('contacts'));
    }
}
