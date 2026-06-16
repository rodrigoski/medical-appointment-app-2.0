<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTable extends DataTableComponent
{
    protected $model = Appointment::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableAttributes([
            'class' => 'min-w-full divide-y divide-gray-200',
        ]);
    }

    public function builder(): Builder
    {
        return Appointment::query()->with(['patient.user', 'doctor']);
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Paciente", "patient.user.name")
                ->sortable()
                ->searchable(),

            Column::make("Doctor", "doctor.name")
                ->sortable()
                ->searchable(),

            Column::make("Fecha", "date")
                ->sortable(),

            Column::make("Hora inicio", "start_time")
                ->sortable(),

            Column::make("Estatus", "status")
                ->format(function($value, $row, Column $column) {
                    $labels = [
                        1 => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendiente</span>',
                        2 => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completada</span>',
                        3 => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelada</span>',
                    ];
                    return $labels[$value] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Desconocido</span>';
                })
                ->html(),

            Column::make("Acciones", "id")
                ->format(function($value, $row, Column $column) {
                    $consultUrl = route('admin.appointments.consult', $value);
                    $editUrl = route('admin.appointments.edit', $value);
                    $deleteUrl = route('admin.appointments.destroy', $value);

                    return '
                        <div class="flex items-center space-x-2">
                            <a href="' . $consultUrl . '" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                <i class="fa-solid fa-stethoscope mr-1"></i> Atender
                            </a>
                            <a href="' . $editUrl . '" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fa-solid fa-user-pen mr-1"></i> Editar
                            </a>
                            <form action="' . $deleteUrl . '" method="POST" class="delete-form">
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
