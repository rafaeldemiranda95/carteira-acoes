<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

interface Stock {
    id: number;
    symbol: string;
    name: string;
    close: number;
    change: number;
    volume: number;
    market_cap: number;
    logo_url: string;
    sector: string;
    type: string;
}

import { usePage } from '@inertiajs/vue3';

const page = usePage();
const stocks = page.props.stocks as Stock[];
</script>

<template>

    <Head title="Ações" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Ações
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Loop para cada ação -->
                    <div v-for="(stock, index) in stocks" :key="index"
                        class="overflow-hidden bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow border">
                        <!-- Cabeçalho do card com imagem -->
                        <div class="p-4 bg-gradient-to-r from-blue-500 to-blue-400 flex items-center justify-center">
                            <img :src="stock.logo_url" alt="Logo"
                                class="w-20 h-20 rounded-full bg-white object-contain shadow-md border" />
                        </div>
                        <!-- Informações da ação -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ stock.name }}
                            </h3>
                            <p class="text-sm text-gray-500 mb-4">
                                {{ stock.symbol }} - {{ stock.sector }}
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-500">
                                        <strong>Fechamento:</strong>
                                    </p>
                                    <p class="text-lg font-semibold text-gray-800">
                                        R$ {{ stock.close ? stock.close.toFixed(2) : 'N/A' }}

                                    </p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-500">
                                        <strong>Variação:</strong>
                                    </p>
                                    <p :class="{
                                        'text-green-500': stock.change > 0,
                                        'text-red-500': stock.change < 0,
                                    }" class="text-lg font-semibold">
                                        {{ stock.change !== null && stock.change !== undefined ? stock.change.toFixed(2)
                                            : 'N/A'
                                        }}%
                                    </p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-500">
                                        <strong>Volume:</strong>
                                    </p>
                                    <p class="text-sm text-gray-800">
                                        {{ stock.volume }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-500">
                                        <strong>Market Cap:</strong>
                                    </p>
                                    <p class="text-sm text-gray-800">
                                        R$ {{ stock.market_cap ? stock.market_cap.toLocaleString() : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Rodapé do card -->
                        <div class="p-4 bg-gray-50 border-t">
                            <button @click="$inertia.get(route('stocks.show', { stock: stock.id }))"
                                class="w-full px-4 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:bg-blue-600 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-50">
                                Ver Detalhes
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
