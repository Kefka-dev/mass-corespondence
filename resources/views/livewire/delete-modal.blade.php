<div>
    <flux:modal name="delete-modal" class="md:w-96" wire:model="modalOpen">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Potvrdenie zmazania</flux:heading>
                <flux:text class="mt-2">Naozaj chcete odstrániť tento záznam? Táto akcia je nevratná.</flux:text>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="delete" variant="danger">Odstrániť</flux:button>
                <flux:button wire:click="$set('modalOpen', false)" class="ml-2">Zrušiť</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
