export default function notif() {
    return {
        showSuccess: false,
        showError: false,
        showDeletionSuccess: false,

        successMessage: '',
        errorMessage: '',
        deletionMessage: '',

        showSuccessNotification(message = 'Operação concluída com sucesso!') {
            this.successMessage = message;
            this.showSuccess = true;
            setTimeout(() => this.showSuccess = false, 4000);
        },
        hideSuccessNotification() {
            this.showSuccess = false;
        },

        showErrorNotification(message = 'Ocorreu um erro inesperado!') {
            this.errorMessage = message;
            this.showError = true;
            setTimeout(() => this.showError = false, 4000);
        },
        hideErrorNotification() {
            this.showError = false;
        },

        showDeletionSuccessNotification(message = 'Item removido com sucesso!') {
            this.deletionMessage = message;
            this.showDeletionSuccess = true;
            setTimeout(() => this.showDeletionSuccess = false, 4000);
        },
        hideDeletionSuccessNotification() {
            this.showDeletionSuccess = false;
        },
    };
}
