export default function passwordToggle() {
    return {
        show: false,
        toggle() {
            this.show = !this.show;
        }
    }
}
