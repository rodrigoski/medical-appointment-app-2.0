<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Insurance;
use Illuminate\Database\Eloquent\Builder;

class InsuranceTable extends DataTableComponent
{
    protected $model = Insurance::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setTableAttributes([
            'class' => 'min-w-full divide-y divide-gray-200',
        ]);
    }

    public function builder(): Builder
    {
        return Insurance::query();
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),

            Column::make("Proveedor", "provider")
                ->sortable()
                ->searchable(),

            Column::make("No. Póliza", "policy_number")
                ->sortable()
                ->searchable(),

            Column::make("Tipo de Cobertura", "coverage_type")
                ->sortable()
                ->searchable(),

            Column::make("Teléfono", "phone")
                ->sortable(),

            Column::make("Estado", "status")
                ->format(function ($value, $row, Column $column) {
                    return $value
                        ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>'
                        : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>';
                })
                ->html(),

            Column::make("Acciones", "id")
                ->format(function ($value, $row, Column $column) {
                    $editUrl   = route('admin.insurances.edit', $value);
                    $deleteUrl = route('admin.insurances.destroy', $value);

                    return '
                        <div class="flex items-center space-x-2">
                            <a href="' . $editUrl . '" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fa-solid fa-pen mr-1"></i> Editar
                            </a>

                            <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'¿Estás seguro de eliminar este seguro?\')">
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
