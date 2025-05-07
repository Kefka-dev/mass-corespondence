<div>
    <flux:textarea wire:model.live="content" placeholder="Enter your template content..." rows="10" />
    <div class="mt-4">
        <h3>Select Contacts</h3>
        @foreach ($contacts as $contact)
            <label class="flex items-center">
                <input type="checkbox" wire:model.live="selectedContactIds" value="{{ $contact->id }}">
                {{ $contact->name }} ({{ $contact->email }})
            </label>
        @endforeach
    </div>
    <flux:button.group class="mt-4">
        <flux:button wire:click="openNameModal">Save Template</flux:button>
        <flux:button wire:click="sendEmails">Send Emails</flux:button>
    </flux:button.group>

    <flux:modal name="name-modal" wire:model="showNameModal">
        <div>
            <flux:heading>Save Template</flux:heading>
            <flux:input wire:model="templateName" placeholder="Template Name" />
            <flux:button wire:click="checkTemplate">Save</flux:button>
            <flux:button wire:click="$set('showNameModal', false)">Cancel</flux:button>
        </div>
    </flux:modal>

    <flux:modal name="confirm-modal" wire:model="showConfirmModal">
        <div>
            <flux:heading>Confirm Overwrite</flux:heading>
            <flux:text>A template with this name already exists. Do you want to overwrite it?</flux:text>
            <flux:button wire:click="overwriteTemplate">Yes</flux:button>
            <flux:button wire:click="$set('showConfirmModal', false)">No</flux:button>
        </div>
    </flux:modal>
</div>
