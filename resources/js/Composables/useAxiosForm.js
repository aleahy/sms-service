
//The form data is placed as an object in the
//usage:
//import {useForm} from '@/composables/Form';
//const form = useForm({a: 10, b: 15});
//form.submit('post', '/login');
import {reactive} from "vue";

export default function useAxiosForm(data) {
    const originalData = {...data};

    const form = reactive({
        ...data,
        loading: false,
        errors: {},
        submit(method, url) {
            this.loading = true;
            this.clearErrors();
            return new Promise(async (resolve, reject) => {

                try {
                    let response = undefined;
                    if (data) {
                        response = await axios[method](url, this.data());
                    }
                    else {
                        response = await axios[method](url);
                    }
                    resolve(response.data);
                }
                catch(error) {
                    let errorData = error.response.data.errors;
                    for (let field in errorData) {
                        this.setError(field, errorData[field][0]);
                    }
                    reject(error.response.data.errors);
                }
                finally {
                    this.loading = false;
                }
            });
        },
        post(url) {
            return this.submit('post', url);
        },
        data() {
            console.log(data);
            return Object
                .keys(data)
                .reduce((carry, key) => {
                    carry[key] = this[key]
                    return carry
                }, {})
        },
        setError(key, value) {
            Object.assign(this.errors, (value ? { [key]: value} : key));
            this.hasErrors = Object.keys(this.errors).length > 0;
            return this;
        },
        hasError(key) {
            return this.errors.hasOwnProperty(key);
        },
        clearErrors() {
            this.errors = {};
        }
    })

    return form;
}
