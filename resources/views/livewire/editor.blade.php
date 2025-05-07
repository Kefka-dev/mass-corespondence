<div>
    <flux:textarea wire:model.live="content" placeholder="Enter your template content..." rows="10" />
    <flux:button.group>
        <flux:button wire:click="openNameModal">Save Template</flux:button>
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
