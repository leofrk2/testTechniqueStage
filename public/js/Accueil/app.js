Vue.component("modal", {
    template: "#modal-template",
});

new Vue({
    delimiters: ['${', '}'],
    el: '#app',
    data: {
        theme : false,
        showModal: false,
    },
    watch: {
        theme() {
            document.querySelector('body').style.backgroundColor = this.theme ? '#F4ABC4' : null;
            document.querySelector('.container').style.backgroundColor = this.theme ? '#595B83' : null;
            document.querySelector('h1').style.color = this.theme ? '#333456' : null;
            document.querySelector('.btn1').style.backgroundColor = this.theme ? '#060930' : null;
            document.querySelector('.btn2').style.backgroundColor = this.theme ? '#060930' : null;
            document.querySelector('.btn3').style.backgroundColor = this.theme ? '#060930' : null;
            document.querySelector('.btn4').style.backgroundColor = this.theme ? '#060930' : null;
        }
    },
    methods: {
    }
})



