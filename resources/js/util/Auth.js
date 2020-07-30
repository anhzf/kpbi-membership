import config from "@/config";

function updateToken(newTokenType, newToken) {
    // Set Token to Browser Session
    const sessTokenName = config.session.AUTH_TOKEN_NAME
    window.sessionStorage.setItem(sessTokenName, `${newTokenType} ${newToken}`)
    // Set axios default header
    const SESSION_TOKEN = window.sessionStorage.getItem(sessTokenName)
    window.axios.defaults.headers.common['Authorization'] = SESSION_TOKEN;
    return true
}

async function Login(loginData, finallyCB = null) {
    try {
        const {
            data: { success, access_token, token_type }
        } = await axios.post('/api/auth/login', loginData).finally(any => finallyCB?.(any))

        if (success) {
            updateToken(token_type, access_token)
            return {
                success: true,
                token_type, access_token
            }
        }
    } catch (error) {
        return {
            success: false,
            message: error.message,
            response: {...error.response},
            request: {...error.request},
            config: {...error.config},
        }
    }
}

async function Logout(finallyCB = null) {
    try {
        const { data } = await axios.post('/api/auth/logout').finally(any => finallyCB?.(any))
        return {
            success: true,
            ...data
        }
    } catch (error) {
        return {
            success: false,
            message: error.message,
            response: {...error.response},
            request: {...error.request},
            config: {...error.config},
        }
    }
}

export {
    updateToken, Login, Logout
}