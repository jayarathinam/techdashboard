import axios from 'axios';

export function getUsers() {
    return new Promise((res, err) => {
        axios.get('/api/users/getusers')
            .then((response) => {
                res(response.data);
            })
            .catch((error) => {
                err(error);
            })
    })
}