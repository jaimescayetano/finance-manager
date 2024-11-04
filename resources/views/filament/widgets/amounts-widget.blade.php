<x-filament-widgets::widget>
    <style scoped>
        .container {
            height: 100%;
        }

        .container .grid {
            display: grid;
            gap: 8px;
        }

        .container .grid .card {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .container .grid .card h4 {
            color: #333333;
        }

        .container .grid .card .__info {
            font-size: 12px;
            color: #666666;
        }

        .container .grid .card .__amount {
            font-size: 14px;
            font-weight: 600;
        }
    </style>

    <x-filament::section class="container">
        <div class="grid">
            <x-filament::section>
                <div class="card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="#2D8B2F" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-moneybag">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M9.5 3h5a1.5 1.5 0 0 1 1.5 1.5a3.5 3.5 0 0 1 -3.5 3.5h-1a3.5 3.5 0 0 1 -3.5 -3.5a1.5 1.5 0 0 1 1.5 -1.5z" />
                        <path d="M4 17v-1a8 8 0 1 1 16 0v1a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" />
                    </svg>
                    <div>
                        <h4>Incomes</h4>
                        <p class="__info">{{ $startDate }} - Today</p>
                        <p class="__amount">{{ $prefix . $incomes }}</p>
                    </div>
                </div>
            </x-filament::section>

            <!-- Incomes -->
            <x-filament::section>
                <div class="card">

                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                        fill="none" stroke="#4A4A4A" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17h-11v-14h-2" />
                        <path d="M6 5l14 1l-1 7h-13" />
                    </svg>
                    <div>
                        <h4>Expenses</h4>
                        <p class="__info">{{ $startDate }} - Today</p>
                        <p class="__amount">{{ $prefix . $expenses }}</p>
                    </div>
                </div>
            </x-filament::section>

            <!-- Savings -->
            <x-filament::section>
                <div class="card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                        fill="none" stroke="#F4C6C6" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-pig">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 11v.01" />
                        <path
                            d="M16 3l0 3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342a6.008 6.008 0 0 1 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3z" />
                    </svg>

                    <div>
                        <h4>Savings</h4>
                        <p class="__info">{{ $startDate }} - Today</p>
                        <p class="__amount">{{ $prefix . $savings }}</p>
                    </div>
                </div>
            </x-filament::section>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
