<?php

namespace App\Livewire;

use App\Models\EmailLog; // Make sure this is correct
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class EmailHistory extends PowerGridComponent
{
    public string $tableName = 'email-history-gwxfab-table';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        // Eager load the relationship for better performance
        return EmailLog::query()->with('contact');
    }

    public function relationSearch(): array
    {
        return [
            'contact' => [ // The relationship name
                'name',    // The column(s) in the 'contacts' table you want to search
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            // This is optional but good for clarity and complex data,
            // especially if contact can be null.
            ->add('contact_name', fn (EmailLog $log) => $log->contact?->name ?? 'N/A')
        ->add('contact_name', fn (EmailLog $log) => $log->contact?->name ?? 'N/A')
        ->add('sent_at_formatted', fn (EmailLog $log) => Carbon::parse($log->sent_at)->format('d/m/Y H:i A'));
        // You can also directly use contact.name in columns if you prefer
        // and your PowerGrid version supports it well without explicit fields.
    }

    public function columns(): array
    {
        return [
            // Option 1: Using the field defined in fields() method (recommended for clarity and null safety)
            Column::make('Contact', 'contact_name')
                ->sortable('contacts.name') // For sorting, specify the actual table.column
                ->searchable(), // Relies on relationSearch

            // Option 2: Directly using the relationship (works in many PG versions)
            // Column::make('Contact', 'contact.name')
            //     ->sortable() // PowerGrid will attempt to infer the sortable column
            //     ->searchable(), // Relies on relationSearch

            Column::make('Subject', 'subject')
                ->sortable()
                ->searchable(),

            Column::make('Body', 'body')
                ->sortable()
                ->searchable(),

            Column::make('Sent at', 'sent_at_formatted', 'sent_at') // 'sent_at_formatted' is for display, 'sent_at' for data/sorting
            ->sortable()
                ->searchable(),
        ];
    }

    // If you used fields() for sent_at formatting as well:
//     public function fields(): PowerGridFields
//     {
//         return PowerGrid::fields()
//             ->add('contact_name', fn (EmailLog $log) => $log->contact?->name ?? 'N/A')
//             ->add('sent_at_formatted', fn (EmailLog $log) => Carbon::parse($log->sent_at)->format('d/m/Y H:i A'));
//     }


    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }
}
