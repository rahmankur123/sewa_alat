<header class="bg-white shadow p-4 flex justify-between items-center">

<div class="flex items-center gap-3">
<img src="https://cdn-icons-png.flaticon.com/512/2966/2966480.png" class="w-8">
<h1 class="font-bold text-xl text-indigo-600">Sistem Persewaan Alat Bela Diri</h1>
</div>

<div class="flex items-center gap-4">

<div class="text-right">
<p class="font-semibold">{{ auth()->user()->name }}</p>
<p class="text-sm text-gray-500">
Role:
<span class="text-indigo-600 font-bold">
{{ auth()->user()->role }}
</span>
</p>
</div>

<img src="https://i.pravatar.cc/40" class="rounded-full border">

<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
Logout
</button>
</form>

</div>

</header>