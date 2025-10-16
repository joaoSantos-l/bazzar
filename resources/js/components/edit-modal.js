export default function editModal() {
    return {
        isOpen: false,
        open() {
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
        }
    }
}
