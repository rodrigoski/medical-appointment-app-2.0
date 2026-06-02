<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;

class DoctorTable extends DataTableComponent
{
    protected $model = Doctor::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setTableAttributes([
            'class' => 'min-w-full divide-y divide-gray-200',
        ]);

        $this->setToolBarAttributes(['class' => 'flex items-center justify-between mb-4']);

        $this->setToolsAttributes(['class' => 'flex items-center space-x-2']);
    }

    public function toolsView(): ?string
    {
        return 'layouts.includes.admin.doctors.partials.toolbar';
    }

    public function builder(): Builder
    {
        return Doctor::query()->with('user', 'speciality');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Nombre", "user.name")
                ->sortable()
                ->searchable(),

            Column::make("Correo", "user.email")
                ->sortable()
                ->searchable(),

            Column::make("Especialidad", "speciality.name")
                ->sortable()
                ->searchable(),

            Column::make("Cédula", "license_number")
                ->sortable()
                ->searchable(),

            Column::make("Teléfono", "phone")
                ->sortable(),

            Column::make("Acciones", "id")
                ->format(function ($value, $row, Column $column) {
                    $editUrl = route('admin.doctors.edit', $value);

                    return '<a href="' . $editUrl . '" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fa-solid fa-user-pen mr-1"></i> Editar
                            </a>';
                })
                ->html(),

            Column::make("Acciones", "id")
    ->format(function ($value, $row, Column $column) {
        $editUrl   = route('admin.doctors.edit', $value);
        $deleteUrl = route('admin.doctors.destroy', $value);

        return '
            <div class="flex items-center space-x-2">
                <a href="' . $editUrl . '" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fa-solid fa-user-pen mr-1"></i> Editar
                </a>

                <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'¿Estás seguro de eliminar este doctor?\')">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fa-solid fa-trash mr-1"></i> Eliminar
                    </button>
                </form>
            </div>
        ';
    })
    ->html(),
        ];
    }
}
