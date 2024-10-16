<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    private static function updateBalance(int $userId, float $amount, string $successMessage): array
    {
        $newBalance = DB::transaction(function () use ($userId, $amount) {
            $user = DB::table('users')->where('id', $userId)->lockForUpdate()->first();

            $currentBalance = round($user->balance, 2);
            $updatedBalance = round($currentBalance + $amount, 2);

            DB::table('users')->where('id', $userId)->update(['balance' => $updatedBalance]);

            return $updatedBalance;
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
}
