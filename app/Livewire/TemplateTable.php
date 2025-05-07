<?php

namespace App\Livewire;

use App\Models\Template;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class TemplateTable extends PowerGridComponent
{
    public string $tableName = 'template-table-w2maro-table';

    protected $listeners = [
        'template-deleted' => '$refresh',
        'template-saved'=> '$refresh',
    ];

    public function setUp(): array
    {

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage(5, [5, 10, 50])
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Template::query()->where('user_id', auth()->id());
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('template')
            ->add('user_id')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Template $row): array
    {
        return [
            Button::add('load')
                ->slot('Load')
                ->id()
                ->class('relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none h-10 text-sm rounded-lg px-4 inline-flex bg-green-500 hover:bg-green-600 text-white')
                ->dispatch('load-template', ['templateId' => $row->id]),
            Button::add('delete')
                ->slot('Delete')
                ->id()
                ->class('relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none h-10 text-sm rounded-lg px-4 inline-flex  bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 text-white  shadow-[inset_0px_1px_var(--color-red-500),inset_0px_2px_--theme(--color-white/.15)] dark:shadow-none [[data-flux-button-group]_&]:border-e [:is([data-flux-button-group]>&:last-child,_[data-flux-button-group]_:last-child>&)]:border-e-0 [[data-flux-button-group]_&]:border-red-600 dark:[[data-flux-button-group]_&]:border-red-900/25')
                ->dispatch('open-delete-modal', ['recordId' => $row->id, 'model' => 'Template', 'eventName' => 'template-deleted']),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
