<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-2 text-gray-700">Welcome, {{ $user->name }}!</h2>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-2 text-gray-700">Current Time</h2>
                <p class="text-gray-600">{{ $currentTime }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-2 text-gray-700">Total Accounts</h2>
                <p class="text-gray-600">{{ $totalAccounts }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Todo List</h2>
            <ul class="space-y-4">
                @foreach ($todos as $todo)
                    <li class="bg-white rounded-lg shadow-md p-4 flex items-center justify-between">
                        <div>
                            <div class="flex items-center">
                                <form method="POST" action="/todos/{{ $todo->id }}/complete" class="mr-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                        @if ($todo->completed)
                                            Mark Incomplete
                                        @else
                                            Mark Complete
                                        @endif
                                    </button>
                                </form>
                                <span class="text-gray-800 font-medium">{{ $todo->task }}</span>
                            </div>
                            <div class="text-gray-600 text-sm mt-1">
                                Due: {{ $todo->due_date }} &amp;bull; Created: {{ $todo->created_at }}
                            </div>
                        </div>
                        <div>
                            <form method="POST" action="/todos/{{ $todo->id }}" class="ml-2 inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                            </form>
                            <button type="button" data-id="{{ $todo->id }}" data-task="{{ $todo->task }}" data-due-date="{{ $todo->due_date }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded ml-2 edit-button">Edit</button>
                        </div>
                    </li>
                @endforeach
            </ul>

            <form method="POST" action="/todos" class="mt-4">
                @csrf
                <div class="mb-2">
                    <label for="task" class="block text-gray-700 font-bold mb-1">Add new todo</label>
                    <input type="text" name="task" id="task" class="border rounded px-2 py-1 w-full" required>
                </div>
                <div class="mb-2">
                    <label for="due_date" class="block text-gray-700 font-bold mb-1">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="border rounded px-2 py-1 w-full">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Todo</button>
            </form>
        </div>

        <div class="mt-6">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</button>
            </form>
        </div>
    </div>

    <div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto">
        <div class="bg-white mx-auto mt-10 p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Edit Todo</h2>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                <div class="mb-4">
                    <label for="edit-task" class="block text-gray-700 font-bold mb-2">Task</label>
                    <input type="text" name="task" id="edit-task" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="edit-due-date" class="block text-gray-700 font-bold mb-2">Due Date</label>
                    <input type="date" name="due_date" id="edit-due-date" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="edit-completed" class="block text-gray-700 font-bold mb-2">Completed</label>
                    <input type="checkbox" name="completed" id="edit-completed">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Todo</button>
            </form>
        </div>
    </div>

    <script>
        const editButtons = document.querySelectorAll('.edit-button');
        const editModal = document.getElementById('edit-modal');
        const editForm = document.getElementById('edit-form');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const todoId = button.dataset.id;
                const todoTask = button.dataset.task;
                const todoDueDate = button.dataset.dueDate;

                document.getElementById('edit-id').value = todoId;
                document.getElementById('edit-task').value = todoTask;
                document.getElementById('edit-due-date').value = todoDueDate;
                editModal.classList.remove('hidden');
            });
        });

        editForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(editForm);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            formData.append('_token', csrfToken);
            const url = `/todos/${document.getElementById('edit-id').value}`;
            fetch(url, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error updating todo');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating todo');
            });
        });

        document.addEventListener('click', (event) => {
            if (event.target === editModal) {
                editModal.classList.add('hidden');
            }
        });
    </script>

</body>

</html>
