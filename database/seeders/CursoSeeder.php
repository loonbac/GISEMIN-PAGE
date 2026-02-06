<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Borrar todos los cursos existentes
        Curso::truncate();

        $cursos = [
            // 🔴 CAPACITACIONES OBLIGATORIAS / NORMATIVAS (SST)
            ['nombre' => 'Inducción en Seguridad y Salud en el Trabajo', 'categoria' => 'obligatorias'],
            ['nombre' => 'Política y Reglamento Interno de SST', 'categoria' => 'obligatorias'],
            ['nombre' => 'Identificación de Peligros, Evaluación de Riesgos y Controles (IPERC)', 'categoria' => 'obligatorias'],
            ['nombre' => 'IPERC Continuo / IPERC de tareas críticas', 'categoria' => 'obligatorias'],
            ['nombre' => 'Comité de SST / Supervisor de SST', 'categoria' => 'obligatorias'],
            ['nombre' => 'Derechos y obligaciones del trabajador en SST', 'categoria' => 'obligatorias'],
            ['nombre' => 'Investigación de incidentes y accidentes de trabajo', 'categoria' => 'obligatorias'],
            ['nombre' => 'Reporte de actos y condiciones subestándar', 'categoria' => 'obligatorias'],
            ['nombre' => 'Auditorías internas en SST', 'categoria' => 'obligatorias'],
            ['nombre' => 'Inspecciones de seguridad', 'categoria' => 'obligatorias'],
            ['nombre' => 'Legislación en SST (Ley 29783 y su reglamento)', 'categoria' => 'obligatorias'],

            // 🟠 TRABAJOS DE ALTO RIESGO (TAR)
            ['nombre' => 'Trabajo en Altura', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Rescate en Altura', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Trabajo en Espacios Confinados', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Rescate en Espacios Confinados', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Trabajo en Caliente (soldadura, oxicorte, esmerilado)', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Trabajo con Energías Peligrosas (LOTO)', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Trabajo en Excavaciones y Zanjas', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Trabajo en Izaje de Cargas', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Señalero / Rigger', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Trabajo en Proximidad a Líneas Eléctricas', 'categoria' => 'alto_riesgo'],
            ['nombre' => 'Trabajos con Sustancias Peligrosas', 'categoria' => 'alto_riesgo'],

            // 🟡 EMERGENCIAS Y PRIMEROS AUXILIOS
            ['nombre' => 'Primeros Auxilios Básicos', 'categoria' => 'emergencias'],
            ['nombre' => 'Primeros Auxilios Industriales', 'categoria' => 'emergencias'],
            ['nombre' => 'Soporte Básico de Vida (RCP y uso de DEA)', 'categoria' => 'emergencias'],
            ['nombre' => 'Control de Hemorragias', 'categoria' => 'emergencias'],
            ['nombre' => 'Manejo de Quemaduras', 'categoria' => 'emergencias'],
            ['nombre' => 'Plan de Respuesta ante Emergencias', 'categoria' => 'emergencias'],
            ['nombre' => 'Brigadas de Emergencia', 'categoria' => 'emergencias'],
            ['nombre' => 'Brigada contra Incendios', 'categoria' => 'emergencias'],
            ['nombre' => 'Uso y Manejo de Extintores', 'categoria' => 'emergencias'],
            ['nombre' => 'Evacuación y Simulacros', 'categoria' => 'emergencias'],
            ['nombre' => 'Búsqueda y Rescate Básico', 'categoria' => 'emergencias'],

            // 🔵 EQUIPOS, MAQUINARIA Y HERRAMIENTAS
            ['nombre' => 'Seguridad en el Uso de Herramientas Manuales', 'categoria' => 'equipos'],
            ['nombre' => 'Seguridad en el Uso de Herramientas Eléctricas', 'categoria' => 'equipos'],
            ['nombre' => 'Operación Segura de Montacargas', 'categoria' => 'equipos'],
            ['nombre' => 'Operación Segura de Plataformas Elevadoras (Manlift)', 'categoria' => 'equipos'],
            ['nombre' => 'Operación de Grúas (según alcance de la consultora)', 'categoria' => 'equipos'],
            ['nombre' => 'Seguridad en Maquinaria Industrial', 'categoria' => 'equipos'],
            ['nombre' => 'Mantenimiento Seguro (permiso de trabajo)', 'categoria' => 'equipos'],

            // 🟢 HIGIENE OCUPACIONAL Y SALUD
            ['nombre' => 'Ergonomía en el Trabajo', 'categoria' => 'salud'],
            ['nombre' => 'Ergonomía Administrativa (oficina / home office)', 'categoria' => 'salud'],
            ['nombre' => 'Manejo Manual de Cargas', 'categoria' => 'salud'],
            ['nombre' => 'Fatiga y Riesgos Psicosociales', 'categoria' => 'salud'],
            ['nombre' => 'Estrés laboral', 'categoria' => 'salud'],
            ['nombre' => 'Ruido ocupacional', 'categoria' => 'salud'],
            ['nombre' => 'Vibraciones', 'categoria' => 'salud'],
            ['nombre' => 'Iluminación en el trabajo', 'categoria' => 'salud'],
            ['nombre' => 'Exposición a agentes químicos', 'categoria' => 'salud'],
            ['nombre' => 'Exposición a agentes biológicos', 'categoria' => 'salud'],
            ['nombre' => 'Enfermedades ocupacionales', 'categoria' => 'salud'],

            // 🟣 MEDIO AMBIENTE Y SST (SSOMA)
            ['nombre' => 'Manejo de Residuos Sólidos', 'categoria' => 'ambiente'],
            ['nombre' => 'Residuos Peligrosos', 'categoria' => 'ambiente'],
            ['nombre' => 'Control de Derrames', 'categoria' => 'ambiente'],
            ['nombre' => 'Buenas Prácticas Ambientales', 'categoria' => 'ambiente'],
            ['nombre' => 'Plan de Contingencias Ambientales', 'categoria' => 'ambiente'],
            ['nombre' => 'Seguridad, Salud y Medio Ambiente (SSOMA)', 'categoria' => 'ambiente'],

            // ⚫ CAPACITACIONES COMPLEMENTARIAS / CULTURA PREVENTIVA
            ['nombre' => 'Cultura de Seguridad', 'categoria' => 'cultura'],
            ['nombre' => 'Observación de Conductas Seguras (BBS)', 'categoria' => 'cultura'],
            ['nombre' => 'Liderazgo en Seguridad', 'categoria' => 'cultura'],
            ['nombre' => 'Seguridad Basada en el Comportamiento', 'categoria' => 'cultura'],
            ['nombre' => 'Orden y Limpieza – Metodología 5S', 'categoria' => 'cultura'],
            ['nombre' => 'Fatiga y Somnolencia', 'categoria' => 'cultura'],
            ['nombre' => 'Alcohol y Drogas en el Trabajo', 'categoria' => 'cultura'],
            ['nombre' => 'Seguridad Vial / Conducción Segura', 'categoria' => 'cultura'],
            ['nombre' => 'Trabajo Seguro en Oficina', 'categoria' => 'cultura'],
            ['nombre' => 'Teletrabajo Seguro', 'categoria' => 'cultura'],

            // 🔧 CAPACITACIONES ESPECÍFICAS (SEGÚN SECTOR)
            ['nombre' => 'SST en Construcción Civil', 'categoria' => 'sectores'],
            ['nombre' => 'SST en Minería (básico)', 'categoria' => 'sectores'],
            ['nombre' => 'SST en Industria', 'categoria' => 'sectores'],
            ['nombre' => 'SST en Clínicas y Centros de Salud', 'categoria' => 'sectores'],
            ['nombre' => 'Bioseguridad', 'categoria' => 'sectores'],
            ['nombre' => 'Manipulación de Alimentos', 'categoria' => 'sectores'],
            ['nombre' => 'Seguridad en Laboratorios', 'categoria' => 'sectores'],
            ['nombre' => 'SST para Contratistas', 'categoria' => 'sectores'],
        ];

        foreach ($cursos as $curso) {
            Curso::create([
                'nombre' => $curso['nombre'],
                'categoria' => $curso['categoria'],
                'uso_count' => 0
            ]);
        }
    }
}
