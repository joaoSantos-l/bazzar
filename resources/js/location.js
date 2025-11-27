import axios from 'axios';

async function fetchStates() {
    try {
        const response = await axios.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        return response.data.sort((a, b) => a.nome.localeCompare(b.nome));
    } catch (error) {
        console.error("Erro ao buscar estados:", error);
        return [];
    }
}

async function fetchCities(ufCode) {
    if (!ufCode) return [];
    try {
        const url = `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${ufCode}/municipios`;
        const response = await axios.get(url);
        return response.data.sort((a, b) => a.nome.localeCompare(b.nome));
    } catch (error) {
        console.error(`Erro ao buscar cidades para UF ${ufCode}:`, error);
        return [];
    }
}

export default function location() {
    return {
        states: [],
        cities: [],
        selectedState: '',
        selectedCity: '',
        loading: {
            states: true,
            cities: false,
        },
        
        async init() {
            this.states = await fetchStates();
            this.loading.states = false;
        },

        async loadCities() {
            if (!this.selectedState) {
                this.cities = [];
                this.selectedCity = '';
                return;
            }

            this.loading.cities = true;
            this.selectedCity = '';
            
            this.cities = await fetchCities(this.selectedState);
            this.loading.cities = false;
        },
        
        getCityPlaceholder() {
            if (this.loading.cities) return 'Carregando cidades...';
            if (!this.selectedState) return 'Selecione um Estado primeiro';
            if (this.cities.length === 0) return 'Nenhuma cidade encontrada';
            return 'Sua cidade';
        }
    }
}