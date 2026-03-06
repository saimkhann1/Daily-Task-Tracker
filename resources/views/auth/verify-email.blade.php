<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Smart Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <div>
            <h2 class="text-3xl font-extrabold text-blue-600 tracking-tight">Daily Task Tracker</h2>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-xl">

            <div class="mb-4 text-sm text-gray-600 leading-relaxed">
                Daily Task Tracker mein sign up karne ka shukriya! Shuru karne se pehle, kya aap apna email address verify kar sakte hain? Humne aapko ek link email kiya hai, us par click karein. Agar aapko email nahi mili, toh hum dobara bhej denge.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-700 bg-green-50 p-4 rounded-lg border border-green-200">
                    Ek naya verification link aapke us email address par bhej diya gaya hai jo aapne registration ke waqt diya tha.
                </div>
            @endif

            <div class="mt-6 flex items-center justify-between">
                
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                        Resend Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-500 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        Log Out
                    </button>
                </form>

            </div>
        </div>
    </div>
</body>
</html>