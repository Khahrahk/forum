<template>
    <div class="py-6 ml-10">
        <div v-if="! signedIn">
            <p class="text-center text-sm text-grey-dark">
                Пожалуйста <a href="/login" @click.prevent="$modal.show('login')" class="text-grey link">войдите</a> что бы общаться.
            </p>
        </div>

        <div v-else-if="! confirmed">
            Чтобы общаться, подтвердите ваш Email
        </div>

        <div v-else>
            <div class="mb-3">
                <wysiwyg name="body" v-model="body" placeholder="Есть что сказать?"></wysiwyg>
            </div>

            <button type="submit"
                    class="btn bg-black hover:bg-grey-darkest"
                    @click="addReply">Запостить</button>
        </div>
    </div>
</template>

<script>
import "jquery.caret";
import "at.js";

export default {
    data() {
        return {
            body: ""
        };
    },

    computed: {
        confirmed() {
            return window.App.user.confirmed;
        }
    },

    mounted() {
        $("#body").atwho({
            at: "@",
            delay: 750,
            callbacks: {
                remoteFilter: function(query, callback) {
                    $.getJSON("/api/users", { name: query }, function(
                        usernames
                    ) {
                        callback(usernames);
                    });
                }
            }
        });
    },

    methods: {
        addReply() {
            axios
                .post(location.pathname + "/replies", { body: this.body })
                .catch(error => {
                    flash(error.response.data, "danger");
                })
                .then(({ data }) => {
                    this.body = "";

                    flash("Ваш ответ был опубликован.");

                    this.$emit("created", data);
                });
        }
    }
};
</script>

<style scoped>
.new-reply {
    background-color: #fff;
}
</style>
