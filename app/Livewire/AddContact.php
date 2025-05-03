<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Component;

class AddContact extends Component
{
    public $name = '';
    public $email = '';
    public $use_vykanie = true;
    public $oslovenie = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'use_vykanie' => 'boolean',
        'oslovenie' => 'nullable|string|max:255',
    ];
    protected array $messages = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Email must be a valid email address.',
        'use_vykanie.boolean' => 'Use vykanie must be true or false.',
        'oslovenie.string' => 'Oslovenie must be a string.',
    ];

    public function save(): void{
        $validated = $this->validate();

        try {
            Contact::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'use_vykanie' => $validated['use_vykanie'],
                'oslovenie' => $validated['oslovenie'] ?: null,
            ]);
            $this->reset(['name', 'email', 'use_vykanie', 'oslovenie']);
            $this->dispatch('modal-close', 'add-contact');
            $this->dispatch('contact-added');
            session()->flash('message', 'Contact added successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { // Duplikátny záznam
                $this->addError('email', 'This email already exists for your account.');
            } else {
                throw $e; // Iná chyba
            }
        }

    }
    public function render()
    {
        return view('livewire.add-contact');
    }
}
