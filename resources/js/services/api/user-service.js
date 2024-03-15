import api from "../api"

const updateDeviceId = async (deviceId) => {
    const response = await api.put('/user/update-device-id', {
        device_id: deviceId
    });

    return response.data;
}

export {
    updateDeviceId
}
