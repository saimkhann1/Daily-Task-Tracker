<x-app-layout>
    <div class="min-h-screen bg-[#0f172a] text-slate-200">
        <header class="bg-[#1e293b] border-b border-slate-700 shadow-lg">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="font-bold text-2xl text-blue-400 tracking-tight">
                    {{ __('Task Control Center') }}
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-400">Welcome, <span class="text-white font-semibold">{{ Auth::user()->name }}</span></span>
                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-[#1e293b] p-6 rounded-2xl border border-slate-700 shadow-sm">
                        <p class="text-slate-400 text-sm font-medium">Total Tasks</p>
                        <h4 class="text-3xl font-bold text-white mt-1">12</h4>
                    </div>
                    <div class="bg-[#1e293b] p-6 rounded-2xl border border-slate-700 shadow-sm">
                        <p class="text-slate-400 text-sm font-medium">Pending</p>
                        <h4 class="text-3xl font-bold text-yellow-500 mt-1">05</h4>
                    </div>
                    <div class="bg-[#1e293b] p-6 rounded-2xl border border-slate-700 shadow-sm">
                        <p class="text-slate-400 text-sm font-medium">Completed</p>
                        <h4 class="text-3xl font-bold text-green-500 mt-1">07</h4>
                    </div>
                </div>

                <div class="bg-[#1e293b] overflow-hidden shadow-2xl sm:rounded-2xl border border-slate-700">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold text-white">Your Daily To-Do</h3>
                            <button class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl font-medium transition-all shadow-lg shadow-blue-900/20">
                                + New Task
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>