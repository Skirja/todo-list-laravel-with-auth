<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-96">
            @if (session('status'))
                <div class="bg-green-200 text-green-700 p-4 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->has('email'))
                <div class="bg-red-200 text-red-700 p-4 rounded mb-4">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <h2 class="text-2xl font-bold mb-4">Reset Password</h2>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email Address</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Send Password Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
