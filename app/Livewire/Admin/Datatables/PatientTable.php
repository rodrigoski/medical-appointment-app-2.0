<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;

class PatientTable extends DataTableComponent
{
    protected $model = Patient::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        // Opcional: Puedes ajustar el diseño de la tabla aquí
        $this->setTableAttributes([
            'class' => 'min-w-full divide-y divide-gray-200',
        ]);
    }

    public function builder(): Builder
    {
        // Cargamos la relación 'user' para obtener nombre y correo sin lentitud
        return Patient::query()->with('user');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            // Datos desde la relación con Users
            Column::make("Nombre", "user.name")
                ->sortable()
                ->searchable(),

            Column::make("Correo", "user.email")
                ->sortable()
                ->searchable(),

            // Usamos el teléfono de emergencia según tu migración
            Column::make("Teléfono Emergencia", "emergency_contact_phone")
                ->sortable()
                ->searchable(),

            // Columna de Acciones
            Column::make("Acciones", "id")
                ->format(function($value, $row, Column $column) {
                    $editUrl = route('admin.patients.edit', $value);

                    // Retornamos el HTML del botón de editar
                    return '<a href="'.$editUrl.'" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fa-solid fa-user-pen mr-1"></i> Editar
                            </a>';
                })
                ->html(),
        ];
    }
}
