<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;

class EditContactModal extends Component
{
    public $contactId = null;
    public $name = '';
    public $email = '';
    public $use_vykanie = true;
    public $oslovenie = '';
    public bool $modalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'use_vykanie' => 'boolean',
        'oslovenie' => 'nullable|string|max:255',
    ];

    #[\Livewire\Attributes\On('open-edit-modal')]
    public function openModal($contactId): void
    {
        $this->contactId = $contactId;
        $contact = Contact::findOrFail($contactId);
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->use_vykanie = $contact->use_vykanie;
        $this->oslovenie = $contact->oslovenie;
        $this->modalOpen = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $contact = Contact::findOrFail($this->contactId);
        $contact->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'use_vykanie' => $validated['use_vykanie'],
            'oslovenie' => $validated['oslovenie'],
        ]);

        $this->modalOpen = false;
        $this->dispatch('contact-updated');
        session()->flash('message', 'Kontakt bol úspešne aktualizovaný.');
    }

    public function render()
    {
        return view('livewire.edit-contact-modal');
    }
}
