<script>
export default {
    data() {
        return {
            form: { email: "", password: "" },
            feedback: "",
            loading: false
        };
    },

    methods: {
        login() {
            this.loading = true;

            axios
                .post("/login", this.form, {
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json'
                    }
                })
                .then(({data: {redirect}}) => {
                    location.assign(redirect);
                })
                .catch(error => {
                    this.feedback =
                        "Данные неккоректны, повторите еще раз.";
                    this.loading = false;
                });
        },

        register() {
            this.$modal.hide("login");
            this.$modal.show("register");
        }
    }
};
</script>
