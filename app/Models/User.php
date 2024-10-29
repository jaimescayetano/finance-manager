<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const TABLE_NAME = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance'
    ];

    public static function applySaving(float $amount): array
    {
        $expenseResponse = self::applyExpense($amount);
        if (!$expenseResponse['status']) return $expenseResponse;

        return self::updateSavings(auth()->id(), $amount, 'Savings updated correctly');
    }

    public static function applyExpense(float $amount): array
    {
        $user = auth()->user();
        $userId = $user->id;
        $response = [
            'status' => false,
            'message' => 'Insufficient balance',
            'balance' => $user->balance,
        ];

        if ($amount > $user->balance) {
            return $response;
        }

        return self::updateBalance($userId, -$amount, 'Expense successfully registered');
    }

    public static function applyIncome(float $amount): array
    {
        $user = auth()->user();
        $userId = $user->id;
        $response = [
            'status' => false,
            'message' => 'Invalid income',
            'balance' => $user->balance,
        ];

        if ($amount <= 0) {
            return $response;
        }

        return self::updateBalance($userId, $amount, 'Income successfully registered');
    }

    private static function updateSavings(int $userId, float $amount, string $successMessage): array
    {
        return self::updateMoney($userId, $amount, $successMessage, 'savings');
    }

    private static function updateBalance(int $userId, float $amount, string $successMessage): array
    {
        return self::updateMoney($userId, $amount, $successMessage, 'balance');
    }

    private static function updateMoney(int $userId, float $amount, string $successMessage, string $type): array
    {
        if (!Schema::hasColumn(self::TABLE_NAME, $type)) {
            return [
                'status' => false,
                'message' => 'Invalid operation'
            ];
        }

        $newBalance = DB::transaction(function () use ($userId, $amount, $type) {
            $user = DB::table('users')->where('id', $userId)->lockForUpdate()->first();

            $current = round($user->$type, 2);
            $updated = round($current + $amount, 2);

            DB::table('users')->where('id', $userId)->update([$type => $updated]);

            return $updated;
        });

        return [
            'status' => true,
            'message' => $successMessage,
            'balance' => $newBalance,
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function income_sources()
    {
        return $this->hasMany(IncomeSource::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function actionTracking()
    {
        return $this->hasMany(ActionTracking::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }
}
