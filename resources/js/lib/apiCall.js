import axios from 'axios';
import Cookies from 'js-cookie';

export default (url, method = 'get', options = {}) => {
    const axiosInstance = axios.create();
    const toast = useToast();
    console.log(toast); //displays correctly

    axiosInstance.interceptors.response.use(
        function (response) {
            return response;
        },
        function (error) {
            switch (error.status) {
                case 403:
                    toast.add({
                        title: 'Whoops!',
                        description: "You're trying to do something that's off limits to you...",
                        // color: 'error',
                    });
                    break;
                case 404:
                    toast.add({
                        title: 'Whoops!',
                        description: "We can't find what you're looking for...",
                        // color: 'error',
                    });
                    break;
                case 406:
                    toast.add({
                        title: '🤖 Bleep bloop: Anti-bot test failed 🤖',
                        description: 'This looks like suspicious behaviour.',
                        // color: 'error',
                    });
                    break;
                case 409:
                    throw error;
                case 417:
                    throw error;
                case 419:
                    toast.add({
                        title: '🔒 Authentication error',
                        description: 'For your security, please log in again. If this error persists, please clear your cookies and try again. 🍪',
                        color: 'error',
                    });
                    useSanctumAuth().logout();
                    break;
                case 422:
                    throw error;
                case 429:
                    toast.add({
                        title: '🐌 Take it easy 🐢',
                        description: "We're not keen on you doing that so often. Please wait a minute or two and then try again.",
                        color: 'error',
                    });
                    break;
                default:
                    toast.add({
                        title: 'Uh oh!',
                        description: 'Something went wrong on our end. Try again in a little while.',
                        color: 'error',
                    });
                    break;
            }

            return Promise.reject(error);
        }
    );

    return axiosInstance({
        method,
        url,
        baseURL: import.meta.env.VITE_API_URL,
        headers: {
            Accept: 'application/json',
            'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN'),
        },
        withCredentials: true,
        withXSRFToken: true,
        ...options,
    });
};
