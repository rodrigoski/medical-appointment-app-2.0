<?php

namespace Database\Seeders;

use App\Models\Speciality;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    public function run(): void
    {
        $specialities = [
            ['name' => 'Cardiología',          'description' => 'Diagnóstico y tratamiento de enfermedades del corazón y sistema cardiovascular.'],
            ['name' => 'Pediatría',             'description' => 'Atención médica integral para niños y adolescentes.'],
            ['name' => 'Neurología',            'description' => 'Diagnóstico y tratamiento de enfermedades del sistema nervioso.'],
            ['name' => 'Traumatología',         'description' => 'Tratamiento de lesiones del aparato locomotor, huesos y articulaciones.'],
            ['name' => 'Ginecología',           'description' => 'Salud del sistema reproductor femenino y atención obstétrica.'],
            ['name' => 'Dermatología',          'description' => 'Diagnóstico y tratamiento de enfermedades de la piel, cabello y uñas.'],
            ['name' => 'Oftalmología',          'description' => 'Diagnóstico y tratamiento de enfermedades y trastornos visuales.'],
            ['name' => 'Psiquiatría',           'description' => 'Diagnóstico y tratamiento de trastornos mentales y del comportamiento.'],
            ['name' => 'Endocrinología',        'description' => 'Tratamiento de enfermedades hormonales y metabólicas como diabetes.'],
            ['name' => 'Medicina General',      'description' => 'Atención primaria y prevención de enfermedades en pacientes de todas las edades.'],
        ];

        foreach ($specialities as $speciality) {
            Speciality::firstOrCreate(['name' => $speciality['name']], $speciality);
        }
    }
}
