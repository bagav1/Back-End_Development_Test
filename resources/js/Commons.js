export default {
    data() {
        return {
            //
        }
    },
    methods: {
        async callApi(method, url, data) {
            return await axios({
                method: method,
                url: location.origin + url,
                data: data,
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem("token")}`,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;multipart/form-data'
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        i(desc, title = "Atencion") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title = "Genial!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title = "Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title = "Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    }
}
