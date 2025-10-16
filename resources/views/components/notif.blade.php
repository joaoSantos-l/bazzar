<div x-data="notif()" x-init="@if (session('success')) setTimeout(() => showSuccessNotification('{{ session('success') }}'), 100) @endif
@if (session('deletion-success')) setTimeout(() => showDeletionSuccessNotification('{{ session('deletion-success') }}'), 100) @endif
@if (session('error')) setTimeout(() => showErrorNotification('{{ session('error') }}'), 100) @endif">
    <div x-show="showSuccess" x-transition
        class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 flex items-center gap-2"
        style="display: none;">
        <i class="bi bi-check-circle-fill text-xl"></i>
        <span x-text="successMessage"></span>
        <button @click="hideSuccessNotification()" class="ml-2 hover:text-green-200">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div x-show="showError" x-transition
        class="fixed top-6 right-6 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 flex items-center gap-2"
        style="display: none;">
        <i class="bi bi-exclamation-circle-fill text-xl"></i>
        <span x-text="errorMessage"></span>
        <button @click="hideErrorNotification()" class="ml-2 hover:text-red-200">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div x-show="showDeletionSuccess" x-transition
        class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 flex items-center gap-2"
        style="display: none;">
        <i class="bi bi-trash-fill text-xl"></i>
        <span x-text="deletionMessage"></span>
        <button @click="hideDeletionSuccessNotification()" class="ml-2 hover:text-green-200">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</div>
