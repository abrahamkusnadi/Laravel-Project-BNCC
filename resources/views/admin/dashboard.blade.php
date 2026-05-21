@extends('layout.admin')

@section('title', 'Admin Dashboard')

@section('content')
    {{-- Greeting --}}
    <div class="bg-gray-900 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <h1 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-gray-400">Here is what's happening with your store today.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $stats = [
                ['label' => 'Total Users', 'value' => $data['total_users'], 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857', 'color' => 'indigo'],
                ['label' => 'Total Products', 'value' => $data['total_products'], 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4', 'color' => 'blue'],
                ['label' => 'Categories', 'value' => $data['total_categories'], 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6', 'color' => 'purple'],
                ['label' => 'Total Revenue', 'value' => 'Rp ' . number_format($data['total_revenue'], 0, ',', '.'), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2', 'color' => 'green'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-{{$stat['color']}}-50 text-{{$stat['color']}}-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{$stat['icon']}}"></path></svg>
                </div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Recent Orders Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h2 class="text-lg font-bold text-gray-900">Recent Completed Orders</h2>
        </div>
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500">
                <tr>
                    <th class="py-4 px-6 font-medium">Invoice #</th>
                    <th class="py-4 px-6 font-medium">Customer</th>
                    <th class="py-4 px-6 font-medium">Date</th>
                    <th class="py-4 px-6 font-medium text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($data['recent_orders'] as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-semibold text-blue-600">{{ $order->invoice_number }}</td>
                        <td class="py-4 px-6 text-gray-700">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="py-4 px-6 text-right font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-8 text-center text-gray-400">No completed orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection