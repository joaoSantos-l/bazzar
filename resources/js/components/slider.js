document.addEventListener('alpine:init', () => {
    Alpine.data('carousel', () => ({
        controle: 0,
        slides: [
            {
                title: 'Bem-vindo ao Bazzar',
                text: 'Gerencie produtos, carrinho, wishlist e muito mais de forma prática.',
                image: '/build/assets/hero1.jpg'
            },
            {
                title: 'Venda com Segurança',
                text: 'Proteja os dados dos seus clientes com autenticação avançada.',
                image: '/build/assets/hero2.jpg'
            },
            {
                title: 'Suporte Dedicado',
                text: 'Conte com nossa equipe pronta para ajudar sempre que precisar.',
                image: '/build/assets/hero3.jpg'
            }
        ],
        intervalId: null,

        next() {
            this.controle = (this.controle + 1) % this.slides.length;
            this.resetTimer();
        },
        prev() {
            this.controle = (this.controle - 1 + this.slides.length) % this.slides.length;
            this.resetTimer();
        },
        goTo(index) {
            this.controle = index;
            this.resetTimer();
        },
        start() {
            this.intervalId = setInterval(() => {
                this.nextNoReset();
            }, 5000);
        },
        resetTimer() {
            clearInterval(this.intervalId);
            this.start();
        },
        nextNoReset() {
            this.controle = (this.controle + 1) % this.slides.length;
        }
    }));
});
