export default function deleteConfirm() {
    return {
        confirm: false,

        trigger(event) {
            event.preventDefault();

            if (!this.confirm) {
                this.confirm = true;
                setTimeout(() => {
                    this.confirm = false;
                }, 3000);
            } else {
                this.$root.submit();
            }
        },

        showDeletionSuccessNotification() {
            this.showDeletionSuccess = true;
            setTimeout(() => {
                this.hideDeletionSuccessNotification();
            }, 5000);
        },

        hideDeletionSuccessNotification() {
            this.showDeletionSuccess = false;
        }
    }
}