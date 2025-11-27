export default function searchComponent() {
    return {
        query: '',
        results: '',
        isLoading: false,
        isVisible: false,
        searchTimeout: null,
        controller: null,

        init() {
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.isVisible = false;
                }
            });
            this.$el.addEventListener('submit', this.handleFormSubmit.bind(this));
        },

        handleFormSubmit(e) {
            if (this.query.trim() === '') {
                e.preventDefault();
                return;
            }
            
            this.isVisible = false; 
        },

        performSearch(source = 'input') {
            const query = this.query.trim();

            clearTimeout(this.searchTimeout);

            if (query === '') {
                this.isVisible = false;
                this.results = '';
                if (this.controller) {
                    this.controller.abort();
                    this.controller = null;
                }
                return;
            }

            this.isLoading = true;
            this.isVisible = true;

            this.searchTimeout = setTimeout(() => {
                this.executeSearch(query);
            }, 300);
        },

        executeSearch(query) {
            if (this.controller) {
                this.controller.abort();
            }
            this.controller = new AbortController();
            const url = this.$el.action || window.location.href;

            axios.get(url, {
                params: {
                    q: query,
                    ajax: true
                },
                signal: this.controller.signal
            })
            .then(response => {
                this.results = response.data;
                this.isLoading = false;
            })
            .catch(error => {
                if (axios.isCancel(error) || error.name === 'AbortError') {
                    return; 
                }
                console.error('Search error:', error);
                this.results = '<div class="p-4 text-gray-500">Erro na busca</div>';
                this.isLoading = false;
            })
            .finally(() => {
                this.controller = null;
            });
        },

        clearSearch() {
            this.query = '';
            this.isVisible = false;
            this.results = '';
            this.isLoading = false;

            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            if (this.controller) {
                this.controller.abort();
                this.controller = null;
            }
        },
        
        selectProduct() {
            this.isVisible = false;
        }
    }
}