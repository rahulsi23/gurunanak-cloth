@extends('layouts.admin')

@section('title', 'hPanel Enterprise - Dashboard')

@section('content')
    <!-- Statistics / Rapid Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Revenue Card -->
        <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-violet-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
            </div>
            <div class="relative z-10">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Total Revenue</span>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-brand font-bold text-white tracking-tight">${{ number_format($totalRevenue, 2) }}</span>
                    <span class="text-[10px] text-emerald-400 font-bold bg-emerald-400/10 px-1.5 py-0.5 rounded mb-1">+12.4%</span>
                </div>
            </div>
        </div>

        <!-- Active Orders Card -->
        <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Active Orders</span>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-brand font-bold text-white tracking-tight">{{ $activeOrders }}</span>
                    <span class="text-[10px] text-amber-400 font-bold bg-amber-400/10 px-1.5 py-0.5 rounded mb-1">In Process</span>
                </div>
            </div>
        </div>

        <!-- Total Customers Card -->
        <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Total Users</span>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-brand font-bold text-white tracking-tight">{{ $totalUsers }}</span>
                    <span class="text-[10px] text-violet-400 font-bold bg-violet-400/10 px-1.5 py-0.5 rounded mb-1">{{ $adminUsers }} Admins</span>
                </div>
            </div>
        </div>

        <!-- Completed Shipments -->
        <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-1">Delivered</span>
                <div class="flex items-end gap-2">
                    <span class="text-2xl font-brand font-bold text-white tracking-tight">{{ $deliveredOrders }}</span>
                    <span class="text-[10px] text-emerald-400 font-bold bg-emerald-400/10 px-1.5 py-0.5 rounded mb-1">Lifetime</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts & Advanced Analytics Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Main Sales Chart -->
        <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="font-brand font-bold text-sm text-white">Revenue Analytics</h3>
                    <p class="text-[10px] text-slate-500 font-medium">Monthly revenue progression for the last 6 months</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-800/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                        Gross Sales
                    </span>
                </div>
            </div>
            <div class="p-6 flex-1 bg-slate-900/40">
                <div id="analyticsChart" class="w-full h-80"></div>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-800">
                <h3 class="font-brand font-bold text-sm text-white">Live Activity</h3>
                <p class="text-[10px] text-slate-500 font-medium">Real-time system & order events</p>
            </div>
            <div class="p-4 flex-1 space-y-4 overflow-y-auto max-h-[350px]">
                <div class="flex gap-4 items-start group">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-slate-200 leading-tight">New Order <span class="font-bold text-violet-400">#ORD-2941</span> received</p>
                        <span class="text-[10px] text-slate-500 mt-1 block italic">2 mins ago • $1,240.00</span>
                    </div>
                </div>

                <div class="flex gap-4 items-start group">
                    <div class="w-8 h-8 rounded-lg bg-violet-500/10 border border-violet-500/20 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-slate-200 leading-tight">New Customer <span class="font-bold text-violet-400">Sarah Jenkins</span> joined</p>
                        <span class="text-[10px] text-slate-500 mt-1 block italic">1 hour ago • London, UK</span>
                    </div>
                </div>
            </div>
            <a href="#" class="p-3 text-center border-t border-slate-800 text-[10px] font-bold text-violet-400 hover:bg-violet-600/5 transition-all">View Full System Log →</a>
        </div>

    </div>

    <!-- Featured Management Row -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-xl">
                <h3 class="font-brand font-bold text-lg text-white mb-2">Welcome back, Control Center is Ready.</h3>
                <p class="text-xs text-slate-400 leading-relaxed font-medium">Your storefront is currently active and performing optimally. Use the quick action tools below to manage your premium inventory or customize your user experience.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>New Product</span>
                </a>
                <a href="/" target="_blank" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-all border border-slate-700">View Storefront</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const options = {
                series: [{
                    name: 'Gross Sales ($)',
                    type: 'area',
                    data: @json($salesData['revenue'])
                }, {
                    name: 'Total Orders',
                    type: 'column',
                    data: @json($salesData['orders'])
                }],
                chart: {
                    height: 320,
                    type: 'line',
                    stacked: false,
                    toolbar: { show: false },
                    background: 'transparent',
                    foreColor: '#64748b',
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                },
                theme: {
                    mode: 'dark'
                },
                stroke: {
                    width: [3, 0],
                    curve: 'smooth',
                    colors: ['#7c3aed']
                },
                plotOptions: {
                    bar: {
                        columnWidth: '40%',
                        borderRadius: 6
                    }
                },
                colors: ['#7c3aed', '#10b981'],
                fill: {
                    type: ['gradient', 'solid'],
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                labels: @json($salesData['labels']),
                markers: {
                    size: 4,
                    colors: ['#7c3aed'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: { size: 6 }
                },
                grid: {
                    borderColor: '#1e293b',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } }
                },
                xaxis: {
                    type: 'category',
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: [{
                    title: {
                        text: "Sales Revenue ($)",
                        style: { color: '#7c3aed', fontWeight: 600 }
                    },
                    labels: {
                        formatter: function (val) {
                            return "$" + val.toFixed(0);
                        }
                    }
                }, {
                    opposite: true,
                    title: {
                        text: "Total Orders",
                        style: { color: '#10b981', fontWeight: 600 }
                    },
                    labels: {
                        formatter: function (val) {
                            return val.toFixed(0);
                        }
                    }
                }],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        }
                    },
                    theme: 'dark'
                },
                legend: {
                    horizontalAlign: 'right',
                    offsetX: 40,
                    labels: { colors: '#94a3b8' }
                }
            };

            const chart = new ApexCharts(document.querySelector("#analyticsChart"), options);
            chart.render();
        });
    </script>
@endsection
