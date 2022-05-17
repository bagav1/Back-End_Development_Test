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
        }
    }
}
