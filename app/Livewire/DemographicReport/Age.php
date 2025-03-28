<?php

namespace App\Livewire\DemographicReport;

use App\Models\Worker;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class Age extends Component
{
    public function render()
    {
        // Obtener los datos agrupados por rango de edad y promedio
        $averageAgeByGroup = $this->getAverageAgeByGroup();

        // Crear el gráfico de tarta
        $chart = $this->createAgeDistributionChart($averageAgeByGroup);

        return view('livewire.demographic-report.age', compact('chart'));
    }

    /**
     * Obtener el promedio de edades agrupado por rango de edad.
     *
     * @return array
     */
    public function getAverageAgeByGroup()
    {
        return Worker::where('FECNTO', '<>', 0)
            ->where(function ($query) {
                $query->where('INACT', '')->orWhereNull('INACT');
            })
            ->whereRaw('ISDATE(CONVERT(VARCHAR(8), FECNTO)) = 1') // Filtrar registros válidos
            ->select(DB::raw("
                CASE
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 < 20 THEN '0-19'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 20 AND 29 THEN '20-29'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 30 AND 39 THEN '30-39'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 40 AND 49 THEN '40-49'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 50 AND 59 THEN '50-59'
                    ELSE '60+'
                END AS age_range,
                AVG(DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365.0) AS average_age
            "))
            ->groupBy(DB::raw("
                CASE
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 < 20 THEN '0-19'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 20 AND 29 THEN '20-29'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 30 AND 39 THEN '30-39'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 40 AND 49 THEN '40-49'
                    WHEN DATEDIFF(DAY, CONVERT(DATE, CONVERT(VARCHAR(8), FECNTO), 112), GETDATE()) / 365 BETWEEN 50 AND 59 THEN '50-59'
                    ELSE '60+'
                END
            "))->get()->pluck('average_age', 'age_range')->toArray();
    }

    /**
     * Crear el gráfico de distribución de edades.
     *
     * @param array $averageAgeByGroup
     * @return PieChartModel
     */
    private function createAgeDistributionChart($averageAgeByGroup)
    {
        $chart = new PieChartModel();
        $chart->setTitle('Distribución de Edades')
            ->addSlice('De 0 a 19', $this->getGroupAgeValue($averageAgeByGroup, '0-19'), '#f1c40f')
            ->addSlice('De 20 a 29', $this->getGroupAgeValue($averageAgeByGroup, '20-29'), '#1abc9c')
            ->addSlice('De 30 a 39', $this->getGroupAgeValue($averageAgeByGroup, '30-39'), '#3498db')
            ->addSlice('De 40 a 49', $this->getGroupAgeValue($averageAgeByGroup, '40-49'), '#9b59b6')
            ->addSlice('De 50 a 59', $this->getGroupAgeValue($averageAgeByGroup, '50-59'), '#2c3e50')
            ->addSlice('Más de 59', $this->getGroupAgeValue($averageAgeByGroup, '60+'), '#2ecc71')
            ->setAnimated(true)
            ->withLegend()
            ->withOnSliceClickEvent('onSliceClick');

        return $chart;
    }

    /**
     * Obtener el valor del grupo de edad con un fallback en 0.
     *
     * @param array $averageAgeByGroup
     * @param string $ageRange
     * @return int
     */
    private function getGroupAgeValue($averageAgeByGroup, $ageRange)
    {
        return intval(data_get($averageAgeByGroup, $ageRange, 0));
    }
}
