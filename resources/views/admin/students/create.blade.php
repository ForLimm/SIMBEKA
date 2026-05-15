<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa Baru - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="container mx-auto p-6 max-w-2xl">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Siswa Baru</h1>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.students.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Siswa</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded p-2" required value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded p-2" required value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">NISN</label>
                <input type="text" name="nisn" class="w-full border border-gray-300 rounded p-2" value="{{ old('nisn') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Kelas</label>
                <input type="text" name="class" class="w-full border border-gray-300 rounded p-2" required value="{{ old('class') }}">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Pilih Guru BK Pembimbing</label>
                <select name="teacher_id" class="w-full border border-gray-300 rounded p-2 bg-white" required>
                    <option value="" disabled selected>-- Pilih Guru BK --</option>
                    @foreach($teachers as $teacher)
                        @php
                            $isFull = $teacher->students_count >= $teacher->max_quota;
                        @endphp
                        <option value="{{ $teacher->id }}" {{ $isFull ? 'disabled' : '' }} class="{{ $isFull ? 'text-red-500 bg-red-50' : '' }}">
                            {{ $teacher->user->name }} (Terisi: {{ $teacher->students_count }}/{{ $teacher->max_quota }}) 
                            @if($isFull) - [KUOTA PENUH] @endif
                        </option>
                    @endforeach
                </select>
                @if($errors->has('teacher_id'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('teacher_id') }}</p>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Simpan Siswa</button>
            </div>
        </form>
    </div>
</body>
</html>
