import api from "../.."

const createBig = async (data) => {
    console.log(data);
    const response = await api.post('/bigs', data);

    return response.data;
}

export {
    createBig,
}
