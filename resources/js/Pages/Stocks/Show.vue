<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Tipar os dados se estiver usando TypeScript
interface Dividend {
    date: string;
    value: number;
}

interface Stock {
    id: number;
    symbol: string;
    name: string;
    short_name: string | null;
    type: string;
    currency: string;
    price: number | null;
    change: number | null;
    change_percent: number | null;
    day_high: number | null;
    day_low: number | null;
    day_open: number | null;
    volume: number | null;
    previous_close: number | null;
    pe_ratio: number | null;
    eps: number | null;
    logo_url: string | null;
    fifty_two_week_range: string | null;
    fifty_two_week_low: number | null;
    fifty_two_week_high: number | null;
    close: number | null;
    sector: string | null;
    market_cap: number | null;
    description: string | null;
}

import { usePage } from '@inertiajs/vue3';
const page = usePage();
const stock = page.props.stock as Stock;
const dividends = page.props.dividends as Dividend[];
</script>

<template>

    <Head :title="`Detalhes da Ação - ${stock.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Detalhes da Ação - {{ stock.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <!-- Botão para voltar -->
                <div class="mb-4">
                    <Link :href="route('stocks')"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-semibold text-sm leading-tight rounded-md shadow hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Voltar
                    </Link>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <!-- Cabeçalho com imagem centralizada -->
                    <div class="p-6 text-center bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <div class="flex justify-center items-center">
                            <img v-if="stock.logo_url" :src="stock.logo_url" alt="Logo da ação"
                                class="w-40 h-40 object-contain rounded-full shadow-lg border bg-white" />
                        </div>
                        <h3 class="mt-4 text-3xl font-bold">{{ stock.name }}</h3>
                        <p class="text-lg">{{ stock.symbol }} - {{ stock.sector }}</p>
                        <p class="text-sm text-gray-100 mt-2">{{ stock.description || 'Sem descrição disponível.' }}</p>
                    </div>

                    <!-- Detalhes da ação -->
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Preço de Fechamento</p>
                                <p class="text-lg font-bold text-gray-900">R$ {{ stock.close?.toFixed(2) || 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Variação</p>
                                <p :class="{
                                    'text-green-500': stock.change && stock.change > 0,
                                    'text-red-500': stock.change && stock.change < 0,
                                }" class="text-lg font-bold">
                                    {{ stock.change?.toFixed(2) || 'N/A' }}%
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Preço Atual</p>
                                <p class="text-lg font-bold text-gray-900">R$ {{ stock.price?.toFixed(2) || 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Volume Negociado</p>
                                <p class="text-lg font-bold text-gray-900">{{ stock.volume?.toLocaleString() || 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Market Cap</p>
                                <p class="text-lg font-bold text-gray-900">R$ {{ stock.market_cap?.toLocaleString() ||
                                    'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Máximo (52 semanas)</p>
                                <p class="text-lg font-bold text-gray-900">R$ {{ stock.fifty_two_week_high?.toFixed(2)
                                    || 'N/A'
                                    }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Mínimo (52 semanas)</p>
                                <p class="text-lg font-bold text-gray-900">R$ {{ stock.fifty_two_week_low?.toFixed(2) ||
                                    'N/A'
                                    }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">Faixa (52 semanas)</p>
                                <p class="text-lg font-bold text-gray-900">{{ stock.fifty_two_week_range || 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">PE Ratio</p>
                                <p class="text-lg font-bold text-gray-900">{{ stock.pe_ratio?.toFixed(2) || 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold">EPS</p>
                                <p class="text-lg font-bold text-gray-900">{{ stock.eps?.toFixed(2) || 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Calendário de Dividendos -->
                    <div class="p-6 space-y-4">
                        <h3 class="text-lg font-semibold">Calendário de Dividendos</h3>
                        <table class="min-w-full bg-white border border-gray-200 rounded-md">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Data</th>
                                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-600">Valor (R$)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="dividend in dividends" :key="dividend.date">
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ new
                                        Date(dividend.date).toLocaleDateString()
                                        }}</td>
                                    <td class="px-4 py-2 text-right text-sm text-gray-700">R$ {{ Number(dividend.value
                                        ||
                                        0).toFixed(2) }}</td>
                                </tr>
                                <tr v-if="!dividends.length">
                                    <td class="px-4 py-2 text-sm text-gray-500 text-center" colspan="2">Nenhum dividendo
                                        disponível.</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
