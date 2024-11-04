<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BalanceOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $user = auth()->user();

        return [
            Stat::make('Balance', $user->balance)
                ->description('Available balance')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Expenses', Expense::getPercentaje(Expense::TYPE_ACTION) . '%')
                ->description($this->getPercentageChangeDescription(Expense::class, $user->id))
                ->descriptionIcon($this->getPercentageChangeIcon(Expense::class, $user->id))
                ->color($this->getPercentageChangeColor(Expense::class, $user->id)),

            Stat::make('Incomes', Income::getPercentaje(Income::TYPE_ACTION) . '%')
                ->description($this->getPercentageChangeDescription(Income::class, $user->id))
                ->descriptionIcon($this->getPercentageChangeIcon(Income::class, $user->id))
                ->color($this->getPercentageChangeColor(Income::class, $user->id)),

            Stat::make('Savings', $user->savings ?? 0)
                ->description('Saved')
                ->descriptionIcon('heroicon-o-star')
                ->color('primary'),
        ];
    }

    /**
     * Calcula el porcentaje de cambio entre el mes actual y el anterior para un modelo específico.
     *
     * @param string $modelClass - Clase del modelo (Expense o Income).
     * @param int $userId - ID del usuario.
     * @return float - Porcentaje de cambio.
     */
    private function calculatePercentageChange(string $modelClass, int $userId): float
    {
        $currentMonth = $modelClass::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $previousMonth = $modelClass::where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('amount');

        // Calcula el porcentaje de cambio
        return $previousMonth != 0
            ? (($currentMonth - $previousMonth) / $previousMonth) * 100
            : 100;
    }

    /**
     * Genera una descripción del porcentaje de cambio.
     *
     * @param string $modelClass - Clase del modelo.
     * @param int $userId - ID del usuario.
     * @return string - Descripción del porcentaje.
     */
    private function getPercentageChangeDescription(string $modelClass, int $userId): string
    {
        $percentageChange = $this->calculatePercentageChange($modelClass, $userId);
        return ($percentageChange >= 0 ? '+' : '') . round($percentageChange, 2) . '% vs last month';
    }

    /**
     * Determina el ícono según el porcentaje de cambio.
     *
     * @param string $modelClass - Clase del modelo.
     * @param int $userId - ID del usuario.
     * @return string - Ícono.
     */
    private function getPercentageChangeIcon(string $modelClass, int $userId): string
    {
        $percentageChange = $this->calculatePercentageChange($modelClass, $userId);
        return $percentageChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
    }

    /**
     * Determina el color según el porcentaje de cambio.
     *
     * @param string $modelClass - Clase del modelo.
     * @param int $userId - ID del usuario.
     * @return string - Color.
     */
    private function getPercentageChangeColor(string $modelClass, int $userId): string
    {
        $percentageChange = $this->calculatePercentageChange($modelClass, $userId);

        // Diferente lógica para gastos
        if ($modelClass === Expense::class) {
            return $percentageChange >= 0 ? 'danger' : 'success'; // Rojo si aumenta, verde si disminuye
        }

        // Por defecto, ingresos: verde si aumenta, rojo si disminuye
        return $percentageChange >= 0 ? 'success' : 'danger';
    }
}
