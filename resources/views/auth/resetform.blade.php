<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer>
        function toggleVisibility(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function validateForm(e) {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;

            if (pass !== confirm) {
                e.preventDefault();
                alert("Password dan konfirmasi harus sama!");
            }
        }
    </script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white to-blue-100">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
        <a href="/" ><div class="mb-6 text-center">
            <img src="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" alt="Logo SMKN 8 Jakarta" class="w-20 h-20 mx-auto">
        </div></a>
        </div>

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>
        <h3 class="text-1xl text-center m-3">{{ $email }}</h3>

    <form method="GET" action="{{ route('resetpassfeedback') }}" onsubmit="return validateForm(event)">
    @csrf

    {{-- Hidden token or email param --}}
    <input type="hidden" name="oldpassword" value="{{ request()->route('data') }}">

    <!-- New Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
        <div class="relative">
            <input type="password" id="password" name="newpassword" required
                class="mt-1 block w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-200 shadow-sm">
            <button type="button" onclick="toggleVisibility('password')"
                class="absolute right-3 top-2 text-sm text-gray-500">👁️</button>
        </div>
    </div>

    <!-- Confirm Password -->
    <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <div class="relative">
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="mt-1 block w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-200 shadow-sm">
            <button type="button" onclick="toggleVisibility('password_confirmation')"
                class="absolute right-3 top-2 text-sm text-gray-500">👁️</button>
        </div>
    </div>

    <!-- Reminder -->
    <div class="text-sm text-gray-600 mb-4">
        🔐 <strong>Ingat baik-baik password yang Anda masukkan 🙂</strong>
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
            Reset Password
        </button>
    </div>
</form>

<!-- JS Validation + Toggle Visibility -->
<script>
function toggleVisibility(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}

function validateForm(event) {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    
    if (password !== confirmation) {
        alert('Password dan konfirmasi harus sama!');
        event.preventDefault();
        return false;
    }
    return true;
}
</script>

    </div>

</body>
</html>
