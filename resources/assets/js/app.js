
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

/*

const app = new Vue({
    el: '#app'
});
*/


new Vue({
    el: '#aml',
    created: function() {
        this.getFacturas(1);
        this.getEmpresas();
        this.getClientes();
    },

    data: {
        facturas: [],
        empresas: [],
        clientes: [],
        pagination: {
            "total": 0,
            "count": 0,
            "per_page": 0,
            "current_page": 0,
            "total_pages": 0,
            "links": {
                "next": "https://aml-api.dev/api/facturas?page=1"
            }
        },

        newFactura: {'numero': '', 'subtotal':'', 'empresa_id': '', 'cliente_id': ''},
        fillFactura: {'id': '', 'subtotal': ''},
        errors: '',
        offset: 5,
    },
    computed: {
        isActived: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if(!this.pagination.total_pages){
                return [];
            }

            let from = this.pagination.current_page - this.offset;
            if(from < 1){
                from = 1;
            }

            let to = from + (this.offset * 2);
            if(to >= this.pagination.total_pages){
                to = this.pagination.total_pages;
            }

            let pagesArray = [];
            while(from <= to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    methods: {
        getFacturas: function(page) {
            let urlFacturas = 'api/facturas?page='+page;
            axios.get(urlFacturas).then(response => {
                this.facturas = response.data.data
                this.pagination = response.data.meta.pagination
            });
        },
        editFactura: function(factura) {
            this.fillFactura.id   = factura.id;
            this.fillFactura.subtotal = factura.subtotal;
            $('#edit').modal('show');
        },
        updateFactura: function(id) {
            let url = 'api/facturas/' + id;
            axios.put(url, this.fillFactura).then(response => {
                this.getFacturas();
                this.fillFactura = {'id': '', 'subtotal': ''};
                this.errors = [];
                $('#edit').modal('hide');
                toastr.success('Factura actualizada');
            }).catch(error => {
                this.errors =  error.response
            });
        },
        createFactura: function() {
            let url = 'api/facturas';
            axios.post(url, this.newFactura).then(response => {
                this.getFacturas();
                this.newFactura = {};
                this.errors = [];
                $('#create').modal('hide');
                toastr.success('Nueva factura');
            }).catch(error => {
                this.errors =  error.response
            });
        },

        getEmpresas: function() {
            let urlEmpresas = 'api/empresas';
            axios.get(urlEmpresas).then(response => {
                this.empresas = response.data.data
            });
        },

        getClientes: function() {
            let urlClientes = 'api/clientes';
            axios.get(urlClientes).then(response => {
                this.clientes = response.data.data
            });
        },

        changePage: function(page) {
            this.pagination.current_page = page;
            this.getFacturas(page);
        }
    }
});
